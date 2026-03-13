@if($recursos->isEmpty())
    <div class="bg-white border border-gray-200 rounded-xl p-12 text-center">
        <div class="text-4xl mb-3">📭</div>
        <div class="text-gray-400 text-sm">No hay {{ $categoria }}s cargados aún.</div>
        @role('admin')
        <a href="{{ route('documentos.create', $cliente) }}"
           class="inline-block mt-3 text-sm text-red-600 font-semibold hover:text-red-700">
            + Subir primero →
        </a>
        @endrole
    </div>
@else
<div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
    <table class="w-full">
        <thead>
            <tr class="bg-gray-50 border-b border-gray-100">
                <th class="text-left px-4 py-3 text-xs font-mono text-gray-400 uppercase tracking-wider">Nombre</th>
                <th class="text-left px-4 py-3 text-xs font-mono text-gray-400 uppercase tracking-wider hidden sm:table-cell">Tipo</th>
                <th class="text-left px-4 py-3 text-xs font-mono text-gray-400 uppercase tracking-wider hidden md:table-cell">Versión</th>
                <th class="text-left px-4 py-3 text-xs font-mono text-gray-400 uppercase tracking-wider hidden md:table-cell">Tamaño</th>
                <th class="text-right px-4 py-3 text-xs font-mono text-gray-400 uppercase tracking-wider">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @foreach($recursos as $recurso)
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-4 py-3">
                    <div class="flex items-center gap-3">
                        <span class="text-xl">{{ $recurso->icono }}</span>
                        <div>
                            <div class="text-sm font-medium text-gray-900">{{ $recurso->nombre }}</div>
                            @if($recurso->descripcion)
                            <div class="text-xs text-gray-400 truncate max-w-xs">{{ $recurso->descripcion }}</div>
                            @endif
                        </div>
                    </div>
                </td>
                <td class="px-4 py-3 hidden sm:table-cell">
                    <span class="text-xs font-mono font-bold px-2 py-1 rounded
                        {{ $recurso->tipo === 'PDF' ? 'bg-red-50 text-red-600' : '' }}
                        {{ $recurso->tipo === 'ISO' ? 'bg-purple-50 text-purple-600' : '' }}
                        {{ $recurso->tipo === 'EXE' ? 'bg-green-50 text-green-600' : '' }}
                        {{ $recurso->tipo === 'IMG' ? 'bg-amber-50 text-amber-600' : '' }}
                        {{ $recurso->tipo === 'ZIP' ? 'bg-blue-50 text-blue-600' : '' }}
                        {{ $recurso->tipo === 'LINK' ? 'bg-gray-100 text-gray-600' : '' }}">
                        {{ $recurso->tipo }}
                    </span>
                </td>
                <td class="px-4 py-3 hidden md:table-cell">
                    <span class="text-xs text-gray-400 font-mono">{{ $recurso->version ?? '—' }}</span>
                </td>
                <td class="px-4 py-3 hidden md:table-cell">
                    <span class="text-xs text-gray-400 font-mono">{{ $recurso->tamanio ?? '—' }}</span>
                </td>
                <td class="px-4 py-3">
                    <div class="flex items-center justify-end gap-2">
                        @if($recurso->tipo === 'PDF')
                        <a href="{{ route('documentos.ver', $recurso) }}"
                           class="text-xs bg-red-50 text-red-600 border border-red-100 rounded px-2 py-1 hover:bg-red-600 hover:text-white transition-colors font-semibold">
                            📖 Leer
                        </a>
                        @endif
                        @if($recurso->archivo || $recurso->url)
                        <a href="{{ $recurso->url ?? route('documentos.descargar', $recurso) }}"
                           class="text-xs bg-gray-50 text-gray-600 border border-gray-200 rounded px-2 py-1 hover:bg-gray-600 hover:text-white transition-colors"
                           {{ $recurso->url ? 'target=_blank' : '' }}>
                            ⬇ Bajar
                        </a>
                        @endif
                        @role('admin')
                        <a href="{{ route('documentos.edit', $recurso) }}"
                           class="text-xs text-gray-400 border border-gray-200 rounded px-2 py-1 hover:text-gray-600 transition-colors">
                            ✏️
                        </a>
                        <form method="POST" action="{{ route('documentos.destroy', $recurso) }}"
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