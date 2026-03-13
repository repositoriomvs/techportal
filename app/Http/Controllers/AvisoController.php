<?php

namespace App\Http\Controllers;

use App\Models\Aviso;
use Illuminate\Http\Request;

class AvisoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'titulo'    => 'required|string|max:255',
            'contenido' => 'nullable|string',
            'tipo'      => 'required|in:info,advertencia,actualizacion',
            'url'       => 'nullable|string',
            'url_texto' => 'nullable|string|max:100',
        ]);

        Aviso::create([
            'user_id'      => auth()->id(),
            'titulo'       => $request->titulo,
            'contenido'    => $request->contenido,
            'tipo'         => $request->tipo,
            'url'          => $request->url,
            'url_texto'    => $request->url_texto,
            'activo'       => true,
            'publicado_at' => now(),
        ]);

        return back()->with('success', 'Aviso publicado.');
    }

    public function destroy(Aviso $aviso)
    {
        $aviso->delete();
        return back()->with('success', 'Aviso eliminado.');
    }

    public function toggle(Aviso $aviso)
    {
        $aviso->update(['activo' => !$aviso->activo]);
        return back();
    }
}