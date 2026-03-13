@extends('layouts.app')

@section('title', 'Clientes')
@section('page-title', 'Clientes')
@section('page-subtitle', $clientes->count() . ' clientes registrados')

@section('topbar-actions')
    @if(auth()->user()->hasRole('admin'))
    <a href="{{ route('clientes.create') }}"
       class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors">
        + Nuevo Cliente
    </a>
    @endif
@endsection

@section('content')

@if($clientes->isEmpty())
    <div class="bg-white border border-gray-200 rounded-xl p-16 text-center">
        <div class="text-5xl mb-4">🏢</div>
        <div class="text-gray-500 text-sm">No hay clientes registrados aún.</div>
        @role('admin')
        <a href="{{ route('clientes.create') }}"
           class="inline-block mt-4 bg-red-600 text-white text-sm font-semibold px-6 py-2 rounded-lg hover:bg-red-700">
            + Crear primer cliente
        </a>
        @endrole
    </div>
@else
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
    @foreach($clientes as $cliente)
    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all">

        {{-- Top --}}
        <div class="p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white font-bold text-lg flex-shrink-0"
                 style="background-color: {{ $cliente->color }}">
                {{ $cliente->iniciales }}
            </div>
            <div class="flex-1 min-w-0">
                <div class="font-bold text-gray-900 truncate">{{ $cliente->nombre }}</div>
                <div class="text-xs text-gray-400 font-mono">{{ $cliente->codigo }}</div>
            </div>
            <span class="text-xs font-mono font-semibold px-2 py-1 rounded
                {{ $cliente->estado === 'activo' ? 'bg-green-50 text-green-600' : 'bg-gray-100 text-gray-400' }}">
                {{ $cliente->estado }}
            </span>
        </div>

        {{-- Stats --}}
        <div class="px-5 py-3 bg-gray-50 border-t border-gray-100 grid grid-cols-3 gap-2">
            <div class="text-center">
                <div class="text-lg font-bold text-gray-900">
                    {{ $cliente->documentos()->where('categoria', 'documento')->count() }}
                </div>
                <div class="text-xs text-gray-400 font-mono uppercase">Docs</div>
            </div>
            <div class="text-center">
                <div class="text-lg font-bold text-gray-900">
                    {{ $cliente->documentos()->where('categoria', 'procedimiento')->count() }}
                </div>
                <div class="text-xs text-gray-400 font-mono uppercase">Procs</div>
            </div>
            <div class="text-center">
                <div class="text-lg font-bold text-gray-900">
                    {{ $cliente->documentos()->where('categoria', 'imagen')->count() }}
                </div>
                <div class="text-xs text-gray-400 font-mono uppercase">Imgs</div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="px-5 py-3 border-t border-gray-100 flex items-center justify-between">
            <a href="{{ route('clientes.show', $cliente) }}"
               class="text-sm text-red-600 font-semibold hover:text-red-700">
                Ver repositorio →
            </a>
            @role('admin')
            <div class="flex gap-2">
                <a href="{{ route('clientes.edit', $cliente) }}"
                   class="text-xs text-gray-400 hover:text-gray-600 border border-gray-200 rounded px-2 py-1 transition-colors">
                    ✏️ Editar
                </a>
                <form method="POST" action="{{ route('clientes.destroy', $cliente) }}"
                      onsubmit="return confirm('¿Eliminar {{ $cliente->nombre }}?')">
                    @csrf @method('DELETE')
                    <button class="text-xs text-red-400 hover:text-red-600 border border-red-100 rounded px-2 py-1 transition-colors">
                        🗑️
                    </button>
                </form>
            </div>
            @endrole
        </div>
    </div>
    @endforeach
</div>
@endif

@endsection