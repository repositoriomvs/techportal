@extends('layouts.app')
@section('title', 'Ticket ' . $incidencia->numero_ticket)
@section('page-title', $incidencia->numero_ticket)
@section('page-subtitle', $incidencia->asunto)

@section('topbar-actions')
<a href="{{ route('incidencias.index') }}"
   class="flex items-center gap-2 border border-gray-200 hover:bg-gray-50 text-gray-600 text-sm font-semibold px-4 py-2 rounded-lg transition-colors">
    ← Volver al listado
</a>
@if(!in_array($incidencia->estado_mesa, ['cerrado','cancelado_cliente']))
<a href="{{ route('incidencias.cierre', $incidencia) }}"
   class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors">
    Cerrar Ticket
</a>
@endif
@endsection

@section('content')

@php
    $prioColors = [
        'alta'  => 'bg-red-100 text-red-700 border border-red-200',
        'media' => 'bg-amber-100 text-amber-700 border border-amber-200',
        'baja'  => 'bg-green-100 text-green-700 border border-green-200',
    ];
    $estadoColors = [
        'abierto'            => 'bg-blue-100 text-blue-700 border border-blue-200',
        'en_gestion'         => 'bg-purple-100 text-purple-700 border border-purple-200',
        'asignado'           => 'bg-amber-100 text-amber-700 border border-amber-200',
        'pendiente_cliente'  => 'bg-orange-100 text-orange-700 border border-orange-200',
        'cancelado_cliente'  => 'bg-gray-100 text-gray-500 border border-gray-200',
        'cerrado'            => 'bg-green-100 text-green-700 border border-green-200',
    ];
    $estadoLabels = [
        'abierto'            => 'Abierto',
        'en_gestion'         => 'En gestión',
        'asignado'           => 'Asignado',
        'pendiente_cliente'  => 'Pendiente cliente',
        'cancelado_cliente'  => 'Cancelado',
        'cerrado'            => 'Cerrado',
    ];
    $tipoLabels = [
        'incidencia_hardware' => 'Incidencia Hardware',
        'incidencia_software' => 'Incidencia Software',
        'requerimiento'       => 'Requerimiento',
    ];
@endphp

<div class="grid grid-cols-3 gap-4">

    {{-- COLUMNA PRINCIPAL --}}
    <div class="col-span-2 space-y-4">

        {{-- CABECERA DEL TICKET --}}
        <div class="bg-white border border-gray-200 rounded-xl p-5">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <div class="flex items-center gap-3 mb-1">
                        <span class="font-mono text-lg font-bold text-gray-800">{{ $incidencia->numero_ticket }}</span>
                        <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $estadoColors[$incidencia->estado_mesa] ?? 'bg-gray-100 text-gray-500' }}">
                            {{ $estadoLabels[$incidencia->estado_mesa] ?? $incidencia->estado_mesa }}
                        </span>
                        <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $prioColors[$incidencia->prioridad] ?? '' }}">
                            {{ ucfirst($incidencia->prioridad) }}
                        </span>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900">{{ $incidencia->asunto }}</h2>
                    <p class="text-sm text-gray-500 mt-1">
                        {{ $tipoLabels[$incidencia->tipo_ticket] ?? $incidencia->tipo_ticket }}
                        · Canal: {{ $incidencia->canal_ingreso }}
                    </p>
                </div>
                <div class="text-right text-xs text-gray-400">
                    <div>Creado el {{ $incidencia->created_at->format('d/m/Y H:i') }}</div>
                    <div>por {{ $incidencia->agente->name ?? '—' }}</div>
                </div>
            </div>

            <div class="border-t border-gray-100 pt-4">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Descripción de la falla</p>
                <p class="text-sm text-gray-700 leading-relaxed">{{ $incidencia->descripcion_falla }}</p>
            </div>

            @if($incidencia->adjunto)
            <div class="mt-4 pt-4 border-t border-gray-100">
                <a href="{{ Storage::url($incidencia->adjunto) }}" target="_blank"
                   class="inline-flex items-center gap-2 text-sm text-red-600 hover:text-red-700 font-semibold">
                    📎 Ver adjunto
                </a>
            </div>
            @endif
        </div>

        {{-- EQUIPO --}}
        <div class="bg-white border border-gray-200 rounded-xl p-5">
            <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-4">Información del Equipo</p>
            <div class="grid grid-cols-3 gap-4 text-sm">
                <div>
                    <span class="text-xs text-gray-400 block mb-0.5">Categoría</span>
                    <span class="font-semibold text-gray-800">{{ ucfirst($incidencia->categoria_equipo) }}</span>
                </div>
                <div>
                    <span class="text-xs text-gray-400 block mb-0.5">Tipo</span>
                    <span class="font-semibold text-gray-800">{{ $incidencia->tipo_equipo }}</span>
                </div>
                <div>
                    <span class="text-xs text-gray-400 block mb-0.5">Marca</span>
                    <span class="font-semibold text-gray-800">{{ $incidencia->marca_equipo ?? '—' }}</span>
                </div>
                <div>
                    <span class="text-xs text-gray-400 block mb-0.5">Modelo</span>
                    <span class="font-semibold text-gray-800">{{ $incidencia->modelo_equipo ?? '—' }}</span>
                </div>
                <div>
                    <span class="text-xs text-gray-400 block mb-0.5">N° Serie</span>
                    <div class="flex items-center gap-1.5">
                        <span class="font-mono text-xs font-bold text-gray-800">{{ $incidencia->serie_equipo_real ?? $incidencia->serie_equipo }}</span>
                        @if($incidencia->serie_temporal)
                            <span class="text-xs bg-amber-100 text-amber-600 px-1.5 py-0.5 rounded font-bold">Temporal</span>
                        @endif
                    </div>
                </div>
                <div>
                    <span class="text-xs text-gray-400 block mb-0.5">Ubicación</span>
                    <span class="font-semibold text-gray-800">{{ $incidencia->ubicacion_equipo ?? '—' }}</span>
                </div>
            </div>
        </div>

        {{-- HISTORIAL DE GESTIÓN --}}
        <div class="bg-white border border-gray-200 rounded-xl p-5">
            <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-4">Historial de Gestión</p>

            @php
                $tipoGestion = [
                    'nota_interna' => ['label' => 'Nota interna',  'color' => 'bg-gray-100 text-gray-600',   'dot' => 'bg-gray-400'],
                    'asignacion'   => ['label' => 'Asignación',    'color' => 'bg-blue-100 text-blue-700',   'dot' => 'bg-blue-500'],
                    'actualizacion'=> ['label' => 'Actualización', 'color' => 'bg-purple-100 text-purple-700','dot' => 'bg-purple-500'],
                    'cierre'       => ['label' => 'Cierre',        'color' => 'bg-green-100 text-green-700', 'dot' => 'bg-green-500'],
                ];
            @endphp

            <div class="space-y-3">
                @forelse($incidencia->gestiones->sortByDesc('created_at') as $g)
                @php $cfg = $tipoGestion[$g->tipo] ?? ['label' => $g->tipo, 'color' => 'bg-gray-100 text-gray-600', 'dot' => 'bg-gray-400']; @endphp
                <div class="flex gap-3">
                    <div class="flex-shrink-0 mt-1.5">
                        <div class="w-2.5 h-2.5 rounded-full {{ $cfg['dot'] }}"></div>
                    </div>
                    <div class="flex-1 pb-3 border-b border-gray-100 last:border-0">
                        <div class="flex items-center justify-between mb-1">
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-bold {{ $cfg['color'] }} px-2 py-0.5 rounded-full">{{ $cfg['label'] }}</span>
                                <span class="text-xs font-semibold text-gray-700">{{ $g->user->name ?? '—' }}</span>
                            </div>
                            <span class="text-xs text-gray-400">{{ $g->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <p class="text-sm text-gray-600">{{ $g->descripcion }}</p>
                    </div>
                </div>
                @empty
                <p class="text-sm text-gray-400 text-center py-4">Sin historial de gestión.</p>
                @endforelse
            </div>
        </div>

        {{-- CIERRE --}}
        @if($incidencia->estado_mesa === 'cerrado')
        <div class="bg-green-50 border border-green-200 rounded-xl p-5">
            <p class="text-xs font-bold text-green-700 uppercase tracking-wide mb-4">Resolución del Ticket</p>
            <div class="grid grid-cols-2 gap-4 text-sm mb-3">
                <div>
                    <span class="text-xs text-green-600 block mb-0.5">Categoría de cierre</span>
                    <span class="font-semibold text-gray-800">{{ $incidencia->categoria_cierre ?? '—' }}</span>
                </div>
                <div>
                    <span class="text-xs text-green-600 block mb-0.5">Subcategoría</span>
                    <span class="font-semibold text-gray-800">{{ $incidencia->subcategoria_cierre ?? '—' }}</span>
                </div>
            </div>
            <div>
                <span class="text-xs text-green-600 block mb-0.5">Comentario de cierre</span>
                <p class="text-sm text-gray-700">{{ $incidencia->comentario_cierre ?? '—' }}</p>
            </div>
            @if($incidencia->closed_at)
            <p class="text-xs text-green-600 mt-3">Cerrado el {{ $incidencia->closed_at->format('d/m/Y H:i') }}</p>
            @endif
        </div>
        @endif

    </div>

    {{-- COLUMNA LATERAL --}}
    <div class="space-y-4">

        {{-- CLIENTE Y LOCAL --}}
        <div class="bg-white border border-gray-200 rounded-xl p-5">
            <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-3">Cliente</p>
            <div class="space-y-2 text-sm">
                <div>
                    <span class="text-xs text-gray-400 block">Empresa</span>
                    <span class="font-bold text-gray-800">{{ $incidencia->cliente->nombre }}</span>
                </div>
                <div>
                    <span class="text-xs text-gray-400 block">Local / Sucursal</span>
                    <span class="font-semibold text-gray-700">{{ $incidencia->local->nombre ?? $incidencia->local->codigo ?? '—' }}</span>
                </div>
                <div>
                    <span class="text-xs text-gray-400 block">Contacto</span>
                    <span class="font-semibold text-gray-700">{{ $incidencia->nombre_contacto }}</span>
                </div>
                <div>
                    <span class="text-xs text-gray-400 block">Teléfono</span>
                    <span class="font-semibold text-gray-700">{{ $incidencia->telefono_contacto }}</span>
                </div>
            </div>
        </div>

        {{-- TÉCNICO --}}
        <div class="bg-white border border-gray-200 rounded-xl p-5">
            <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-3">Técnico Asignado</p>

            @if($incidencia->tecnico)
            <div class="flex items-center gap-3 mb-3">
                <div class="w-9 h-9 rounded-full bg-red-100 flex items-center justify-center text-red-700 font-bold text-sm">
                    {{ strtoupper(substr($incidencia->tecnico->name, 0, 1)) }}
                </div>
                <div>
                    <div class="font-semibold text-gray-800 text-sm">{{ $incidencia->tecnico->name }}</div>
                    <div class="text-xs text-gray-400">{{ $incidencia->tecnico->email }}</div>
                </div>
            </div>
            @if($incidencia->fecha_asignacion)
            <p class="text-xs text-gray-400">Asignado el {{ $incidencia->fecha_asignacion->format('d/m/Y H:i') }}</p>
            @endif
            @else
            <p class="text-sm text-gray-400 mb-3">Sin técnico asignado</p>
            @endif

            @if(!in_array($incidencia->estado_mesa, ['cerrado','cancelado_cliente']))
            <button onclick="document.getElementById('modal-asignar').classList.remove('hidden')"
                class="w-full mt-2 border border-red-600 text-red-600 hover:bg-red-50 text-sm font-bold px-4 py-2 rounded-lg transition-colors">
                {{ $incidencia->tecnico ? 'Reasignar Técnico' : 'Asignar Técnico' }}
            </button>
            @endif
        </div>

        {{-- SLA --}}
        <div class="bg-white border border-gray-200 rounded-xl p-5">
            <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-3">SLA</p>
            <div class="space-y-3 text-sm">
                <div>
                    <span class="text-xs text-gray-400 block mb-0.5">Límite de respuesta</span>
                    @if($incidencia->fecha_limite_respuesta)
                        <span class="font-semibold {{ now()->gt($incidencia->fecha_limite_respuesta) && !$incidencia->fecha_primera_atencion ? 'text-red-600' : 'text-gray-800' }}">
                            {{ $incidencia->fecha_limite_respuesta->format('d/m/Y H:i') }}
                        </span>
                        @if($incidencia->slaRespuestaCumplido())
                            <span class="ml-1 text-xs text-green-600 font-bold">✓ Cumplido</span>
                        @elseif(now()->gt($incidencia->fecha_limite_respuesta) && !$incidencia->fecha_primera_atencion)
                            <span class="ml-1 text-xs text-red-600 font-bold">⚠ Vencido</span>
                        @endif
                    @else
                        <span class="text-gray-400">Sin SLA</span>
                    @endif
                </div>
                <div>
                    <span class="text-xs text-gray-400 block mb-0.5">Límite de resolución</span>
                    @if($incidencia->fecha_limite_resolucion)
                        <span class="font-semibold {{ now()->gt($incidencia->fecha_limite_resolucion) && !$incidencia->closed_at ? 'text-red-600' : 'text-gray-800' }}">
                            {{ $incidencia->fecha_limite_resolucion->format('d/m/Y H:i') }}
                        </span>
                        @if($incidencia->slaResolucionCumplido())
                            <span class="ml-1 text-xs text-green-600 font-bold">✓ Cumplido</span>
                        @elseif(now()->gt($incidencia->fecha_limite_resolucion) && !$incidencia->closed_at)
                            <span class="ml-1 text-xs text-red-600 font-bold">⚠ Vencido</span>
                        @endif
                    @else
                        <span class="text-gray-400">Sin SLA</span>
                    @endif
                </div>
                @if($incidencia->closed_at)
                <div>
                    <span class="text-xs text-gray-400 block mb-0.5">Fecha de cierre</span>
                    <span class="font-semibold text-gray-800">{{ $incidencia->closed_at->format('d/m/Y H:i') }}</span>
                </div>
                @endif
            </div>
        </div>

        {{-- AGENTE --}}
        <div class="bg-white border border-gray-200 rounded-xl p-5">
            <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-3">Agente Mesa</p>
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 font-bold text-sm">
                    {{ strtoupper(substr($incidencia->agente->name ?? 'A', 0, 1)) }}
                </div>
                <div>
                    <div class="font-semibold text-gray-800 text-sm">{{ $incidencia->agente->name ?? '—' }}</div>
                    <div class="text-xs text-gray-400">{{ $incidencia->agente->email ?? '' }}</div>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- MODAL ASIGNAR TÉCNICO --}}
<div id="modal-asignar" class="hidden fixed inset-0 z-50 flex items-center justify-center">
    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"
         onclick="document.getElementById('modal-asignar').classList.add('hidden')"></div>

    {{-- Modal --}}
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 p-6">
        <div class="flex items-center justify-between mb-5">
            <h3 class="text-base font-bold text-gray-900">Asignar Técnico</h3>
            <button onclick="document.getElementById('modal-asignar').classList.add('hidden')"
                class="text-gray-400 hover:text-gray-600 text-xl leading-none">&times;</button>
        </div>

        {{-- Búsqueda --}}
        <div class="mb-3">
            <input type="text" id="buscar-tecnico" placeholder="Buscar técnico por nombre..."
                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-500"
                oninput="filtrarTecnicos(this.value)">
        </div>

        {{-- Lista de técnicos --}}
        <div id="lista-tecnicos" class="max-h-56 overflow-y-auto space-y-1 mb-5">
            @foreach($tecnicos as $tec)
            <label class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-gray-50 cursor-pointer border border-transparent has-[:checked]:border-red-200 has-[:checked]:bg-red-50 transition-colors tecnico-item"
                   data-nombre="{{ strtolower($tec->name) }}">
                <input type="radio" name="tecnico_seleccionado" value="{{ $tec->id }}"
                    class="accent-red-600"
                    {{ $incidencia->tecnico_id == $tec->id ? 'checked' : '' }}>
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

        <form method="POST" action="{{ route('incidencias.asignar', $incidencia) }}" id="form-asignar">
            @csrf
            @method('PATCH')
            <input type="hidden" name="tecnico_id" id="tecnico_id_hidden">
            <div class="flex gap-2">
                <button type="button"
                    onclick="document.getElementById('modal-asignar').classList.add('hidden')"
                    class="flex-1 border border-gray-200 text-gray-600 text-sm font-semibold px-4 py-2.5 rounded-lg hover:bg-gray-50 transition-colors">
                    Cancelar
                </button>
                <button type="button" onclick="confirmarAsignacion()"
                    class="flex-1 bg-red-600 hover:bg-red-700 text-white text-sm font-bold px-4 py-2.5 rounded-lg transition-colors">
                    Confirmar Asignación
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function filtrarTecnicos(query) {
    const items = document.querySelectorAll('.tecnico-item');
    const q = query.toLowerCase().trim();
    items.forEach(item => {
        item.style.display = item.dataset.nombre.includes(q) ? '' : 'none';
    });
}

function confirmarAsignacion() {
    const seleccionado = document.querySelector('input[name="tecnico_seleccionado"]:checked');
    if (!seleccionado) {
        alert('Por favor selecciona un técnico.');
        return;
    }
    document.getElementById('tecnico_id_hidden').value = seleccionado.value;
    document.getElementById('form-asignar').submit();
}
</script>

@endsection
