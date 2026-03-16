
<?php $__env->startSection('title', 'Dashboard Ejecutivo'); ?>
<?php $__env->startSection('page-title', 'Dashboard Ejecutivo'); ?>
<?php $__env->startSection('page-subtitle', 'Métricas de servicio y soporte técnico'); ?>

<?php $__env->startSection('content'); ?>
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Syne:wght@700;800&display=swap');

.dash { font-family: 'Inter', sans-serif; }
.num  { font-family: 'Syne', sans-serif; }

.card {
    background: #fff;
    border: 1px solid #f1f5f9;
    border-radius: 14px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.04);
}
.card-header {
    padding: 14px 20px 12px;
    border-bottom: 1px solid #f8fafc;
    display: flex; align-items: center; justify-content: space-between;
}
.card-title {
    font-size: 11px; font-weight: 700;
    text-transform: uppercase; letter-spacing: .08em; color: #94a3b8;
}
.card-body { padding: 18px 20px; }

.kpi {
    background: #fff; border: 1px solid #f1f5f9;
    border-radius: 14px; padding: 18px 20px;
    position: relative; overflow: hidden;
    box-shadow: 0 1px 4px rgba(0,0,0,0.04);
    transition: transform .15s, box-shadow .15s;
}
.kpi:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,0.07); }
.kpi-accent { position: absolute; left:0; top:0; bottom:0; width:4px; border-radius:14px 0 0 14px; }
.kpi-label { font-size:11px; font-weight:600; color:#94a3b8; text-transform:uppercase; letter-spacing:.07em; margin-bottom:8px; padding-left:8px; }
.kpi-value { font-family:'Syne',sans-serif; font-size:34px; font-weight:800; line-height:1; padding-left:8px; }
.kpi-sub   { font-size:11px; color:#94a3b8; margin-top:5px; padding-left:8px; }
.kpi-badge { display:inline-block; font-size:10px; font-weight:700; padding:2px 8px; border-radius:99px; margin-top:5px; margin-left:8px; }

.prog-bar-track { height:5px; background:#f1f5f9; border-radius:99px; overflow:hidden; }
.prog-bar-fill  { height:100%; border-radius:99px; }

.dt td, .dt th { padding:10px 16px; font-size:12px; }
.dt th { font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:#94a3b8; background:#fafafa; }
.dt tbody tr:hover td { background:#fafafa; }
.dt td { border-top:1px solid #f8fafc; color:#374151; vertical-align:middle; }

.chip { display:inline-flex; align-items:center; gap:4px; padding:2px 8px; border-radius:99px; font-size:11px; font-weight:700; }

.filter-bar { background:#fff; border:1px solid #f1f5f9; border-radius:14px; padding:14px 20px; box-shadow:0 1px 4px rgba(0,0,0,0.04); }
.filter-select { border:1px solid #e2e8f0; border-radius:8px; padding:7px 12px; font-size:13px; font-family:'Inter',sans-serif; color:#374151; background:#fafafa; outline:none; cursor:pointer; transition:border-color .15s; }
.filter-select:focus { border-color:#ef4444; background:#fff; }
.btn-primary { background:#dc2626; color:#fff; border:none; border-radius:8px; padding:7px 18px; font-size:13px; font-weight:600; cursor:pointer; font-family:'Inter',sans-serif; transition:background .15s; }
.btn-primary:hover { background:#b91c1c; }
.btn-ghost { background:none; color:#64748b; border:1px solid #e2e8f0; border-radius:8px; padding:7px 14px; font-size:13px; font-family:'Inter',sans-serif; cursor:pointer; text-decoration:none; transition:background .15s; display:inline-block; }
.btn-ghost:hover { background:#f8fafc; }
</style>

<?php
$tasa_cierre = $total > 0 ? round($cerrados / $total * 100) : 0;
$score = 0;
if ($pct_sla_respuesta  >= 80) $score += 25; elseif ($pct_sla_respuesta  >= 60) $score += 12;
if ($pct_sla_resolucion >= 80) $score += 25; elseif ($pct_sla_resolucion >= 60) $score += 12;
if ($total > 0) $score += min(30, round($tasa_cierre * 30 / 100));
if ($criticos == 0) $score += 20; elseif ($criticos <= 2) $score += 10;
$score = min($score, 100);
$scoreColor = $score >= 75 ? '#16a34a' : ($score >= 50 ? '#d97706' : '#dc2626');
$scoreBg    = $score >= 75 ? '#f0fdf4' : ($score >= 50 ? '#fffbeb' : '#fef2f2');
$scoreText  = $score >= 75 ? 'Servicio Saludable' : ($score >= 50 ? 'Atención Requerida' : 'Estado Crítico');
$arc = fn($p) => round($p * 1.696, 1);
?>

<div class="dash space-y-4">


<div class="filter-bar">
    <form method="GET" class="flex flex-wrap items-end gap-3">
        <div>
            <div class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1.5">Cliente</div>
            <select name="cliente_id" class="filter-select">
                <option value="">Todos los clientes</option>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $clientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <option value="<?php echo e($c->id); ?>" <?php echo e(request('cliente_id')==$c->id?'selected':''); ?>><?php echo e($c->nombre); ?></option>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </select>
        </div>
        <div>
            <div class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1.5">Período</div>
            <select name="periodo" class="filter-select">
                <option value="7"   <?php echo e(request('periodo','30')=='7'  ?'selected':''); ?>>Últimos 7 días</option>
                <option value="30"  <?php echo e(request('periodo','30')=='30' ?'selected':''); ?>>Últimos 30 días</option>
                <option value="90"  <?php echo e(request('periodo','30')=='90' ?'selected':''); ?>>Últimos 90 días</option>
                <option value="365" <?php echo e(request('periodo','30')=='365'?'selected':''); ?>>Último año</option>
            </select>
        </div>
        <button type="submit" class="btn-primary">Aplicar filtros</button>
        <a href="<?php echo e(route('incidencias.dashboard')); ?>" class="btn-ghost">Limpiar</a>
        <div class="ml-auto flex items-center gap-2">
            <span class="text-xs text-gray-400">Índice de salud:</span>
            <span class="chip" style="background:<?php echo e($scoreBg); ?>;color:<?php echo e($scoreColor); ?>;border:1px solid <?php echo e($scoreColor); ?>33">
                <svg width="7" height="7"><circle cx="3.5" cy="3.5" r="3.5" fill="<?php echo e($scoreColor); ?>"/></svg>
                <?php echo e($scoreText); ?> · <?php echo e($score); ?>/100
            </span>
        </div>
    </form>
</div>


<div class="grid grid-cols-6 gap-3">
<?php
$kpis = [
    ['Total Tickets', $total,        '#64748b', 'en el período',         null, null],
    ['Abiertos',      $abiertos,     '#2563eb', 'sin resolver',          null, null],
    ['En Gestión',    $en_gestion,   '#7c3aed', 'en proceso',            null, null],
    ['Cerrados',      $cerrados,     '#16a34a', 'resueltos',             $tasa_cierre.'% del total', '#dcfce7'],
    ['Críticos',      $criticos,     '#dc2626', 'prioridad alta abierta', $criticos>0?'⚠ Requiere acción':'✓ Sin críticos', $criticos>0?'#fee2e2':'#dcfce7'],
    ['MTTR',          $mttr.'h',     '#d97706', 'tiempo medio resolución', null, null],
];
?>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $kpis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$lbl,$val,$color,$sub,$badge,$badgeBg]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
<div class="kpi">
    <div class="kpi-accent" style="background:<?php echo e($color); ?>"></div>
    <div class="kpi-label"><?php echo e($lbl); ?></div>
    <div class="kpi-value" style="color:<?php echo e($color); ?>"><?php echo e($val); ?></div>
    <div class="kpi-sub"><?php echo e($sub); ?></div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($badge): ?>
    <span class="kpi-badge" style="background:<?php echo e($badgeBg); ?>;color:<?php echo e($color); ?>"><?php echo e($badge); ?></span>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
</div>


<div class="grid grid-cols-4 gap-4">

<?php
$gauges = [
    ['SLA Respuesta',    $pct_sla_respuesta,  'Tiempo de primera atención', 80],
    ['SLA Resolución',   $pct_sla_resolucion, 'Cierre dentro del plazo',    80],
    ['Tasa de Cierre',   $tasa_cierre,        'Tickets cerrados / total',   70],
];
?>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $gauges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$glbl, $gpct, $gsub, $gmeta]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
<?php $gc = $gpct>=$gmeta?'#16a34a':($gpct>=($gmeta*0.75)?'#d97706':'#dc2626'); ?>
<div class="card">
    <div class="card-header">
        <span class="card-title"><?php echo e($glbl); ?></span>
        <span class="chip" style="background:<?php echo e($gpct>=$gmeta?'#f0fdf4':($gpct>=($gmeta*0.75)?'#fffbeb':'#fef2f2')); ?>;color:<?php echo e($gc); ?>">
            <?php echo e($gpct>=$gmeta?'Cumple':($gpct>=($gmeta*0.75)?'Parcial':'Incumple')); ?>

        </span>
    </div>
    <div class="card-body flex flex-col items-center gap-1">
        <svg width="160" height="92" viewBox="0 0 160 92">
            <path d="M14 88 A66 66 0 0 1 146 88" fill="none" stroke="#f1f5f9" stroke-width="13" stroke-linecap="round"/>
            <path d="M14 88 A66 66 0 0 1 146 88" fill="none" stroke="<?php echo e($gc); ?>" stroke-width="13" stroke-linecap="round"
                  stroke-dasharray="<?php echo e($arc($gpct)); ?> 210"/>
            <text x="80" y="77" text-anchor="middle" font-size="26" font-weight="800" fill="<?php echo e($gc); ?>" font-family="Syne,sans-serif"><?php echo e($gpct); ?>%</text>
            <text x="80" y="90" text-anchor="middle" font-size="9" fill="#94a3b8" font-family="Inter,sans-serif">META <?php echo e($gmeta); ?>%</text>
            <text x="10"  y="92" font-size="8" fill="#cbd5e1" font-family="Inter,sans-serif">0</text>
            <text x="145" y="92" font-size="8" fill="#cbd5e1" font-family="Inter,sans-serif">100</text>
        </svg>
        <div class="text-xs text-gray-400 text-center"><?php echo e($gsub); ?></div>
    </div>
</div>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>


<div class="card">
    <div class="card-header"><span class="card-title">MTTR por Prioridad</span></div>
    <div class="card-body space-y-3">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = [['Alta',$mttr_alta,'#dc2626','#fef2f2'],['Media',$mttr_media,'#d97706','#fffbeb'],['Baja',$mttr_baja,'#16a34a','#f0fdf4']]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$pl,$pv,$pc,$pbg]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
        <div class="flex items-center justify-between p-3 rounded-xl" style="background:<?php echo e($pbg); ?>">
            <div>
                <div class="text-xs font-bold" style="color:<?php echo e($pc); ?>">Prioridad <?php echo e($pl); ?></div>
                <div class="text-xs text-gray-400">resolución prom.</div>
            </div>
            <div class="text-2xl font-bold num" style="color:<?php echo e($pc); ?>">
                <?php echo e($pv=='???' ? '—' : $pv); ?><span class="text-xs font-normal text-gray-400 ml-0.5"><?php echo e($pv!='???' ? 'h' : ''); ?></span>
            </div>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
    </div>
</div>

</div>


<div class="grid grid-cols-3 gap-4">
    <div class="card">
        <div class="card-header"><span class="card-title">Distribución por Estado</span></div>
        <div class="card-body">
            <canvas id="chartEstados" height="190"></canvas>
            <div id="legendEstados" class="mt-4 space-y-2"></div>
        </div>
    </div>
    <div class="card">
        <div class="card-header"><span class="card-title">Carga por Técnico</span></div>
        <div class="card-body">
            <canvas id="chartTecnicos" height="190"></canvas>
        </div>
    </div>
    <div class="card">
        <div class="card-header"><span class="card-title">Tipo de Ticket</span></div>
        <div class="card-body">
            <canvas id="chartTipos" height="190"></canvas>
            <div id="legendTipos" class="mt-4 space-y-2"></div>
        </div>
    </div>
</div>


<div class="card">
    <div class="card-header">
        <span class="card-title">Tendencia Mensual</span>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tendencia->count()): ?>
        <span class="text-xs text-gray-400"><?php echo e($tendencia->count()); ?> períodos</span>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
    <div class="card-body">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tendencia->count()): ?>
        <canvas id="chartTendencia" height="75"></canvas>
        <?php else: ?>
        <div class="flex items-center justify-center h-16 text-gray-400 text-sm">Sin datos de tendencia para el período seleccionado</div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>


<div class="grid grid-cols-2 gap-4">

    <div class="card">
        <div class="card-header"><span class="card-title">Rendimiento por Cliente</span></div>
        <div class="overflow-x-auto">
            <table class="w-full dt">
                <thead><tr>
                    <th class="text-left">Cliente</th>
                    <th class="text-center">Total</th>
                    <th class="text-center">Abiertos</th>
                    <th class="text-center">SLA</th>
                    <th class="text-left">Riesgo</th>
                </tr></thead>
                <tbody>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $por_cliente; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <?php
                    $sla = $item->pct_sla;
                    $r='Bajo'; $rc='#16a34a'; $rb='#f0fdf4';
                    if ($item->abiertos>5 || ($sla!==null&&$sla<60)) { $r='Alto';  $rc='#dc2626'; $rb='#fef2f2'; }
                    elseif ($item->abiertos>2 || ($sla!==null&&$sla<80)) { $r='Medio'; $rc='#d97706'; $rb='#fffbeb'; }
                ?>
                <tr>
                    <td class="font-semibold"><?php echo e($item->cliente->nombre ?? '—'); ?></td>
                    <td class="text-center font-bold"><?php echo e($item->total); ?></td>
                    <td class="text-center"><span class="<?php echo e($item->abiertos>0?'text-blue-600 font-bold':'text-gray-300'); ?>"><?php echo e($item->abiertos); ?></span></td>
                    <td class="text-center">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sla!==null): ?>
                        <div class="flex flex-col items-center gap-1">
                            <span class="font-bold text-xs <?php echo e($sla>=80?'text-green-600':($sla>=60?'text-amber-600':'text-red-600')); ?>"><?php echo e($sla); ?>%</span>
                            <div class="w-16 prog-bar-track"><div class="prog-bar-fill <?php echo e($sla>=80?'bg-green-500':($sla>=60?'bg-amber-500':'bg-red-500')); ?>" style="width:<?php echo e($sla); ?>%"></div></div>
                        </div>
                        <?php else: ?>
                        <span class="text-gray-300 text-xs">N/A</span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </td>
                    <td><span class="chip" style="background:<?php echo e($rb); ?>;color:<?php echo e($rc); ?>"><?php echo e($r); ?></span></td>
                </tr>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <tr><td colspan="5" class="text-center text-gray-400 py-6 text-xs">Sin datos en este período</td></tr>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-header"><span class="card-title">Rendimiento por Técnico</span></div>
        <div class="overflow-x-auto">
            <table class="w-full dt">
                <thead><tr>
                    <th class="text-left">Técnico</th>
                    <th class="text-center">Total</th>
                    <th class="text-center">Activos</th>
                    <th class="text-center">Cerrados</th>
                    <th class="text-center">SLA</th>
                    <th class="text-left">Carga</th>
                </tr></thead>
                <tbody>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $por_tecnico; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <?php
                    $c=$item->abiertos??0;
                    $cc=$c>=6?'#dc2626':($c>=3?'#d97706':'#16a34a');
                    $cb=$c>=6?'#fef2f2':($c>=3?'#fffbeb':'#f0fdf4');
                    $cl=$c>=6?'Alta':($c>=3?'Media':'Normal');
                    $ts=$item->pct_sla;
                ?>
                <tr>
                    <td>
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-full bg-red-50 flex items-center justify-center text-red-600 font-bold text-xs flex-shrink-0">
                                <?php echo e(strtoupper(substr($item->tecnico->name??'T',0,1))); ?>

                            </div>
                            <span class="font-semibold text-xs"><?php echo e($item->tecnico->name??'—'); ?></span>
                        </div>
                    </td>
                    <td class="text-center font-bold"><?php echo e($item->total); ?></td>
                    <td class="text-center text-blue-600 font-bold"><?php echo e($item->abiertos??0); ?></td>
                    <td class="text-center text-green-600 font-bold"><?php echo e($item->cerrados??0); ?></td>
                    <td class="text-center font-bold <?php echo e(($ts??0)>=80?'text-green-600':'text-red-600'); ?>"><?php echo e($ts!==null?$ts.'%':'—'); ?></td>
                    <td><span class="chip" style="background:<?php echo e($cb); ?>;color:<?php echo e($cc); ?>"><?php echo e($cl); ?></span></td>
                </tr>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <tr><td colspan="6" class="text-center text-gray-400 py-6 text-xs">Sin técnicos asignados en este período</td></tr>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tickets_criticos->count()): ?>
<div class="card" style="border-color:#fecaca">
    <div class="card-header" style="background:#fff5f5;border-color:#fecaca">
        <div class="flex items-center gap-2">
            <span class="card-title" style="color:#dc2626">Tickets Críticos Activos</span>
            <span class="chip" style="background:#dc2626;color:#fff"><?php echo e($tickets_criticos->count()); ?></span>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full dt">
            <thead><tr>
                <th class="text-left">Ticket</th>
                <th class="text-left">Cliente</th>
                <th class="text-left">Asunto</th>
                <th class="text-left">Estado</th>
                <th class="text-left">Técnico</th>
                <th class="text-left">SLA Vence</th>
                <th></th>
            </tr></thead>
            <tbody>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $tickets_criticos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
            <?php
                $em=['abierto'=>['Abierto','#2563eb','#eff6ff'],'en_gestion'=>['En gestión','#7c3aed','#f5f3ff'],'asignado'=>['Asignado','#d97706','#fffbeb'],'pendiente_cliente'=>['Pend. cliente','#ea580c','#fff7ed']];
                [$eL,$eC,$eB]=$em[$inc->estado_mesa]??[$inc->estado_mesa,'#94a3b8','#f8fafc'];
            ?>
            <tr>
                <td class="font-mono font-bold text-gray-600 text-xs"><?php echo e($inc->numero_ticket); ?></td>
                <td class="font-semibold"><?php echo e($inc->cliente->nombre); ?></td>
                <td class="text-gray-600 max-w-xs truncate"><?php echo e($inc->asunto); ?></td>
                <td><span class="chip" style="background:<?php echo e($eB); ?>;color:<?php echo e($eC); ?>"><?php echo e($eL); ?></span></td>
                <td class="text-gray-500"><?php echo e($inc->tecnico->name??'Sin asignar'); ?></td>
                <td>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($inc->fecha_limite_resolucion): ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(now()->gt($inc->fecha_limite_resolucion)): ?>
                            <span class="chip" style="background:#fef2f2;color:#dc2626">Vencido</span>
                        <?php else: ?>
                            <span class="font-semibold text-amber-600 text-xs"><?php echo e(now()->diffForHumans($inc->fecha_limite_resolucion,true)); ?></span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php else: ?>
                        <span class="text-gray-300 text-xs">Sin SLA</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
                <td>
                    <a href="<?php echo e(route('incidencias.show',$inc)); ?>"
                       class="inline-flex items-center gap-1 bg-red-600 hover:bg-red-700 text-white text-xs font-bold px-3 py-1.5 rounded-lg transition-colors">
                        Ver →
                    </a>
                </td>
            </tr>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script>
Chart.defaults.font.family = "'Inter', sans-serif";
Chart.defaults.color = '#94a3b8';

/* PHP → JS data */
const estadosRaw = {
    labels: [<?php $__currentLoopData = $por_estado; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php $m=['abierto'=>'Abierto','en_gestion'=>'En gestión','asignado'=>'Asignado','pendiente_cliente'=>'Pend. cliente','cancelado_cliente'=>'Cancelado','cerrado'=>'Cerrado']; ?> "<?php echo e($m[$k]??$k); ?>",<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>],
    data:   [<?php $__currentLoopData = $por_estado; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php echo e($v); ?>,<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>],
    colors: ['#3b82f6','#8b5cf6','#f59e0b','#f97316','#94a3b8','#22c55e']
};
const tecnicosRaw = {
    labels:   [<?php $__currentLoopData = $por_tecnico; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> "<?php echo e(addslashes($i->tecnico->name??'—')); ?>",<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>],
    abiertos: [<?php $__currentLoopData = $por_tecnico; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php echo e($i->abiertos??0); ?>,<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>],
    cerrados: [<?php $__currentLoopData = $por_tecnico; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php echo e($i->cerrados??0); ?>,<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>],
};
const tiposRaw = {
    <?php $tm=['incidencia_hardware'=>'Inc. Hardware','incidencia_software'=>'Inc. Software','requerimiento'=>'Requerimiento']; ?>
    labels: [<?php $__currentLoopData = $por_tipo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> "<?php echo e($tm[$k]??$k); ?>",<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>],
    data:   [<?php $__currentLoopData = $por_tipo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php echo e($v); ?>,<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>],
    colors: ['#ef4444','#3b82f6','#10b981']
};
const tendenciaRaw = {
    labels: [<?php $__currentLoopData = $tendencia; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> "<?php echo e(\Carbon\Carbon::createFromFormat('Y-m',$t->mes)->locale('es')->isoFormat('MMM YY')); ?>",<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>],
    data:   [<?php $__currentLoopData = $tendencia; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php echo e($t->total); ?>,<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>]
};

/* Donut */
function donut(id, legendId, labels, data, colors) {
    const ctx = document.getElementById(id);
    if (!ctx) return;
    new Chart(ctx, {
        type: 'doughnut',
        data: { labels, datasets:[{ data, backgroundColor: colors, borderWidth:2, borderColor:'#fff', hoverOffset:6 }] },
        options: {
            cutout: '68%',
            plugins: {
                legend: { display:false },
                tooltip: { callbacks:{ label: c => ` ${c.label}: ${c.raw} tickets` } }
            }
        }
    });
    const total = data.reduce((a,b)=>a+b,0);
    const leg = document.getElementById(legendId);
    if (!leg) return;
    labels.forEach((l,i) => {
        const pct = total>0 ? Math.round(data[i]/total*100) : 0;
        leg.innerHTML += `<div style="display:flex;align-items:center;justify-content:space-between;font-size:11px;padding:2px 0">
            <div style="display:flex;align-items:center;gap:6px">
                <span style="width:9px;height:9px;border-radius:2px;background:${colors[i]};display:inline-block;flex-shrink:0"></span>
                <span style="color:#374151;font-weight:500">${l}</span>
            </div>
            <span style="color:#64748b;font-weight:600">${data[i]}<span style="color:#cbd5e1;font-weight:400"> (${pct}%)</span></span>
        </div>`;
    });
}

/* Grouped bar */
function bars() {
    const ctx = document.getElementById('chartTecnicos');
    if (!ctx) return;
    if (!tecnicosRaw.labels.length) {
        ctx.parentElement.innerHTML = '<div style="display:flex;align-items:center;justify-content:center;height:160px;color:#94a3b8;font-size:13px">Sin técnicos asignados</div>';
        return;
    }
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: tecnicosRaw.labels,
            datasets: [
                { label:'Activos',  data:tecnicosRaw.abiertos, backgroundColor:'rgba(59,130,246,0.15)', borderColor:'#3b82f6', borderWidth:1.5, borderRadius:5 },
                { label:'Cerrados', data:tecnicosRaw.cerrados, backgroundColor:'rgba(34,197,94,0.15)',  borderColor:'#22c55e', borderWidth:1.5, borderRadius:5 },
            ]
        },
        options: {
            responsive:true,
            plugins:{ legend:{ position:'bottom', labels:{ boxWidth:10, padding:12, font:{size:11} } } },
            scales:{
                x:{ grid:{display:false}, ticks:{font:{size:10}} },
                y:{ grid:{color:'#f8fafc'}, ticks:{precision:0,font:{size:10}}, beginAtZero:true }
            }
        }
    });
}

/* Line tendencia */
function line() {
    const ctx = document.getElementById('chartTendencia');
    if (!ctx || !tendenciaRaw.labels.length) return;
    new Chart(ctx, {
        type:'line',
        data:{
            labels: tendenciaRaw.labels,
            datasets:[{
                label:'Tickets', data:tendenciaRaw.data,
                fill:true, backgroundColor:'rgba(220,38,38,0.06)',
                borderColor:'#dc2626', borderWidth:2,
                pointBackgroundColor:'#dc2626', pointRadius:4, pointHoverRadius:6,
                tension:0.4
            }]
        },
        options:{
            responsive:true,
            plugins:{ legend:{display:false} },
            scales:{
                x:{ grid:{display:false}, ticks:{font:{size:11}} },
                y:{ grid:{color:'#f8fafc'}, ticks:{precision:0,font:{size:11}}, beginAtZero:true }
            }
        }
    });
}

donut('chartEstados','legendEstados', estadosRaw.labels, estadosRaw.data, estadosRaw.colors);
donut('chartTipos',  'legendTipos',   tiposRaw.labels,   tiposRaw.data,   tiposRaw.colors);
bars();
line();
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Projects\techportal\resources\views/incidencias/dashboard.blade.php ENDPATH**/ ?>