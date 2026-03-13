<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Documento;
use App\Models\HistorialVisita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentoController extends Controller
{
    public function create(Cliente $cliente)
    {
        return view('documentos.create', compact('cliente'));
    }

    public function store(Request $request, Cliente $cliente)
    {
        $request->validate([
            'nombre'      => 'required|string|max:255',
            'categoria'   => 'required|in:documento,procedimiento,imagen',
            'tipo'        => 'required|in:PDF,ISO,EXE,IMG,ZIP,LINK',
            'descripcion' => 'nullable|string',
            'version'     => 'nullable|string|max:50',
            'url'         => 'nullable|url',
            'archivo'     => 'nullable|file|max:102400',
        ]);

        $data               = $request->except('archivo');
        $data['cliente_id'] = $cliente->id;
        $data['user_id']    = auth()->id();
        $data['icono']      = $this->getIcono($request->tipo, $request->categoria);

        if ($request->hasFile('archivo')) {
            $file            = $request->file('archivo');
            $data['archivo'] = $file->store('documentos/' . $cliente->id, 'public');
            $data['tamanio'] = $this->formatSize($file->getSize());
        }

        $cliente->documentos()->create($data);

        return redirect()->route('clientes.show', $cliente)
            ->with('success', 'Recurso subido correctamente.');
    }

    public function edit(Documento $documento)
    {
        return view('documentos.edit', compact('documento'));
    }

    public function update(Request $request, Documento $documento)
    {
        $request->validate([
            'nombre'      => 'required|string|max:255',
            'categoria'   => 'required|in:documento,procedimiento,imagen',
            'tipo'        => 'required|in:PDF,ISO,EXE,IMG,ZIP,LINK',
            'descripcion' => 'nullable|string',
            'version'     => 'nullable|string|max:50',
            'url'         => 'nullable|url',
            'archivo'     => 'nullable|file|max:102400',
        ]);

        $data          = $request->except('archivo');
        $data['icono'] = $this->getIcono($request->tipo, $request->categoria);

        if ($request->hasFile('archivo')) {
            // Eliminar archivo anterior si existe
            if ($documento->archivo) {
                Storage::disk('public')->delete($documento->archivo);
            }
            $file            = $request->file('archivo');
            $data['archivo'] = $file->store('documentos/' . $documento->cliente_id, 'public');
            $data['tamanio'] = $this->formatSize($file->getSize());
        }

        $documento->update($data);

        return redirect()->route('clientes.show', $documento->cliente)
            ->with('success', 'Recurso actualizado correctamente.');
    }

    public function destroy(Documento $documento)
    {
        $cliente = $documento->cliente;

        if ($documento->archivo) {
            Storage::disk('public')->delete($documento->archivo);
        }

        $documento->delete();

        return redirect()->route('clientes.show', $cliente)
            ->with('success', 'Recurso eliminado.');
    }

public function ver(Documento $documento)
{
    \App\Models\HistorialVisita::updateOrCreate(
        [
            'user_id'    => auth()->id(),
            'tipo'       => 'documento',
            'recurso_id' => $documento->id,
        ],
        [
            'recurso_nombre' => $documento->nombre,
            'recurso_url'    => route('documentos.ver', $documento),
            'visitado_at'    => now(),
        ]
    );

    return view('documentos.ver', compact('documento'));
}

    public function descargar(Documento $documento)
    {
        abort_unless(Storage::disk('public')->exists($documento->archivo), 404);

        return response()->download(
            Storage::disk('public')->path($documento->archivo)
        );
    }

    private function getIcono(string $tipo, string $categoria): string
    {
        return match($tipo) {
            'PDF'  => '📄',
            'ISO'  => '💿',
            'EXE'  => '📦',
            'IMG'  => '👻',
            'ZIP'  => '🗜️',
            'LINK' => '🔗',
            default => '📄',
        };
    }

    private function formatSize(int $bytes): string
    {
        if ($bytes >= 1073741824) return round($bytes / 1073741824, 1) . ' GB';
        if ($bytes >= 1048576)    return round($bytes / 1048576, 1) . ' MB';
        if ($bytes >= 1024)       return round($bytes / 1024, 1) . ' KB';
        return $bytes . ' B';
    }
}