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
    public function adminIndex()
{
    $clientes = Cliente::withCount('documentos')->orderBy('nombre')->get();
    return view('admin.gestionclientes', compact('clientes'));
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
            'tiene_sla'              => 'nullable|boolean',
            'sla_horas_respuesta'    => 'nullable|integer|min:0',
            'sla_horas_resolucion'   => 'nullable|integer|min:0',
            'sla_horas_cambio_equipo'=> 'nullable|integer|min:0',
        ]);

        $tiene_sla = $request->boolean('tiene_sla');

        Cliente::create([
            'nombre'                 => $request->nombre,
            'codigo'                 => $request->codigo,
            'contacto'               => $request->contacto,
            'email'                  => $request->email,
            'telefono'               => $request->telefono,
            'color'                  => $request->color,
            'estado'                 => $request->estado ?? 'activo',
            'notas'                  => $request->notas,
            'tiene_sla'              => $tiene_sla,
            'sla_horas_respuesta'    => $tiene_sla ? ($request->sla_horas_respuesta    ?? 0) : 0,
            'sla_horas_resolucion'   => $tiene_sla ? ($request->sla_horas_resolucion   ?? 0) : 0,
            'sla_horas_cambio_equipo'=> $tiene_sla ? ($request->sla_horas_cambio_equipo ?? 0) : 0,
        ]);

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
            'tiene_sla'              => 'nullable|boolean',
            'sla_horas_respuesta'    => 'nullable|integer|min:0',
            'sla_horas_resolucion'   => 'nullable|integer|min:0',
            'sla_horas_cambio_equipo'=> 'nullable|integer|min:0',
        ]);

        $tiene_sla = $request->boolean('tiene_sla');

        $cliente->update([
            'nombre'                 => $request->nombre,
            'codigo'                 => $request->codigo,
            'contacto'               => $request->contacto,
            'email'                  => $request->email,
            'telefono'               => $request->telefono,
            'color'                  => $request->color,
            'estado'                 => $request->estado ?? $cliente->estado,
            'notas'                  => $request->notas,
            'tiene_sla'              => $tiene_sla,
            'sla_horas_respuesta'    => $tiene_sla ? ($request->sla_horas_respuesta    ?? 0) : 0,
            'sla_horas_resolucion'   => $tiene_sla ? ($request->sla_horas_resolucion   ?? 0) : 0,
            'sla_horas_cambio_equipo'=> $tiene_sla ? ($request->sla_horas_cambio_equipo ?? 0) : 0,
        ]);

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
