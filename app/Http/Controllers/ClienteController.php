<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::withCount('documentos')->orderBy('nombre')->get();
        return view('clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('clientes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'   => 'required|string|max:255',
            'codigo'   => 'required|string|unique:clientes,codigo',
            'contacto' => 'nullable|string|max:255',
            'email'    => 'nullable|email',
            'telefono' => 'nullable|string|max:50',
            'color'    => 'nullable|string|max:7',
            'notas'    => 'nullable|string',
        ]);

        Cliente::create($request->all());

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente creado correctamente.');
    }

    public function show(Cliente $cliente)
    {
        $documentos     = $cliente->documentos()->where('categoria', 'documento')->get();
        $procedimientos = $cliente->documentos()->where('categoria', 'procedimiento')->get();
        $imagenes       = $cliente->documentos()->where('categoria', 'imagen')->get();

        return view('clientes.show', compact('cliente', 'documentos', 'procedimientos', 'imagenes'));
    }

    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([
            'nombre'   => 'required|string|max:255',
            'codigo'   => 'required|string|unique:clientes,codigo,' . $cliente->id,
            'contacto' => 'nullable|string|max:255',
            'email'    => 'nullable|email',
            'telefono' => 'nullable|string|max:50',
            'color'    => 'nullable|string|max:7',
            'notas'    => 'nullable|string',
        ]);

        $cliente->update($request->all());

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente actualizado correctamente.');
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return redirect()->route('clientes.index')
            ->with('success', 'Cliente eliminado.');
    }
}