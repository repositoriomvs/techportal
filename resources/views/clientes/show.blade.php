@extends('layouts.app')

@section('title', $cliente->nombre)
@section('page-title', $cliente->nombre)
@section('page-subtitle', $cliente->codigo . ' · ' . $cliente->documentos->count() . ' recursos')

@section('topbar-actions')
    @role('admin')
    <a href="{{ route('documentos.create', $cliente) }}"
       class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors">
        + Subir Recurso
    </a>
    @endrole
@endsection

@section('content')

{{-- Header cliente --}}
<div class="bg-white border border-gray-200 rounded-xl p-5 mb-5 flex items-center gap-4 shadow-sm">
    <div class="w-14 h-14 rounded-xl flex items-center justify-center text-white font-bold text-xl flex-shrink-0"
         style="background-color: {{ $cliente->color }}">
        {{ $cliente->iniciales }}
    </div>
    <div class="flex-1">
        <div class="font-bold text-xl text-gray-900">{{ $cliente->nombre }}</div>
        <div class="text-sm text-gray-400 font-mono mt-0.5">
            {{ $cliente->codigo }}
            @if($cliente->contacto) · {{ $cliente->contacto }} @endif
            @if($cliente->email) · {{ $cliente->email }} @endif
        </div>
    </div>
    <div class="hidden sm:flex gap-6 text-center">
        <div>
            <div class="text-2xl font-bold text-gray-900">{{ $documentos->count() }}</div>
            <div class="text-xs text-gray-400 font-mono uppercase">Documentos</div>
        </div>
        <div>
            <div class="text-2xl font-bold text-gray-900">{{ $procedimientos->count() }}</div>
            <div class="text-xs text-gray-400 font-mono uppercase">Procedimientos</div>
        </div>
        <div>
            <div class="text-2xl font-bold text-gray-900">{{ $imagenes->count() }}</div>
            <div class="text-xs text-gray-400 font-mono uppercase">Imágenes</div>
        </div>
    </div>
    @role('admin')
    <a href="{{ route('clientes.edit', $cliente) }}"
       class="text-sm text-gray-400 hover:text-gray-600 border border-gray-200 rounded-lg px-3 py-2 transition-colors">
        ✏️ Editar
    </a>
    @endrole
</div>

{{-- Tabs --}}
<div x-data="{ tab: 'documentos' }">

    {{-- Tab buttons --}}
    <div class="flex gap-0 bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm mb-4">
        <button @click="tab = 'documentos'"
                :class="tab === 'documentos' ? 'bg-red-50 text-red-600 font-bold border-b-2 border-red-600' : 'text-gray-500 hover:bg-gray-50'"
                class="flex-1 px-4 py-3 text-sm transition-all flex items-center justify-center gap-2">
            📄 Documentos
            <span class="bg-gray-100 text-gray-600 text-xs font-mono px-2 py-0.5 rounded-full">
                {{ $documentos->count() }}
            </span>
        </button>
        <button @click="tab = 'procedimientos'"
                :class="tab === 'procedimientos' ? 'bg-red-50 text-red-600 font-bold border-b-2 border-red-600' : 'text-gray-500 hover:bg-gray-50'"
                class="flex-1 px-4 py-3 text-sm transition-all flex items-center justify-center gap-2 border-x border-gray-200">
            📋 Procedimientos
            <span class="bg-gray-100 text-gray-600 text-xs font-mono px-2 py-0.5 rounded-full">
                {{ $procedimientos->count() }}
            </span>
        </button>
        <button @click="tab = 'imagenes'"
                :class="tab === 'imagenes' ? 'bg-red-50 text-red-600 font-bold border-b-2 border-red-600' : 'text-gray-500 hover:bg-gray-50'"
                class="flex-1 px-4 py-3 text-sm transition-all flex items-center justify-center gap-2">
            🖼️ Imágenes
            <span class="bg-gray-100 text-gray-600 text-xs font-mono px-2 py-0.5 rounded-full">
                {{ $imagenes->count() }}
            </span>
        </button>
    </div>

    {{-- Tab: Documentos --}}
    <div x-show="tab === 'documentos'">
        @include('clientes.partials.tabla-recursos', ['recursos' => $documentos, 'categoria' => 'documento'])
    </div>

    {{-- Tab: Procedimientos --}}
    <div x-show="tab === 'procedimientos'">
        @include('clientes.partials.tabla-recursos', ['recursos' => $procedimientos, 'categoria' => 'procedimiento'])
    </div>

    {{-- Tab: Imágenes --}}
    <div x-show="tab === 'imagenes'">
        @include('clientes.partials.tabla-recursos', ['recursos' => $imagenes, 'categoria' => 'imagen'])
    </div>

</div>

@endsection