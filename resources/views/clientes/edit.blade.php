@extends('layouts.app')

@section('title', 'Editar Cliente')
@section('page-title', 'Editar Cliente')
@section('page-subtitle', $cliente->nombre)

@section('content')

<div class="max-w-2xl">
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">

        <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center text-white font-bold flex-shrink-0"
                 style="background-color: {{ $cliente->color }}">
                {{ $cliente->iniciales }}
            </div>
            <div>
                <div class="font-bold text-gray-900">{{ $cliente->nombre }}</div>
                <div class="text-xs text-gray-400 font-mono">{{ $cliente->codigo }}</div>
            </div>
        </div>

        <form method="POST" action="{{ route('clientes.update', $cliente) }}" class="p-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">

                {{-- Nombre --}}
                <div class="sm:col-span-2">
                    <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">
                        Nombre <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nombre" value="{{ old('nombre', $cliente->nombre) }}" required
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all
                                  {{ $errors->has('nombre') ? 'border-red-400' : '' }}">
                    @error('nombre') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Código --}}
                <div>
                    <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">
                        Código <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="codigo" value="{{ old('codigo', $cliente->codigo) }}" required
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm font-mono focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all
                                  {{ $errors->has('codigo') ? 'border-red-400' : '' }}">
                    @error('codigo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Color --}}
                <div>
                    <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">
                        Color Avatar
                    </label>
                    <div class="flex items-center gap-3">
                        <input type="color" name="color" value="{{ old('color', $cliente->color) }}"
                               class="w-10 h-10 rounded-lg border border-gray-200 cursor-pointer p-1">
                        <span class="text-xs text-gray-400">Color del avatar del cliente</span>
                    </div>
                </div>

                {{-- Contacto --}}
                <div>
                    <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">
                        Contacto
                    </label>
                    <input type="text" name="contacto" value="{{ old('contacto', $cliente->contacto) }}"
                           placeholder="Nombre del contacto"
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all">
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">
                        Email
                    </label>
                    <input type="email" name="email" value="{{ old('email', $cliente->email) }}"
                           placeholder="contacto@empresa.com"
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all">
                </div>

                {{-- Teléfono --}}
                <div>
                    <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">
                        Teléfono
                    </label>
                    <input type="text" name="telefono" value="{{ old('telefono', $cliente->telefono) }}"
                           placeholder="+56 9 1234 5678"
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all">
                </div>

                {{-- Estado --}}
                <div>
                    <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">
                        Estado
                    </label>
                    <select name="estado"
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all">
                        <option value="activo"   {{ old('estado', $cliente->estado) === 'activo'   ? 'selected' : '' }}>Activo</option>
                        <option value="inactivo" {{ old('estado', $cliente->estado) === 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>

                {{-- Notas --}}
                <div class="sm:col-span-2">
                    <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">
                        Notas
                    </label>
                    <textarea name="notas" rows="3"
                              placeholder="Información adicional del cliente..."
                              class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all resize-none">{{ old('notas', $cliente->notas) }}</textarea>
                </div>

            </div>

            <div class="flex items-center gap-3 pt-2 border-t border-gray-100">
                <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-2.5 rounded-lg text-sm transition-colors">
                    Guardar Cambios
                </button>
                <a href="{{ route('clientes.show', $cliente) }}"
                   class="text-sm text-gray-500 hover:text-gray-700 border border-gray-200 px-6 py-2.5 rounded-lg transition-colors">
                    Cancelar
                </a>
                <a href="{{ route('clientes.index') }}"
                   class="text-sm text-gray-400 hover:text-gray-600 ml-auto">
                    ← Volver al listado
                </a>
            </div>

        </form>
    </div>
</div>

@endsection