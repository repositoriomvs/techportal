@extends('layouts.app')

@section('title', 'Usuarios')
@section('page-title', 'Usuarios')
@section('page-subtitle', $usuarios->count() . ' usuarios registrados')

@section('topbar-actions')
    <a href="{{ route('usuarios.create') }}"
       class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors">
        + Nuevo Usuario
    </a>
@endsection

@section('content')

<div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
    <table class="w-full">
        <thead>
            <tr class="bg-gray-50 border-b border-gray-100">
                <th class="text-left px-5 py-3 text-xs font-mono text-gray-400 uppercase tracking-wider">Usuario</th>
                <th class="text-left px-5 py-3 text-xs font-mono text-gray-400 uppercase tracking-wider hidden sm:table-cell">Email</th>
                <th class="text-left px-5 py-3 text-xs font-mono text-gray-400 uppercase tracking-wider">Rol</th>
                <th class="text-left px-5 py-3 text-xs font-mono text-gray-400 uppercase tracking-wider hidden md:table-cell">Creado</th>
                <th class="text-right px-5 py-3 text-xs font-mono text-gray-400 uppercase tracking-wider">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @foreach($usuarios as $usuario)
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-5 py-3">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-red-600 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                            {{ strtoupper(substr($usuario->name, 0, 2)) }}
                        </div>
                        <div class="font-medium text-sm text-gray-900">
                            {{ $usuario->name }}
                            @if($usuario->id === auth()->id())
                                <span class="text-xs text-gray-400 font-mono">(vos)</span>
                            @endif
                        </div>
                    </div>
                </td>
                <td class="px-5 py-3 hidden sm:table-cell">
                    <span class="text-sm text-gray-500 font-mono">{{ $usuario->email }}</span>
                </td>
                <td class="px-5 py-3">
                    @foreach($usuario->roles as $role)
                        <span class="text-xs font-mono font-bold px-2 py-1 rounded
                            {{ $role->name === 'admin' ? 'bg-red-50 text-red-600' : 'bg-blue-50 text-blue-600' }}">
                            {{ $role->name === 'admin' ? '🛡️ Admin' : '🔧 Técnico' }}
                        </span>
                    @endforeach
                </td>
                <td class="px-5 py-3 hidden md:table-cell">
                    <span class="text-xs text-gray-400 font-mono">{{ $usuario->created_at->format('d/m/Y') }}</span>
                </td>
                <td class="px-5 py-3">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('usuarios.edit', $usuario) }}"
                           class="text-xs text-gray-400 border border-gray-200 rounded px-2 py-1 hover:text-gray-600 transition-colors">
                            ✏️ Editar
                        </a>
                        @if($usuario->id !== auth()->id())
                        <form method="POST" action="{{ route('usuarios.destroy', $usuario) }}"
                              onsubmit="return confirm('¿Eliminar a {{ $usuario->name }}?')">
                            @csrf @method('DELETE')
                            <button class="text-xs text-red-400 border border-red-100 rounded px-2 py-1 hover:text-red-600 transition-colors">
                                🗑️
                            </button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection