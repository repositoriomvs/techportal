@extends('layouts.app')

@section('title', 'Editar Usuario')
@section('page-title', 'Editar Usuario')
@section('page-subtitle', $usuario->name)

@section('content')

<div class="max-w-lg">
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">

        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="font-bold text-gray-900">Editar datos</h2>
        </div>

        <form method="POST" action="{{ route('usuarios.update', $usuario) }}" class="p-6">
            @csrf @method('PUT')

            <div class="flex flex-col gap-4">

                <div>
                    <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">Nombre completo</label>
                    <input type="text" name="name" value="{{ old('name', $usuario->name) }}" required
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', $usuario->email) }}" required
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">Rol</label>
                    <select name="role" required
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all">
                        @foreach($roles as $role)
                        <option value="{{ $role->name }}"
                            {{ $usuario->hasRole($role->name) ? 'selected' : '' }}>
                            {{ $role->name === 'admin' ? '🛡️ Administrador' : '🔧 Técnico' }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">
                        Nueva Contraseña <span class="text-gray-300">(dejar vacío para no cambiar)</span>
                    </label>
                    <input type="password" name="password"
                           placeholder="Nueva contraseña"
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all">
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">Confirmar Nueva Contraseña</label>
                    <input type="password" name="password_confirmation"
                           placeholder="Ingresa nuevamente la contraseña"
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all">
                </div>

            </div>

            <div class="flex items-center gap-3 pt-4 mt-4 border-t border-gray-100">
                <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-2.5 rounded-lg text-sm transition-colors">
                    Guardar Cambios
                </button>
                <a href="{{ route('usuarios.index') }}"
                   class="text-sm text-gray-500 hover:text-gray-700 border border-gray-200 px-6 py-2.5 rounded-lg transition-colors">
                    Cancelar
                </a>
            </div>

        </form>
    </div>
</div>

@endsection