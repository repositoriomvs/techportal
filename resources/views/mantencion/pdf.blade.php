<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>{{ $mantencion->numero_orden }} - Mantención Preventiva</title>
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
body { font-family: Arial, Helvetica, sans-serif; font-size: 10pt; color: #1e293b; background: white; }

/* ── VARIABLES DE COLOR ── */
/* Primario: #0f172a (casi negro azulado) */
/* Acento:   #dc2626 (rojo) */
/* Gris suave: #f8fafc */

/* ══════════════════════════════════
   HEADER
══════════════════════════════════ */
.header-wrap {
    display: table;
    width: 100%;
    margin-bottom: 6mm;
}
.header-logo-cell {
    display: table-cell;
    width: 35mm;
    vertical-align: middle;
}
.header-logo-cell img {
    max-height: 18mm;
    max-width: 32mm;
    width: auto;
    height: auto;
}
.header-center-cell {
    display: table-cell;
    vertical-align: middle;
    text-align: center;
    padding: 0 6mm;
}
.header-title {
    font-size: 17pt;
    font-weight: 700;
    color: #0f172a;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    line-height: 1.1;
}
.header-subtitle {
    font-size: 8pt;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.12em;
    margin-top: 1.5mm;
}
.header-right-cell {
    display: table-cell;
    width: 35mm;
    vertical-align: middle;
    text-align: right;
}
/* Placeholder logo cliente — recuadro punteado igual al PDF original */
.logo-placeholder {
    display: inline-block;
    width: 28mm;
    height: 18mm;
    border: 1.5px dashed #aaa;
    border-radius: 3px;
}

/* Línea decorativa bajo el header */
.header-line {
    height: 3px;
    background: #0f172a;
    margin-bottom: 1mm;
}
.header-line-accent {
    height: 2px;
    background: #dc2626;
    width: 40mm;
    margin-bottom: 5mm;
}

/* ══════════════════════════════════
   BANDA DE ORDEN
══════════════════════════════════ */
.orden-band {
    background: #0f172a;
    color: white;
    display: table;
    width: 100%;
    margin-bottom: 5mm;
    border-radius: 3px;
}
.orden-band-left {
    display: table-cell;
    padding: 3.5mm 5mm;
    vertical-align: middle;
}
.orden-band-dot {
    display: inline-block;
    width: 3mm;
    height: 3mm;
    background: #dc2626;
    border-radius: 50%;
    margin-right: 2mm;
    vertical-align: middle;
}
.orden-band-num {
    font-size: 12pt;
    font-weight: 700;
    letter-spacing: 0.06em;
    vertical-align: middle;
}
.orden-band-right {
    display: table-cell;
    padding: 3.5mm 5mm;
    text-align: right;
    vertical-align: middle;
}
.orden-band-meta {
    font-size: 7.5pt;
    color: #94a3b8;
    font-family: 'Courier New', monospace;
}

/* ══════════════════════════════════
   SECCIONES
══════════════════════════════════ */
.seccion {
    margin-bottom: 4mm;
    border: 1px solid #e2e8f0;
    border-radius: 3px;
    overflow: hidden;
}
.seccion-header {
    display: table;
    width: 100%;
    background: #f1f5f9;
    border-bottom: 1px solid #e2e8f0;
}
.seccion-header-accent {
    display: table-cell;
    width: 4px;
    background: #dc2626;
}
.seccion-header-text {
    display: table-cell;
    padding: 2.5mm 4mm;
    font-size: 7.5pt;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: #334155;
}
.seccion-header-right {
    display: table-cell;
    padding: 2.5mm 4mm;
    text-align: right;
    font-size: 7pt;
    color: #94a3b8;
    vertical-align: middle;
}

/* ══════════════════════════════════
   CAMPOS
══════════════════════════════════ */
.campos-grid { display: table; width: 100%; border-collapse: collapse; }
.campos-row  { display: table-row; }
.campo {
    display: table-cell;
    padding: 2.5mm 4mm;
    border-right: 1px solid #f1f5f9;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: top;
    background: white;
}
.campo:last-child { border-right: none; }
.campo-label {
    font-size: 6.5pt;
    font-weight: 700;
    color: #94a3b8;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    margin-bottom: 1.5mm;
    font-family: 'Courier New', monospace;
}
.campo-value {
    font-size: 9.5pt;
    font-weight: 600;
    color: #0f172a;
    line-height: 1.3;
}

/* ══════════════════════════════════
   TARJETAS RESUMEN
══════════════════════════════════ */
.cards-row {
    display: table;
    width: 100%;
    border-collapse: separate;
    border-spacing: 2mm;
    margin-bottom: 4mm;
}
.card {
    display: table-cell;
    width: 25%;
    padding: 3.5mm 4mm;
    border-radius: 4px;
    text-align: center;
    vertical-align: middle;
}
.card-total   { background: #f8fafc; border: 1.5px solid #e2e8f0; }
.card-op      { background: #f0fdf4; border: 1.5px solid #bbf7d0; }
.card-obs     { background: #fffbeb; border: 1.5px solid #fde68a; }
.card-def     { background: #fef2f2; border: 1.5px solid #fecaca; }
.card-label   { font-size: 6.5pt; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: #64748b; margin-bottom: 2mm; }
.card-value   { font-size: 22pt; font-weight: 700; line-height: 1; margin-bottom: 1mm; }
.card-pct     { font-size: 7pt; color: #94a3b8; font-family: 'Courier New', monospace; }
.card-v-total { color: #0f172a; }
.card-v-op    { color: #16a34a; }
.card-v-obs   { color: #d97706; }
.card-v-def   { color: #dc2626; }

/* ══════════════════════════════════
   TABLA RESUMEN
══════════════════════════════════ */
.resumen-body { display: table; width: 100%; border-collapse: collapse; }
.col-tabla    { display: table-cell; width: 58%; vertical-align: top; padding: 0 3mm 4mm 4mm; }
.col-grafico  { display: table-cell; width: 42%; vertical-align: top; padding: 0 4mm 4mm 2mm; }

.tabla-resumen {
    width: 100%;
    border-collapse: collapse;
    font-size: 8.5pt;
}
.tabla-resumen thead th {
    background: #f8fafc;
    padding: 2mm 3mm;
    font-weight: 700;
    font-size: 7pt;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.07em;
    border: 1px solid #e2e8f0;
    text-align: center;
}
.tabla-resumen thead th:first-child { text-align: left; }
.tabla-resumen tbody td {
    padding: 2mm 3mm;
    border: 1px solid #f1f5f9;
    text-align: center;
    color: #374151;
    vertical-align: middle;
}
.tabla-resumen tbody td:first-child { text-align: left; font-weight: 600; color: #1e293b; }
.tabla-resumen tfoot td {
    padding: 2mm 3mm;
    border: 1px solid #e2e8f0;
    background: #f1f5f9;
    font-weight: 700;
    text-align: center;
    font-size: 8.5pt;
}
.tabla-resumen tfoot td:first-child { text-align: left; }
.n-op  { color: #16a34a; font-weight: 700; }
.n-obs { color: #d97706; font-weight: 700; }
.n-def { color: #dc2626; font-weight: 700; }

/* ══════════════════════════════════
   GRÁFICO DE BARRAS
══════════════════════════════════ */
.grafico-box {
    border: 1px solid #e2e8f0;
    border-radius: 4px;
    padding: 3mm;
    background: #f8fafc;
}
.grafico-title {
    font-size: 7pt;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    text-align: center;
    margin-bottom: 3mm;
}

/* ══════════════════════════════════
   FIRMA
══════════════════════════════════ */
.firma-table { width: 100%; border-collapse: collapse; }
.firma-campo {
    padding: 2.5mm 4mm;
    border: 1px solid #f1f5f9;
    vertical-align: top;
    background: white;
}
.firma-img-cell {
    padding: 4mm;
    text-align: center;
    background: #f8fafc;
    border: 1px solid #f1f5f9;
    vertical-align: middle;
}

/* ══════════════════════════════════
   EQUIPOS
══════════════════════════════════ */
.equipo-wrap {
    border: 1.5px solid #cbd5e1;
    border-radius: 4px;
    overflow: hidden;
    margin-bottom: 4mm;
}

.equipo-header-band {
    background: #0f172a;
    color: white;
    display: table;
    width: 100%;
}
.equipo-header-left {
    display: table-cell;
    padding: 4mm 5mm;
    vertical-align: middle;
}
.equipo-num-badge {
    display: inline-block;
    width: 8mm;
    height: 8mm;
    background: #dc2626;
    color: white;
    border-radius: 50%;
    text-align: center;
    line-height: 8mm;
    font-size: 9pt;
    font-weight: 700;
    margin-right: 2.5mm;
    vertical-align: middle;
}
.equipo-tipo-label {
    font-size: 11pt;
    font-weight: 700;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    vertical-align: middle;
}
.equipo-header-right {
    display: table-cell;
    padding: 4mm 5mm;
    text-align: right;
    vertical-align: middle;
}

/* Pills de estado */
.pill {
    display: inline-block;
    padding: 2mm 5mm;
    border-radius: 99px;
    font-size: 8.5pt;
    font-weight: 700;
}
.pill-op  { background: #dcfce7; color: #15803d; }
.pill-obs { background: #fef3c7; color: #92400e; }
.pill-def { background: #fee2e2; color: #b91c1c; }

/* Datos del equipo */
.equipo-datos-band {
    display: table;
    width: 100%;
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
}
.equipo-dato {
    display: table-cell;
    padding: 2.5mm 4mm;
    border-right: 1px solid #e2e8f0;
    width: 25%;
}
.equipo-dato:last-child { border-right: none; }
.equipo-dato-label {
    font-size: 6.5pt;
    font-weight: 700;
    color: #94a3b8;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    margin-bottom: 1mm;
    font-family: 'Courier New', monospace;
}
.equipo-dato-value {
    font-size: 9pt;
    font-weight: 600;
    color: #0f172a;
}

/* Checklist */
.checklist-section-bar {
    background: #f1f5f9;
    padding: 2mm 4mm;
    display: table;
    width: 100%;
    border-top: 1px solid #e2e8f0;
    border-bottom: 1px solid #e2e8f0;
}
.checklist-section-dot {
    display: table-cell;
    width: 3mm;
    vertical-align: middle;
}
.checklist-section-dot-inner {
    width: 2mm;
    height: 2mm;
    background: #dc2626;
    border-radius: 50%;
}
.checklist-section-text {
    display: table-cell;
    font-size: 7.5pt;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: #334155;
    padding-left: 2mm;
    vertical-align: middle;
}

.checklist-item {
    display: table;
    width: 100%;
    border-bottom: 1px solid #f8fafc;
    padding: 2mm 4mm;
}
.checklist-item-alt { background: #fafafa; }
.checklist-item-nombre {
    display: table-cell;
    font-size: 9pt;
    color: #374151;
    vertical-align: middle;
    padding-right: 3mm;
}
.critico-tag {
    display: inline-block;
    font-size: 6.5pt;
    background: #fff7ed;
    color: #c2410c;
    border: 1px solid #fed7aa;
    padding: 0.5mm 2.5mm;
    border-radius: 2px;
    margin-left: 2mm;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}
.checklist-item-resp {
    display: table-cell;
    width: 30mm;
    text-align: right;
    vertical-align: middle;
}
.respuesta {
    display: inline-block;
    font-size: 7.5pt;
    font-weight: 700;
    padding: 1.5mm 4mm;
    border-radius: 3px;
    min-width: 24mm;
    text-align: center;
}
.r-operativo    { background: #dcfce7; color: #15803d; }
.r-defectuoso   { background: #fee2e2; color: #b91c1c; }
.r-no_aplica    { background: #f1f5f9; color: #64748b; }
.r-realizado    { background: #dbeafe; color: #1d4ed8; }
.r-no_realizado { background: #fef3c7; color: #92400e; }

/* Observaciones */
.obs-band {
    padding: 3mm 4mm;
    background: #fffbeb;
    border-top: 1px solid #fde68a;
    border-bottom: 1px solid #fde68a;
}
.obs-label {
    font-size: 6.5pt;
    font-weight: 700;
    color: #92400e;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    margin-bottom: 1.5mm;
    font-family: 'Courier New', monospace;
}
.obs-text { font-size: 9pt; color: #374151; line-height: 1.5; }

/* Fotos */
.fotos-band { display: table; width: 100%; padding: 3.5mm 4mm; background: white; }
.foto-cell  { display: table-cell; width: 50%; padding: 0 2mm; vertical-align: top; }
.foto-cell:first-child { padding-left: 0; }
.foto-cell:last-child  { padding-right: 0; }
.foto-img   { width: 100%; height: 38mm; object-fit: cover; border: 1px solid #e2e8f0; border-radius: 3px; display: block; }
.foto-ph    {
    width: 100%; height: 38mm;
    border: 1.5px dashed #cbd5e1;
    border-radius: 3px;
    background: #f8fafc;
    text-align: center;
    padding-top: 13mm;
}
.foto-ph-icon { font-size: 14pt; color: #cbd5e1; }
.foto-ph-text { font-size: 7.5pt; color: #94a3b8; margin-top: 1.5mm; }
.foto-caption { font-size: 7pt; color: #94a3b8; text-align: center; margin-top: 1.5mm; font-style: italic; }

/* ══════════════════════════════════
   FOOTER
══════════════════════════════════ */
.doc-footer {
    margin-top: 6mm;
    border-top: 1px solid #e2e8f0;
    padding-top: 2.5mm;
    display: table;
    width: 100%;
}
.footer-left {
    display: table-cell;
    font-size: 7pt;
    color: #94a3b8;
    font-family: 'Courier New', monospace;
    vertical-align: middle;
}
.footer-center {
    display: table-cell;
    font-size: 7pt;
    color: #cbd5e1;
    text-align: center;
    vertical-align: middle;
}
.footer-right {
    display: table-cell;
    font-size: 7pt;
    color: #94a3b8;
    text-align: right;
    font-family: 'Courier New', monospace;
    vertical-align: middle;
}

/* ══════════════════════════════════
   UTILIDADES
══════════════════════════════════ */
.page-break { page-break-before: always; }
.no-break   { page-break-inside: avoid; }
.clearfix:after { content: ""; display: table; clear: both; }
</style>
</head>
<body>
<div style="margin: 14mm 18mm;">

{{-- ═══════════════════════════════════════════════════════
     HOJA 1 — PORTADA / DATOS DEL SERVICIO
═══════════════════════════════════════════════════════ --}}

{{-- HEADER --}}
<div class="header-wrap">
    {{-- Logo empresa prestadora (izquierda) --}}
    <div class="header-logo-cell">
        <img src="{{ public_path('images/logo.png') }}" alt="Logo empresa">
    </div>
    {{-- Título central --}}
    <div class="header-center-cell">
        <div class="header-title">Mantención Preventiva</div>
        <div class="header-subtitle">Informe Técnico de Servicio</div>
    </div>
    {{-- Placeholder logo cliente (derecha) — recuadro punteado --}}
    <div class="header-right-cell">
        <div class="logo-placeholder"></div>
    </div>
</div>
<div class="header-line"></div>
<div class="header-line-accent"></div>

{{-- BANDA ORDEN --}}
<div class="orden-band">
    <div class="orden-band-left">
        <span class="orden-band-dot"></span>
        <span class="orden-band-num">{{ $mantencion->numero_orden }}</span>
    </div>
    <div class="orden-band-right">
        <div class="orden-band-meta">Emitido: {{ now()->format('d/m/Y') }} — {{ now()->format('H:i') }} hrs</div>
    </div>
</div>

{{-- DATOS DEL SERVICIO --}}
<div class="seccion">
    <div class="seccion-header">
        <div class="seccion-header-accent"></div>
        <div class="seccion-header-text">1. Datos del Servicio</div>
    </div>
    <div class="campos-grid">
        <div class="campos-row">
            <div class="campo" style="width:22%">
                <div class="campo-label">Fecha</div>
                <div class="campo-value">{{ $mantencion->fecha->format('d/m/Y') }}</div>
            </div>
            <div class="campo" style="width:18%">
                <div class="campo-label">Hora inicio</div>
                <div class="campo-value">{{ $mantencion->hora_inicio }}</div>
            </div>
            <div class="campo" style="width:18%">
                <div class="campo-label">Hora término</div>
                <div class="campo-value">{{ $mantencion->hora_termino ?? '—' }}</div>
            </div>
            <div class="campo" style="width:42%">
                <div class="campo-label">Técnico responsable</div>
                <div class="campo-value">{{ $mantencion->user->name }}</div>
            </div>
        </div>
    </div>
</div>

{{-- DATOS DEL CLIENTE --}}
<div class="seccion">
    <div class="seccion-header">
        <div class="seccion-header-accent"></div>
        <div class="seccion-header-text">2. Datos del Cliente</div>
    </div>
    <div class="campos-grid">
        <div class="campos-row">
            <div class="campo" style="width:28%">
                <div class="campo-label">Cliente</div>
                <div class="campo-value">{{ $mantencion->cliente->nombre }}</div>
            </div>
            <div class="campo" style="width:18%">
                <div class="campo-label">Código local</div>
                <div class="campo-value">{{ $mantencion->codigo_local }}</div>
            </div>
            <div class="campo" style="width:18%">
                <div class="campo-label">Ciudad</div>
                <div class="campo-value">{{ $mantencion->ciudad }}</div>
            </div>
            <div class="campo" style="width:36%">
                <div class="campo-label">Dirección</div>
                <div class="campo-value">{{ $mantencion->direccion }}</div>
            </div>
        </div>
    </div>
</div>

{{-- RESUMEN EJECUTIVO --}}
@php
    $tipo_labels = [
        'impresora_sin_adf'   => 'Impresora sin ADF',
        'impresora_con_adf'   => 'Impresora con ADF',
        'impresora_termica'   => 'Impresora Térmica',
        'computador_aio'      => 'Computador AIO',
        'computador_desktop'  => 'Computador Desktop',
        'computador_notebook' => 'Computador Notebook',
    ];
    $total     = $mantencion->equipos->count();
    $operativo = $mantencion->equipos->where('estado_final','operativo')->count();
    $obs       = $mantencion->equipos->where('estado_final','operativo_con_observaciones')->count();
    $defec     = $mantencion->equipos->where('estado_final','defectuoso')->count();
    $pct_op    = $total > 0 ? round($operativo * 100 / $total) : 0;
    $pct_obs   = $total > 0 ? round($obs  * 100 / $total) : 0;
    $pct_def   = $total > 0 ? round($defec * 100 / $total) : 0;
    $por_tipo  = $mantencion->equipos->groupBy('tipo');
    $max_val   = max($operativo, $obs, $defec, 1);
    $bar_h     = 28;
    $h_op      = max(1, round($bar_h * $operativo / $max_val));
    $h_obs     = max(1, round($bar_h * $obs / $max_val));
    $h_def     = max(1, round($bar_h * $defec / $max_val));
@endphp

<div class="seccion">
    <div class="seccion-header">
        <div class="seccion-header-accent"></div>
        <div class="seccion-header-text">3. Resumen Ejecutivo</div>
        <div class="seccion-header-right">{{ $total }} equipo{{ $total !== 1 ? 's' : '' }} atendido{{ $total !== 1 ? 's' : '' }}</div>
    </div>

    {{-- Tarjetas KPI --}}
    <div style="padding: 4mm 4mm 0;">
        <div class="cards-row">
            <div class="card card-total">
                <div class="card-label">Total equipos</div>
                <div class="card-value card-v-total">{{ $total }}</div>
                <div class="card-pct">en esta orden</div>
            </div>
            <div class="card card-op">
                <div class="card-label">Operativos</div>
                <div class="card-value card-v-op">{{ $operativo }}</div>
                <div class="card-pct">{{ $pct_op }}% del total</div>
            </div>
            <div class="card card-obs">
                <div class="card-label">Con observaciones</div>
                <div class="card-value card-v-obs">{{ $obs }}</div>
                <div class="card-pct">{{ $pct_obs }}% del total</div>
            </div>
            <div class="card card-def">
                <div class="card-label">Defectuosos</div>
                <div class="card-value card-v-def">{{ $defec }}</div>
                <div class="card-pct">{{ $pct_def }}% del total</div>
            </div>
        </div>
    </div>

    {{-- Tabla + Gráfico --}}
    <div class="resumen-body">
        <div class="col-tabla">
            <table class="tabla-resumen">
                <thead>
                    <tr>
                        <th style="width:44%; text-align:left;">Tipo de equipo</th>
                        <th style="width:14%">Total</th>
                        <th style="width:14%">Op.</th>
                        <th style="width:14%">Obs.</th>
                        <th style="width:14%">Def.</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($por_tipo as $tipo => $equipos_tipo)
                    @php
                        $t_total = $equipos_tipo->count();
                        $t_op    = $equipos_tipo->where('estado_final','operativo')->count();
                        $t_obs   = $equipos_tipo->where('estado_final','operativo_con_observaciones')->count();
                        $t_def   = $equipos_tipo->where('estado_final','defectuoso')->count();
                    @endphp
                    <tr>
                        <td>{{ $tipo_labels[$tipo] ?? $tipo }}</td>
                        <td><strong>{{ $t_total }}</strong></td>
                        <td class="{{ $t_op  > 0 ? 'n-op'  : '' }}">{{ $t_op  }}</td>
                        <td class="{{ $t_obs > 0 ? 'n-obs' : '' }}">{{ $t_obs }}</td>
                        <td class="{{ $t_def > 0 ? 'n-def' : '' }}">{{ $t_def }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td>Total general</td>
                        <td>{{ $total }}</td>
                        <td class="n-op">{{ $operativo }}</td>
                        <td class="n-obs">{{ $obs }}</td>
                        <td class="n-def">{{ $defec }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="col-grafico">
            <div class="grafico-box">
                <div class="grafico-title">Distribución de estados</div>
                <table style="width:100%; border-collapse:collapse; height:{{ $bar_h + 14 }}mm;">
                    <tr style="vertical-align:bottom; height:{{ $bar_h }}mm;">
                        <td style="width:7mm; vertical-align:bottom; border-right:1px solid #e2e8f0; padding-right:1.5mm;">
                            <div style="font-size:5.5pt; color:#94a3b8; text-align:right; margin-bottom:{{ $bar_h - 4.5 }}mm; font-family:'Courier New',monospace;">{{ $max_val }}</div>
                            <div style="font-size:5.5pt; color:#94a3b8; text-align:right; font-family:'Courier New',monospace;">0</div>
                        </td>
                        <td style="vertical-align:bottom; border-bottom:1px solid #e2e8f0; padding:0 2mm;">
                            <table style="width:94%; margin:0 auto; border-collapse:collapse; height:{{ $bar_h }}mm;">
                                <tr style="vertical-align:bottom; height:{{ $bar_h }}mm;">
                                    <td style="width:33%; vertical-align:bottom; text-align:center; padding:0 3mm;">
                                        <div style="background: linear-gradient(180deg, #4ade80, #16a34a); height:{{ $h_op }}mm; border-radius:3px 3px 0 0; box-shadow: 0 -1px 3px rgba(22,163,74,0.3);"></div>
                                    </td>
                                    <td style="width:33%; vertical-align:bottom; text-align:center; padding:0 3mm;">
                                        <div style="background: linear-gradient(180deg, #fbbf24, #d97706); height:{{ $h_obs }}mm; border-radius:3px 3px 0 0; box-shadow: 0 -1px 3px rgba(217,119,6,0.3);"></div>
                                    </td>
                                    <td style="width:33%; vertical-align:bottom; text-align:center; padding:0 3mm;">
                                        <div style="background: linear-gradient(180deg, #f87171, #dc2626); height:{{ $h_def }}mm; border-radius:3px 3px 0 0; box-shadow: 0 -1px 3px rgba(220,38,38,0.3);"></div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="padding:0 2mm;">
                            <table style="width:94%; margin:0 auto; border-collapse:collapse;">
                                <tr>
                                    <td style="width:33%; text-align:center; padding-top:2mm;">
                                        <div style="font-size:9pt; font-weight:700; color:#16a34a;">{{ $operativo }}</div>
                                        <div style="font-size:5.5pt; color:#64748b; margin-top:0.5mm;">Operativo</div>
                                    </td>
                                    <td style="width:33%; text-align:center; padding-top:2mm;">
                                        <div style="font-size:9pt; font-weight:700; color:#d97706;">{{ $obs }}</div>
                                        <div style="font-size:5.5pt; color:#64748b; margin-top:0.5mm;">Con obs.</div>
                                    </td>
                                    <td style="width:33%; text-align:center; padding-top:2mm;">
                                        <div style="font-size:9pt; font-weight:700; color:#dc2626;">{{ $defec }}</div>
                                        <div style="font-size:5.5pt; color:#64748b; margin-top:0.5mm;">Defectuoso</div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- FIRMA DEL RECEPTOR --}}
<div class="no-break">
    <div class="seccion" style="margin-top:4mm;">
        <div class="seccion-header">
            <div class="seccion-header-accent"></div>
            <div class="seccion-header-text">4. Recepción del Servicio</div>
        </div>
        <table class="firma-table">
            <tr>
                <td class="firma-campo" style="width:50%; border-right:1px solid #f1f5f9;">
                    <div class="campo-label">Nombre receptor</div>
                    <div class="campo-value" style="font-size:10pt;">{{ $mantencion->firma_nombre ?? '—' }}</div>
                </td>
                <td class="firma-campo" style="width:50%;">
                    <div class="campo-label">Cargo</div>
                    <div class="campo-value" style="font-size:10pt;">{{ $mantencion->firma_cargo ?? '—' }}</div>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="firma-img-cell" style="height:22mm;">
                    @if($mantencion->firma_imagen)
                        <img src="{{ $mantencion->firma_imagen }}"
                             style="height:18mm; width:auto; max-width:45%; display:block; margin:0 auto;">
                    @else
                        <div style="font-size:8.5pt; color:#94a3b8; padding:4mm 0;">Sin firma registrada</div>
                    @endif
                    <div style="margin-top:2mm; border-top:1px solid #e2e8f0; padding-top:1.5mm; font-size:6.5pt; color:#94a3b8; font-family:'Courier New',monospace; text-align:center;">
                        Firma conforme — {{ $mantencion->fecha->format('d/m/Y') }}
                    </div>
                </td>
            </tr>
        </table>
    </div>

    {{-- FOOTER HOJA 1 --}}
    <div class="doc-footer">
        <div class="footer-left">{{ $mantencion->numero_orden }} · Hoja 1 de {{ $total + 1 }}</div>
        <div class="footer-center">CONFIDENCIAL · USO INTERNO</div>
        <div class="footer-right">Generado: {{ now()->format('d/m/Y H:i') }} hrs</div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════
     HOJAS DE EQUIPOS — 1 POR EQUIPO
═══════════════════════════════════════════════════════ --}}
@foreach($mantencion->equipos as $equipo)
@php
    $estado_map = [
        'operativo'                   => ['class' => 'pill-op',  'label' => '✓ Operativo'],
        'operativo_con_observaciones' => ['class' => 'pill-obs', 'label' => '⚠ Con observaciones'],
        'defectuoso'                  => ['class' => 'pill-def', 'label' => '✕ Defectuoso'],
    ];
    $ei         = $estado_map[$equipo->estado_final] ?? ['class' => '', 'label' => '-'];
    $secciones  = $equipo->respuestas->groupBy('item.seccion');
    $tipo_label = $tipo_labels[$equipo->tipo] ?? $equipo->tipo;
    $num_equipo = $loop->iteration;
@endphp

<div class="page-break"></div>

{{-- Mini header reutilizable en cada hoja --}}
<div class="header-wrap" style="margin-bottom:3mm;">
    {{-- Logo empresa prestadora (izquierda) --}}
    <div class="header-logo-cell">
        <img src="{{ public_path('images/logo.png') }}" alt="Logo empresa">
    </div>
    {{-- Info central --}}
    <div class="header-center-cell">
        <div style="font-size:8.5pt; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.1em;">
            Mantención Preventiva · Detalle de Equipo
        </div>
        <div style="font-size:7.5pt; color:#94a3b8; margin-top:1mm; font-family:'Courier New',monospace;">
            {{ $mantencion->numero_orden }} · {{ $mantencion->cliente->nombre }} · {{ $mantencion->fecha->format('d/m/Y') }}
        </div>
    </div>
    {{-- Placeholder logo cliente (derecha) --}}
    <div class="header-right-cell">
        <div class="logo-placeholder"></div>
    </div>
</div>
<div class="header-line"></div>
<div class="header-line-accent"></div>

{{-- BLOQUE DEL EQUIPO --}}
<div class="equipo-wrap">

    {{-- Header del equipo --}}
    <div class="equipo-header-band">
        <div class="equipo-header-left">
            <span class="equipo-num-badge">{{ $num_equipo }}</span>
            <span class="equipo-tipo-label">{{ $tipo_label }}</span>
        </div>
        <div class="equipo-header-right">
            <span class="pill {{ $ei['class'] }}">{{ $ei['label'] }}</span>
        </div>
    </div>

    {{-- Datos técnicos --}}
    <div class="equipo-datos-band">
        <div class="equipo-dato">
            <div class="equipo-dato-label">Marca</div>
            <div class="equipo-dato-value">{{ $equipo->marca ?? '—' }}</div>
        </div>
        <div class="equipo-dato">
            <div class="equipo-dato-label">Modelo</div>
            <div class="equipo-dato-value">{{ $equipo->modelo ?? '—' }}</div>
        </div>
        <div class="equipo-dato">
            <div class="equipo-dato-label">N° Serie</div>
            <div class="equipo-dato-value">{{ $equipo->serie ?? '—' }}</div>
        </div>
        <div class="equipo-dato">
            <div class="equipo-dato-label">Estado final</div>
            <div class="equipo-dato-value">{{ $ei['label'] }}</div>
        </div>
    </div>

    {{-- Checklist --}}
    @foreach($secciones as $seccion => $items)
    <div class="checklist-section-bar">
        <div class="checklist-section-dot"><div class="checklist-section-dot-inner"></div></div>
        <div class="checklist-section-text">{{ $seccion }}</div>
    </div>
    @foreach($items as $idx => $respuesta)
    @php
        $r_map = [
            'operativo'    => ['class' => 'r-operativo',    'label' => 'Operativo'],
            'defectuoso'   => ['class' => 'r-defectuoso',   'label' => 'Defectuoso'],
            'no_aplica'    => ['class' => 'r-no_aplica',    'label' => 'No aplica'],
            'realizado'    => ['class' => 'r-realizado',    'label' => 'Realizado'],
            'no_realizado' => ['class' => 'r-no_realizado', 'label' => 'No realizado'],
        ];
        $r = $r_map[$respuesta->respuesta] ?? ['class' => '', 'label' => $respuesta->respuesta];
    @endphp
    <div class="checklist-item {{ $idx % 2 === 1 ? 'checklist-item-alt' : '' }}">
        <div class="checklist-item-nombre">
            {{ $respuesta->item->descripcion }}
            @if($respuesta->item->es_critico)
                <span class="critico-tag">Crítico</span>
            @endif
        </div>
        <div class="checklist-item-resp">
            <span class="respuesta {{ $r['class'] }}">{{ $r['label'] }}</span>
        </div>
    </div>
    @endforeach
    @endforeach

    {{-- Observaciones --}}
    @if($equipo->observaciones)
    <div class="obs-band">
        <div class="obs-label">Observaciones técnicas</div>
        <div class="obs-text">{{ $equipo->observaciones }}</div>
    </div>
    @endif

    {{-- Fotografías --}}
    <div class="fotos-band">
        <div class="foto-cell">
            @if($equipo->foto_equipo)
                <img class="foto-img" src="{{ storage_path('app/public/' . $equipo->foto_equipo) }}">
            @else
                <div class="foto-ph">
                    <div class="foto-ph-icon">📷</div>
                    <div class="foto-ph-text">Sin fotografía</div>
                </div>
            @endif
            <div class="foto-caption">Fotografía del equipo</div>
        </div>
        <div class="foto-cell">
            @if($equipo->foto_serie)
                <img class="foto-img" src="{{ storage_path('app/public/' . $equipo->foto_serie) }}">
            @else
                <div class="foto-ph">
                    <div class="foto-ph-icon">🔢</div>
                    <div class="foto-ph-text">Sin fotografía</div>
                </div>
            @endif
            <div class="foto-caption">Fotografía número de serie</div>
        </div>
    </div>

</div>{{-- fin equipo-wrap --}}

{{-- FOOTER DE EQUIPO --}}
<div class="doc-footer">
    <div class="footer-left">{{ $mantencion->numero_orden }} · Equipo {{ $num_equipo }} de {{ $total }}</div>
    <div class="footer-center">CONFIDENCIAL · USO INTERNO</div>
    <div class="footer-right">Generado: {{ now()->format('d/m/Y H:i') }} hrs</div>
</div>

@endforeach

</div>{{-- fin márgenes --}}
</body>
</html>
