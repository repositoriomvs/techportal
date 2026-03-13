@extends('layouts.app')

@section('title', 'Subir Recurso')
@section('page-title', 'Subir Recurso')
@section('page-subtitle', $cliente->nombre)

@section('content')

<div class="max-w-2xl">
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">

        <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center text-white text-sm font-bold flex-shrink-0"
                 style="background-color: {{ $cliente->color }}">
                {{ $cliente->iniciales }}
            </div>
            <div>
                <div class="font-bold text-gray-900 text-sm">Subir recurso para {{ $cliente->nombre }}</div>
                <div class="text-xs text-gray-400 font-mono">{{ $cliente->codigo }}</div>
            </div>
        </div>

        <form method="POST"
              action="{{ route('documentos.store', $cliente) }}"
              enctype="multipart/form-data"
              class="p-6">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">

                {{-- Nombre --}}
                <div class="sm:col-span-2">
                    <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">
                        Nombre <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nombre" value="{{ old('nombre') }}" required
                           placeholder="Ej: Manual de Red LAN v2.0"
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all">
                    @error('nombre') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Categoría --}}
                <div>
                    <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">
                        Categoría <span class="text-red-500">*</span>
                    </label>
                    <select name="categoria" required
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all">
                        <option value="">Seleccionar...</option>
                        <option value="documento" {{ old('categoria') === 'documento' ? 'selected' : '' }}>📄 Documento</option>
                        <option value="procedimiento" {{ old('categoria') === 'procedimiento' ? 'selected' : '' }}>📋 Procedimiento</option>
                        <option value="imagen" {{ old('categoria') === 'imagen' ? 'selected' : '' }}>🖼️ Imagen</option>
                    </select>
                    @error('categoria') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Tipo --}}
                <div>
                    <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">
                        Tipo de archivo <span class="text-red-500">*</span>
                    </label>
                    <select name="tipo" required
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all">
                        <option value="">Seleccionar...</option>
                        <option value="PDF" {{ old('tipo') === 'PDF' ? 'selected' : '' }}>PDF</option>
                        <option value="ISO" {{ old('tipo') === 'ISO' ? 'selected' : '' }}>ISO</option>
                        <option value="EXE" {{ old('tipo') === 'EXE' ? 'selected' : '' }}>EXE</option>
                        <option value="IMG" {{ old('tipo') === 'IMG' ? 'selected' : '' }}>IMG</option>
                        <option value="ZIP" {{ old('tipo') === 'ZIP' ? 'selected' : '' }}>ZIP</option>
                        <option value="LINK" {{ old('tipo') === 'LINK' ? 'selected' : '' }}>LINK</option>
                    </select>
                    @error('tipo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Versión --}}
                <div>
                    <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">Versión</label>
                    <input type="text" name="version" value="{{ old('version') }}"
                           placeholder="Ej: v2.0"
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all">
                </div>

                {{-- URL --}}
                <div>
                    <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">URL externa</label>
                    <input type="url" name="url" value="{{ old('url') }}"
                           placeholder="https://..."
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all">
                </div>

                {{-- Descripción --}}
                <div class="sm:col-span-2">
                    <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">Descripción</label>
                    <textarea name="descripcion" rows="2"
                              placeholder="Descripción breve del recurso..."
                              class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all resize-none">{{ old('descripcion') }}</textarea>
                </div>

                {{-- Archivo --}}
                <div class="sm:col-span-2">
                    <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">Archivo</label>
                    <div class="border-2 border-dashed border-gray-200 rounded-lg p-6 text-center hover:border-red-300 transition-colors">
                        <div class="text-3xl mb-2">📁</div>
                        <div class="text-sm text-gray-500 mb-2">Arrastrá el archivo o</div>
                        <label class="cursor-pointer text-sm text-red-600 font-semibold hover:text-red-700">
                            seleccioná desde tu equipo
                            <input type="file" name="archivo" class="hidden"
                                   onchange="document.getElementById('filename').textContent = this.files[0]?.name ?? ''">
                        </label>
                        <div id="filename" class="text-xs text-gray-400 mt-2 font-mono"></div>
                        <div class="text-xs text-gray-300 mt-1">Máximo 100 MB</div>
                    </div>
                    @error('archivo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

            </div>

            <div class="flex items-center gap-3 pt-2 border-t border-gray-100">
                <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-2.5 rounded-lg text-sm transition-colors">
                    ↑ Subir Recurso
                </button>
                <a href="{{ route('clientes.show', $cliente) }}"
                   class="text-sm text-gray-500 hover:text-gray-700 border border-gray-200 px-6 py-2.5 rounded-lg transition-colors">
                    Cancelar
                </a>
            </div>

        </form>
    </div>
</div>

@endsection