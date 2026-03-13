<?php

namespace App\Http\Controllers;

use App\Models\HardwareTipo;
use App\Models\HardwareMarca;
use App\Models\HardwareModelo;
use Illuminate\Http\Request;

class HardwareController extends Controller
{
    public function index()
    {
        $tipos = HardwareTipo::with('marcas.modelos.recursos')->orderBy('nombre')->get();
        return view('hardware.index', compact('tipos'));
    }

    public function storeTipo(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'icono'  => 'nullable|string|max:10',
        ]);
        HardwareTipo::create($request->only('nombre', 'icono'));
        return back()->with('success', 'Tipo creado correctamente.');
    }

    public function destroyTipo(HardwareTipo $tipo)
    {
        $tipo->delete();
        return back()->with('success', 'Tipo eliminado.');
    }

    public function storeMarca(Request $request)
    {
        $request->validate([
            'hardware_tipo_id' => 'required|exists:hardware_tipos,id',
            'nombre'           => 'required|string|max:255',
        ]);
        HardwareMarca::create($request->only('hardware_tipo_id', 'nombre', 'icono'));
        return back()->with('success', 'Marca creada correctamente.');
    }

    public function destroyMarca(HardwareMarca $marca)
    {
        $marca->delete();
        return back()->with('success', 'Marca eliminada.');
    }

    public function storeModelo(Request $request)
    {
        $request->validate([
            'hardware_marca_id' => 'required|exists:hardware_marcas,id',
            'nombre'            => 'required|string|max:255',
            'numero_parte'      => 'nullable|string|max:255',
            'descripcion'       => 'nullable|string',
        ]);
        HardwareModelo::create($request->only('hardware_marca_id', 'nombre', 'numero_parte', 'descripcion'));
        return back()->with('success', 'Modelo creado correctamente.');
    }

    public function destroyModelo(HardwareModelo $modelo)
    {
        $modelo->delete();
        return back()->with('success', 'Modelo eliminado.');
    }
}