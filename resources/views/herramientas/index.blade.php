@extends('layouts.app')

@section('title', 'Herramientas')
@section('page-title', 'Herramientas')
@section('page-subtitle', 'Software, booteables y utilidades globales')

@section('topbar-actions')
    @role('admin')
    <button onclick="document.getElementById('modal-nueva').classList.remove('hidden')"
            class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors">
        + Nueva Herramienta
    </button>
    @endrole
@endsection

@section('content')

@if($categorias->isEmpty())
    <div class="bg-white border border-gray-200 rounded-xl p-16 text-center shadow-sm">
        <div class="text-5xl mb-4">🔧</div>
        <div class="text-gray-500 font-medium">No hay herramientas cargadas aún.</div>
        @role('admin')
        <button onclick="document.getElementById('modal-nueva').classList.remove('hidden')"
                class="mt-4 inline-block bg-red-600 text-white text-sm font-semibold px-4 py-2 rounded-lg hover:bg-red-700 transition-colors">
            + Agregar primera herramienta
        </button>
        @endrole
    </div>
@else
    <div class="flex flex-col gap-6">
        @foreach($categorias as $categoria => $items)
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">

            {{-- Header categoría --}}
            <div class="px-5 py-3.5 border-b border-gray-100 flex items-center justify-between bg-gray-50">
                <div class="flex items-center gap-2">
                    <span class="text-base">📁</span>
                    <h2 class="font-bold text-gray-800 uppercase tracking-wide text-sm">{{ $categoria }}</h2>
                    <span class="text-xs font-mono text-gray-400 bg-gray-100 px-2 py-0.5 rounded-full">
                        {{ $items->count() }}
                    </span>
                </div>
            </div>

            {{-- Items --}}
            <div class="divide-y divide-gray-50">
                @foreach($items as $herramienta)
                <div class="px-5 py-3.5 flex items-center gap-4 hover:bg-gray-50 transition-colors group">

                    {{-- Ícono --}}
                    <div class="text-2xl flex-shrink-0">{{ $herramienta->icono }}</div>

                    {{-- Info --}}
                    <div class="flex-1 min-w-0">
                        <div class="text-sm font-semibold text-gray-900">{{ $herramienta->nombre }}</div>
                        @if($herramienta->descripcion)
                        <div class="text-xs text-gray-400 mt-0.5 truncate">{{ $herramienta->descripcion }}</div>
                        @endif
                        <div class="flex items-center gap-3 mt-1 flex-wrap">
                            @if($herramienta->version)
                            <span class="text-xs font-mono text-gray-400">v{{ $herramienta->version }}</span>
                            @endif
                            @if($herramienta->tamanio)
                            <span class="text-xs font-mono text-gray-400">{{ $herramienta->tamanio }}</span>
                            @endif
                            <span class="text-xs font-mono font-bold px-2 py-0.5 rounded
                                {{ $herramienta->tipo === 'ISO'  ? 'bg-purple-50 text-purple-600' : '' }}
                                {{ $herramienta->tipo === 'EXE'  ? 'bg-green-50 text-green-600'   : '' }}
                                {{ $herramienta->tipo === 'LINK' ? 'bg-blue-50 text-blue-600'     : '' }}
                                {{ $herramienta->tipo === 'ZIP'  ? 'bg-amber-50 text-amber-600'   : '' }}
                                {{ $herramienta->tipo === 'PDF'  ? 'bg-red-50 text-red-600'       : '' }}">
                                {{ $herramienta->tipo }}
                            </span>
                        </div>
                    </div>

                    {{-- Acciones --}}
                    <div class="flex items-center gap-2 flex-shrink-0">
                        @if($herramienta->tipo === 'LINK' && $herramienta->url)
                            <a href="{{ $herramienta->url }}" target="_blank"
                               class="text-xs border border-gray-200 px-3 py-1.5 rounded-lg hover:bg-gray-100 transition-colors font-medium text-gray-600">
                                🔗 Abrir
                            </a>
                        @elseif($herramienta->archivo)
                            <a href="{{ route('herramientas.descargar', $herramienta) }}"
                               class="text-xs border border-gray-200 px-3 py-1.5 rounded-lg hover:bg-gray-100 transition-colors font-medium text-gray-600">
                                ⬇ Descargar
                            </a>
                        @endif

                        @role('admin')
                        <button onclick="abrirEditar({{ $herramienta->id }}, {{ $herramienta->toJson() }})"
                                class="text-xs border border-gray-200 px-3 py-1.5 rounded-lg hover:bg-gray-100 transition-colors text-gray-500">
                            ✏️
                        </button>
                        <form method="POST" action="{{ route('herramientas.destroy', $herramienta) }}"
                              onsubmit="return confirm('¿Eliminar {{ $herramienta->nombre }}?')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="text-xs border border-red-100 px-3 py-1.5 rounded-lg hover:bg-red-50 transition-colors text-red-400">
                                🗑️
                            </button>
                        </form>
                        @endrole
                    </div>

                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
@endif

{{-- ── MODAL NUEVA HERRAMIENTA ── --}}
@role('admin')
<div id="modal-nueva"
     class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40"
     onclick="if(event.target===this) this.classList.add('hidden')">
    <div class="bg-white rounded-xl shadow-xl p-6 w-full max-w-lg mx-4">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-bold text-gray-900">🔧 Nueva Herramienta</h3>
            <button onclick="document.getElementById('modal-nueva').classList.add('hidden')"
                    class="text-gray-400 hover:text-gray-600 text-lg leading-none">✕</button>
        </div>

        <form method="POST" action="{{ route('herramientas.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="flex flex-col gap-3">

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-mono text-gray-500 uppercase tracking-wide mb-1">Nombre *</label>
                        <input type="text" name="nombre" required
                               placeholder="Ej: Rufus"
                               class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-400">
                    </div>
                    <div>
                        <label class="block text-xs font-mono text-gray-500 uppercase tracking-wide mb-1">Versión</label>
                        <input type="text" name="version"
                               placeholder="Ej: 4.5.2"
                               class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-400">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-mono text-gray-500 uppercase tracking-wide mb-1">Categoría *</label>
                        <input type="text" name="categoria" required
                               list="categorias-list"
                               placeholder="Ej: Diagnóstico"
                               class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-400">
                        <datalist id="categorias-list">
                            @foreach($categorias->keys() as $cat)
                            <option value="{{ $cat }}">
                            @endforeach
                        </datalist>
                    </div>
                    <div>
                        <label class="block text-xs font-mono text-gray-500 uppercase tracking-wide mb-1">Tipo *</label>
                        <select name="tipo" id="tipo-select" onchange="toggleCampos()"
                                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-400">
                            <option value="EXE">📦 EXE — Software</option>
                            <option value="ISO">💿 ISO — Booteable</option>
                            <option value="ZIP">🗜️ ZIP — Comprimido</option>
                            <option value="PDF">📄 PDF — Documento</option>
                            <option value="LINK">🔗 LINK — Enlace</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-mono text-gray-500 uppercase tracking-wide mb-1">Descripción</label>
                    <textarea name="descripcion" rows="2"
                              placeholder="Breve descripción de la herramienta..."
                              class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-400 resize-none"></textarea>
                </div>

                {{-- Campo archivo --}}
                <div id="campo-archivo">
                    <label class="block text-xs font-mono text-gray-500 uppercase tracking-wide mb-1">Archivo</label>
                    <input type="file" name="archivo"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-400">
                </div>

                {{-- Campo URL (solo LINK) --}}
                <div id="campo-url" class="hidden">
                    <label class="block text-xs font-mono text-gray-500 uppercase tracking-wide mb-1">URL *</label>
                    <input type="url" name="url"
                           placeholder="https://..."
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-400">
                </div>

            </div>

            <div class="flex gap-2 mt-5">
                <button type="submit"
                        class="flex-1 bg-red-600 text-white font-semibold py-2.5 rounded-lg text-sm hover:bg-red-700 transition-colors">
                    Guardar herramienta
                </button>
                <button type="button"
                        onclick="document.getElementById('modal-nueva').classList.add('hidden')"
                        class="flex-1 border border-gray-200 text-gray-500 py-2.5 rounded-lg text-sm hover:bg-gray-50 transition-colors">
                    Cancelar
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ── MODAL EDITAR HERRAMIENTA ── --}}
<div id="modal-editar"
     class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40"
     onclick="if(event.target===this) this.classList.add('hidden')">
    <div class="bg-white rounded-xl shadow-xl p-6 w-full max-w-lg mx-4">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-bold text-gray-900">✏️ Editar Herramienta</h3>
            <button onclick="document.getElementById('modal-editar').classList.add('hidden')"
                    class="text-gray-400 hover:text-gray-600 text-lg leading-none">✕</button>
        </div>

        <form id="form-editar" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="flex flex-col gap-3">

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-mono text-gray-500 uppercase tracking-wide mb-1">Nombre *</label>
                        <input type="text" name="nombre" id="edit-nombre" required
                               class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-400">
                    </div>
                    <div>
                        <label class="block text-xs font-mono text-gray-500 uppercase tracking-wide mb-1">Versión</label>
                        <input type="text" name="version" id="edit-version"
                               class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-400">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-mono text-gray-500 uppercase tracking-wide mb-1">Categoría *</label>
                        <input type="text" name="categoria" id="edit-categoria" required
                               list="categorias-list"
                               class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-400">
                    </div>
                    <div>
                        <label class="block text-xs font-mono text-gray-500 uppercase tracking-wide mb-1">Tipo *</label>
                        <select name="tipo" id="edit-tipo"
                                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-400">
                            <option value="EXE">📦 EXE — Software</option>
                            <option value="ISO">💿 ISO — Booteable</option>
                            <option value="ZIP">🗜️ ZIP — Comprimido</option>
                            <option value="PDF">📄 PDF — Documento</option>
                            <option value="LINK">🔗 LINK — Enlace</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-mono text-gray-500 uppercase tracking-wide mb-1">Descripción</label>
                    <textarea name="descripcion" id="edit-descripcion" rows="2"
                              class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-400 resize-none"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-mono text-gray-500 uppercase tracking-wide mb-1">Reemplazar archivo</label>
                    <input type="file" name="archivo"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm">
                </div>

                <div>
                    <label class="block text-xs font-mono text-gray-500 uppercase tracking-wide mb-1">URL</label>
                    <input type="url" name="url" id="edit-url"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-400">
                </div>

            </div>

            <div class="flex gap-2 mt-5">
                <button type="submit"
                        class="flex-1 bg-red-600 text-white font-semibold py-2.5 rounded-lg text-sm hover:bg-red-700 transition-colors">
                    Guardar cambios
                </button>
                <button type="button"
                        onclick="document.getElementById('modal-editar').classList.add('hidden')"
                        class="flex-1 border border-gray-200 text-gray-500 py-2.5 rounded-lg text-sm hover:bg-gray-50 transition-colors">
                    Cancelar
                </button>
            </div>
        </form>
    </div>
</div>
@endrole

@endsection

@push('scripts')
<script>
function toggleCampos() {
    const tipo = document.getElementById('tipo-select').value;
    document.getElementById('campo-archivo').classList.toggle('hidden', tipo === 'LINK');
    document.getElementById('campo-url').classList.toggle('hidden', tipo !== 'LINK');
}

function abrirEditar(id, data) {
    document.getElementById('form-editar').action = `/herramientas/${id}`;
    document.getElementById('edit-nombre').value      = data.nombre     ?? '';
    document.getElementById('edit-version').value     = data.version    ?? '';
    document.getElementById('edit-categoria').value   = data.categoria  ?? '';
    document.getElementById('edit-tipo').value        = data.tipo       ?? 'EXE';
    document.getElementById('edit-descripcion').value = data.descripcion ?? '';
    document.getElementById('edit-url').value         = data.url        ?? '';
    document.getElementById('modal-editar').classList.remove('hidden');
}
</script>
@endpush