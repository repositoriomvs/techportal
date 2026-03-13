@extends('layouts.app')
 
@section('title', 'Hardware')
@section('page-title', 'Hardware')
@section('page-subtitle', 'Repositorio de manuales, firmware y recursos técnicos')
 
@section('topbar-actions')
    @role('admin')
    <button x-data @click="$dispatch('abrir-modal-tipo')"
            class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors">
        + Nuevo Tipo
    </button>
    @endrole
@endsection
 
@section('content')
 
{{-- Flash --}}
@if(session('success'))
<div class="mb-4 bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-xl">
    ✅ {{ session('success') }}
</div>
@endif
 
{{-- Modal nuevo tipo --}}
@role('admin')
<div x-data="{ abierto: false }"
     @abrir-modal-tipo.window="abierto = true"
     x-show="abierto"
     class="fixed inset-0 z-50 flex items-center justify-center bg-black/40"
     x-cloak>
    <div class="bg-white rounded-xl shadow-xl p-6 w-full max-w-sm mx-4" @click.outside="abierto = false">
        <h3 class="font-bold text-gray-900 mb-4">Nuevo Tipo de Hardware</h3>
        <form method="POST" action="{{ route('hardware.tipos.store') }}">
            @csrf
            <div class="flex flex-col gap-3">
                <div>
                    <label class="block text-xs font-mono text-gray-500 uppercase mb-1">Nombre *</label>
                    <input type="text" name="nombre" required placeholder="Ej: Computador"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-400">
                </div>
                <div>
                    <label class="block text-xs font-mono text-gray-500 uppercase mb-1">Icono (emoji)</label>
                    <input type="text" name="icono" placeholder="🖥️"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-400">
                </div>
            </div>
            <div class="flex gap-2 mt-4">
                <button type="submit" class="flex-1 bg-red-600 text-white font-semibold py-2 rounded-lg text-sm hover:bg-red-700">Crear</button>
                <button type="button" @click="abierto = false" class="flex-1 border border-gray-200 text-gray-500 py-2 rounded-lg text-sm hover:bg-gray-50">Cancelar</button>
            </div>
        </form>
    </div>
</div>
@endrole
 
{{-- Sin tipos --}}
@if($tipos->isEmpty())
<div class="bg-white border border-gray-200 rounded-xl p-16 text-center">
    <div class="text-5xl mb-4">🖥️</div>
    <div class="text-gray-500 text-sm">No hay tipos de hardware registrados.</div>
    @role('admin')
    <button x-data @click="$dispatch('abrir-modal-tipo')"
            class="inline-block mt-4 bg-red-600 text-white text-sm font-semibold px-6 py-2 rounded-lg hover:bg-red-700">
        + Crear primer tipo
    </button>
    @endrole
</div>
@endif
 
{{-- Tipos en cascada --}}
@foreach($tipos as $tipo)
<div class="mb-6" x-data="{ expandido: true }">
 
    {{-- Header Tipo --}}
    <div class="flex items-center gap-3 mb-3">
        <button @click="expandido = !expandido"
                class="flex items-center gap-3 flex-1 bg-gray-900 text-white rounded-xl px-5 py-3 hover:bg-gray-800 transition-colors text-left">
            <span class="text-xl">{{ $tipo->icono ?? '🖥️' }}</span>
            <span class="font-bold text-base">{{ $tipo->nombre }}</span>
            <span class="text-xs text-gray-400 font-mono ml-1">{{ $tipo->marcas->count() }} marcas</span>
            <span class="ml-auto text-gray-400 text-sm" x-text="expandido ? '▲' : '▼'"></span>
        </button>
        @role('admin')
        <form method="POST" action="{{ route('hardware.tipos.destroy', $tipo) }}"
              onsubmit="return confirm('¿Eliminar tipo {{ $tipo->nombre }} y todo su contenido?')">
            @csrf @method('DELETE')
            <button class="text-xs text-red-400 border border-red-100 rounded-lg px-3 py-3 hover:text-red-600 hover:bg-red-50 transition-colors">
                🗑️
            </button>
        </form>
        @endrole
    </div>
 
    <div x-show="expandido" x-transition class="pl-4">
 
        {{-- Marcas --}}
        @foreach($tipo->marcas as $marca)
        <div class="mb-4" x-data="{ expandidoMarca: true }">
 
            {{-- Header Marca --}}
            <div class="flex items-center gap-3 mb-2">
                <button @click="expandidoMarca = !expandidoMarca"
                        class="flex items-center gap-3 flex-1 bg-white border border-gray-200 rounded-xl px-4 py-2.5 hover:bg-gray-50 transition-colors text-left shadow-sm">
                    <span class="text-lg">{{ $marca->icono ?? '🏭' }}</span>
                    <span class="font-semibold text-gray-900">{{ $marca->nombre }}</span>
                    <span class="text-xs text-gray-400 font-mono">{{ $marca->modelos->count() }} modelos</span>
                    <span class="ml-auto text-gray-400 text-sm" x-text="expandidoMarca ? '▲' : '▼'"></span>
                </button>
                @role('admin')
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open"
                            class="text-xs border border-gray-200 rounded-lg px-3 py-2.5 text-gray-500 hover:bg-gray-50 transition-colors block">
                        + Modelo
                    </button>
                    <div x-show="open" @click.outside="open = false"
                         class="absolute right-0 top-full mt-1 bg-white border border-gray-200 rounded-xl shadow-xl p-4 w-72 z-20">
                        <form method="POST" action="{{ route('hardware.modelos.store') }}">
                            @csrf
                            <input type="hidden" name="hardware_marca_id" value="{{ $marca->id }}">
                            <div class="flex flex-col gap-2">
                                <input type="text" name="nombre" required placeholder="Nombre del modelo *"
                                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-400">
                                <input type="text" name="numero_parte" placeholder="Número de parte"
                                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-400">
                                <textarea name="descripcion" rows="2" placeholder="Descripción (opcional)"
                                          class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-400 resize-none"></textarea>
                                <button type="submit" class="w-full bg-red-600 text-white font-semibold py-2 rounded-lg text-sm hover:bg-red-700">
                                    Crear Modelo
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <form method="POST" action="{{ route('hardware.marcas.destroy', $marca) }}"
                      onsubmit="return confirm('¿Eliminar marca {{ $marca->nombre }}?')">
                    @csrf @method('DELETE')
                    <button class="text-xs text-red-400 border border-red-100 rounded-lg px-3 py-2.5 hover:text-red-600 hover:bg-red-50 transition-colors">
                        🗑️
                    </button>
                </form>
                @endrole
            </div>
 
            <div x-show="expandidoMarca" x-transition class="pl-4">
 
                {{-- Modelos --}}
                @foreach($marca->modelos as $modelo)
                <div class="mb-3" x-data="{ expandidoModelo: false }">
 
                    {{-- Header Modelo --}}
                    <div class="flex items-center gap-2 mb-2">
                        <button @click="expandidoModelo = !expandidoModelo"
                                class="flex items-center gap-3 flex-1 bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 hover:bg-gray-100 transition-colors text-left">
                            <span class="text-base">🖥️</span>
                            <span class="font-medium text-gray-900 text-sm">{{ $modelo->nombre }}</span>
                            @if($modelo->numero_parte)
                            <span class="text-xs text-gray-400 font-mono">{{ $modelo->numero_parte }}</span>
                            @endif
                            <span class="text-xs bg-red-50 text-red-600 font-mono px-2 py-0.5 rounded-full">
                                {{ $modelo->recursos->count() }} recursos
                            </span>
                            <span class="ml-auto text-gray-400 text-xs" x-text="expandidoModelo ? '▲' : '▼'"></span>
                        </button>
                        @role('admin')
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open"
                                    class="text-xs border border-gray-200 rounded-lg px-3 py-2.5 text-gray-500 hover:bg-gray-50 transition-colors block">
                                ↑ Recurso
                            </button>
                            <div x-show="open" @click.outside="open = false"
                                 class="absolute right-0 top-full mt-1 bg-white border border-gray-200 rounded-xl shadow-xl p-4 w-80 z-20">
                                <div class="font-semibold text-gray-900 text-sm mb-3">Subir recurso para {{ $modelo->nombre }}</div>
                                <form method="POST"
                                      action="{{ route('hardware.recursos.store', $modelo) }}"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="flex flex-col gap-2">
                                        <input type="text" name="nombre" required placeholder="Nombre del recurso *"
                                               class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-400">
                                        <select name="categoria" required
                                                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-400">
                                            <option value="">Categoría *</option>
                                            <option value="manual_tecnico">📄 Manual Técnico</option>
                                            <option value="list_part">🔩 List Part</option>
                                            <option value="firmware">💾 Firmware</option>
                                            <option value="procedimiento">📋 Procedimiento</option>
                                        </select>
                                        <select name="tipo" required
                                                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-400">
                                            <option value="">Tipo de archivo *</option>
                                            <option value="PDF">PDF</option>
                                            <option value="ISO">ISO</option>
                                            <option value="EXE">EXE</option>
                                            <option value="ZIP">ZIP</option>
                                            <option value="LINK">LINK</option>
                                        </select>
                                        <input type="text" name="version" placeholder="Versión"
                                               class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-400">
                                        <input type="url" name="url" placeholder="URL externa (opcional)"
                                               class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-400">
                                        <label class="border-2 border-dashed border-gray-200 rounded-lg p-3 text-center cursor-pointer hover:border-red-300 transition-colors">
                                            <div class="text-xs text-gray-500">📁 Seleccionar archivo</div>
                                            <input type="file" name="archivo" class="hidden"
                                                   onchange="this.previousElementSibling.textContent = this.files[0]?.name ?? '📁 Seleccionar archivo'">
                                        </label>
                                        <button type="submit" class="w-full bg-red-600 text-white font-semibold py-2 rounded-lg text-sm hover:bg-red-700">
                                            ↑ Subir
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('hardware.modelos.destroy', $modelo) }}"
                              onsubmit="return confirm('¿Eliminar modelo {{ $modelo->nombre }}?')">
                            @csrf @method('DELETE')
                            <button class="text-xs text-red-400 border border-red-100 rounded-lg px-3 py-2.5 hover:text-red-600 hover:bg-red-50 transition-colors">
                                🗑️
                            </button>
                        </form>
                        @endrole
                    </div>
 
                    {{-- Recursos del modelo --}}
                    <div x-show="expandidoModelo" x-transition class="pl-4">
                        @if($modelo->recursos->isEmpty())
                            <div class="text-xs text-gray-400 font-mono px-4 py-3 bg-gray-50 rounded-xl">
                                Sin recursos cargados.
                            </div>
                        @else
                        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                            <table class="w-full">
                                <thead>
                                    <tr class="bg-gray-50 border-b border-gray-100">
                                        <th class="text-left px-4 py-2.5 text-xs font-mono text-gray-400 uppercase">Recurso</th>
                                        <th class="text-left px-4 py-2.5 text-xs font-mono text-gray-400 uppercase hidden sm:table-cell">Categoría</th>
                                        <th class="text-left px-4 py-2.5 text-xs font-mono text-gray-400 uppercase hidden md:table-cell">Versión</th>
                                        <th class="text-right px-4 py-2.5 text-xs font-mono text-gray-400 uppercase">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @foreach($modelo->recursos as $recurso)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-4 py-2.5">
                                            <div class="flex items-center gap-2">
                                                <span class="text-lg">{{ $recurso->icono ?? '📄' }}</span>
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">{{ $recurso->nombre }}</div>
                                                    <span class="text-xs font-mono font-bold px-1.5 py-0.5 rounded
                                                        {{ $recurso->tipo === 'PDF' ? 'bg-red-50 text-red-600' : '' }}
                                                        {{ $recurso->tipo === 'ISO' ? 'bg-purple-50 text-purple-600' : '' }}
                                                        {{ $recurso->tipo === 'EXE' ? 'bg-green-50 text-green-600' : '' }}
                                                        {{ $recurso->tipo === 'ZIP' ? 'bg-blue-50 text-blue-600' : '' }}
                                                        {{ $recurso->tipo === 'LINK' ? 'bg-gray-100 text-gray-600' : '' }}">
                                                        {{ $recurso->tipo }}
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-2.5 hidden sm:table-cell">
                                            <span class="text-xs text-gray-500 font-mono">
                                                {{ match($recurso->categoria) {
                                                    'manual_tecnico' => '📄 Manual Técnico',
                                                    'list_part'      => '🔩 List Part',
                                                    'firmware'       => '💾 Firmware',
                                                    'procedimiento'  => '📋 Procedimiento',
                                                    default          => $recurso->categoria
                                                } }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-2.5 hidden md:table-cell">
                                            <span class="text-xs text-gray-400 font-mono">{{ $recurso->version ?? '—' }}</span>
                                        </td>
                                        <td class="px-4 py-2.5">
                                            <div class="flex items-center justify-end gap-1.5">
                                                @if($recurso->tipo === 'PDF')
                                                <a href="{{ route('hardware.recursos.ver', $recurso) }}"
                                                   class="text-xs bg-red-50 text-red-600 border border-red-100 rounded px-2 py-1 hover:bg-red-600 hover:text-white transition-colors font-semibold">
                                                    📖 Leer
                                                </a>
                                                @endif
                                                @if($recurso->archivo || $recurso->url)
                                                <a href="{{ $recurso->url ?? route('hardware.recursos.descargar', $recurso) }}"
                                                   class="text-xs bg-gray-50 text-gray-600 border border-gray-200 rounded px-2 py-1 hover:bg-gray-600 hover:text-white transition-colors"
                                                   {{ $recurso->url ? 'target=_blank' : '' }}>
                                                    ⬇ Bajar
                                                </a>
                                                @endif
                                                @role('admin')
                                                <a href="{{ route('hardware.recursos.edit', $recurso) }}"
                                                   class="text-xs text-gray-400 border border-gray-200 rounded px-2 py-1 hover:text-gray-600 transition-colors">
                                                    ✏️
                                                </a>
                                                <form method="POST" action="{{ route('hardware.recursos.destroy', $recurso) }}"
                                                      onsubmit="return confirm('¿Eliminar este recurso?')">
                                                    @csrf @method('DELETE')
                                                    <button class="text-xs text-red-400 border border-red-100 rounded px-2 py-1 hover:text-red-600 transition-colors">
                                                        🗑️
                                                    </button>
                                                </form>
                                                @endrole
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                    </div>
 
                </div>
                @endforeach
 
                @role('admin')
                @if($marca->modelos->isEmpty())
                <div class="text-xs text-gray-400 font-mono px-2 py-1">Sin modelos aún.</div>
                @endif
                @endrole
 
            </div>
        </div>
        @endforeach
 
        {{-- Botón agregar marca al tipo --}}
        @role('admin')
        <div x-data="{ open: false }" class="mt-2">
            <button @click="open = !open"
                    class="text-xs text-gray-500 border border-dashed border-gray-300 rounded-lg px-4 py-2 hover:border-red-400 hover:text-red-600 transition-colors">
                + Agregar marca a {{ $tipo->nombre }}
            </button>
            <div x-show="open" @click.outside="open = false"
                 class="mt-2 bg-white border border-gray-200 rounded-xl shadow-lg p-4 w-72 z-20">
                <form method="POST" action="{{ route('hardware.marcas.store') }}">
                    @csrf
                    <input type="hidden" name="hardware_tipo_id" value="{{ $tipo->id }}">
                    <div class="flex flex-col gap-2">
                        <input type="text" name="nombre" required placeholder="Nombre de la marca *"
                               class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-400">
                        <input type="text" name="icono" placeholder="Icono emoji (opcional)"
                               class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-400">
                        <button type="submit" class="w-full bg-red-600 text-white font-semibold py-2 rounded-lg text-sm hover:bg-red-700">
                            Crear Marca
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endrole
 
    </div>
</div>
@endforeach
 
@endsection