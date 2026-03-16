@extends('layouts.app')

@section('title', $cliente->nombre)
@section('page-title', $cliente->nombre)
@section('page-subtitle', $cliente->codigo . ' · ' . $cliente->documentos->count() . ' recursos')

@section('topbar-actions')
    @role('admin')
    <a href="{{ route('documentos.create', $cliente) }}"
       class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors">
        + Subir Recurso
    </a>
    @endrole
@endsection

@section('content')

{{-- Header cliente --}}
<div class="bg-white border border-gray-200 rounded-xl p-5 mb-5 shadow-sm">
    <div class="flex items-center gap-4">
        <div class="w-14 h-14 rounded-xl flex items-center justify-center text-white font-bold text-xl flex-shrink-0"
             style="background-color: {{ $cliente->color }}">
            {{ $cliente->iniciales }}
        </div>
        <div class="flex-1">
            <div class="font-bold text-xl text-gray-900">{{ $cliente->nombre }}</div>
            <div class="text-sm text-gray-400 font-mono mt-0.5">
                {{ $cliente->codigo }}
                @if($cliente->contacto) · {{ $cliente->contacto }} @endif
                @if($cliente->email) · {{ $cliente->email }} @endif
            </div>
        </div>
        <div class="hidden sm:flex gap-6 text-center">
            <div>
                <div class="text-2xl font-bold text-gray-900">{{ $documentos->count() }}</div>
                <div class="text-xs text-gray-400 font-mono uppercase">Documentos</div>
            </div>
            <div>
                <div class="text-2xl font-bold text-gray-900">{{ $procedimientos->count() }}</div>
                <div class="text-xs text-gray-400 font-mono uppercase">Procedimientos</div>
            </div>
            <div>
                <div class="text-2xl font-bold text-gray-900">{{ $imagenes->count() }}</div>
                <div class="text-xs text-gray-400 font-mono uppercase">Imágenes</div>
            </div>
        </div>
        @role('admin')
        <a href="{{ route('clientes.edit', $cliente) }}"
           class="text-sm text-gray-400 hover:text-gray-600 border border-gray-200 rounded-lg px-3 py-2 transition-colors">
            ✏️ Editar
        </a>
        @endrole
    </div>

    {{-- ══════════════════════════════════════ --}}
    {{-- BLOQUE SLA                            --}}
    {{-- ══════════════════════════════════════ --}}
    <div class="mt-4 pt-4 border-t border-gray-100">
        @if($slas->isNotEmpty())
            <div class="flex items-center gap-2 mb-3">
                <span class="inline-flex items-center gap-1.5 bg-green-50 text-green-700 border border-green-200 text-xs font-semibold px-3 py-1 rounded-full">
                    ✓ Cuenta con SLA
                </span>
            </div>

            {{-- Tabla SLA --}}
            <div class="border border-gray-200 rounded-lg overflow-hidden">
                {{-- Header --}}
                <div class="grid grid-cols-4 bg-gray-50 border-b border-gray-200">
                    <div class="px-4 py-2.5 text-xs font-bold text-gray-500 uppercase tracking-wider">Prioridad</div>
                    <div class="px-4 py-2.5 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Tiempo respuesta</div>
                    <div class="px-4 py-2.5 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Tiempo resolución</div>
                    <div class="px-4 py-2.5 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Cambio de equipo</div>
                </div>

                @foreach([
                    'alta'  => ['label' => 'Alta',  'color' => 'bg-red-500'],
                    'media' => ['label' => 'Media', 'color' => 'bg-amber-500'],
                    'baja'  => ['label' => 'Baja',  'color' => 'bg-green-500'],
                ] as $prioridad => $info)
                @if(isset($slas[$prioridad]))
                @php $sla = $slas[$prioridad]; @endphp
                <div class="grid grid-cols-4 border-b border-gray-100 last:border-b-0 items-center {{ $loop->even ? 'bg-gray-50/50' : '' }}">
                    <div class="px-4 py-3 flex items-center gap-2">
                        <span class="inline-block w-2 h-2 rounded-full {{ $info['color'] }}"></span>
                        <span class="text-sm font-semibold text-gray-700">{{ $info['label'] }}</span>
                    </div>
                    <div class="px-4 py-3 text-center">
                        @if($sla->horas_respuesta > 0)
                            <span class="text-sm font-bold text-gray-900">{{ $sla->horas_respuesta }}</span>
                            <span class="text-xs text-gray-400 ml-1">hr{{ $sla->horas_respuesta !== 1 ? 's' : '' }}</span>
                        @else
                            <span class="text-xs text-gray-400">—</span>
                        @endif
                    </div>
                    <div class="px-4 py-3 text-center">
                        @if($sla->horas_resolucion > 0)
                            <span class="text-sm font-bold text-gray-900">{{ $sla->horas_resolucion }}</span>
                            <span class="text-xs text-gray-400 ml-1">hr{{ $sla->horas_resolucion !== 1 ? 's' : '' }}</span>
                        @else
                            <span class="text-xs text-gray-400">—</span>
                        @endif
                    </div>
                    <div class="px-4 py-3 text-center">
                        @if($sla->horas_cambio_equipo > 0)
                            <span class="text-sm font-bold text-gray-900">{{ $sla->horas_cambio_equipo }}</span>
                            <span class="text-xs text-gray-400 ml-1">hr{{ $sla->horas_cambio_equipo !== 1 ? 's' : '' }}</span>
                        @else
                            <span class="text-xs text-gray-400">—</span>
                        @endif
                    </div>
                </div>
                @endif
                @endforeach
            </div>

        @else
            <span class="inline-flex items-center gap-1.5 bg-gray-50 text-gray-400 border border-gray-200 text-xs font-semibold px-3 py-1 rounded-full">
                — Sin SLA definido
            </span>
        @endif
    </div>
</div>

{{-- Tabs --}}
<div x-data="{ tab: 'documentos' }">

    <div class="flex gap-0 bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm mb-4">
        <button @click="tab = 'documentos'"
                :class="tab === 'documentos' ? 'bg-red-50 text-red-600 font-bold border-b-2 border-red-600' : 'text-gray-500 hover:bg-gray-50'"
                class="flex-1 px-4 py-3 text-sm transition-all flex items-center justify-center gap-2">
            📄 Documentos
            <span class="bg-gray-100 text-gray-600 text-xs font-mono px-2 py-0.5 rounded-full">{{ $documentos->count() }}</span>
        </button>
        <button @click="tab = 'procedimientos'"
                :class="tab === 'procedimientos' ? 'bg-red-50 text-red-600 font-bold border-b-2 border-red-600' : 'text-gray-500 hover:bg-gray-50'"
                class="flex-1 px-4 py-3 text-sm transition-all flex items-center justify-center gap-2 border-x border-gray-200">
            📋 Procedimientos
            <span class="bg-gray-100 text-gray-600 text-xs font-mono px-2 py-0.5 rounded-full">{{ $procedimientos->count() }}</span>
        </button>
        <button @click="tab = 'imagenes'"
                :class="tab === 'imagenes' ? 'bg-red-50 text-red-600 font-bold border-b-2 border-red-600' : 'text-gray-500 hover:bg-gray-50'"
                class="flex-1 px-4 py-3 text-sm transition-all flex items-center justify-center gap-2">
            🖼️ Imágenes
            <span class="bg-gray-100 text-gray-600 text-xs font-mono px-2 py-0.5 rounded-full">{{ $imagenes->count() }}</span>
        </button>
    </div>

    <div x-show="tab === 'documentos'">
        @include('clientes.partials.tabla-recursos', ['recursos' => $documentos, 'categoria' => 'documento'])
    </div>
    <div x-show="tab === 'procedimientos'">
        @include('clientes.partials.tabla-recursos', ['recursos' => $procedimientos, 'categoria' => 'procedimiento'])
    </div>
    <div x-show="tab === 'imagenes'">
        @include('clientes.partials.tabla-recursos', ['recursos' => $imagenes, 'categoria' => 'imagen'])
    </div>

</div>

@endsection
