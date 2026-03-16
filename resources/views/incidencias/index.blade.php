@extends('layouts.app')
@section('title', 'Mis Tickets')
@section('page-title', 'Mis Tickets')
@section('page-subtitle', 'Listado de incidencias')

@section('topbar-actions')
<a href="{{ route('incidencias.create') }}"
   class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors">
    + Nueva Incidencia
</a>
@endsection

@section('content')

{{-- FILTROS --}}
<div class="bg-white border border-gray-200 rounded-xl p-4 mb-4">
    <form method="GET" action="{{ route('incidencias.index') }}" class="grid grid-cols-6 gap-3">
        <div>
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Estado</label>
            <select name="estado" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-500">
                <option value="">Todos</option>
                <option value="abierto"           {{ request('estado') == 'abierto'            ? 'selected' : '' }}>Abierto</option>
                <option value="en_gestion"        {{ request('estado') == 'en_gestion'         ? 'selected' : '' }}>En gestión</option>
                <option value="asignado"          {{ request('estado') == 'asignado'           ? 'selected' : '' }}>Asignado</option>
                <option value="pendiente_cliente" {{ request('estado') == 'pendiente_cliente'  ? 'selected' : '' }}>Pendiente cliente</option>
                <option value="cancelado_cliente" {{ request('estado') == 'cancelado_cliente'  ? 'selected' : '' }}>Cancelado</option>
                <option value="cerrado"           {{ request('estado') == 'cerrado'            ? 'selected' : '' }}>Cerrado</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Prioridad</label>
            <select name="prioridad" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-500">
                <option value="">Todas</option>
                <option value="alta"  {{ request('prioridad') == 'alta'  ? 'selected' : '' }}>Alta</option>
                <option value="media" {{ request('prioridad') == 'media' ? 'selected' : '' }}>Media</option>
                <option value="baja"  {{ request('prioridad') == 'baja'  ? 'selected' : '' }}>Baja</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Cliente</label>
            <select name="cliente_id" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-500">
                <option value="">Todos</option>
                @foreach($clientes as $c)
                <option value="{{ $c->id }}" {{ request('cliente_id') == $c->id ? 'selected' : '' }}>{{ $c->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Desde</label>
            <input type="date" name="desde" value="{{ request('desde') }}"
                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-500">
        </div>
        <div>
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Hasta</label>
            <input type="date" name="hasta" value="{{ request('hasta') }}"
                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-500">
        </div>
        <div class="flex items-end gap-2">
            <button type="submit"
                class="flex-1 bg-red-600 hover:bg-red-700 text-white text-sm font-bold px-4 py-2 rounded-lg">
                Filtrar
            </button>
            <a href="{{ route('incidencias.index') }}"
                class="px-3 py-2 border border-gray-200 rounded-lg text-sm text-gray-500 hover:bg-gray-50">
                ✕
            </a>
        </div>
    </form>
</div>

{{-- TABLA --}}
<div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="bg-gray-50 border-b border-gray-200">
                <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wide">Ticket</th>
                <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wide">Cliente</th>
                <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wide">Asunto</th>
                <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wide">Prioridad</th>
                <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wide">Estado</th>
                <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wide">Técnico</th>
                <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wide">Creado</th>
                <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wide">SLA</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($incidencias as $inc)
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-4 py-3">
                    <span class="font-mono text-xs font-bold text-gray-700">{{ $inc->numero_ticket }}</span>
                </td>
                <td class="px-4 py-3">
                    <div class="font-semibold text-gray-800 text-xs">{{ $inc->cliente->nombre }}</div>
                    <div class="text-xs text-gray-400">{{ $inc->local->codigo ?? '—' }}</div>
                </td>
                <td class="px-4 py-3">
                    <div class="text-sm text-gray-700 max-w-xs truncate">{{ $inc->asunto }}</div>
                    <div class="text-xs text-gray-400">{{ $inc->tipo_equipo }} — {{ $inc->categoria_equipo }}</div>
                </td>
                <td class="px-4 py-3">
                    @php
                        $prio = [
                            'alta'  => 'bg-red-100 text-red-700',
                            'media' => 'bg-amber-100 text-amber-700',
                            'baja'  => 'bg-green-100 text-green-700',
                        ];
                    @endphp
                    <span class="px-2 py-1 rounded-full text-xs font-bold {{ $prio[$inc->prioridad] ?? '' }}">
                        {{ ucfirst($inc->prioridad) }}
                    </span>
                </td>
                <td class="px-4 py-3">
                    @php
                        $estados = [
                            'abierto'            => 'bg-blue-100 text-blue-700',
                            'en_gestion'         => 'bg-purple-100 text-purple-700',
                            'asignado'           => 'bg-amber-100 text-amber-700',
                            'pendiente_cliente'  => 'bg-orange-100 text-orange-700',
                            'cancelado_cliente'  => 'bg-gray-100 text-gray-500',
                            'cerrado'            => 'bg-green-100 text-green-700',
                        ];
                        $labels = [
                            'abierto'            => 'Abierto',
                            'en_gestion'         => 'En gestión',
                            'asignado'           => 'Asignado',
                            'pendiente_cliente'  => 'Pend. cliente',
                            'cancelado_cliente'  => 'Cancelado',
                            'cerrado'            => 'Cerrado',
                        ];
                    @endphp
                    <span class="px-2 py-1 rounded-full text-xs font-bold {{ $estados[$inc->estado_mesa] ?? 'bg-gray-100 text-gray-500' }}">
                        {{ $labels[$inc->estado_mesa] ?? $inc->estado_mesa }}
                    </span>
                </td>
{{-- COLUMNA TÉCNICO (reemplaza el <td> actual de técnico) --}}
<td class="px-4 py-3">
    @if($inc->tecnico)
        <div class="flex items-center gap-2">
            <div class="w-6 h-6 rounded-full bg-red-100 flex items-center justify-center text-red-700 font-bold text-xs flex-shrink-0">
                {{ strtoupper(substr($inc->tecnico->name, 0, 1)) }}
            </div>
            <span class="text-xs text-gray-700 font-semibold">{{ $inc->tecnico->name }}</span>
        </div>
    @else
        <button onclick="abrirModalAsignar({{ $inc->id }}, '{{ addslashes($inc->numero_ticket) }}')"
            class="text-xs text-red-600 hover:text-red-700 font-bold border border-red-200 hover:border-red-400 bg-red-50 hover:bg-red-100 px-2 py-1 rounded-lg transition-colors">
            + Asignar
        </button>
    @endif
</td>
 
{{-- COLUMNA VER (reemplaza el último <td> con el enlace "Ver →") --}}
<td class="px-4 py-3">
    <a href="{{ route('incidencias.show', $inc) }}"
        class="inline-flex items-center gap-1 text-xs font-bold text-white bg-red-600 hover:bg-red-700 px-3 py-1.5 rounded-lg transition-colors">
        Ver <span class="text-xs">→</span>
    </a>
</td>
 
                <td class="px-4 py-3 text-xs text-gray-500">
                    {{ $inc->created_at->format('d/m/Y') }}<br>
                    <span class="text-gray-400">{{ $inc->created_at->format('H:i') }}</span>
                </td>
                <td class="px-4 py-3">
                    @if($inc->fecha_limite_resolucion)
                        @if($inc->closed_at)
                            <span class="text-xs font-bold {{ $inc->slaResolucionCumplido() ? 'text-green-600' : 'text-red-600' }}">
                                {{ $inc->slaResolucionCumplido() ? '✓ Cumplido' : '✕ Incumplido' }}
                            </span>
                        @elseif(now()->gt($inc->fecha_limite_resolucion))
                            <span class="text-xs font-bold text-red-600">⚠ Vencido</span>
                        @else
                            <span class="text-xs text-amber-600 font-bold">
                                {{ now()->diffForHumans($inc->fecha_limite_resolucion, true) }}
                            </span>
                        @endif
                    @else
                        <span class="text-xs text-gray-400">Sin SLA</span>
                    @endif
                </td>
                <td class="px-4 py-3">
                    <a href="{{ route('incidencias.show', $inc) }}"
                        class="text-xs font-bold text-red-600 hover:text-red-700">Ver →</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="px-4 py-12 text-center text-gray-400 text-sm">
                    No hay incidencias que coincidan con los filtros.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($incidencias->hasPages())
    <div class="px-4 py-3 border-t border-gray-100">
        {{ $incidencias->appends(request()->query())->links() }}
    </div>
    @endif
</div>
{{-- Pega esto ANTES del @endsection del index --}}

{{-- MODAL ASIGNAR TÉCNICO (desde el listado) --}}
<div id="modal-asignar-index" class="hidden fixed inset-0 z-50 flex items-center justify-center">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"
         onclick="cerrarModalAsignar()"></div>

    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 p-6">
        <div class="flex items-center justify-between mb-1">
            <h3 class="text-base font-bold text-gray-900">Asignar Técnico</h3>
            <button onclick="cerrarModalAsignar()" class="text-gray-400 hover:text-gray-600 text-xl leading-none">&times;</button>
        </div>
        <p id="modal-ticket-label" class="text-xs text-gray-400 mb-4"></p>

        <div class="mb-3">
            <input type="text" id="buscar-tecnico-index" placeholder="Buscar técnico por nombre..."
                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-500"
                oninput="filtrarTecnicosIndex(this.value)">
        </div>

        <div id="lista-tecnicos-index" class="max-h-56 overflow-y-auto space-y-1 mb-5">
            @foreach($tecnicos as $tec)
            <label class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-gray-50 cursor-pointer border border-transparent has-[:checked]:border-red-200 has-[:checked]:bg-red-50 transition-colors tecnico-index-item"
                   data-nombre="{{ strtolower($tec->name) }}">
                <input type="radio" name="tecnico_index" value="{{ $tec->id }}" class="accent-red-600">
                <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center text-red-700 font-bold text-xs flex-shrink-0">
                    {{ strtoupper(substr($tec->name, 0, 1)) }}
                </div>
                <div>
                    <div class="text-sm font-semibold text-gray-800">{{ $tec->name }}</div>
                    <div class="text-xs text-gray-400">{{ $tec->email }}</div>
                </div>
            </label>
            @endforeach
        </div>

        <form method="POST" id="form-asignar-index" action="">
            @csrf
            @method('PATCH')
            <input type="hidden" name="tecnico_id" id="tecnico_id_index_hidden">
            <div class="flex gap-2">
                <button type="button" onclick="cerrarModalAsignar()"
                    class="flex-1 border border-gray-200 text-gray-600 text-sm font-semibold px-4 py-2.5 rounded-lg hover:bg-gray-50 transition-colors">
                    Cancelar
                </button>
                <button type="button" onclick="confirmarAsignacionIndex()"
                    class="flex-1 bg-red-600 hover:bg-red-700 text-white text-sm font-bold px-4 py-2.5 rounded-lg transition-colors">
                    Confirmar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function abrirModalAsignar(id, ticket) {
    document.getElementById('modal-ticket-label').textContent = 'Ticket: ' + ticket;
    document.getElementById('form-asignar-index').action = '/incidencias/' + id + '/asignar';
    // Reset
    document.querySelectorAll('input[name="tecnico_index"]').forEach(r => r.checked = false);
    document.getElementById('buscar-tecnico-index').value = '';
    filtrarTecnicosIndex('');
    document.getElementById('modal-asignar-index').classList.remove('hidden');
}

function cerrarModalAsignar() {
    document.getElementById('modal-asignar-index').classList.add('hidden');
}

function filtrarTecnicosIndex(query) {
    const q = query.toLowerCase().trim();
    document.querySelectorAll('.tecnico-index-item').forEach(item => {
        item.style.display = item.dataset.nombre.includes(q) ? '' : 'none';
    });
}

function confirmarAsignacionIndex() {
    const sel = document.querySelector('input[name="tecnico_index"]:checked');
    if (!sel) { alert('Selecciona un técnico.'); return; }
    document.getElementById('tecnico_id_index_hidden').value = sel.value;
    document.getElementById('form-asignar-index').submit();
}
</script>
@endsection