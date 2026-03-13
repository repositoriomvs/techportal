<?php

namespace App\Http\Controllers;

use App\Models\HardwareModelo;
use App\Models\HardwareRecurso;
use Illuminate\Http\Request;

class HardwareRecursoController extends Controller
{
    public function store(Request $request, HardwareModelo $modelo)
    {
        $request->validate([
            'nombre'    => 'required|string|max:255',
            'categoria' => 'required|in:manual_tecnico,list_part,firmware,procedimiento',
            'tipo'      => 'required|in:PDF,ISO,EXE,IMG,ZIP,LINK',
            'version'   => 'nullable|string|max:50',
            'url'       => 'nullable|url',
            'archivo'   => 'nullable|file|max:102400',
        ]);

        $data = $request->except('archivo');
        $data['hardware_modelo_id'] = $modelo->id;
        $data['user_id']            = auth()->id();
        $data['icono']              = $this->getIcono($request->tipo);

        if ($request->hasFile('archivo')) {
            $path = $request->file('archivo')->store('hardware/' . $modelo->id, 'public');
            $data['archivo'] = $path;
            $data['tamanio'] = $this->formatSize($request->file('archivo')->getSize());
        }

        HardwareRecurso::create($data);
        return back()->with('success', 'Recurso subido correctamente.');
    }

 public function edit(HardwareRecurso $recurso)
{
    $recurso->load('modelo.marca.tipo');
    return view('hardware.recursos.edit', compact('recurso'));
}

    public function update(Request $request, HardwareRecurso $recurso)
    {
        $request->validate([
            'nombre'      => 'required|string|max:255',
            'categoria'   => 'required|in:manual_tecnico,list_part,firmware,procedimiento',
            'tipo'        => 'required|in:PDF,ISO,EXE,IMG,ZIP,LINK',
            'version'     => 'nullable|string|max:50',
            'descripcion' => 'nullable|string',
            'url'         => 'nullable|url',
            'archivo'     => 'nullable|file|max:102400',
        ]);

        $data = $request->except('archivo');
        $data['icono'] = $this->getIcono($request->tipo);

        if ($request->hasFile('archivo')) {
            if ($recurso->archivo) {
                \Storage::disk('public')->delete($recurso->archivo);
            }
            $path = $request->file('archivo')->store('hardware/' . $recurso->hardware_modelo_id, 'public');
            $data['archivo'] = $path;
            $data['tamanio'] = $this->formatSize($request->file('archivo')->getSize());
        }

        $recurso->update($data);
        return redirect()->route('hardware.index')->with('success', 'Recurso actualizado.');
    }

    public function destroy(HardwareRecurso $recurso)
    {
        if ($recurso->archivo) {
            \Storage::disk('public')->delete($recurso->archivo);
        }
        $recurso->delete();
        return back()->with('success', 'Recurso eliminado.');
    }

public function ver(\App\Models\HardwareRecurso $recurso)

{
    $recurso->load('modelo.marca.tipo');

    // Registrar visita
    \App\Models\HistorialVisita::updateOrCreate(
        [
            'user_id'    => auth()->id(),
            'tipo'       => 'hardware_recurso',
            'recurso_id' => $recurso->id,
        ],
        [
            'recurso_nombre' => $recurso->nombre,
            'recurso_url'    => route('hardware.recursos.ver', $recurso),
            'visitado_at'    => now(),
        ]
    );

    return view('hardware.recursos.ver', compact('recurso'));
}

    public function descargar(HardwareRecurso $recurso)
    {
        return response()->download(storage_path('app/public/' . $recurso->archivo));
    }

    private function getIcono($tipo)
    {
        return ['PDF' => '📄', 'ISO' => '💿', 'EXE' => '📦', 'IMG' => '👻', 'ZIP' => '🗜️', 'LINK' => '🔗'][$tipo] ?? '📄';
    }

    private function formatSize($bytes)
    {
        if ($bytes >= 1073741824) return round($bytes / 1073741824, 1) . ' GB';
        if ($bytes >= 1048576)    return round($bytes / 1048576, 1) . ' MB';
        if ($bytes >= 1024)       return round($bytes / 1024, 1) . ' KB';
        return $bytes . ' B';
    }
}