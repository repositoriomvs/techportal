<?php
namespace App\Http\Controllers;

use App\Models\Incidencia;
use App\Models\Cliente;
use App\Models\Local;
use App\Models\SlaCliente;
use App\Models\GestionIncidencia;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\IncidenciasExport;

class IncidenciaController extends Controller
{
// MÉTODO index — agrega $tecnicos
public function index(Request $request)
{
    $user = auth()->user();
    $query = Incidencia::with(['cliente','local','agente','tecnico'])->orderByDesc('created_at');

    if ($user->hasRole('agente')) $query->where('agente_id', $user->id);
    if ($request->estado)      $query->where('estado_mesa', $request->estado);
    if ($request->prioridad)   $query->where('prioridad', $request->prioridad);
    if ($request->cliente_id)  $query->where('cliente_id', $request->cliente_id);
    if ($request->desde)       $query->whereDate('created_at', '>=', $request->desde);
    if ($request->hasta)       $query->whereDate('created_at', '<=', $request->hasta);

    $incidencias = $query->paginate(20);
    $clientes    = Cliente::orderBy('nombre')->get();
    $tecnicos    = User::role('tecnico')->orderBy('name')->get(); // ← AGREGAR

    return view('incidencias.index', compact('incidencias', 'clientes', 'tecnicos')); // ← AGREGAR tecnicos
}
public function create()
{
    $clientes = Cliente::orderBy('nombre')->get();
    $tecnicos = User::role('tecnico')->orderBy('name')->get();
    return view('incidencias.create', compact('clientes', 'tecnicos'));
}

    public function store(Request $request)
{
    $request->validate([
        'cliente_id'        => 'required|exists:clientes,id',
        'local_id'          => 'required|exists:locales,id',
        'canal_ingreso'     => 'required|string',
        'nombre_contacto'   => 'required|string',
        'telefono_contacto' => 'required|string',
        'tipo_ticket'       => 'required|string',
        'categoria_equipo'  => 'required|string',
        'tipo_equipo'       => 'required|string',
        'asunto'            => 'required|string',
        'descripcion_falla' => 'required|string',
        'prioridad'         => 'required|in:baja,media,alta',
      
    ]);

    $incidencia = null;

    DB::transaction(function () use ($request, &$incidencia) {
        $sla = SlaCliente::where('cliente_id', $request->cliente_id)
            ->where('prioridad', $request->prioridad)
            ->first();

        $adjunto = null;
        if ($request->hasFile('adjunto')) {
            $adjunto = $request->file('adjunto')->store('incidencias/adjuntos', 'public');
        }

        $serie = $request->serie_equipo;
        $serieTemporal = false;
        if (empty($serie)) {
            $serie = 'TMP-' . strtoupper(substr(md5(uniqid()), 0, 8));
            $serieTemporal = true;
        }

        $incidencia = Incidencia::create([
            'cliente_id'              => $request->cliente_id,
            'local_id'                => $request->local_id,
            'agente_id'               => auth()->id(),
            'tecnico_id'              => $request->tecnico_id ?: null,
            'canal_ingreso'           => $request->canal_ingreso,
            'nombre_contacto'         => $request->nombre_contacto,
            'telefono_contacto'       => $request->telefono_contacto,
            'tipo_ticket'             => $request->tipo_ticket,
            'categoria_equipo'        => $request->categoria_equipo,
            'tipo_equipo'             => $request->tipo_equipo,
            'marca_equipo'            => $request->marca_equipo,
            'modelo_equipo'           => $request->modelo_equipo,
            'serie_equipo'            => $serie,
            'serie_temporal'          => $serieTemporal,
            'ubicacion_equipo'        => $request->ubicacion_equipo,
            'asunto'                  => $request->asunto,
            'descripcion_falla'       => $request->descripcion_falla,
            'adjunto'                 => $adjunto,
            'prioridad'               => $request->prioridad,
            'estado_mesa'             => $request->tecnico_id ? 'asignado' : 'abierto',
            'estado_tecnico'          => $request->tecnico_id ? 'asignado' : null,
            'fecha_asignacion'        => $request->tecnico_id ? now() : null,
            'fecha_limite_respuesta'  => $sla ? now()->addHours($sla->horas_respuesta) : null,
            'fecha_limite_resolucion' => $sla ? now()->addHours($sla->horas_resolucion) : null,
        ]);

        GestionIncidencia::create([
            'incidencia_id' => $incidencia->id,
            'user_id'       => auth()->id(),
            'tipo'          => 'nota_interna',
            'descripcion'   => 'Incidencia creada por ' . auth()->user()->name,
        ]);

        if ($request->tecnico_id) {
            GestionIncidencia::create([
                'incidencia_id' => $incidencia->id,
                'user_id'       => auth()->id(),
                'tipo'          => 'asignacion',
                'descripcion'   => 'Asignada a ' . User::find($request->tecnico_id)->name,
            ]);
        }
    });
\Log::info('Incidencia creada: ' . ($incidencia ? $incidencia->id : 'NULL'));
    // Mensaje de éxito
    $estadoLabels = [
        'abierto'  => 'Abierto',
        'asignado' => 'Asignado',
    ];
    $mensaje = 'Incidencia creada exitosamente con número ' . $incidencia->numero_ticket 
             . ' — Estado: ' . ($estadoLabels[$incidencia->estado_mesa] ?? $incidencia->estado_mesa) . '.';

    if ($incidencia->tecnico_id) {
        $tecnico = User::find($incidencia->tecnico_id);
        $mensaje .= ' Queda asignada al técnico ' . $tecnico->name . '.';
    }

    return redirect()->route('incidencias.index')->with('success', $mensaje);
}

    public function show(Incidencia $incidencia)
    {
        $incidencia->load(['cliente','local','agente','tecnico','gestiones.user']);
        $tecnicos = User::role('tecnico')->orderBy('name')->get();
        return view('incidencias.show', compact('incidencia', 'tecnicos'));
    }

    public function asignar(Request $request, Incidencia $incidencia)
    {
        $request->validate(['tecnico_id' => 'required|exists:users,id']);

        $incidencia->update([
            'tecnico_id'       => $request->tecnico_id,
            'estado_mesa'      => 'asignado',
            'estado_tecnico'   => 'asignado',
            'fecha_asignacion' => now(),
        ]);

        GestionIncidencia::create([
            'incidencia_id' => $incidencia->id,
            'user_id'       => auth()->id(),
            'tipo'          => 'asignacion',
            'descripcion'   => 'Asignada a ' . User::find($request->tecnico_id)->name,
        ]);

        return back()->with('success', 'Técnico asignado correctamente.');
    }

    public function formCierre(Incidencia $incidencia)
    {
        $incidencia->load(['cliente','local','gestiones.user']);
        return view('incidencias.cierre', compact('incidencia'));
    }

    public function guardarCierre(Request $request, Incidencia $incidencia)
    {
        $request->validate([
            'categoria_cierre'    => 'required|string',
            'subcategoria_cierre' => 'required|string',
            'comentario_cierre'   => 'required|string',
        ]);

        $incidencia->update([
            'categoria_cierre'    => $request->categoria_cierre,
            'subcategoria_cierre' => $request->subcategoria_cierre,
            'comentario_cierre'   => $request->comentario_cierre,
            'serie_equipo_real'   => $request->serie_equipo_real ?: $incidencia->serie_equipo,
            'estado_mesa'         => 'cerrado',
            'estado_tecnico'      => 'cerrado',
            'closed_at'           => now(),
            'fecha_primera_atencion' => $incidencia->fecha_primera_atencion ?? now(),
        ]);

        GestionIncidencia::create([
            'incidencia_id' => $incidencia->id,
            'user_id'       => auth()->id(),
            'tipo'          => 'cierre',
            'descripcion'   => $request->comentario_cierre,
        ]);

        return redirect()->route('incidencias.index')
            ->with('success', 'Incidencia cerrada correctamente.');
    }

    public function dashboard(Request $request)
{
    $periodo    = $request->get('periodo', 30);
    $clienteId  = $request->get('cliente_id');
    $clientes   = Cliente::orderBy('nombre')->get();
    $desde      = now()->subDays($periodo);

    $query = Incidencia::query()->where('created_at', '>=', $desde);
    if ($clienteId) $query->where('cliente_id', $clienteId);

    $total      = (clone $query)->count();
    $abiertos   = (clone $query)->where('estado_mesa', 'abierto')->count();
    $en_gestion = (clone $query)->where('estado_mesa', 'en_gestion')->count();
    $cerrados   = (clone $query)->where('estado_mesa', 'cerrado')->count();
    $criticos   = (clone $query)->where('prioridad', 'alta')->whereNotIn('estado_mesa', ['cerrado','cancelado_cliente'])->count();

    // SLA
    $con_sla_resp = (clone $query)->whereNotNull('fecha_primera_atencion')->whereNotNull('fecha_limite_respuesta')->get();
    $con_sla_res  = (clone $query)->whereNotNull('closed_at')->whereNotNull('fecha_limite_resolucion')->get();

    $pct_sla_respuesta  = $con_sla_resp->count()  > 0 ? round($con_sla_resp->filter(fn($i)  => $i->slaRespuestaCumplido())->count()  / $con_sla_resp->count()  * 100) : 0;
    $pct_sla_resolucion = $con_sla_res->count()   > 0 ? round($con_sla_res->filter(fn($i)   => $i->slaResolucionCumplido())->count() / $con_sla_res->count()   * 100) : 0;

    // MTTR
    $cerrados_con_fecha = (clone $query)->whereNotNull('closed_at')->get();
    $mttr       = $cerrados_con_fecha->count() > 0 ? round($cerrados_con_fecha->avg(fn($i) => $i->created_at->diffInHours($i->closed_at))) : 0;
    $mttr_alta  = $cerrados_con_fecha->where('prioridad','alta')->count()  > 0 ? round($cerrados_con_fecha->where('prioridad','alta')->avg(fn($i)  => $i->created_at->diffInHours($i->closed_at))) : '—';
    $mttr_media = $cerrados_con_fecha->where('prioridad','media')->count() > 0 ? round($cerrados_con_fecha->where('prioridad','media')->avg(fn($i) => $i->created_at->diffInHours($i->closed_at))) : '—';
    $mttr_baja  = $cerrados_con_fecha->where('prioridad','baja')->count()  > 0 ? round($cerrados_con_fecha->where('prioridad','baja')->avg(fn($i)  => $i->created_at->diffInHours($i->closed_at))) : '—';

    // Por estado
    $por_estado = (clone $query)->select('estado_mesa', DB::raw('count(*) as total'))
        ->groupBy('estado_mesa')->pluck('total', 'estado_mesa');

    // Por tipo
    $por_tipo = (clone $query)->select('tipo_ticket', DB::raw('count(*) as total'))
        ->groupBy('tipo_ticket')->pluck('total', 'tipo_ticket');

    // Por técnico
    $por_tecnico = (clone $query)->whereNotNull('tecnico_id')
        ->select('tecnico_id', DB::raw('count(*) as total'))
        ->groupBy('tecnico_id')->with('tecnico:id,name')->get()
        ->map(function($item) use ($query) {
            $item->abiertos = Incidencia::where('tecnico_id', $item->tecnico_id)->whereNotIn('estado_mesa',['cerrado','cancelado_cliente'])->count();
            $item->cerrados = Incidencia::where('tecnico_id', $item->tecnico_id)->where('estado_mesa','cerrado')->count();
            $cerr = Incidencia::where('tecnico_id', $item->tecnico_id)->whereNotNull('closed_at')->whereNotNull('fecha_limite_resolucion')->get();
            $item->pct_sla  = $cerr->count() > 0 ? round($cerr->filter(fn($i) => $i->slaResolucionCumplido())->count() / $cerr->count() * 100) : null;
            return $item;
        });

    // Por cliente
$por_cliente = (clone $query)->select('cliente_id', DB::raw('count(*) as total'))
    ->groupBy('cliente_id')->with('cliente:id,nombre')->get()
    ->map(function($item) {
        $item->abiertos = Incidencia::where('cliente_id', $item->cliente_id)->whereNotIn('estado_mesa',['cerrado','cancelado_cliente'])->count();
        $item->cerrados = Incidencia::where('cliente_id', $item->cliente_id)->where('estado_mesa','cerrado')->count(); // ← ESTA LÍNEA
        $cerr = Incidencia::where('cliente_id', $item->cliente_id)->whereNotNull('closed_at')->whereNotNull('fecha_limite_resolucion')->get();
        $item->pct_sla  = $cerr->count() > 0 ? round($cerr->filter(fn($i) => $i->slaResolucionCumplido())->count() / $cerr->count() * 100) : null;
        return $item;
    });

    // Tendencia mensual
    $tendencia = (clone $query)->select(
            DB::raw("TO_CHAR(created_at, 'YYYY-MM') as mes"),
            DB::raw('count(*) as total')
        )->groupBy('mes')->orderBy('mes')->get();

    // Tickets críticos activos
    $tickets_criticos = (clone $query)->where('prioridad','alta')
        ->whereNotIn('estado_mesa',['cerrado','cancelado_cliente'])
        ->with(['cliente','tecnico'])->orderBy('created_at')->get();

    return view('incidencias.dashboard', compact(
        'total','abiertos','en_gestion','cerrados','criticos',
        'pct_sla_respuesta','pct_sla_resolucion',
        'mttr','mttr_alta','mttr_media','mttr_baja',
        'por_estado','por_tipo','por_tecnico','por_cliente',
        'tendencia','tickets_criticos','clientes'
    ));
}

    public function reportes(Request $request)
{
    $query = Incidencia::with(['cliente','local','agente','tecnico'])
        ->orderByDesc('created_at');

    if ($request->cliente_id) $query->where('cliente_id', $request->cliente_id);
    if ($request->estado)     $query->where('estado_mesa', $request->estado);
    if ($request->prioridad)  $query->where('prioridad', $request->prioridad);
    if ($request->desde)      $query->whereDate('created_at', '>=', $request->desde);
    if ($request->hasta)      $query->whereDate('created_at', '<=', $request->hasta);

    $incidencias = $query->get();
    $clientes    = Cliente::orderBy('nombre')->get();

    return view('incidencias.reportes', compact('incidencias', 'clientes')); // ← vista correcta
}

    public function exportarExcel(Request $request)
    {
        return Excel::download(new IncidenciasExport($request->all()), 'incidencias-' . now()->format('Ymd') . '.xlsx');
    }

    public function exportarPdf(Request $request)
    {
        $query = Incidencia::with(['cliente','local','agente','tecnico'])->orderByDesc('created_at');
        if ($request->cliente_id) $query->where('cliente_id', $request->cliente_id);
        if ($request->estado)     $query->where('estado_mesa', $request->estado);
        if ($request->desde)      $query->whereDate('created_at', '>=', $request->desde);
        if ($request->hasta)      $query->whereDate('created_at', '<=', $request->hasta);
        $incidencias = $query->get();

        $pdf = Pdf::loadView('incidencias.reporte-pdf', compact('incidencias'))
            ->setPaper('letter', 'landscape');
        return $pdf->download('reporte-incidencias-' . now()->format('Ymd') . '.pdf');
    }
}