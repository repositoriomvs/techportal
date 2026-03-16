<?php
namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\SlaCliente;
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
            'tiene_sla'                  => 'nullable|boolean',
            'sla.*.horas_respuesta'      => 'nullable|integer|min:0',
            'sla.*.horas_resolucion'     => 'nullable|integer|min:0',
            'sla.*.horas_cambio_equipo'  => 'nullable|integer|min:0',
        ]);

        $cliente = Cliente::create([
            'nombre'   => $request->nombre,
            'codigo'   => $request->codigo,
            'contacto' => $request->contacto,
            'email'    => $request->email,
            'telefono' => $request->telefono,
            'color'    => $request->color,
            'estado'   => $request->estado ?? 'activo',
            'notas'    => $request->notas,
        ]);

        if ($request->boolean('tiene_sla') && $request->has('sla')) {
            foreach ($request->sla as $prioridad => $valores) {
                SlaCliente::create([
                    'cliente_id'          => $cliente->id,
                    'prioridad'           => $prioridad,
                    'horas_respuesta'     => $valores['horas_respuesta']     ?? 0,
                    'horas_resolucion'    => $valores['horas_resolucion']    ?? 0,
                    'horas_cambio_equipo' => $valores['horas_cambio_equipo'] ?? 0,
                ]);
            }
        }

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente creado correctamente.');
    }

    public function show(Cliente $cliente)
    {
        $documentos     = $cliente->documentos()->where('categoria', 'documento')->get();
        $procedimientos = $cliente->documentos()->where('categoria', 'procedimiento')->get();
        $imagenes       = $cliente->documentos()->where('categoria', 'imagen')->get();
        $slas           = $cliente->slas()->orderByRaw("FIELD(prioridad, 'alta', 'media', 'baja')")->get()->keyBy('prioridad');
        return view('clientes.show', compact('cliente', 'documentos', 'procedimientos', 'imagenes', 'slas'));
    }

    public function edit(Cliente $cliente)
    {
        $slas = $cliente->slas()->get()->keyBy('prioridad');
        return view('clientes.edit', compact('cliente', 'slas'));
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
            'tiene_sla'                  => 'nullable|boolean',
            'sla.*.horas_respuesta'      => 'nullable|integer|min:0',
            'sla.*.horas_resolucion'     => 'nullable|integer|min:0',
            'sla.*.horas_cambio_equipo'  => 'nullable|integer|min:0',
        ]);

        $cliente->update([
            'nombre'   => $request->nombre,
            'codigo'   => $request->codigo,
            'contacto' => $request->contacto,
            'email'    => $request->email,
            'telefono' => $request->telefono,
            'color'    => $request->color,
            'estado'   => $request->estado ?? $cliente->estado,
            'notas'    => $request->notas,
        ]);

        // Eliminar SLAs existentes y recrear
        $cliente->slas()->delete();

        if ($request->boolean('tiene_sla') && $request->has('sla')) {
            foreach ($request->sla as $prioridad => $valores) {
                SlaCliente::create([
                    'cliente_id'          => $cliente->id,
                    'prioridad'           => $prioridad,
                    'horas_respuesta'     => $valores['horas_respuesta']     ?? 0,
                    'horas_resolucion'    => $valores['horas_resolucion']    ?? 0,
                    'horas_cambio_equipo' => $valores['horas_cambio_equipo'] ?? 0,
                ]);
            }
        }

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente actualizado correctamente.');
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->slas()->delete();
        $cliente->delete();
        return redirect()->route('clientes.index')
            ->with('success', 'Cliente eliminado.');
    }
}
