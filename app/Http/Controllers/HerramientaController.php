<?php

namespace App\Http\Controllers;

use App\Models\Herramienta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HerramientaController extends Controller
{
    public function index()
    {
        $herramientas = Herramienta::orderBy('categoria')->orderBy('nombre')->get();
        $categorias   = $herramientas->groupBy('categoria');

        return view('herramientas.index', compact('herramientas', 'categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'      => 'required|string|max:255',
            'categoria'   => 'required|string|max:100',
            'tipo'        => 'required|in:ISO,EXE,LINK,ZIP,PDF',
            'version'     => 'nullable|string|max:50',
            'descripcion' => 'nullable|string',
            'url'         => 'nullable|url',
            'archivo'     => 'nullable|file|max:204800',
        ]);

        $data = $request->except('archivo');
        $data['user_id'] = auth()->id();
        $data['icono']   = $this->getIcono($request->tipo);

        if ($request->hasFile('archivo')) {
            $path = $request->file('archivo')->store('herramientas', 'public');
            $data['archivo'] = $path;
            $data['tamanio'] = $this->formatSize($request->file('archivo')->getSize());
        }

        Herramienta::create($data);
        return back()->with('success', 'Herramienta agregada.');
    }

    public function update(Request $request, Herramienta $herramienta)
    {
        $request->validate([
            'nombre'      => 'required|string|max:255',
            'categoria'   => 'required|string|max:100',
            'tipo'        => 'required|in:ISO,EXE,LINK,ZIP,PDF',
            'version'     => 'nullable|string|max:50',
            'descripcion' => 'nullable|string',
            'url'         => 'nullable|url',
            'archivo'     => 'nullable|file|max:204800',
        ]);

        $data = $request->except('archivo');
        $data['icono'] = $this->getIcono($request->tipo);

        if ($request->hasFile('archivo')) {
            if ($herramienta->archivo) {
                Storage::disk('public')->delete($herramienta->archivo);
            }
            $path = $request->file('archivo')->store('herramientas', 'public');
            $data['archivo'] = $path;
            $data['tamanio'] = $this->formatSize($request->file('archivo')->getSize());
        }

        $herramienta->update($data);
        return back()->with('success', 'Herramienta actualizada.');
    }

    public function destroy(Herramienta $herramienta)
    {
        if ($herramienta->archivo) {
            Storage::disk('public')->delete($herramienta->archivo);
        }
        $herramienta->delete();
        return back()->with('success', 'Herramienta eliminada.');
    }

    public function descargar(Herramienta $herramienta)
    {
        return response()->download(storage_path('app/public/' . $herramienta->archivo));
    }

    private function getIcono($tipo)
    {
        return match($tipo) {
            'ISO'  => '💿',
            'EXE'  => '📦',
            'LINK' => '🔗',
            'ZIP'  => '🗜️',
            'PDF'  => '📄',
            default => '📁',
        };
    }

    private function formatSize($bytes)
    {
        if ($bytes >= 1073741824) return round($bytes / 1073741824, 1) . ' GB';
        if ($bytes >= 1048576)    return round($bytes / 1048576, 1) . ' MB';
        if ($bytes >= 1024)       return round($bytes / 1024, 1) . ' KB';
        return $bytes . ' B';
    }
}