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
        $user = auth()->user();

        // ✅ Si el técnico ya tiene una parcial activa, redirigir a continuarla
        $parcialActiva = MantencionOrden::where('user_id', $user->id)
            ->where('estado', 'parcial')
            ->first();

        if ($parcialActiva) {
            return redirect()->route('mantencion.edit.parcial', $parcialActiva)
                ->with('info', 'Tienes una orden parcial pendiente. Puedes continuar desde aquí.');
        }

        $itemsRaw = MantencionItem::all();
        $items    = $itemsRaw->groupBy('tipo_equipo')->map(fn($g) => $g->values())->toArray();
        $clientes = Cliente::orderBy('nombre')->get();

        return view('mantencion.create', compact('items', 'clientes'));
    }

    // ── GUARDAR COMPLETO ──────────────────────────────────
 public function store(Request $request)
{
    $request->validate([
        'cliente_id'              => 'required|exists:clientes,id',
        'fecha'                   => 'required|date',
        'hora_inicio'             => 'required',
        'codigo_local'            => 'required|string',
        'direccion'               => 'required|string',
        'ciudad'                  => 'required|string',
        'firma_nombre'            => 'required|string',
        'firma_cargo'             => 'required|string',
        'firma_imagen'            => 'required|string',
        'equipos'                 => 'required|array|min:1',
        'equipos.*.tipo'          => 'required|string',
        'equipos.*.marca'         => 'required|string',
        'equipos.*.modelo'        => 'required|string',
        'equipos.*.serie'         => 'required|string',
        'equipos.*.observaciones' => 'required|string',
        'equipos.*.estado_final'  => 'required|string',
        'equipos.*.foto_equipo'   => 'nullable|file|mimes:jpeg,png,jpg,webp|max:10240',  // ← agregado
        'equipos.*.foto_serie'    => 'nullable|file|mimes:jpeg,png,jpg,webp|max:10240',  // ← agregado
    ]);

        DB::transaction(function () use ($request) {
            // Si venía de una parcial, actualizarla en vez de crear nueva
            $orden_id = $request->input('orden_parcial_id');
            if ($orden_id) {
                $orden = MantencionOrden::where('id', $orden_id)
                    ->where('user_id', auth()->id())
                    ->where('estado', 'parcial')
                    ->firstOrFail();

                $orden->update([
                    'cliente_id'   => $request->cliente_id,
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

                // Eliminar equipos previos para reemplazar
                $orden->equipos()->each(function ($e) {
                    $e->respuestas()->delete();
                    $e->delete();
                });
            } else {
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
            }

            $this->guardarEquipos($request, $orden);
        });

        return redirect()->route('mantencion.index')
            ->with('success', 'Orden creada correctamente.');
    }

    // ── GUARDAR PARCIAL ───────────────────────────────────
public function storeParcial(Request $request)
{
    $request->validate([
        'cliente_id'              => 'required|exists:clientes,id',
        'fecha'                   => 'required|date',
        'hora_inicio'             => 'required',
        'codigo_local'            => 'required|string',
        'direccion'               => 'required|string',
        'ciudad'                  => 'required|string',
        'equipos'                 => 'required|array|min:1',
        'equipos.*.tipo'          => 'required|string',
        'equipos.*.marca'         => 'required|string',
        'equipos.*.modelo'        => 'required|string',
        'equipos.*.serie'         => 'required|string',
        'equipos.*.observaciones' => 'required|string',
        'equipos.*.estado_final'  => 'required|string',
        'equipos.*.foto_equipo'   => 'nullable|file|mimes:jpeg,png,jpg,webp|max:10240',  // ← agregado
        'equipos.*.foto_serie'    => 'nullable|file|mimes:jpeg,png,jpg,webp|max:10240',  // ← agregado
    ]);

        $userId = auth()->id();

        // ✅ Verificar que no exista ya una parcial activa de este técnico
        $parcialExistente = MantencionOrden::where('user_id', $userId)
            ->where('estado', 'parcial')
            ->first();

        DB::transaction(function () use ($request, $userId, $parcialExistente) {
            if ($parcialExistente) {
                // Actualizar la parcial existente
                $orden = $parcialExistente;
                $orden->update([
                    'cliente_id'   => $request->cliente_id,
                    'fecha'        => $request->fecha,
                    'hora_inicio'  => $request->hora_inicio,
                    'codigo_local' => $request->codigo_local,
                    'direccion'    => $request->direccion,
                    'ciudad'       => $request->ciudad,
                    'estado'       => 'parcial',
                ]);

                // Limpiar equipos previos
                $orden->equipos()->each(function ($e) {
                    $e->respuestas()->delete();
                    $e->delete();
                });
            } else {
                $orden = MantencionOrden::create([
                    'cliente_id'   => $request->cliente_id,
                    'user_id'      => $userId,
                    'fecha'        => $request->fecha,
                    'hora_inicio'  => $request->hora_inicio,
                    'hora_termino' => null,
                    'codigo_local' => $request->codigo_local,
                    'direccion'    => $request->direccion,
                    'ciudad'       => $request->ciudad,
                    'firma_nombre' => null,
                    'firma_cargo'  => null,
                    'firma_imagen' => null,
                    'estado'       => 'parcial',
                ]);
            }

            $this->guardarEquipos($request, $orden);
        });

        return redirect()->route('mantencion.index')
            ->with('success', 'Orden guardada parcialmente. Puedes continuarla cuando quieras.');
    }

    // ── EDITAR PARCIAL ────────────────────────────────────
public function editParcial(MantencionOrden $mantencion)
{
    if (!auth()->user()->hasRole('admin') && $mantencion->user_id !== auth()->id()) {
        abort(403);
    }

    if ($mantencion->estado !== 'parcial') {
        return redirect()->route('mantencion.index')
            ->with('error', 'Esta orden no está en estado parcial.');
    }

    $mantencion->load(['cliente', 'equipos.respuestas.item']);

    $itemsRaw = MantencionItem::all();
    $items    = $itemsRaw->groupBy('tipo_equipo')->map(fn($g) => $g->values())->toArray();
    $clientes = Cliente::orderBy('nombre')->get();

    // ✅ Preparar equipos guardados para el JS
    $equiposGuardados = $mantencion->equipos->map(function($e) {
        return [
            'tipo'          => $e->tipo,
            'marca'         => $e->marca,
            'modelo'        => $e->modelo,
            'serie'         => $e->serie,
            'observaciones' => $e->observaciones,
            'estado_final'  => $e->estado_final,
            'checklist'     => $e->respuestas->mapWithKeys(fn($r) => [$r->mantencion_item_id => $r->respuesta]),
        ];
    })->values()->toArray();

    return view('mantencion.edit-parcial', compact('mantencion', 'items', 'clientes', 'equiposGuardados'));
}

    // ── HELPER: GUARDAR EQUIPOS ───────────────────────────
    private function guardarEquipos(Request $request, MantencionOrden $orden)
{
    foreach ($request->equipos as $idx => $equipoData) {
        $fotoEquipoPath = null;
        $fotoSeriePath  = null;

        if ($request->hasFile("equipos.{$idx}.foto_equipo")) {
            $fotoEquipoPath = $this->storeConvertida(
                $request->file("equipos.{$idx}.foto_equipo"),
                "mantencion/{$orden->id}"
            );
        }
        if ($request->hasFile("equipos.{$idx}.foto_serie")) {
            $fotoSeriePath = $this->storeConvertida(
                $request->file("equipos.{$idx}.foto_serie"),
                "mantencion/{$orden->id}"
            );
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
    }
// ── HELPER: CONVERTIR Y GUARDAR IMAGEN ───────────────
private function storeConvertida(\Illuminate\Http\UploadedFile $file, string $carpeta): string
{
    $mime = $file->getMimeType();

    // Si NO es webp, guardar normal
    if ($mime !== 'image/webp') {
        return $file->store($carpeta, 'public');
    }

    // Convertir WebP → JPEG usando GD
    $contenido = file_get_contents($file->getRealPath());
    $imgOriginal = imagecreatefromstring($contenido);

    if (!$imgOriginal) {
        // Fallback: guardar tal cual si falla la conversión
        return $file->store($carpeta, 'public');
    }

    $nombreSinExt = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
    $rutaRelativa = $carpeta . '/' . $nombreSinExt . '_' . uniqid() . '.jpg';
    $rutaAbsoluta = storage_path('app/public/' . $rutaRelativa);

    // Crear directorio si no existe
    if (!file_exists(dirname($rutaAbsoluta))) {
        mkdir(dirname($rutaAbsoluta), 0755, true);
    }

    // Guardar como JPEG calidad 90
    imagejpeg($imgOriginal, $rutaAbsoluta, 90);
    imagedestroy($imgOriginal);

    return $rutaRelativa;
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
