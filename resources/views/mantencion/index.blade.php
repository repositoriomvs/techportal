@extends('layouts.app')

@section('title', 'Órdenes de Mantención')
@section('page-title', 'Órdenes de Mantención')
@section('page-subtitle', $ordenes->count() . ' órdenes registradas')

@section('topbar-actions')
    @if(auth()->user()->hasRole('tecnico') || auth()->user()->hasRole('admin'))
    <a href="{{ route('mantencion.create') }}"
       class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors">
        + Nueva Orden
    </a>
    @endif
@endsection

@section('content')

@if($ordenes->isEmpty())
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-12 text-center">
        <div class="text-4xl mb-3">📋</div>
        <div class="text-gray-500 text-sm">No hay órdenes registradas.</div>
        <a href="{{ route('mantencion.create') }}"
           class="inline-block mt-4 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-5 py-2 rounded-lg transition-colors">
            + Crear primera orden
        </a>
    </div>
@else
<div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
    <table class="w-full">
        <thead>
            <tr class="bg-gray-50 border-b border-gray-100">
                <th class="text-left px-5 py-3 text-xs font-mono text-gray-400 uppercase tracking-wider">N° Orden</th>
                <th class="text-left px-5 py-3 text-xs font-mono text-gray-400 uppercase tracking-wider hidden sm:table-cell">Cliente</th>
                <th class="text-left px-5 py-3 text-xs font-mono text-gray-400 uppercase tracking-wider hidden md:table-cell">Técnico</th>
                <th class="text-left px-5 py-3 text-xs font-mono text-gray-400 uppercase tracking-wider hidden md:table-cell">Fecha</th>
                <th class="text-left px-5 py-3 text-xs font-mono text-gray-400 uppercase tracking-wider hidden md:table-cell">Hora Cierre</th>
                <th class="text-left px-5 py-3 text-xs font-mono text-gray-400 uppercase tracking-wider">Equipos</th>
                <th class="text-left px-5 py-3 text-xs font-mono text-gray-400 uppercase tracking-wider">Estado</th>
                <th class="text-right px-5 py-3 text-xs font-mono text-gray-400 uppercase tracking-wider">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @foreach($ordenes as $orden)
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-5 py-3">
                    <span class="text-sm font-mono font-bold text-gray-900">{{ $orden->numero_orden }}</span>
                </td>
                <td class="px-5 py-3 hidden sm:table-cell">
                    <span class="text-sm text-gray-700">{{ $orden->cliente->nombre }}</span>
                </td>
                <td class="px-5 py-3 hidden md:table-cell">
                    <span class="text-sm text-gray-500">{{ $orden->user->name }}</span>
                </td>
                <td class="px-5 py-3 hidden md:table-cell">
                    <span class="text-xs font-mono text-gray-400">{{ $orden->fecha->format('d/m/Y') }}</span>
                </td>
                <td class="px-5 py-3 hidden md:table-cell">
    @if($orden->estado === 'parcial' || !$orden->hora_termino)
        <span class="text-xs font-mono text-gray-300">—</span>
    @else
        <span class="text-xs font-mono text-gray-400">{{ \Carbon\Carbon::parse($orden->hora_termino)->format('H:i') }}</span>
    @endif
</td>
                <td class="px-5 py-3">
                    <span class="text-xs font-mono bg-gray-100 text-gray-600 px-2 py-1 rounded-full">
                        {{ $orden->equipos->count() }} equipo(s)
                    </span>
                </td>
                <td class="px-5 py-3">
                    @if($orden->estado === 'enviada')
                        <span class="text-xs font-mono font-bold px-2 py-1 rounded bg-green-50 text-green-600">
                            ✓ Enviada
                        </span>
                    @elseif($orden->estado === 'parcial')
    <span class="text-xs font-mono font-bold px-2 py-1 rounded bg-amber-50 text-amber-600">
        💾 Parcial
    </span>
@else
    <span class="text-xs font-mono font-bold px-2 py-1 rounded bg-gray-50 text-gray-500">
        Borrador
    </span>
@endif
                </td>
              <td class="px-5 py-3">
    <div class="flex items-center justify-end gap-2">
        @if($orden->estado === 'parcial')
            <a href="{{ route('mantencion.edit.parcial', $orden) }}"
               class="text-xs text-white bg-amber-500 hover:bg-amber-600 rounded px-2 py-1 transition-colors">
                ✏️ Continuar...
            </a>
        @else
            <a href="{{ route('mantencion.show', $orden) }}"
               class="text-xs text-gray-400 border border-gray-200 rounded px-2 py-1 hover:text-gray-600 transition-colors">
                👁 Ver
            </a>
            <a href="{{ route('mantencion.pdf', $orden) }}"
               class="text-xs text-white bg-red-600 hover:bg-red-700 rounded px-2 py-1 transition-colors">
                ⬇ PDF
            </a>
        @endif
    </div>
</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

@endsection
