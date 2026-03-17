@extends('layouts.app')

@section('title', 'Gestión de Clientes')
@section('page-title', 'Gestión de Clientes')
@section('page-subtitle', $clientes->count() . ' clientes registrados')

@section('topbar-actions')
    <a href="{{ route('clientes.create') }}"
       class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors">
        + Agregar Cliente
    </a>
@endsection

@section('content')

@if($clientes->isEmpty())
    <div class="bg-white border border-gray-200 rounded-xl p-16 text-center">
        <div class="text-5xl mb-4">🏢</div>
        <div class="text-gray-500 text-sm mb-4">No hay clientes registrados aún.</div>
        <a href="{{ route('clientes.create') }}"
           class="inline-block bg-red-600 text-white text-sm font-semibold px-6 py-2 rounded-lg hover:bg-red-700">
            + Crear primer cliente
        </a>
    </div>
@else
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Cliente</th>
                    <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Código</th>
                    <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Contacto</th>
                    <th class="px-5 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Estado</th>
                    <th class="px-5 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">SLA</th>
                    <th class="px-5 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Recursos</th>
                    <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($clientes as $cliente)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl flex items-center justify-center text-white font-bold text-sm flex-shrink-0"
                                 style="background-color: {{ $cliente->color }}">
                                {{ $cliente->iniciales }}
                            </div>
                            <div>
                                <div class="font-semibold text-gray-900">{{ $cliente->nombre }}</div>
                                @if($cliente->email)
                                <div class="text-xs text-gray-400 font-mono">{{ $cliente->email }}</div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-3">
                        <span class="font-mono text-xs text-gray-600">{{ $cliente->codigo }}</span>
                    </td>
                    <td class="px-5 py-3 text-gray-500 text-xs">
                        {{ $cliente->contacto ?? '—' }}
                        @if($cliente->telefono)
                        <div class="font-mono text-gray-400">{{ $cliente->telefono }}</div>
                        @endif
                    </td>
                    <td class="px-5 py-3 text-center">
                        <span class="text-xs font-mono font-semibold px-2 py-1 rounded
                            {{ $cliente->estado === 'activo' ? 'bg-green-50 text-green-600' : 'bg-gray-100 text-gray-400' }}">
                            {{ $cliente->estado }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-center">
                        @if($cliente->tiene_sla)
                            <span class="text-xs font-mono font-semibold px-2 py-1 rounded bg-blue-50 text-blue-600">✓ SLA</span>
                        @else
                            <span class="text-xs text-gray-300">—</span>
                        @endif
                    </td>
                    <td class="px-5 py-3 text-center">
                        <span class="text-xs font-mono text-gray-500">{{ $cliente->documentos_count }}</span>
                    </td>
                    <td class="px-5 py-3">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('clientes.show', $cliente) }}"
                               class="text-xs text-gray-400 hover:text-gray-600 border border-gray-200 rounded px-2 py-1 transition-colors">
                                👁 Ver
                            </a>
                            <a href="{{ route('clientes.edit', $cliente) }}"
                               class="text-xs text-gray-400 hover:text-gray-600 border border-gray-200 rounded px-2 py-1 transition-colors">
                                ✏️ Editar
                            </a>
                            <form method="POST" action="{{ route('clientes.destroy', $cliente) }}"
                                  onsubmit="return confirm('¿Eliminar {{ $cliente->nombre }}? Esta acción no se puede deshacer.')">
                                @csrf @method('DELETE')
                                <button class="text-xs text-red-400 hover:text-red-600 border border-red-100 rounded px-2 py-1 transition-colors">
                                    🗑️
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif

@endsection