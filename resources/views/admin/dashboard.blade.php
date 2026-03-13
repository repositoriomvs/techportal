@extends('layouts.app')
 
@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Administrativo')
@section('page-subtitle', 'Estadísticas de uso del sistema · ' . now()->format('d/m/Y'))
 
@section('content')
 
{{-- Tacómetros --}}
@php
$tacometros = [
    ['label' => 'Ingresos hoy',        'valor' => $ingresosHoy,               'max' => 20,  'badge' => 'Hoy',    'color_badge' => 'bg-blue-50 text-blue-600',   'unidad' => 'sesiones', 'sub' => null],
    ['label' => 'Ingresos semana',     'valor' => $ingresosSemana,            'max' => 100, 'badge' => 'Semana', 'color_badge' => 'bg-purple-50 text-purple-600','unidad' => 'sesiones', 'sub' => 'Media: '.$mediaIngresosSemanal.'/sem'],
    ['label' => 'Ingresos mes',        'valor' => $ingresosMes,               'max' => 400, 'badge' => 'Mes',    'color_badge' => 'bg-green-50 text-green-600',  'unidad' => 'sesiones', 'sub' => 'Media: '.$mediaIngresosDiaria.'/día'],
    ['label' => 'Horas activas hoy',   'valor' => round($minutosHoy / 60, 1), 'max' => 12,  'badge' => 'Hoy',    'color_badge' => 'bg-blue-50 text-blue-600',   'unidad' => 'horas',    'sub' => null],
    ['label' => 'Horas activas semana','valor' => round($minutosSemana / 60, 1),'max' => 60,'badge' => 'Semana', 'color_badge' => 'bg-purple-50 text-purple-600','unidad' => 'horas',    'sub' => 'Media: '.$mediaHorasSemanal.'h/sem'],
    ['label' => 'Horas activas mes',   'valor' => round($minutosMes / 60, 1), 'max' => 240, 'badge' => 'Mes',    'color_badge' => 'bg-green-50 text-green-600',  'unidad' => 'horas',    'sub' => 'Media: '.$mediaHorasDiaria.'h/día'],
];
@endphp
 
<div class="grid grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
    @foreach($tacometros as $t)
    @php
        $pct      = $t['max'] > 0 ? min($t['valor'] / $t['max'], 1) : 0;
        $angulo   = -135 + ($pct * 270);
        $radio    = 54;
        $cx = 70; $cy = 72;
 
        // Color verde → amarillo → rojo
        if ($pct < 0.5) {
            $r = round($pct * 2 * 220);
            $g = 190;
        } else {
            $r = 220;
            $g = round((1 - ($pct - 0.5) * 2) * 190);
        }
        $stroke = "rgb({$r},{$g},40)";
 
        // Arco fondo: de -135 a 135
        $startRad = deg2rad(-135);
        $endBgRad = deg2rad(135);
        $bx1 = $cx + $radio * cos($startRad);
        $by1 = $cy + $radio * sin($startRad);
        $bx2 = $cx + $radio * cos($endBgRad);
        $by2 = $cy + $radio * sin($endBgRad);
 
        // Arco valor
        $endRad   = deg2rad($angulo);
        $x1 = $cx + $radio * cos($startRad);
        $y1 = $cy + $radio * sin($startRad);
        $x2 = $cx + $radio * cos($endRad);
        $y2 = $cy + $radio * sin($endRad);
        $largeArc = ($pct * 270) > 180 ? 1 : 0;
 
        // Aguja
        $agujaRad = deg2rad($angulo);
        $ax = $cx + 40 * cos($agujaRad);
        $ay = $cy + 40 * sin($agujaRad);
    @endphp
 
    <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm flex flex-col items-center">
 
        {{-- Header --}}
        <div class="w-full flex justify-between items-center mb-2">
            <span class="text-xs font-mono text-gray-400 uppercase tracking-wider leading-tight">{{ $t['label'] }}</span>
            <span class="text-xs font-mono font-bold px-2 py-0.5 rounded-full {{ $t['color_badge'] }}">
                {{ $t['badge'] }}
            </span>
        </div>
 
        {{-- Valor grande --}}
        <div class="text-3xl font-bold text-gray-900 mb-1">
            {{ $t['valor'] }}
            <span class="text-sm text-gray-400 font-normal">{{ $t['unidad'] }}</span>
        </div>
 
        {{-- SVG Tacómetro --}}
        <svg viewBox="0 0 140 100" class="w-44 h-28">
 
            {{-- Arco fondo --}}
            <path d="M {{ round($bx1,2) }} {{ round($by1,2) }} A {{ $radio }} {{ $radio }} 0 1 1 {{ round($bx2,2) }} {{ round($by2,2) }}"
                  fill="none" stroke="#e5e7eb" stroke-width="10" stroke-linecap="round"/>
 
            {{-- Arco valor --}}
            @if($pct > 0.01)
            <path d="M {{ round($x1,2) }} {{ round($y1,2) }} A {{ $radio }} {{ $radio }} 0 {{ $largeArc }} 1 {{ round($x2,2) }} {{ round($y2,2) }}"
                  fill="none" stroke="{{ $stroke }}" stroke-width="10" stroke-linecap="round"/>
            @endif
 
            {{-- Marcas --}}
            @for($m = 0; $m <= 10; $m++)
            @php
                $mRad = deg2rad(-135 + $m * 27);
                $isMajor = $m % 5 === 0;
                $r1 = $isMajor ? 44 : 47;
                $r2 = $isMajor ? 58 : 54;
                $mx1 = $cx + $r1 * cos($mRad);
                $my1 = $cy + $r1 * sin($mRad);
                $mx2 = $cx + $r2 * cos($mRad);
                $my2 = $cy + $r2 * sin($mRad);
            @endphp
            <line x1="{{ round($mx1,2) }}" y1="{{ round($my1,2) }}"
                  x2="{{ round($mx2,2) }}" y2="{{ round($my2,2) }}"
                  stroke="{{ $isMajor ? '#9ca3af' : '#d1d5db' }}"
                  stroke-width="{{ $isMajor ? 2 : 1 }}"/>
            @endfor
 
            {{-- Etiquetas 0% 50% 100% --}}
            @php
                $lbls = [
                    ['ang' => -135, 'txt' => '0'],
                    ['ang' => 0,    'txt' => '50%'],
                    ['ang' => 135,  'txt' => '100%'],
                ];
            @endphp
            @foreach($lbls as $lbl)
            @php
                $lRad = deg2rad($lbl['ang']);
                $lx = $cx + 68 * cos($lRad);
                $ly = $cy + 68 * sin($lRad);
            @endphp
            <text x="{{ round($lx,1) }}" y="{{ round($ly,1) }}"
                  text-anchor="middle" dominant-baseline="middle"
                  font-size="7" fill="#9ca3af" font-family="monospace">{{ $lbl['txt'] }}</text>
            @endforeach
 
            {{-- Aguja --}}
            <line x1="{{ $cx }}" y1="{{ $cy }}"
                  x2="{{ round($ax,2) }}" y2="{{ round($ay,2) }}"
                  stroke="#1f2937" stroke-width="2.5" stroke-linecap="round"/>
            <circle cx="{{ $cx }}" cy="{{ $cy }}" r="5" fill="#1f2937"/>
            <circle cx="{{ $cx }}" cy="{{ $cy }}" r="2.5" fill="white"/>
 
            {{-- Porcentaje abajo --}}
            <text x="{{ $cx }}" y="{{ $cy + 18 }}"
                  text-anchor="middle" font-size="10"
                  fill="#6b7280" font-family="monospace">
                {{ round($pct * 100) }}%
            </text>
 
        </svg>
 
        {{-- Sub texto --}}
        @if($t['sub'])
        <div class="text-xs text-gray-400 font-mono mt-1">{{ $t['sub'] }}</div>
        @endif
 
    </div>
    @endforeach
</div>
 
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
 
    {{-- Actividad por usuario hoy --}}
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100">
            <h2 class="font-bold text-gray-900">Actividad por usuario hoy</h2>
        </div>
        @if($actividadPorUsuario->isEmpty())
            <div class="p-8 text-center text-gray-400 text-sm">Sin actividad hoy.</div>
        @else
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="text-left px-5 py-2.5 text-xs font-mono text-gray-400 uppercase">Usuario</th>
                    <th class="text-center px-5 py-2.5 text-xs font-mono text-gray-400 uppercase">Ingresos</th>
                    <th class="text-right px-5 py-2.5 text-xs font-mono text-gray-400 uppercase">Tiempo</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($actividadPorUsuario as $actividad)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-full bg-red-600 flex items-center justify-center text-white text-xs font-bold">
                                {{ strtoupper(substr($actividad['usuario'], 0, 2)) }}
                            </div>
                            <span class="text-sm font-medium text-gray-900">{{ $actividad['usuario'] }}</span>
                        </div>
                    </td>
                    <td class="px-5 py-3 text-center">
                        <span class="text-sm font-bold text-gray-900">{{ $actividad['ingresos'] }}</span>
                    </td>
                    <td class="px-5 py-3 text-right">
                        <span class="text-sm font-mono text-gray-500">
                            {{ floor($actividad['minutos'] / 60) }}h {{ $actividad['minutos'] % 60 }}m
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
 
    {{-- Últimas sesiones --}}
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100">
            <h2 class="font-bold text-gray-900">Últimas sesiones</h2>
        </div>
        @if($ultimasSesiones->isEmpty())
            <div class="p-8 text-center text-gray-400 text-sm">Sin sesiones registradas.</div>
        @else
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="text-left px-5 py-2.5 text-xs font-mono text-gray-400 uppercase">Usuario</th>
                    <th class="text-left px-5 py-2.5 text-xs font-mono text-gray-400 uppercase">Ingreso</th>
                    <th class="text-right px-5 py-2.5 text-xs font-mono text-gray-400 uppercase">Duración</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($ultimasSesiones as $sesion)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-full bg-red-600 flex items-center justify-center text-white text-xs font-bold">
                                {{ strtoupper(substr($sesion->user->name ?? '?', 0, 2)) }}
                            </div>
                            <span class="text-sm font-medium text-gray-900">{{ $sesion->user->name ?? 'Desconocido' }}</span>
                        </div>
                    </td>
                    <td class="px-5 py-3">
                        <div class="text-xs font-mono text-gray-500">{{ $sesion->login_at->format('d/m H:i') }}</div>
                    </td>
                    <td class="px-5 py-3 text-right">
                        @if($sesion->duracion_minutos)
                            <span class="text-xs font-mono text-gray-500">
                                {{ floor($sesion->duracion_minutos / 60) }}h {{ $sesion->duracion_minutos % 60 }}m
                            </span>
                        @else
                            <span class="text-xs font-mono text-green-500">● Activo</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
 
</div>
 
{{-- Ranking usuarios del mes --}}
<div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden mt-4">
    <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
        <h2 class="font-bold text-gray-900">Ranking de usuarios — {{ now()->translatedFormat('F Y') }}</h2>
        <span class="text-xs font-mono text-gray-400">Por ingresos al sistema</span>
    </div>
 
    @if($rankingUsuarios->isEmpty())
        <div class="p-8 text-center text-gray-400 text-sm">Sin actividad este mes.</div>
    @else
    <table class="w-full">
        <thead>
            <tr class="bg-gray-50 border-b border-gray-100">
                <th class="text-left px-5 py-2.5 text-xs font-mono text-gray-400 uppercase w-10">#</th>
                <th class="text-left px-5 py-2.5 text-xs font-mono text-gray-400 uppercase">Usuario</th>
                <th class="text-center px-5 py-2.5 text-xs font-mono text-gray-400 uppercase">Ingresos</th>
                <th class="text-right px-5 py-2.5 text-xs font-mono text-gray-400 uppercase">Tiempo total</th>
                <th class="text-right px-5 py-2.5 text-xs font-mono text-gray-400 uppercase hidden sm:table-cell">Barra</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @php $maxIngresos = $rankingUsuarios->first()['total_ingresos']; @endphp
            @foreach($rankingUsuarios as $i => $item)
            <tr class="hover:bg-gray-50 transition-colors
                {{ $i === 0 ? 'bg-yellow-50' : '' }}
                {{ $i === $rankingUsuarios->count() - 1 && $rankingUsuarios->count() > 1 ? 'bg-red-50' : '' }}">
                <td class="px-5 py-3 text-center">
                    @if($i === 0) <span class="text-lg">🥇</span>
                    @elseif($i === 1) <span class="text-lg">🥈</span>
                    @elseif($i === 2) <span class="text-lg">🥉</span>
                    @else <span class="text-sm font-mono text-gray-400">{{ $i + 1 }}</span>
                    @endif
                </td>
                <td class="px-5 py-3">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-full flex items-center justify-center text-white text-xs font-bold
                            {{ $i === 0 ? 'bg-yellow-500' : ($i === $rankingUsuarios->count() - 1 ? 'bg-red-400' : 'bg-red-600') }}">
                            {{ strtoupper(substr($item['usuario'], 0, 2)) }}
                        </div>
                        <span class="text-sm font-medium text-gray-900">{{ $item['usuario'] }}</span>
                    </div>
                </td>
                <td class="px-5 py-3 text-center">
                    <span class="text-sm font-bold text-gray-900">{{ $item['total_ingresos'] }}</span>
                    <span class="text-xs text-gray-400 font-mono ml-1">sesiones</span>
                </td>
                <td class="px-5 py-3 text-right">
                    <span class="text-sm font-mono text-gray-500">
                        {{ floor($item['total_minutos'] / 60) }}h {{ $item['total_minutos'] % 60 }}m
                    </span>
                </td>
                <td class="px-5 py-3 hidden sm:table-cell">
                    <div class="flex items-center justify-end gap-2">
                        <div class="w-24 bg-gray-100 rounded-full h-2">
                            <div class="h-2 rounded-full {{ $i === 0 ? 'bg-yellow-400' : ($i === $rankingUsuarios->count() - 1 ? 'bg-red-400' : 'bg-red-600') }}"
                                 style="width: {{ $maxIngresos > 0 ? round(($item['total_ingresos'] / $maxIngresos) * 100) : 0 }}%">
                            </div>
                        </div>
                        <span class="text-xs font-mono text-gray-400 w-8 text-right">
                            {{ $maxIngresos > 0 ? round(($item['total_ingresos'] / $maxIngresos) * 100) : 0 }}%
                        </span>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="px-5 py-3 border-t border-gray-100 bg-gray-50 flex items-center gap-4 text-xs font-mono text-gray-400">
        <span>🥇 Mayor actividad del mes</span>
        <span class="text-red-400">🔴 Menor actividad del mes</span>
    </div>
    @endif
</div>
 
@endsection
 