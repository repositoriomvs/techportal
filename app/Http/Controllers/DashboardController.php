<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Documento;
use App\Models\Herramienta;
use App\Models\User;
use App\Models\HistorialVisita;
use App\Models\Aviso;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'totalClientes'     => Cliente::count(),
            'totalRecursos'     => Documento::count(),
            'totalHerramientas' => Herramienta::count(),
            'totalUsuarios'     => User::count(),
            'recursosRecientes' => Documento::with('cliente')->latest()->take(5)->get(),
            'ultimasVisitas'    => HistorialVisita::where('user_id', auth()->id())
                                    ->orderBy('visitado_at', 'desc')
                                    ->take(3)
                                    ->get(),
            'avisos'            => Aviso::where('activo', true)
                                    ->orderBy('publicado_at', 'desc')
                                    ->take(5)
                                    ->get(),
        ]);
    }
}