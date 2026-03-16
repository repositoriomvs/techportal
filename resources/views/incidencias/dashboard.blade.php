@extends('layouts.app')
@section('title', 'Dashboard Mesa de Ayuda')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Métricas operacionales del servicio')

@section('content')

@php
$tasa = $total > 0 ? round($cerrados / $total * 100) : 0;
$pendientes = $total - $cerrados;

$estadoLabels = [
    'abierto'           => 'Abierto',
    'en_gestion'        => 'En gestión',
    'asignado'          => 'Asignado',
    'pendiente_cliente' => 'Pend. cliente',
    'cancelado_cliente' => 'Cancelado',
    'cerrado'           => 'Cerrado',
];
$estadoColors = ['#3b82f6','#8b5cf6','#f59e0b','#f97316','#94a3b8','#22c55e'];
$tipoLabels = [
    'incidencia_hardware' => 'Hardware',
    'incidencia_software' => 'Software',
    'requerimiento'       => 'Requerimiento',
];
$tipoColors = ['#ef4444','#3b82f6','#10b981'];
@endphp

<style>
/* ── base ── */
.db { font-family: ui-sans-serif, system-ui, sans-serif; }
.card { background:#fff; border:1px solid #e5e7eb; border-radius:12px; }
.card-h { padding:12px 16px; border-bottom:1px solid #f3f4f6; display:flex; align-items:center; justify-content:space-between; }
.card-t { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:#6b7280; }
.card-b { padding:14px 16px; }

/* ── KPI ── */
.kpi { background:#fff; border:1px solid #e5e7eb; border-radius:12px; padding:16px; position:relative; overflow:hidden; }
.kpi-bar { position:absolute; left:0; top:0; bottom:0; width:3px; border-radius:12px 0 0 12px; }
.kpi-lbl { font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.08em; color:#9ca3af; margin-bottom:6px; padding-left:6px; }
.kpi-val { font-size:30px; font-weight:800; line-height:1; padding-left:6px; }
.kpi-sub { font-size:11px; color:#9ca3af; margin-top:4px; padding-left:6px; }

/* ── SLA ring ── */
.sla-wrap { display:flex; align-items:center; gap:12px; }
.sla-ring { flex-shrink:0; }
.sla-info { flex:1; }
.sla-pct  { font-size:22px; font-weight:800; line-height:1; }
.sla-meta { font-size:10px; color:#9ca3af; margin-top:2px; }
.sla-bar-track { height:4px; background:#f3f4f6; border-radius:99px; margin-top:8px; overflow:hidden; }
.sla-bar-fill  { height:100%; border-radius:99px; transition:width .8s ease; }

/* ── chip ── */
.chip { display:inline-flex; align-items:center; gap:3px; padding:2px 7px; border-radius:99px; font-size:10px; font-weight:700; }

/* ── table ── */
.tbl th { font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:#9ca3af; padding:8px 12px; background:#fafafa; }
.tbl td { font-size:12px; padding:9px 12px; border-top:1px solid #f3f4f6; color:#374151; vertical-align:middle; }
.tbl tr:hover td { background:#fafafa; }

/* ── map ── */
.region-path { fill:#e2e8f0; stroke:#fff; stroke-width:1.5; cursor:pointer; transition:fill .15s; }
.region-path:hover { fill:#fca5a5; }
.region-path.active { fill:#dc2626; }
.map-tooltip {
    position:fixed; background:#1e293b; color:#fff; font-size:11px; font-weight:600;
    padding:5px 10px; border-radius:7px; pointer-events:none; z-index:999;
    opacity:0; transition:opacity .15s; white-space:nowrap;
}

/* ── filter ── */
.f-select { border:1px solid #e5e7eb; border-radius:8px; padding:6px 10px; font-size:12px; background:#fafafa; outline:none; color:#374151; cursor:pointer; }
.f-select:focus { border-color:#dc2626; }
.f-btn { background:#dc2626; color:#fff; border:none; border-radius:8px; padding:6px 16px; font-size:12px; font-weight:600; cursor:pointer; }
.f-btn:hover { background:#b91c1c; }
.f-clear { background:none; color:#6b7280; border:1px solid #e5e7eb; border-radius:8px; padding:6px 12px; font-size:12px; cursor:pointer; text-decoration:none; display:inline-block; }
.f-clear:hover { background:#f9fafb; }
</style>

<div class="db space-y-4">

{{-- ── FILTER BAR ── --}}
<div class="card">
    <div class="card-b">
        <form method="GET" class="flex flex-wrap items-end gap-3">
            <div>
                <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#9ca3af;margin-bottom:5px">Cliente</div>
                <select name="cliente_id" class="f-select">
                    <option value="">Todos los clientes</option>
                    @foreach($clientes as $c)
                    <option value="{{ $c->id }}" {{ request('cliente_id')==$c->id?'selected':'' }}>{{ $c->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#9ca3af;margin-bottom:5px">Período</div>
                <select name="periodo" class="f-select">
                    <option value="7"   {{ request('periodo','30')=='7'  ?'selected':'' }}>7 días</option>
                    <option value="30"  {{ request('periodo','30')=='30' ?'selected':'' }}>30 días</option>
                    <option value="90"  {{ request('periodo','30')=='90' ?'selected':'' }}>90 días</option>
                    <option value="365" {{ request('periodo','30')=='365'?'selected':'' }}>12 meses</option>
                </select>
            </div>
            <button type="submit" class="f-btn">Aplicar</button>
            <a href="{{ route('incidencias.dashboard') }}" class="f-clear">Limpiar</a>

            {{-- Headline KPIs en el filtro (estilo referencia) --}}
            <div class="ml-auto flex items-center gap-6">
                @php
                    $headline = [
                        ['SLA Respuesta', $pct_sla_respuesta.'%', $pct_sla_respuesta>=80?'#16a34a':'#dc2626'],
                        ['SLA Resolución', $pct_sla_resolucion.'%', $pct_sla_resolucion>=80?'#16a34a':'#dc2626'],
                        ['Total Tickets', $total, '#1d4ed8'],
                        ['Críticos activos', $criticos, $criticos>0?'#dc2626':'#16a34a'],
                    ];
                @endphp
                @foreach($headline as [$hl, $hv, $hc])
                <div class="text-right">
                    <div style="font-size:20px;font-weight:800;color:{{ $hc }};line-height:1">{{ $hv }}</div>
                    <div style="font-size:10px;color:#9ca3af;margin-top:2px">{{ $hl }}</div>
                </div>
                @if(!$loop->last)<div style="width:1px;height:32px;background:#e5e7eb"></div>@endif
                @endforeach
            </div>
        </form>
    </div>
</div>

{{-- ── ROW 1: KPIs ── --}}
<div class="grid grid-cols-6 gap-3">
@php
$kpis = [
    ['Total',        $total,      '#64748b', 'tickets en período'],
    ['Abiertos',     $abiertos,   '#2563eb', 'sin resolver'],
    ['En gestión',   $en_gestion, '#7c3aed', 'en proceso'],
    ['Cerrados',     $cerrados,   '#16a34a', $tasa.'% del total'],
    ['Críticos',     $criticos,   '#dc2626', $criticos>0?'requiere atención':'sin críticos'],
    ['MTTR',         $mttr.'h',   '#d97706', 'tiempo resolución'],
];
@endphp
@foreach($kpis as [$l,$v,$c,$s])
<div class="kpi">
    <div class="kpi-bar" style="background:{{ $c }}"></div>
    <div class="kpi-lbl">{{ $l }}</div>
    <div class="kpi-val" style="color:{{ $c }}">{{ $v }}</div>
    <div class="kpi-sub">{{ $s }}</div>
</div>
@endforeach
</div>

{{-- ── ROW 2: SLA + Estado actual + Tendencia ── --}}
<div class="grid gap-4" style="grid-template-columns:1fr 1fr 2fr">

    {{-- SLA cards --}}
    <div class="space-y-3">
        @foreach([['SLA Respuesta','primera atención',$pct_sla_respuesta,80],['SLA Resolución','cierre en plazo',$pct_sla_resolucion,80]] as [$sl,$ss,$sp,$sm])
        @php $sc = $sp>=$sm?'#16a34a':($sp>=($sm*0.75)?'#d97706':'#dc2626'); @endphp
        <div class="card">
            <div class="card-h">
                <span class="card-t">{{ $sl }}</span>
                <span class="chip" style="background:{{ $sp>=$sm?'#f0fdf4':($sp>=($sm*0.75)?'#fffbeb':'#fef2f2') }};color:{{ $sc }}">
                    {{ $sp>=$sm?'Cumple':($sp>=($sm*0.75)?'Parcial':'Incumple') }}
                </span>
            </div>
            <div class="card-b">
                <div class="sla-wrap">
                    <svg class="sla-ring" width="64" height="64" viewBox="0 0 64 64">
                        <circle cx="32" cy="32" r="26" fill="none" stroke="#f3f4f6" stroke-width="7"/>
                        <circle cx="32" cy="32" r="26" fill="none" stroke="{{ $sc }}" stroke-width="7"
                                stroke-linecap="round" stroke-dasharray="163"
                                stroke-dashoffset="{{ 163 - ($sp/100*163) }}"
                                transform="rotate(-90 32 32)"/>
                        <text x="32" y="37" text-anchor="middle" font-size="13" font-weight="800" fill="{{ $sc }}" font-family="system-ui">{{ $sp }}%</text>
                    </svg>
                    <div class="sla-info">
                        <div class="sla-pct" style="color:{{ $sc }}">{{ $sp }}%</div>
                        <div class="sla-meta">Meta {{ $sm }}% · {{ $ss }}</div>
                        <div class="sla-bar-track">
                            <div class="sla-bar-fill" style="width:{{ $sp }}%;background:{{ $sc }}"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        {{-- Tasa cierre --}}
        <div class="card">
            <div class="card-h"><span class="card-t">Tasa de Cierre</span></div>
            <div class="card-b">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px">
                    <span style="font-size:28px;font-weight:800;color:{{ $tasa>=70?'#16a34a':($tasa>=50?'#d97706':'#dc2626') }}">{{ $tasa }}%</span>
                    <span style="font-size:11px;color:#9ca3af">{{ $cerrados }}/{{ $total }}</span>
                </div>
                <div class="sla-bar-track" style="height:6px">
                    <div class="sla-bar-fill" style="width:{{ $tasa }}%;background:{{ $tasa>=70?'#16a34a':($tasa>=50?'#d97706':'#dc2626') }}"></div>
                </div>
                <div style="display:flex;justify-content:space-between;font-size:10px;color:#9ca3af;margin-top:4px">
                    <span>{{ $cerrados }} cerrados</span><span>{{ $pendientes }} pendientes</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Estado actual (donut) --}}
    <div class="card">
        <div class="card-h"><span class="card-t">Estado Actual</span></div>
        <div class="card-b">
            <div style="display:flex;justify-content:center;margin-bottom:10px">
                <canvas id="cEstado" width="150" height="150"></canvas>
            </div>
            <div id="legEstado" class="space-y-1.5"></div>
        </div>
    </div>

    {{-- Tendencia --}}
    <div class="card">
        <div class="card-h">
            <span class="card-t">Tendencia Mensual</span>
            <span style="font-size:11px;color:#9ca3af">{{ $tendencia->count() }} períodos</span>
        </div>
        <div class="card-b">
            @if($tendencia->count())
            <canvas id="cTendencia" height="130"></canvas>
            @else
            <div style="display:flex;align-items:center;justify-content:center;height:130px;color:#9ca3af;font-size:12px">Sin datos</div>
            @endif
        </div>
    </div>
</div>

{{-- ── ROW 3: Mapa + Tipo + MTTR ── --}}
<div class="grid gap-4" style="grid-template-columns:220px 1fr 1fr">

    {{-- MAPA CHILE --}}
    <div class="card" style="overflow:hidden">
        <div class="card-h"><span class="card-t">Regiones</span></div>
        <div class="card-b" style="padding:8px;display:flex;flex-direction:column;align-items:center">
            <div id="mapTooltip" class="map-tooltip"></div>
            <svg id="mapaChile" viewBox="0 0 200 820" style="width:100%;max-height:420px" xmlns="http://www.w3.org/2000/svg">
                <!-- Arica y Parinacota -->
                <path class="region-path" data-region="Arica y Parinacota" d="M60,10 L140,10 L145,45 L130,50 L60,48 Z"/>
                <!-- Tarapacá -->
                <path class="region-path" data-region="Tarapacá" d="M60,48 L130,50 L135,85 L125,90 L58,88 Z"/>
                <!-- Antofagasta -->
                <path class="region-path" data-region="Antofagasta" d="M58,88 L125,90 L130,160 L115,165 L55,162 Z"/>
                <!-- Atacama -->
                <path class="region-path" data-region="Atacama" d="M55,162 L115,165 L118,225 L105,230 L52,227 Z"/>
                <!-- Coquimbo -->
                <path class="region-path" data-region="Coquimbo" d="M52,227 L105,230 L107,280 L96,285 L50,282 Z"/>
                <!-- Valparaíso -->
                <path class="region-path" data-region="Valparaíso" d="M50,282 L96,285 L97,315 L88,320 L48,317 Z"/>
                <!-- Metropolitana -->
                <path class="region-path" data-region="Metropolitana" d="M48,317 L88,320 L89,345 L80,348 L46,345 Z"/>
                <!-- O'Higgins -->
                <path class="region-path" data-region="O'Higgins" d="M46,345 L80,348 L81,375 L72,378 L44,375 Z"/>
                <!-- Maule -->
                <path class="region-path" data-region="Maule" d="M44,375 L72,378 L73,415 L63,418 L42,415 Z"/>
                <!-- Ñuble -->
                <path class="region-path" data-region="Ñuble" d="M42,415 L63,418 L64,440 L55,442 L40,440 Z"/>
                <!-- Biobío -->
                <path class="region-path" data-region="Biobío" d="M40,440 L55,442 L57,468 L47,471 L38,468 Z"/>
                <!-- Araucanía -->
                <path class="region-path" data-region="Araucanía" d="M38,468 L47,471 L49,505 L38,508 L35,505 Z"/>
                <!-- Los Ríos -->
                <path class="region-path" data-region="Los Ríos" d="M35,505 L38,508 L40,530 L30,532 L28,530 Z"/>
                <!-- Los Lagos -->
                <path class="region-path" data-region="Los Lagos" d="M28,530 L30,532 L35,580 L22,585 L18,580 Z"/>
                <!-- Aysén -->
                <path class="region-path" data-region="Aysén" d="M18,580 L22,585 L28,650 L12,655 L8,650 Z"/>
                <!-- Magallanes -->
                <path class="region-path" data-region="Magallanes" d="M8,650 L12,655 L20,720 L5,725 L2,720 Z"/>
            </svg>
            <div style="font-size:10px;color:#9ca3af;text-align:center;margin-top:4px">Clic para filtrar por región</div>
            <button onclick="clearRegion()" id="btnClearRegion" style="display:none;margin-top:6px;font-size:10px;color:#dc2626;background:none;border:1px solid #fca5a5;border-radius:6px;padding:3px 10px;cursor:pointer">
                Limpiar selección
            </button>
        </div>
    </div>

    {{-- Tipo de ticket --}}
    <div class="card">
        <div class="card-h"><span class="card-t">Tipo de Ticket</span></div>
        <div class="card-b">
            <div style="display:flex;justify-content:center;margin-bottom:10px">
                <canvas id="cTipo" width="160" height="160"></canvas>
            </div>
            <div id="legTipo" class="space-y-1.5"></div>
        </div>
    </div>

    {{-- MTTR + top clientes --}}
    <div class="space-y-3">
        <div class="card">
            <div class="card-h"><span class="card-t">MTTR por Prioridad</span></div>
            <div class="card-b">
                <div class="grid grid-cols-3 gap-2">
                    @foreach([['Alta',$mttr_alta,'#dc2626','#fef2f2'],['Media',$mttr_media,'#d97706','#fffbeb'],['Baja',$mttr_baja,'#16a34a','#f0fdf4']] as [$pl,$pv,$pc,$pb])
                    <div style="background:{{ $pb }};border-radius:10px;padding:10px;text-align:center">
                        <div style="font-size:10px;font-weight:700;color:{{ $pc }};text-transform:uppercase;letter-spacing:.06em;margin-bottom:4px">{{ $pl }}</div>
                        <div style="font-size:22px;font-weight:800;color:{{ $pc }};line-height:1">{{ $pv=='???' ? '—' : $pv }}</div>
                        <div style="font-size:10px;color:{{ $pc }};opacity:.6;margin-top:2px">{{ $pv!='???' ? 'horas' : 'sin datos' }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-h"><span class="card-t">Top Clientes</span></div>
            <div style="overflow-x:auto">
                <table class="w-full tbl">
                    <thead><tr>
                        <th class="text-left">Cliente</th>
                        <th class="text-center">Total</th>
                        <th class="text-center">Abiert.</th>
                        <th class="text-center">SLA</th>
                    </tr></thead>
                    <tbody>
                    @forelse($por_cliente->sortByDesc('total')->take(5) as $item)
                    @php $s=$item->pct_sla; $sc2=$s===null?'#9ca3af':($s>=80?'#16a34a':($s>=60?'#d97706':'#dc2626')); @endphp
                    <tr>
                        <td style="font-weight:600;font-size:11px">{{ $item->cliente->nombre??'—' }}</td>
                        <td style="text-align:center;font-weight:700">{{ $item->total }}</td>
                        <td style="text-align:center;color:{{ $item->abiertos>0?'#2563eb':'#9ca3af' }};font-weight:700">{{ $item->abiertos }}</td>
                        <td style="text-align:center;font-weight:700;color:{{ $sc2 }}">{{ $s!==null?$s.'%':'—' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" style="text-align:center;color:#9ca3af;padding:16px;font-size:11px">Sin datos</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- ── ROW 4: Técnicos + Críticos ── --}}
<div class="grid grid-cols-2 gap-4">
    <div class="card">
        <div class="card-h"><span class="card-t">Rendimiento por Técnico</span></div>
        <div style="overflow-x:auto">
            <table class="w-full tbl">
                <thead><tr>
                    <th class="text-left">Técnico</th>
                    <th class="text-center">Total</th>
                    <th class="text-center">Activos</th>
                    <th class="text-center">Cerrados</th>
                    <th class="text-center">SLA</th>
                    <th class="text-left">Carga</th>
                </tr></thead>
                <tbody>
                @forelse($por_tecnico as $item)
                @php
                    $ca=$item->abiertos??0;
                    $cc2=$ca>=6?'#dc2626':($ca>=3?'#d97706':'#16a34a');
                    $cb2=$ca>=6?'#fef2f2':($ca>=3?'#fffbeb':'#f0fdf4');
                    $cl2=$ca>=6?'Alta':($ca>=3?'Media':'Normal');
                    $ts=$item->pct_sla;
                @endphp
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:6px">
                            <div style="width:26px;height:26px;border-radius:50%;background:#fee2e2;color:#dc2626;font-size:10px;font-weight:800;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                                {{ strtoupper(substr($item->tecnico->name??'T',0,1)) }}
                            </div>
                            <span style="font-weight:600;font-size:11px">{{ $item->tecnico->name??'—' }}</span>
                        </div>
                    </td>
                    <td style="text-align:center;font-weight:700">{{ $item->total }}</td>
                    <td style="text-align:center;color:#2563eb;font-weight:700">{{ $item->abiertos??0 }}</td>
                    <td style="text-align:center;color:#16a34a;font-weight:700">{{ $item->cerrados??0 }}</td>
                    <td style="text-align:center;font-weight:700;color:{{ ($ts??0)>=80?'#16a34a':'#dc2626' }}">{{ $ts!==null?$ts.'%':'—' }}</td>
                    <td><span class="chip" style="background:{{ $cb2 }};color:{{ $cc2 }}">{{ $cl2 }}</span></td>
                </tr>
                @empty
                <tr><td colspan="6" style="text-align:center;color:#9ca3af;padding:16px;font-size:11px">Sin técnicos asignados</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-h">
            <div style="display:flex;align-items:center;gap:8px">
                <span class="card-t" style="color:#dc2626">Tickets Críticos Activos</span>
                @if($tickets_criticos->count())
                <span class="chip" style="background:#dc2626;color:#fff">{{ $tickets_criticos->count() }}</span>
                @endif
            </div>
        </div>
        @if($tickets_criticos->count())
        <div style="overflow-x:auto">
            <table class="w-full tbl">
                <thead><tr>
                    <th class="text-left">Ticket</th>
                    <th class="text-left">Cliente</th>
                    <th class="text-left">Asunto</th>
                    <th class="text-left">Técnico</th>
                    <th class="text-left">SLA</th>
                    <th></th>
                </tr></thead>
                <tbody>
                @foreach($tickets_criticos as $inc)
                <tr>
                    <td style="font-family:monospace;font-weight:700;font-size:11px;color:#6b7280">{{ $inc->numero_ticket }}</td>
                    <td style="font-weight:600;font-size:11px">{{ $inc->cliente->nombre }}</td>
                    <td style="font-size:11px;color:#6b7280;max-width:140px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">{{ $inc->asunto }}</td>
                    <td style="font-size:11px;color:#6b7280">{{ $inc->tecnico->name??'Sin asignar' }}</td>
                    <td style="font-size:11px">
                        @if($inc->fecha_limite_resolucion)
                            @if(now()->gt($inc->fecha_limite_resolucion))
                                <span class="chip" style="background:#fef2f2;color:#dc2626">Vencido</span>
                            @else
                                <span style="color:#d97706;font-weight:600;font-size:11px">{{ now()->diffForHumans($inc->fecha_limite_resolucion,true) }}</span>
                            @endif
                        @else
                            <span style="color:#9ca3af">—</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('incidencias.show',$inc) }}"
                           style="background:#dc2626;color:#fff;font-size:11px;font-weight:700;padding:4px 10px;border-radius:6px;text-decoration:none;display:inline-block">
                            Ver →
                        </a>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="card-b" style="text-align:center;color:#16a34a;font-size:12px;font-weight:600;padding:20px">
            ✓ Sin tickets críticos activos
        </div>
        @endif
    </div>
</div>

</div>{{-- end .db --}}

<div id="mapTooltip" class="map-tooltip"></div>

{{-- SCRIPTS --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script>
Chart.defaults.font.family = "ui-sans-serif, system-ui, sans-serif";
Chart.defaults.color = '#9ca3af';

/* ── data ── */
const dEstado = {
    labels: [@foreach($por_estado as $k=>$v) "{{ $estadoLabels[$k]??$k }}",@endforeach],
    data:   [@foreach($por_estado as $v) {{ $v }},@endforeach],
    colors: ['#3b82f6','#8b5cf6','#f59e0b','#f97316','#94a3b8','#22c55e']
};
const dTipo = {
    labels: [@foreach($por_tipo as $k=>$v) "{{ $tipoLabels[$k]??$k }}",@endforeach],
    data:   [@foreach($por_tipo as $v) {{ $v }},@endforeach],
    colors: ['#ef4444','#3b82f6','#10b981']
};
const dTend = {
    labels: [@foreach($tendencia as $t) "{{ \Carbon\Carbon::createFromFormat('Y-m',$t->mes)->locale('es')->isoFormat('MMM YY') }}",@endforeach],
    data:   [@foreach($tendencia as $t) {{ $t->total }},@endforeach]
};

/* ── donut ── */
function donut(id, legId, labels, data, colors, size=150) {
    const ctx = document.getElementById(id);
    if (!ctx) return;
    ctx.width = size; ctx.height = size;
    new Chart(ctx, {
        type: 'doughnut',
        data: { labels, datasets:[{ data, backgroundColor:colors, borderWidth:2, borderColor:'#fff', hoverOffset:4 }] },
        options: {
            cutout:'70%', responsive:false,
            plugins:{ legend:{display:false}, tooltip:{ callbacks:{ label: c=>' '+c.label+': '+c.raw } } }
        }
    });
    const total = data.reduce((a,b)=>a+b,0);
    const leg = document.getElementById(legId);
    if (!leg) return;
    labels.forEach((l,i)=>{
        const pct = total>0?Math.round(data[i]/total*100):0;
        leg.innerHTML += `<div style="display:flex;align-items:center;justify-content:space-between;font-size:11px;padding:2px 0">
            <div style="display:flex;align-items:center;gap:6px">
                <span style="width:8px;height:8px;border-radius:2px;background:${colors[i]};display:inline-block;flex-shrink:0"></span>
                <span style="color:#374151;font-weight:500">${l}</span>
            </div>
            <span style="color:#6b7280;font-weight:700">${data[i]} <span style="color:#d1d5db;font-weight:400">(${pct}%)</span></span>
        </div>`;
    });
}

/* ── line ── */
function buildLine() {
    const ctx = document.getElementById('cTendencia');
    if (!ctx || !dTend.labels.length) return;
    new Chart(ctx, {
        type:'line',
        data:{ labels:dTend.labels, datasets:[{
            label:'Tickets', data:dTend.data,
            fill:true, backgroundColor:'rgba(220,38,38,0.06)', borderColor:'#dc2626',
            borderWidth:2, pointBackgroundColor:'#dc2626', pointRadius:3,
            pointHoverRadius:5, tension:0.4
        }]},
        options:{
            responsive:true,
            plugins:{ legend:{display:false} },
            scales:{
                x:{ grid:{display:false}, ticks:{font:{size:10}} },
                y:{ grid:{color:'#f9fafb'}, ticks:{precision:0,font:{size:10}}, beginAtZero:true }
            }
        }
    });
}

donut('cEstado','legEstado', dEstado.labels, dEstado.data, dEstado.colors);
donut('cTipo',  'legTipo',   dTipo.labels,   dTipo.data,   dTipo.colors);
buildLine();

/* ── MAPA ── */
const tooltip = document.getElementById('mapTooltip');
let activeRegion = null;

document.querySelectorAll('.region-path').forEach(path => {
    path.addEventListener('mouseenter', e => {
        tooltip.textContent = path.dataset.region;
        tooltip.style.opacity = '1';
    });
    path.addEventListener('mousemove', e => {
        tooltip.style.left = (e.clientX + 12) + 'px';
        tooltip.style.top  = (e.clientY - 28) + 'px';
    });
    path.addEventListener('mouseleave', () => {
        tooltip.style.opacity = '0';
    });
    path.addEventListener('click', () => {
        const reg = path.dataset.region;
        if (activeRegion === reg) {
            clearRegion();
            return;
        }
        document.querySelectorAll('.region-path').forEach(p => p.classList.remove('active'));
        path.classList.add('active');
        activeRegion = reg;
        document.getElementById('btnClearRegion').style.display = 'inline-block';
        // Aquí podrías hacer filtrado real; por ahora muestra un indicador visual
        console.log('Región seleccionada:', reg);
    });
});

function clearRegion() {
    document.querySelectorAll('.region-path').forEach(p => p.classList.remove('active'));
    activeRegion = null;
    document.getElementById('btnClearRegion').style.display = 'none';
}
</script>
@endsection