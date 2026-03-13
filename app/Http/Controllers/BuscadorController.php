<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Documento;
use App\Models\Herramienta;
use App\Models\HardwareModelo;
use Illuminate\Http\Request;

class BuscadorController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('q', '');
        $resultados = $this->buscar($query);
        return view('buscar.index', compact('query', 'resultados'));
    }

    public function ajax(Request $request)
    {
        $query = $request->get('q', '');
        if (strlen($query) < 2) return response()->json([]);

        $resultados = $this->buscar($query, 5);
        return response()->json($resultados);
    }

    private function buscar($query, $limit = 20)
    {
        if (!$query) return [];

        $resultados = [];

        // Clientes
        Cliente::where('nombre', 'ilike', "%{$query}%")
            ->orWhere('codigo', 'ilike', "%{$query}%")
            ->limit($limit)->get()
            ->each(function ($c) use (&$resultados) {
                $resultados[] = [
                    'tipo'     => 'cliente',
                    'icono'    => '🏢',
                    'titulo'   => $c->nombre,
                    'subtitulo'=> $c->codigo,
                    'url'      => route('clientes.show', $c),
                    'badge'    => 'Cliente',
                    'color'    => 'blue',
                ];
            });

        // Documentos
        Documento::with('cliente')
            ->where('nombre', 'ilike', "%{$query}%")
            ->orWhere('descripcion', 'ilike', "%{$query}%")
            ->limit($limit)->get()
            ->each(function ($d) use (&$resultados) {
                $resultados[] = [
                    'tipo'     => 'documento',
                    'icono'    => $d->icono ?? '📄',
                    'titulo'   => $d->nombre,
                    'subtitulo'=> $d->cliente->nombre ?? '',
                    'url'      => $d->tipo === 'PDF' ? route('documentos.ver', $d) : route('clientes.show', $d->cliente),
                    'badge'    => $d->tipo,
                    'color'    => 'red',
                ];
            });

        // Herramientas
        Herramienta::where('nombre', 'ilike', "%{$query}%")
            ->orWhere('descripcion', 'ilike', "%{$query}%")
            ->limit($limit)->get()
            ->each(function ($h) use (&$resultados) {
                $resultados[] = [
                    'tipo'     => 'herramienta',
                    'icono'    => $h->icono ?? '🔧',
                    'titulo'   => $h->nombre,
                    'subtitulo'=> $h->categoria,
                    'url'      => route('herramientas.index'),
                    'badge'    => 'Herramienta',
                    'color'    => 'green',
                ];
            });

        // Hardware modelos
        HardwareModelo::with('marca.tipo')
            ->where('nombre', 'ilike', "%{$query}%")
            ->orWhere('numero_parte', 'ilike', "%{$query}%")
            ->limit($limit)->get()
            ->each(function ($m) use (&$resultados) {
                $resultados[] = [
                    'tipo'     => 'hardware',
                    'icono'    => '🖥️',
                    'titulo'   => $m->nombre,
                    'subtitulo'=> ($m->marca->tipo->nombre ?? '') . ' · ' . ($m->marca->nombre ?? ''),
                    'url'      => route('hardware.index'),
                    'badge'    => 'Hardware',
                    'color'    => 'purple',
                ];
            });

        return $resultados;
    }
}