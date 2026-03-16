@extends('layouts.app')

@section('title', $mantencion->numero_orden)
@section('page-title', $mantencion->numero_orden)
@section('page-subtitle', $mantencion->cliente->nombre . ' · ' . $mantencion->fecha->format('d/m/Y'))

@section('topbar-actions')
    <a href="{{ route('mantencion.index') }}"
       class="text-sm text-gray-500 hover:text-gray-700 border border-gray-200 px-4 py-2 rounded-lg transition-colors">
        ← Volver
    </a>
    <a href="{{ route('mantencion.pdf', $mantencion) }}"
       class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors">
        ⬇ Descargar PDF
    </a>
@endsection

@section('content')

{{-- INFO SERVICIO --}}
<div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden mb-5">
    <div class="px-5 py-3 border-b border-gray-100 bg-gray-50 flex items-center gap-2">
        <span>📋</span><span class="font-bold text-gray-900 text-sm">Datos del Servicio</span>
    </div>
    <div class="p-5 grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div>
            <div class="text-xs font-mono text-gray-400 uppercase tracking-wider mb-1">Fecha</div>
            <div class="text-sm font-semibold">{{ $mantencion->fecha->format('d/m/Y') }}</div>
        </div>
        <div>
            <div class="text-xs font-mono text-gray-400 uppercase tracking-wider mb-1">Hora inicio</div>
            <div class="text-sm font-semibold font-mono">{{ $mantencion->hora_inicio }}</div>
        </div>
        <div>
            <div class="text-xs font-mono text-gray-400 uppercase tracking-wider mb-1">Hora término</div>
            <div class="text-sm font-semibold font-mono">{{ $mantencion->hora_termino ?? '—' }}</div>
        </div>
        <div>
            <div class="text-xs font-mono text-gray-400 uppercase tracking-wider mb-1">Técnico</div>
            <div class="text-sm font-semibold">{{ $mantencion->user->name }}</div>
        </div>
        <div>
            <div class="text-xs font-mono text-gray-400 uppercase tracking-wider mb-1">Cliente</div>
            <div class="text-sm font-semibold">{{ $mantencion->cliente->nombre }}</div>
        </div>
        <div>
            <div class="text-xs font-mono text-gray-400 uppercase tracking-wider mb-1">Código local</div>
            <div class="text-sm font-semibold font-mono">{{ $mantencion->codigo_local }}</div>
        </div>
        <div>
            <div class="text-xs font-mono text-gray-400 uppercase tracking-wider mb-1">Ciudad</div>
            <div class="text-sm font-semibold">{{ $mantencion->ciudad }}</div>
        </div>
        <div>
            <div class="text-xs font-mono text-gray-400 uppercase tracking-wider mb-1">Dirección</div>
            <div class="text-sm font-semibold">{{ $mantencion->direccion }}</div>
        </div>
    </div>
</div>

{{-- EQUIPOS --}}
@foreach($mantencion->equipos as $equipo)
<div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden mb-5">
    <div class="px-5 py-3 border-b border-gray-100 bg-gray-50 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <span>🖥️</span>
            <span class="font-bold text-gray-900 text-sm">{{ $equipo->tipo_label }}</span>
        </div>
        @php
            $estadoColor = match($equipo->estado_final) {
                'operativo' => 'bg-green-50 text-green-700',
                'operativo_con_observaciones' => 'bg-amber-50 text-amber-700',
                'defectuoso' => 'bg-red-50 text-red-700',
                default => 'bg-gray-50 text-gray-500'
            };
            $estadoLabel = match($equipo->estado_final) {
                'operativo' => '✅ Operativo',
                'operativo_con_observaciones' => '⚠️ Operativo c/obs.',
                'defectuoso' => '❌ Defectuoso',
                default => '—'
            };
        @endphp
        <span class="text-xs font-mono font-bold px-3 py-1 rounded-full {{ $estadoColor }}">
            {{ $estadoLabel }}
        </span>
    </div>
    <div class="p-5 grid grid-cols-2 sm:grid-cols-4 gap-4 border-b border-gray-100">
        <div>
            <div class="text-xs font-mono text-gray-400 uppercase mb-1">Marca</div>
            <div class="text-sm font-semibold">{{ $equipo->marca }}</div>
        </div>
        <div>
            <div class="text-xs font-mono text-gray-400 uppercase mb-1">Modelo</div>
            <div class="text-sm font-semibold">{{ $equipo->modelo }}</div>
        </div>
        <div class="col-span-2">
            <div class="text-xs font-mono text-gray-400 uppercase mb-1">N° Serie</div>
            <div class="text-sm font-semibold font-mono">{{ $equipo->serie }}</div>
        </div>
    </div>

    {{-- Checklist --}}
    @php $secciones = $equipo->respuestas->groupBy('item.seccion'); @endphp
    @foreach($secciones as $seccion => $respuestas)
    <div class="px-5 py-2 bg-gray-50 border-b border-gray-100">
        <span class="text-xs font-bold text-gray-600 uppercase tracking-wider">{{ $seccion }}</span>
    </div>
    @foreach($respuestas as $resp)
    @php
        $rColor = match($resp->respuesta) {
            'operativo','realizado' => 'bg-green-50 text-green-700',
            'defectuoso','no_realizado' => 'bg-red-50 text-red-700',
            default => 'bg-gray-100 text-gray-500'
        };
        $rLabel = match($resp->respuesta) {
            'operativo'=>'Operativo','defectuoso'=>'Defectuoso',
            'realizado'=>'Realizado','no_realizado'=>'No realizado',
            'no_aplica'=>'No aplica', default=>$resp->respuesta
        };
    @endphp
    <div class="flex items-center justify-between px-5 py-2.5 border-b border-gray-50 last:border-b-0">
        <span class="text-sm text-gray-700 flex items-center gap-2">
            {{ $resp->item->descripcion }}
            @if($resp->item->es_critico)
                <span class="text-xs font-mono bg-amber-50 text-amber-600 border border-amber-200 px-2 py-0.5 rounded-full">Crítico</span>
            @endif
        </span>
        <span class="text-xs font-mono font-bold px-3 py-1 rounded {{ $rColor }}">{{ $rLabel }}</span>
    </div>
    @endforeach
    @endforeach

    {{-- Observaciones --}}
    <div class="px-5 py-3 border-t border-gray-100 bg-amber-50">
        <div class="text-xs font-mono text-gray-400 uppercase mb-1">Observaciones</div>
        <div class="text-sm text-gray-700">{{ $equipo->observaciones }}</div>
    </div>

    {{-- Fotos --}}
    @if($equipo->foto_equipo || $equipo->foto_serie)
    <div class="px-5 py-3 border-t border-gray-100 grid grid-cols-2 gap-4">
        @if($equipo->foto_equipo)
        <div>
            <div class="text-xs font-mono text-gray-400 uppercase mb-1">Foto equipo</div>
            <img src="{{ Storage::url($equipo->foto_equipo) }}" class="rounded-lg border border-gray-200 w-full object-cover" style="max-height:140px;">
        </div>
        @endif
        @if($equipo->foto_serie)
        <div>
            <div class="text-xs font-mono text-gray-400 uppercase mb-1">Foto serie</div>
            <img src="{{ Storage::url($equipo->foto_serie) }}" class="rounded-lg border border-gray-200 w-full object-cover" style="max-height:140px;">
        </div>
        @endif
    </div>
    @endif
</div>
@endforeach

{{-- FIRMA --}}
<div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden mb-5">
    <div class="px-5 py-3 border-b border-gray-100 bg-gray-50 flex items-center gap-2">
        <span>✍️</span><span class="font-bold text-gray-900 text-sm">Recepción del Servicio</span>
    </div>
    <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <div class="text-xs font-mono text-gray-400 uppercase mb-1">Nombre</div>
            <div class="text-sm font-semibold">{{ $mantencion->firma_nombre }}</div>
        </div>
        <div>
            <div class="text-xs font-mono text-gray-400 uppercase mb-1">Cargo</div>
            <div class="text-sm font-semibold">{{ $mantencion->firma_cargo }}</div>
        </div>
        @if($mantencion->firma_imagen)
        <div class="sm:col-span-2">
            <div class="text-xs font-mono text-gray-400 uppercase mb-1">Firma</div>
            <div class="border border-gray-200 rounded-lg p-3 bg-gray-50 inline-block">
                <img src="{{ $mantencion->firma_imagen }}" class="max-h-20">
            </div>
        </div>
        @endif
    </div>
</div>

@endsection