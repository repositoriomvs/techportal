@extends('layouts.app')

@section('title', 'Editar Recurso')
@section('page-title', 'Editar Recurso')
@section('page-subtitle', $recurso->modelo->nombre ?? 'Hardware')

@section('topbar-actions')
    <a href="{{ route('hardware.index') }}"
       class="text-sm text-gray-500 hover:text-gray-700 border border-gray-200 px-4 py-2 rounded-lg transition-colors">
        ← Volver
    </a>
@endsection

@section('content')
@if($errors->any())
    <div class="mb-4 bg-red-50 border border-red-200 text-red-800 rounded-lg px-4 py-3 text-sm">
        <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
@endif

<div class="max-w-2xl">
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">

        <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
            <span class="text-2xl">{{ $recurso->icono }}</span>
            <div>
                <div class="font-bold text-gray-900">{{ $recurso->nombre }}</div>
                <div class="text-xs text-gray-400 font-mono">
                    {{ $recurso->modelo->marca->tipo->nombre ?? '' }} ·
                    {{ $recurso->modelo->marca->nombre ?? '' }} ·
                    {{ $recurso->modelo->nombre ?? '' }}
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('hardware.recursos.update', $recurso) }}"
              enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">

                <div class="sm:col-span-2">
                    <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">Nombre *</label>
                    <input type="text" name="nombre" value="{{ old('nombre', $recurso->nombre) }}" required
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all">
                </div>

                <div>
                    <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">Categoría *</label>
                    <select name="categoria" required
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all">
                        <option value="manual_tecnico" {{ old('categoria', $recurso->categoria) === 'manual_tecnico' ? 'selected' : '' }}>📄 Manual Técnico</option>
                        <option value="list_part"      {{ old('categoria', $recurso->categoria) === 'list_part'      ? 'selected' : '' }}>🔩 List Part</option>
                        <option value="firmware"       {{ old('categoria', $recurso->categoria) === 'firmware'       ? 'selected' : '' }}>💾 Firmware</option>
                        <option value="procedimiento"  {{ old('categoria', $recurso->categoria) === 'procedimiento'  ? 'selected' : '' }}>📋 Procedimiento</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">Tipo *</label>
                    <select name="tipo" required
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all">
                        <option value="PDF"  {{ old('tipo', $recurso->tipo) === 'PDF'  ? 'selected' : '' }}>PDF</option>
                        <option value="ISO"  {{ old('tipo', $recurso->tipo) === 'ISO'  ? 'selected' : '' }}>ISO</option>
                        <option value="EXE"  {{ old('tipo', $recurso->tipo) === 'EXE'  ? 'selected' : '' }}>EXE</option>
                        <option value="ZIP"  {{ old('tipo', $recurso->tipo) === 'ZIP'  ? 'selected' : '' }}>ZIP</option>
                        <option value="LINK" {{ old('tipo', $recurso->tipo) === 'LINK' ? 'selected' : '' }}>LINK</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">Versión</label>
                    <input type="text" name="version" value="{{ old('version', $recurso->version) }}"
                           placeholder="Ej: v2.0"
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all">
                </div>

                <div>
                    <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">URL externa</label>
                    <input type="url" name="url" value="{{ old('url', $recurso->url) }}"
                           placeholder="https://..."
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all">
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">Descripción</label>
                    <textarea name="descripcion" rows="2"
                              class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all resize-none">{{ old('descripcion', $recurso->descripcion) }}</textarea>
                </div>

                @if($recurso->archivo)
                <div class="sm:col-span-2">
                    <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">Archivo actual</label>
                    <div class="flex items-center gap-3 bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5">
                        <span class="text-xl">{{ $recurso->icono }}</span>
                        <span class="text-sm text-gray-700 font-mono flex-1 truncate">{{ basename($recurso->archivo) }}</span>
                        <span class="text-xs text-gray-400">{{ $recurso->tamanio }}</span>
                    </div>
                </div>
                @endif

                <div class="sm:col-span-2">
                    <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">
                        {{ $recurso->archivo ? 'Reemplazar archivo' : 'Subir archivo' }}
                        <span class="text-gray-300 normal-case">(opcional)</span>
                    </label>
                    <div class="border-2 border-dashed border-gray-200 rounded-lg p-5 text-center hover:border-red-300 transition-colors">
                        <div class="text-2xl mb-1">📁</div>
                        <label class="cursor-pointer text-sm text-red-600 font-semibold hover:text-red-700">
                            Seleccionar archivo
                            <input type="file" name="archivo" class="hidden"
                                   onchange="document.getElementById('new-filename').textContent = this.files[0]?.name ?? ''">
                        </label>
                        <div id="new-filename" class="text-xs text-gray-400 mt-1 font-mono"></div>
                    </div>
                </div>

            </div>

            <div class="flex items-center gap-3 pt-2 border-t border-gray-100">
                <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-2.5 rounded-lg text-sm transition-colors">
                    Guardar Cambios
                </button>
                <a href="{{ route('hardware.index') }}"
                   class="text-sm text-gray-500 hover:text-gray-700 border border-gray-200 px-6 py-2.5 rounded-lg transition-colors">
                    Cancelar
                </a>
            </div>

        </form>
    </div>
</div>

@endsection
