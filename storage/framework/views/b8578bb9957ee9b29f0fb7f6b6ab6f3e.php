<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title><?php echo e($mantencion->numero_orden); ?> - Mantencion Preventiva</title>
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
body { font-family: Arial, Helvetica, sans-serif; font-size: 10pt; color: #1a1a1a; }

.doc-header { display: table; width: 100%; margin-bottom: 4mm; border-bottom: 2px solid #1a1a1a; padding-bottom: 4mm; }
.doc-header-left { display: table-cell; width: 30mm; vertical-align: middle; }
.doc-header-center { display: table-cell; text-align: center; vertical-align: middle; padding: 0 5mm; }
.doc-header-right { display: table-cell; width: 30mm; vertical-align: middle; text-align: right; }
.logo-placeholder { width: 28mm; height: 18mm; border: 1.5px dashed #aaa; border-radius: 3px; display: block; }
.doc-title { font-size: 16pt; font-weight: 700; letter-spacing: 0.05em; color: #1a1a1a; text-transform: uppercase; margin-bottom: 2mm; }
.doc-subtitle { font-size: 8pt; color: #555; letter-spacing: 0.06em; text-transform: uppercase; }

.orden-strip { background: #1a1a1a; color: white; padding: 4mm 5mm; display: table; width: 100%; margin-bottom: 4mm; border-radius: 2px; }
.orden-num { display: table-cell; font-size: 13pt; font-weight: 700; letter-spacing: 0.06em; }
.orden-fecha { display: table-cell; text-align: right; font-size: 8pt; color: #aaa; vertical-align: middle; }

.seccion { margin-bottom: 3mm; border: 1px solid #d1d5db; border-radius: 2px; overflow: hidden; }
.seccion-title { background: #f3f4f6; border-bottom: 1px solid #d1d5db; padding: 2.5mm 4mm; font-size: 8pt; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #374151; }

.campos-grid { display: table; width: 100%; border-collapse: collapse; }
.campos-row { display: table-row; }
.campo { display: table-cell; padding: 1.5mm 3mm; border-right: 1px solid #e5e7eb; border-bottom: 1px solid #e5e7eb; vertical-align: top; }
.campo:last-child { border-right: none; }
.campo-label { font-size: 7pt; font-weight: 700; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 1.5mm; }
.campo-value { font-size: 9.5pt; font-weight: 600; color: #111827; }

.resumen-cards { display: table; width: 100%; border-collapse: collapse; margin-bottom: 4mm; }
.resumen-card { display: table-cell; width: 25%; padding: 3mm 4mm; border: 1px solid #e5e7eb; text-align: center; background: #f9fafb; }
.resumen-card-label { font-size: 7pt; font-weight: 700; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 2mm; }
.resumen-card-value { font-size: 20pt; font-weight: 700; }
.resumen-card-sub { font-size: 7pt; color: #9ca3af; margin-top: 1mm; }

.resumen-body { display: table; width: 100%; border-collapse: collapse; }
.resumen-tabla-col { display: table-cell; width: 60%; vertical-align: top; padding-right: 3mm; }
.resumen-grafico-col { display: table-cell; width: 40%; vertical-align: top; padding-left: 3mm; }

.resumen-table { width: 100%; border-collapse: collapse; font-size: 8.5pt; }
.resumen-table thead th { background: #f3f4f6; padding: 2mm 3mm; text-align: center; font-weight: 700; font-size: 7pt; color: #6b7280; text-transform: uppercase; border: 1px solid #e5e7eb; }
.resumen-table thead th:first-child { text-align: left; }
.resumen-table tbody td { padding: 2mm 3mm; border: 1px solid #e5e7eb; text-align: center; color: #374151; }
.resumen-table tbody td:first-child { text-align: left; font-weight: 600; }
.resumen-table tfoot td { padding: 2mm 3mm; border: 1px solid #d1d5db; background: #f3f4f6; font-weight: 700; text-align: center; }
.resumen-table tfoot td:first-child { text-align: left; }
.num-op { color: #15803d; font-weight: 700; }
.num-obs { color: #92400e; font-weight: 700; }
.num-def { color: #b91c1c; font-weight: 700; }

.grafico-wrap { border: 1px solid #e5e7eb; border-radius: 3px; padding: 3mm; background: #f9fafb; }
.grafico-title { font-size: 7pt; font-weight: 700; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 3mm; text-align: center; }

.equipo-block { border: 1.5px solid #d1d5db; border-radius: 3px; margin-bottom: 5mm; overflow: hidden; }
.equipo-header { background: #1a1a1a; color: white; padding: 3mm 4mm; overflow: hidden; }
.equipo-header-left { float: left; }
.equipo-header-right { float: right; }
.equipo-num { display: inline-block; width: 7mm; height: 7mm; background: #dc2626; color: white; border-radius: 50%; text-align: center; line-height: 7mm; font-size: 8pt; font-weight: 700; margin-right: 2mm; vertical-align: middle; }
.equipo-tipo-text { font-size: 10pt; font-weight: 700; vertical-align: middle; text-transform: uppercase; letter-spacing: 0.06em; }
.estado-pill { display: inline-block; padding: 1.5mm 4mm; border-radius: 99px; font-size: 8pt; font-weight: 700; }
.estado-operativo { background: #dcfce7; color: #15803d; }
.estado-observaciones { background: #fef3c7; color: #92400e; }
.estado-defectuoso { background: #fee2e2; color: #b91c1c; }
.clearfix:after { content: ""; display: table; clear: both; }

.equipo-datos { display: table; width: 100%; border-bottom: 1px solid #d1d5db; background: #f9fafb; }
.equipo-dato { display: table-cell; padding: 2.5mm 4mm; border-right: 1px solid #e5e7eb; width: 25%; }
.equipo-dato:last-child { border-right: none; }
.equipo-dato-label { font-size: 7pt; font-weight: 700; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 1mm; }
.equipo-dato-value { font-size: 9pt; font-weight: 600; color: #111827; }

.checklist-seccion-title { background: #f3f4f6; padding: 2mm 4mm; font-size: 7.5pt; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #374151; border-top: 1px solid #e5e7eb; border-bottom: 1px solid #e5e7eb; }
.checklist-item { display: table; width: 100%; border-bottom: 1px solid #f3f4f6; padding: 2mm 4mm; }
.checklist-item-nombre { display: table-cell; font-size: 9pt; color: #374151; vertical-align: middle; }
.critico-badge { display: inline-block; font-size: 7pt; background: #fef3c7; color: #92400e; border: 1px solid #fde68a; padding: 0.5mm 3mm; border-radius: 2px; margin-left: 2mm; font-weight: 700; }
.checklist-item-resp { display: table-cell; width: 28mm; text-align: center; vertical-align: middle; }
.respuesta { display: inline-block; font-size: 8pt; font-weight: 700; padding: 1.5mm 3.5mm; border-radius: 3px; min-width: 24mm; text-align: center; }
.r-operativo { background: #dcfce7; color: #15803d; }
.r-defectuoso { background: #fee2e2; color: #b91c1c; }
.r-no-aplica { background: #f3f4f6; color: #6b7280; }
.r-realizado { background: #dbeafe; color: #1d4ed8; }
.r-no-realizado { background: #fef3c7; color: #92400e; }

.equipo-obs { padding: 3mm 4mm; border-top: 1px solid #e5e7eb; background: #fffbeb; border-bottom: 1px solid #e5e7eb; }
.equipo-obs-label { font-size: 7pt; font-weight: 700; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 1.5mm; }
.equipo-obs-text { font-size: 9pt; color: #374151; line-height: 1.5; }

.fotos-grid { display: table; width: 100%; padding: 3mm 4mm; }
.foto-col { display: table-cell; width: 50%; padding: 0 2mm; vertical-align: top; }
.foto-col:first-child { padding-left: 0; }
.foto-col:last-child { padding-right: 0; }
.foto-img { width: 100%; height: 35mm; object-fit: cover; border: 1px solid #e5e7eb; border-radius: 3px; }
.foto-placeholder { border: 1.5px dashed #d1d5db; border-radius: 3px; height: 35mm; background: #f9fafb; text-align: center; padding-top: 10mm; }
.foto-placeholder-text { font-size: 8pt; color: #9ca3af; }
.foto-label { font-size: 7pt; color: #9ca3af; text-align: center; margin-top: 1.5mm; font-style: italic; }

.doc-footer { margin-top: 8mm; border-top: 1px solid #e5e7eb; padding-top: 3mm; display: table; width: 100%; }
.footer-left { display: table-cell; font-size: 7pt; color: #9ca3af; font-family: 'Courier New', monospace; }
.footer-right { display: table-cell; text-align: right; font-size: 7pt; color: #9ca3af; font-family: 'Courier New', monospace; }

.page-break { page-break-before: always; }
</style>
</head>
<body>
<div style="margin: 15mm 20mm;">


<div class="doc-header">
<img src="<?php echo e(public_path('images/logo.png')); ?>" style="max-height:18mm; max-width:28mm; width:auto; height:auto;">
    <div class="doc-header-center">
        <div class="doc-title">Mantencion Preventiva</div>
        <div class="doc-subtitle">Informe Tecnico de Servicio</div>
    </div>
    <div class="doc-header-right"><div class="logo-placeholder"></div></div>
</div>


<div class="orden-strip">
    <div class="orden-num"><?php echo e($mantencion->numero_orden); ?></div>
    <div class="orden-fecha">Emitido: <?php echo e(now()->format('d/m/Y')); ?> - <?php echo e(now()->format('H:i')); ?> hrs</div>
</div>


<div class="seccion">
    <div class="seccion-title">Datos del Servicio</div>
    <div class="campos-grid">
        <div class="campos-row">
            <div class="campo" style="width:22%">
                <div class="campo-label">Fecha</div>
                <div class="campo-value"><?php echo e($mantencion->fecha->format('d/m/Y')); ?></div>
            </div>
            <div class="campo" style="width:18%">
                <div class="campo-label">Hora inicio</div>
                <div class="campo-value"><?php echo e($mantencion->hora_inicio); ?></div>
            </div>
            <div class="campo" style="width:18%">
                <div class="campo-label">Hora termino</div>
                <div class="campo-value"><?php echo e($mantencion->hora_termino ?? '-'); ?></div>
            </div>
            <div class="campo" style="width:42%">
                <div class="campo-label">Tecnico responsable</div>
                <div class="campo-value"><?php echo e($mantencion->user->name); ?></div>
            </div>
        </div>
    </div>
</div>


<div class="seccion">
    <div class="seccion-title">Datos del Cliente</div>
    <div class="campos-grid">
        <div class="campos-row">
            <div class="campo" style="width:25%">
                <div class="campo-label">Cliente</div>
                <div class="campo-value"><?php echo e($mantencion->cliente->nombre); ?></div>
            </div>
            <div class="campo" style="width:20%">
                <div class="campo-label">Codigo local</div>
                <div class="campo-value"><?php echo e($mantencion->codigo_local); ?></div>
            </div>
            <div class="campo" style="width:20%">
                <div class="campo-label">Ciudad</div>
                <div class="campo-value"><?php echo e($mantencion->ciudad); ?></div>
            </div>
            <div class="campo" style="width:35%">
                <div class="campo-label">Direccion</div>
                <div class="campo-value"><?php echo e($mantencion->direccion); ?></div>
            </div>
        </div>
    </div>
</div>


<?php
    $tipo_labels = [
        'impresora_sin_adf'   => 'Impresora sin ADF',
        'impresora_con_adf'   => 'Impresora con ADF',
        'impresora_termica'   => 'Impresora Termica',
        'computador_aio'      => 'Computador AIO',
        'computador_desktop'  => 'Computador Desktop',
        'computador_notebook' => 'Computador Notebook',
    ];
    $total     = $mantencion->equipos->count();
    $operativo = $mantencion->equipos->where('estado_final','operativo')->count();
    $obs       = $mantencion->equipos->where('estado_final','operativo_con_observaciones')->count();
    $defec     = $mantencion->equipos->where('estado_final','defectuoso')->count();
    $pct_op    = $total > 0 ? round($operativo * 100 / $total) : 0;
    $pct_obs   = $total > 0 ? round($obs * 100 / $total) : 0;
    $pct_def   = $total > 0 ? round($defec * 100 / $total) : 0;
    $por_tipo  = $mantencion->equipos->groupBy('tipo');
    $max_val   = max($operativo, $obs, $defec, 1);
    $bar_h     = 25;
    $h_op      = round($bar_h * $operativo / $max_val);
    $h_obs     = round($bar_h * $obs / $max_val);
    $h_def     = round($bar_h * $defec / $max_val);
?>

<div class="seccion">
    <div class="seccion-title">Resumen del Trabajo</div>

    
    <div class="resumen-cards">
        <div class="resumen-card">
            <div class="resumen-card-label">Total equipos</div>
            <div class="resumen-card-value" style="color:#1a1a1a;"><?php echo e($total); ?></div>
            <div class="resumen-card-sub">en esta orden</div>
        </div>
        <div class="resumen-card">
            <div class="resumen-card-label">Operativos</div>
            <div class="resumen-card-value" style="color:#15803d;"><?php echo e($operativo); ?></div>
            <div class="resumen-card-sub"><?php echo e($pct_op); ?>% del total</div>
        </div>
        <div class="resumen-card">
            <div class="resumen-card-label">Con observaciones</div>
            <div class="resumen-card-value" style="color:#92400e;"><?php echo e($obs); ?></div>
            <div class="resumen-card-sub"><?php echo e($pct_obs); ?>% del total</div>
        </div>
        <div class="resumen-card">
            <div class="resumen-card-label">Defectuosos</div>
            <div class="resumen-card-value" style="color:#b91c1c;"><?php echo e($defec); ?></div>
            <div class="resumen-card-sub"><?php echo e($pct_def); ?>% del total</div>
        </div>
    </div>

    
    <div style="padding: 0 4mm 4mm;">
        <div class="resumen-body">

            
            <div class="resumen-tabla-col">
                <table class="resumen-table">
                    <thead>
                        <tr>
                            <th style="width:45%; text-align:left;">Tipo de equipo</th>
                            <th style="width:14%">Total</th>
                            <th style="width:14%">Op.</th>
                            <th style="width:14%">Obs.</th>
                            <th style="width:14%">Def.</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $por_tipo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo => $equipos_tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                        <?php
                            $t_total = $equipos_tipo->count();
                            $t_op    = $equipos_tipo->where('estado_final','operativo')->count();
                            $t_obs   = $equipos_tipo->where('estado_final','operativo_con_observaciones')->count();
                            $t_def   = $equipos_tipo->where('estado_final','defectuoso')->count();
                        ?>
                        <tr>
                            <td><?php echo e($tipo_labels[$tipo] ?? $tipo); ?></td>
                            <td><?php echo e($t_total); ?></td>
                            <td class="<?php echo e($t_op > 0 ? 'num-op' : ''); ?>"><?php echo e($t_op); ?></td>
                            <td class="<?php echo e($t_obs > 0 ? 'num-obs' : ''); ?>"><?php echo e($t_obs); ?></td>
                            <td class="<?php echo e($t_def > 0 ? 'num-def' : ''); ?>"><?php echo e($t_def); ?></td>
                        </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>Total</td>
                            <td><?php echo e($total); ?></td>
                            <td class="num-op"><?php echo e($operativo); ?></td>
                            <td class="num-obs"><?php echo e($obs); ?></td>
                            <td class="num-def"><?php echo e($defec); ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            
            <div class="resumen-grafico-col">
                <div class="grafico-wrap">
                    <div class="grafico-title">Distribucion de estados</div>
                    <table style="width:100%; border-collapse:collapse; height:<?php echo e($bar_h + 12); ?>mm;">
                        <tr style="vertical-align:bottom; height:<?php echo e($bar_h); ?>mm;">
                            <td style="width:8mm; vertical-align:bottom; border-right:1px solid #e5e7eb; padding-right:1.5mm; text-align:right;">
                                <div style="font-size:5.5pt; color:#9ca3af; margin-bottom:<?php echo e($bar_h - 4); ?>mm;"><?php echo e($max_val); ?></div>
                                <div style="font-size:5.5pt; color:#9ca3af;">0</div>
                            </td>
                            <td style="vertical-align:bottom; border-bottom:1px solid #e5e7eb; padding-left:2mm;">
                                <table style="width:90%; margin:0 auto; border-collapse:collapse; height:<?php echo e($bar_h); ?>mm;">
                                    <tr style="vertical-align:bottom; height:<?php echo e($bar_h); ?>mm;">
                                        <td style="width:33%; vertical-align:bottom; text-align:center; padding:0 3mm;">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($h_op > 0): ?>
                                            <div style="background:#16a34a; height:<?php echo e($h_op); ?>mm; border-radius:3px 3px 0 0;"></div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </td>
                                        <td style="width:33%; vertical-align:bottom; text-align:center; padding:0 3mm;">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($h_obs > 0): ?>
                                            <div style="background:#d97706; height:<?php echo e($h_obs); ?>mm; border-radius:3px 3px 0 0;"></div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </td>
                                        <td style="width:33%; vertical-align:bottom; text-align:center; padding:0 3mm;">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($h_def > 0): ?>
                                            <div style="background:#dc2626; height:<?php echo e($h_def); ?>mm; border-radius:3px 3px 0 0;"></div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="padding-left:2mm;">
                                <table style="width:90%; margin:0 auto; border-collapse:collapse;">
                                    <tr>
                                        <td style="width:33%; text-align:center; padding-top:1.5mm;">
                                            <div style="font-size:7pt; font-weight:700; color:#16a34a;"><?php echo e($operativo); ?></div>
                                            <div style="font-size:5.5pt; color:#6b7280;">Op.</div>
                                        </td>
                                        <td style="width:33%; text-align:center; padding-top:1.5mm;">
                                            <div style="font-size:7pt; font-weight:700; color:#d97706;"><?php echo e($obs); ?></div>
                                            <div style="font-size:5.5pt; color:#6b7280;">Obs.</div>
                                        </td>
                                        <td style="width:33%; text-align:center; padding-top:1.5mm;">
                                            <div style="font-size:7pt; font-weight:700; color:#dc2626;"><?php echo e($defec); ?></div>
                                            <div style="font-size:5.5pt; color:#6b7280;">Def.</div>
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
</div>



<div style="page-break-inside: avoid;">
    <div class="seccion" style="margin-top:4mm;">
        <div class="seccion-title">Firma del Receptor</div>
        <table style="width:100%; border-collapse:collapse;">
            <tr>
                <td style="width:50%; padding:2.5mm 3mm; border-right:1px solid #e5e7eb; border-bottom:1px solid #e5e7eb;">
                    <div style="font-size:7pt; font-weight:700; color:#9ca3af; text-transform:uppercase; margin-bottom:1mm;">Nombre</div>
                    <div style="font-size:9pt; font-weight:600; color:#111827;"><?php echo e($mantencion->firma_nombre ?? '-'); ?></div>
                </td>
                <td style="width:50%; padding:2.5mm 3mm; border-bottom:1px solid #e5e7eb;">
                    <div style="font-size:7pt; font-weight:700; color:#9ca3af; text-transform:uppercase; margin-bottom:1mm;">Cargo</div>
                    <div style="font-size:9pt; font-weight:600; color:#111827;"><?php echo e($mantencion->firma_cargo ?? '-'); ?></div>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="padding:3mm; text-align:center; background:#fafafa;">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($mantencion->firma_imagen): ?>
                    <img src="<?php echo e($mantencion->firma_imagen); ?>"
                         style="height:15mm; width:auto; max-width:40%; display:block; margin:0 auto;">
                    <?php else: ?>
                    <span style="font-size:8pt; color:#9ca3af;">Sin firma registrada</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>
        </table>
    </div>
    <div class="doc-footer">
        <div class="footer-left"><?php echo e($mantencion->numero_orden); ?></div>
        <div class="footer-right">Generado: <?php echo e(now()->format('d/m/Y H:i')); ?> hrs</div>
    </div>
</div>


<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $mantencion->equipos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $equipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
<?php
    $estado_info = match($equipo->estado_final) {
        'operativo'                   => ['class' => 'estado-operativo',    'label' => 'Operativo'],
        'operativo_con_observaciones' => ['class' => 'estado-observaciones','label' => 'Con observaciones'],
        'defectuoso'                  => ['class' => 'estado-defectuoso',   'label' => 'Defectuoso'],
        default                       => ['class' => '',                    'label' => '-']
    };
    $secciones  = $equipo->respuestas->groupBy('item.seccion');
    $tipo_label = $tipo_labels[$equipo->tipo] ?? $equipo->tipo;
?>

<div class="page-break"></div>
<div style="height:10mm;"></div>

<div class="equipo-block">
    <div class="equipo-header clearfix">
        <div class="equipo-header-left">
            <span class="equipo-num"><?php echo e($loop->iteration); ?></span>
            <span class="equipo-tipo-text"><?php echo e($tipo_label); ?></span>
        </div>
        <div class="equipo-header-right">
            <span class="estado-pill <?php echo e($estado_info['class']); ?>"><?php echo e($estado_info['label']); ?></span>
        </div>
    </div>

    <div class="equipo-datos">
        <div class="equipo-dato">
            <div class="equipo-dato-label">Marca</div>
            <div class="equipo-dato-value"><?php echo e($equipo->marca ?? '-'); ?></div>
        </div>
        <div class="equipo-dato">
            <div class="equipo-dato-label">Modelo</div>
            <div class="equipo-dato-value"><?php echo e($equipo->modelo ?? '-'); ?></div>
        </div>
        <div class="equipo-dato">
            <div class="equipo-dato-label">N° Serie</div>
            <div class="equipo-dato-value"><?php echo e($equipo->serie ?? '-'); ?></div>
        </div>
        <div class="equipo-dato">
            <div class="equipo-dato-label">Estado final</div>
            <div class="equipo-dato-value"><?php echo e($estado_info['label']); ?></div>
        </div>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $secciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $seccion => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
    <div class="checklist-seccion-title"><?php echo e($seccion); ?></div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $respuesta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
    <?php
        $resp_labels = [
            'operativo'    => ['class' => 'r-operativo',    'label' => 'Operativo'],
            'defectuoso'   => ['class' => 'r-defectuoso',   'label' => 'Defectuoso'],
            'no_aplica'    => ['class' => 'r-no-aplica',    'label' => 'No aplica'],
            'realizado'    => ['class' => 'r-realizado',    'label' => 'Realizado'],
            'no_realizado' => ['class' => 'r-no-realizado', 'label' => 'No realizado'],
        ];
        $r = $resp_labels[$respuesta->respuesta] ?? ['class' => '', 'label' => $respuesta->respuesta];
    ?>
    <div class="checklist-item">
        <div class="checklist-item-nombre">
            <?php echo e($respuesta->item->descripcion); ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($respuesta->item->es_critico): ?>
            <span class="critico-badge">CRITICO</span>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
        <div class="checklist-item-resp">
            <span class="respuesta <?php echo e($r['class']); ?>"><?php echo e($r['label']); ?></span>
        </div>
    </div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($equipo->observaciones): ?>
    <div class="equipo-obs">
        <div class="equipo-obs-label">Observaciones</div>
        <div class="equipo-obs-text"><?php echo e($equipo->observaciones); ?></div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="fotos-grid">
        <div class="foto-col">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($equipo->foto_equipo): ?>
            <img class="foto-img" src="<?php echo e(storage_path('app/public/' . $equipo->foto_equipo)); ?>">
            <?php else: ?>
            <div class="foto-placeholder">
                <div class="foto-placeholder-text">Sin fotografia</div>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <div class="foto-label">Fotografia del equipo</div>
        </div>
        <div class="foto-col">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($equipo->foto_serie): ?>
            <img class="foto-img" src="<?php echo e(storage_path('app/public/' . $equipo->foto_serie)); ?>">
            <?php else: ?>
            <div class="foto-placeholder">
                <div class="foto-placeholder-text">Sin fotografia</div>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <div class="foto-label">Fotografia numero de serie</div>
        </div>
    </div>
</div>

<div class="doc-footer">
    <div class="footer-left"><?php echo e($mantencion->numero_orden); ?> — Equipo <?php echo e($loop->iteration); ?> de <?php echo e($total); ?></div>
    <div class="footer-right">Generado: <?php echo e(now()->format('d/m/Y H:i')); ?> hrs</div>
</div>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

</div>
</body>
</html>
<?php /**PATH E:\Projects\techportal\resources\views/mantencion/pdf.blade.php ENDPATH**/ ?>