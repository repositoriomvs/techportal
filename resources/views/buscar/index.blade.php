@extends('layouts.app')

@section('title', 'Búsqueda')
@section('page-title', 'Resultados de búsqueda')
@section('page-subtitle', count($resultados) . ' resultados para "' . $query . '"')

@section('content')

@if(!$query)
    <div class="bg-white border border-gray-200 rounded-xl p-16 text-center">
        <div class="text-5xl mb-4">🔍</div>
        <div class="text-gray-500 text-sm">Escribe algo en el buscador para comenzar.</div>
    </div>
@elseif(empty($resultados))
    <div class="bg-white border border-gray-200 rounded-xl p-16 text-center">
        <div class="text-5xl mb-4">😔</div>
        <div class="text-gray-700 font-semibold mb-2">Sin resultados para "{{ $query }}"</div>
        <div class="text-gray-400 text-sm">Intenta con otros términos de búsqueda.</div>
    </div>
@else
    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
        @foreach($resultados as $resultado)
        <a href="{{ $resultado['url'] }}"
           class="flex items-center gap-4 px-5 py-3.5 border-b border-gray-50 hover:bg-gray-50 transition-colors last:border-b-0">

            <div class="text-2xl w-8 text-center flex-shrink-0">{{ $resultado['icono'] }}</div>

            <div class="flex-1 min-w-0">
                <div class="text-sm font-semibold text-gray-900">{{ $resultado['titulo'] }}</div>
                <div class="text-xs text-gray-400 font-mono">{{ $resultado['subtitulo'] }}</div>
            </div>

            <span class="text-xs font-mono font-bold px-2 py-1 rounded flex-shrink-0
                {{ $resultado['color'] === 'red'    ? 'bg-red-50 text-red-600' : '' }}
                {{ $resultado['color'] === 'blue'   ? 'bg-blue-50 text-blue-600' : '' }}
                {{ $resultado['color'] === 'green'  ? 'bg-green-50 text-green-600' : '' }}
                {{ $resultado['color'] === 'purple' ? 'bg-purple-50 text-purple-600' : '' }}">
                {{ $resultado['badge'] }}
            </span>

            <span class="text-gray-300 flex-shrink-0">→</span>
        </a>
        @endforeach
    </div>
@endif

@endsection