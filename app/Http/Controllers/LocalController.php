<?php
namespace App\Http\Controllers;

use App\Models\Local;
use App\Models\Cliente;
use Illuminate\Http\Request;

class LocalController extends Controller
{
    public function porCliente(Cliente $cliente)
    {
        return response()->json(
            Local::where('cliente_id', $cliente->id)
                ->orderBy('direccion')
                ->get(['id','codigo','direccion','ciudad','region'])
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'direccion'  => 'required|string',
            'ciudad'     => 'required|string',
            'region'     => 'required|string',
            'codigo'     => 'nullable|string',
        ]);

        $local = Local::create($request->only('cliente_id','codigo','direccion','ciudad','region'));

        return response()->json($local);
    }
}