<?php
namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\MantencionOrden;
use App\Models\MantencionEquipo;
use App\Models\MantencionItem;
use App\Models\MantencionRespuesta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class MantencionController extends Controller
{
    // ── LISTADO ──────────────────────────────────────────
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            $ordenes = MantencionOrden::with(['cliente', 'user', 'equipos'])
                ->orderByDesc('created_at')
                ->get();
        } else {
            $ordenes = MantencionOrden::with(['cliente', 'user', 'equipos'])
                ->where('user_id', $user->id)
                ->orderByDesc('created_at')
                ->get();
        }

        return view('mantencion.index', compact('ordenes'));
    }

    // ── CREAR ─────────────────────────────────────────────
public function create()
{
    // 1. Obtener los items (asegúrate de que la columna 'tipo_equipo' 
    // contenga valores como 'computador_aio', 'impresora_termica', etc.)
    $itemsRaw = ItemMantencion::all(); 

    // 2. Agruparlos por tipo para que JS pueda acceder a ellos por llave
    $items = $itemsRaw->groupBy('tipo_equipo');

    // 3. Pasar a la vista
    return view('mantencion.create', compact('items', 'clientes'));
}

    // ── GUARDAR ───────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'cliente_id'            => 'required|exists:clientes,id',
            'fecha'                 => 'required|date',
            'hora_inicio'           => 'required',
            'codigo_local'          => 'required|string',
            'direccion'             => 'required|string',
            'ciudad'                => 'required|string',
            'firma_nombre'          => 'required|string',
            'firma_cargo'           => 'required|string',
            'firma_imagen'          => 'required|string',
            'equipos'               => 'required|array|min:1',
            'equipos.*.tipo'        => 'required|string',
            'equipos.*.marca'       => 'required|string',
            'equipos.*.modelo'      => 'required|string',
            'equipos.*.serie'       => 'required|string',
            'equipos.*.observaciones' => 'required|string',
            'equipos.*.estado_final'  => 'required|string',
        ]);

        DB::transaction(function () use ($request) {

            // Crear orden
            $orden = MantencionOrden::create([
                'cliente_id'   => $request->cliente_id,
                'user_id'      => auth()->id(),
                'fecha'        => $request->fecha,
                'hora_inicio'  => $request->hora_inicio,
                'hora_termino' => now()->format('H:i'),
                'codigo_local' => $request->codigo_local,
                'direccion'    => $request->direccion,
                'ciudad'       => $request->ciudad,
                'firma_nombre' => $request->firma_nombre,
                'firma_cargo'  => $request->firma_cargo,
                'firma_imagen' => $request->firma_imagen,
                'estado'       => 'enviada',
            ]);

            // Crear equipos
            foreach ($request->equipos as $idx => $equipoData) {
                $fotoEquipoPath = null;
                $fotoSeriePath  = null;

                if ($request->hasFile("equipos.{$idx}.foto_equipo")) {
                    $fotoEquipoPath = $request->file("equipos.{$idx}.foto_equipo")
                        ->store("mantencion/{$orden->id}", 'public');
                }
                if ($request->hasFile("equipos.{$idx}.foto_serie")) {
                    $fotoSeriePath = $request->file("equipos.{$idx}.foto_serie")
                        ->store("mantencion/{$orden->id}", 'public');
                }

                $equipo = MantencionEquipo::create([
                    'mantencion_orden_id' => $orden->id,
                    'tipo'                => $equipoData['tipo'],
                    'marca'               => $equipoData['marca'],
                    'modelo'              => $equipoData['modelo'],
                    'serie'               => $equipoData['serie'],
                    'observaciones'       => $equipoData['observaciones'],
                    'estado_final'        => $equipoData['estado_final'],
                    'foto_equipo'         => $fotoEquipoPath,
                    'foto_serie'          => $fotoSeriePath,
                ]);

                // Guardar respuestas del checklist
                if (isset($equipoData['checklist'])) {
                    foreach ($equipoData['checklist'] as $itemId => $respuesta) {
                        MantencionRespuesta::create([
                            'mantencion_equipo_id' => $equipo->id,
                            'mantencion_item_id'   => $itemId,
                            'respuesta'            => $respuesta,
                        ]);
                    }
                }
            }
        });

        return redirect()->route('mantencion.index')
            ->with('success', 'Orden creada correctamente.');
    }

    // ── VER ───────────────────────────────────────────────
    public function show(MantencionOrden $mantencion)
    {
        $mantencion->load(['cliente', 'user', 'equipos.respuestas.item']);
        return view('mantencion.show', compact('mantencion'));
    }

    // ── PDF ───────────────────────────────────────────────
 public function pdf(MantencionOrden $mantencion)
{
    $mantencion->load(['cliente', 'user', 'equipos.respuestas.item']);
    
    $pdf = Pdf::loadView('mantencion.pdf', compact('mantencion'))
        ->setPaper('letter', 'portrait');

    $dompdf = $pdf->getDomPDF();
    $dompdf->set_option('margin_top', 25);
    $dompdf->set_option('margin_bottom', 25);
    $dompdf->set_option('margin_left', 25);
    $dompdf->set_option('margin_right', 25);
    
    return $pdf->download('mantencion-' . $mantencion->numero_orden . '.pdf');
}
}
