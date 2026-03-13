<?php

namespace App\Http\Controllers;

use App\Models\HistorialVisita;
use Illuminate\Http\Request;

class HistorialController extends Controller
{
   public function actualizarPagina(Request $request)
{
    $request->validate([
        'tipo'       => 'required|string',
        'recurso_id' => 'required|integer',
        'pagina'     => 'required|integer|min:1',
    ]);

    HistorialVisita::where('user_id', auth()->id())
        ->where('tipo', $request->tipo)
        ->where('recurso_id', $request->recurso_id)
        ->update([
            'ultima_pagina' => $request->pagina,
            'visitado_at'   => now(),
        ]);

    return response()->json(['ok' => true]);
}
}