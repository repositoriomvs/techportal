
 
<?php $__env->startSection('title', 'Dashboard Admin'); ?>
<?php $__env->startSection('page-title', 'Dashboard Administrativo'); ?>
<?php $__env->startSection('page-subtitle', 'Estadísticas de uso del sistema · ' . now()->format('d/m/Y')); ?>
 
<?php $__env->startSection('content'); ?>
 

<?php
$tacometros = [
    ['label' => 'Ingresos hoy',        'valor' => $ingresosHoy,               'max' => 20,  'badge' => 'Hoy',    'color_badge' => 'bg-blue-50 text-blue-600',   'unidad' => 'sesiones', 'sub' => null],
    ['label' => 'Ingresos semana',     'valor' => $ingresosSemana,            'max' => 100, 'badge' => 'Semana', 'color_badge' => 'bg-purple-50 text-purple-600','unidad' => 'sesiones', 'sub' => 'Media: '.$mediaIngresosSemanal.'/sem'],
    ['label' => 'Ingresos mes',        'valor' => $ingresosMes,               'max' => 400, 'badge' => 'Mes',    'color_badge' => 'bg-green-50 text-green-600',  'unidad' => 'sesiones', 'sub' => 'Media: '.$mediaIngresosDiaria.'/día'],
    ['label' => 'Horas activas hoy',   'valor' => round($minutosHoy / 60, 1), 'max' => 12,  'badge' => 'Hoy',    'color_badge' => 'bg-blue-50 text-blue-600',   'unidad' => 'horas',    'sub' => null],
    ['label' => 'Horas activas semana','valor' => round($minutosSemana / 60, 1),'max' => 60,'badge' => 'Semana', 'color_badge' => 'bg-purple-50 text-purple-600','unidad' => 'horas',    'sub' => 'Media: '.$mediaHorasSemanal.'h/sem'],
    ['label' => 'Horas activas mes',   'valor' => round($minutosMes / 60, 1), 'max' => 240, 'badge' => 'Mes',    'color_badge' => 'bg-green-50 text-green-600',  'unidad' => 'horas',    'sub' => 'Media: '.$mediaHorasDiaria.'h/día'],
];
?>
 
<div class="grid grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $tacometros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
    <?php
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
    ?>
 
    <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm flex flex-col items-center">
 
        
        <div class="w-full flex justify-between items-center mb-2">
            <span class="text-xs font-mono text-gray-400 uppercase tracking-wider leading-tight"><?php echo e($t['label']); ?></span>
            <span class="text-xs font-mono font-bold px-2 py-0.5 rounded-full <?php echo e($t['color_badge']); ?>">
                <?php echo e($t['badge']); ?>

            </span>
        </div>
 
        
        <div class="text-3xl font-bold text-gray-900 mb-1">
            <?php echo e($t['valor']); ?>

            <span class="text-sm text-gray-400 font-normal"><?php echo e($t['unidad']); ?></span>
        </div>
 
        
        <svg viewBox="0 0 140 100" class="w-44 h-28">
 
            
            <path d="M <?php echo e(round($bx1,2)); ?> <?php echo e(round($by1,2)); ?> A <?php echo e($radio); ?> <?php echo e($radio); ?> 0 1 1 <?php echo e(round($bx2,2)); ?> <?php echo e(round($by2,2)); ?>"
                  fill="none" stroke="#e5e7eb" stroke-width="10" stroke-linecap="round"/>
 
            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($pct > 0.01): ?>
            <path d="M <?php echo e(round($x1,2)); ?> <?php echo e(round($y1,2)); ?> A <?php echo e($radio); ?> <?php echo e($radio); ?> 0 <?php echo e($largeArc); ?> 1 <?php echo e(round($x2,2)); ?> <?php echo e(round($y2,2)); ?>"
                  fill="none" stroke="<?php echo e($stroke); ?>" stroke-width="10" stroke-linecap="round"/>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
 
            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($m = 0; $m <= 10; $m++): ?>
            <?php
                $mRad = deg2rad(-135 + $m * 27);
                $isMajor = $m % 5 === 0;
                $r1 = $isMajor ? 44 : 47;
                $r2 = $isMajor ? 58 : 54;
                $mx1 = $cx + $r1 * cos($mRad);
                $my1 = $cy + $r1 * sin($mRad);
                $mx2 = $cx + $r2 * cos($mRad);
                $my2 = $cy + $r2 * sin($mRad);
            ?>
            <line x1="<?php echo e(round($mx1,2)); ?>" y1="<?php echo e(round($my1,2)); ?>"
                  x2="<?php echo e(round($mx2,2)); ?>" y2="<?php echo e(round($my2,2)); ?>"
                  stroke="<?php echo e($isMajor ? '#9ca3af' : '#d1d5db'); ?>"
                  stroke-width="<?php echo e($isMajor ? 2 : 1); ?>"/>
            <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
 
            
            <?php
                $lbls = [
                    ['ang' => -135, 'txt' => '0'],
                    ['ang' => 0,    'txt' => '50%'],
                    ['ang' => 135,  'txt' => '100%'],
                ];
            ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $lbls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lbl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
            <?php
                $lRad = deg2rad($lbl['ang']);
                $lx = $cx + 68 * cos($lRad);
                $ly = $cy + 68 * sin($lRad);
            ?>
            <text x="<?php echo e(round($lx,1)); ?>" y="<?php echo e(round($ly,1)); ?>"
                  text-anchor="middle" dominant-baseline="middle"
                  font-size="7" fill="#9ca3af" font-family="monospace"><?php echo e($lbl['txt']); ?></text>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
 
            
            <line x1="<?php echo e($cx); ?>" y1="<?php echo e($cy); ?>"
                  x2="<?php echo e(round($ax,2)); ?>" y2="<?php echo e(round($ay,2)); ?>"
                  stroke="#1f2937" stroke-width="2.5" stroke-linecap="round"/>
            <circle cx="<?php echo e($cx); ?>" cy="<?php echo e($cy); ?>" r="5" fill="#1f2937"/>
            <circle cx="<?php echo e($cx); ?>" cy="<?php echo e($cy); ?>" r="2.5" fill="white"/>
 
            
            <text x="<?php echo e($cx); ?>" y="<?php echo e($cy + 18); ?>"
                  text-anchor="middle" font-size="10"
                  fill="#6b7280" font-family="monospace">
                <?php echo e(round($pct * 100)); ?>%
            </text>
 
        </svg>
 
        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($t['sub']): ?>
        <div class="text-xs text-gray-400 font-mono mt-1"><?php echo e($t['sub']); ?></div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
 
    </div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
</div>
 
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
 
    
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100">
            <h2 class="font-bold text-gray-900">Actividad por usuario hoy</h2>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($actividadPorUsuario->isEmpty()): ?>
            <div class="p-8 text-center text-gray-400 text-sm">Sin actividad hoy.</div>
        <?php else: ?>
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="text-left px-5 py-2.5 text-xs font-mono text-gray-400 uppercase">Usuario</th>
                    <th class="text-center px-5 py-2.5 text-xs font-mono text-gray-400 uppercase">Ingresos</th>
                    <th class="text-right px-5 py-2.5 text-xs font-mono text-gray-400 uppercase">Tiempo</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $actividadPorUsuario; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $actividad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-full bg-red-600 flex items-center justify-center text-white text-xs font-bold">
                                <?php echo e(strtoupper(substr($actividad['usuario'], 0, 2))); ?>

                            </div>
                            <span class="text-sm font-medium text-gray-900"><?php echo e($actividad['usuario']); ?></span>
                        </div>
                    </td>
                    <td class="px-5 py-3 text-center">
                        <span class="text-sm font-bold text-gray-900"><?php echo e($actividad['ingresos']); ?></span>
                    </td>
                    <td class="px-5 py-3 text-right">
                        <span class="text-sm font-mono text-gray-500">
                            <?php echo e(floor($actividad['minutos'] / 60)); ?>h <?php echo e($actividad['minutos'] % 60); ?>m
                        </span>
                    </td>
                </tr>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </tbody>
        </table>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
 
    
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100">
            <h2 class="font-bold text-gray-900">Últimas sesiones</h2>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($ultimasSesiones->isEmpty()): ?>
            <div class="p-8 text-center text-gray-400 text-sm">Sin sesiones registradas.</div>
        <?php else: ?>
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="text-left px-5 py-2.5 text-xs font-mono text-gray-400 uppercase">Usuario</th>
                    <th class="text-left px-5 py-2.5 text-xs font-mono text-gray-400 uppercase">Ingreso</th>
                    <th class="text-right px-5 py-2.5 text-xs font-mono text-gray-400 uppercase">Duración</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $ultimasSesiones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sesion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-full bg-red-600 flex items-center justify-center text-white text-xs font-bold">
                                <?php echo e(strtoupper(substr($sesion->user->name ?? '?', 0, 2))); ?>

                            </div>
                            <span class="text-sm font-medium text-gray-900"><?php echo e($sesion->user->name ?? 'Desconocido'); ?></span>
                        </div>
                    </td>
                    <td class="px-5 py-3">
                        <div class="text-xs font-mono text-gray-500"><?php echo e($sesion->login_at->format('d/m H:i')); ?></div>
                    </td>
                    <td class="px-5 py-3 text-right">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sesion->duracion_minutos): ?>
                            <span class="text-xs font-mono text-gray-500">
                                <?php echo e(floor($sesion->duracion_minutos / 60)); ?>h <?php echo e($sesion->duracion_minutos % 60); ?>m
                            </span>
                        <?php else: ?>
                            <span class="text-xs font-mono text-green-500">● Activo</span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </td>
                </tr>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </tbody>
        </table>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
 
</div>
 

<div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden mt-4">
    <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
        <h2 class="font-bold text-gray-900">Ranking de usuarios — <?php echo e(now()->translatedFormat('F Y')); ?></h2>
        <span class="text-xs font-mono text-gray-400">Por ingresos al sistema</span>
    </div>
 
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($rankingUsuarios->isEmpty()): ?>
        <div class="p-8 text-center text-gray-400 text-sm">Sin actividad este mes.</div>
    <?php else: ?>
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
            <?php $maxIngresos = $rankingUsuarios->first()['total_ingresos']; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $rankingUsuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
            <tr class="hover:bg-gray-50 transition-colors
                <?php echo e($i === 0 ? 'bg-yellow-50' : ''); ?>

                <?php echo e($i === $rankingUsuarios->count() - 1 && $rankingUsuarios->count() > 1 ? 'bg-red-50' : ''); ?>">
                <td class="px-5 py-3 text-center">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($i === 0): ?> <span class="text-lg">🥇</span>
                    <?php elseif($i === 1): ?> <span class="text-lg">🥈</span>
                    <?php elseif($i === 2): ?> <span class="text-lg">🥉</span>
                    <?php else: ?> <span class="text-sm font-mono text-gray-400"><?php echo e($i + 1); ?></span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
                <td class="px-5 py-3">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-full flex items-center justify-center text-white text-xs font-bold
                            <?php echo e($i === 0 ? 'bg-yellow-500' : ($i === $rankingUsuarios->count() - 1 ? 'bg-red-400' : 'bg-red-600')); ?>">
                            <?php echo e(strtoupper(substr($item['usuario'], 0, 2))); ?>

                        </div>
                        <span class="text-sm font-medium text-gray-900"><?php echo e($item['usuario']); ?></span>
                    </div>
                </td>
                <td class="px-5 py-3 text-center">
                    <span class="text-sm font-bold text-gray-900"><?php echo e($item['total_ingresos']); ?></span>
                    <span class="text-xs text-gray-400 font-mono ml-1">sesiones</span>
                </td>
                <td class="px-5 py-3 text-right">
                    <span class="text-sm font-mono text-gray-500">
                        <?php echo e(floor($item['total_minutos'] / 60)); ?>h <?php echo e($item['total_minutos'] % 60); ?>m
                    </span>
                </td>
                <td class="px-5 py-3 hidden sm:table-cell">
                    <div class="flex items-center justify-end gap-2">
                        <div class="w-24 bg-gray-100 rounded-full h-2">
                            <div class="h-2 rounded-full <?php echo e($i === 0 ? 'bg-yellow-400' : ($i === $rankingUsuarios->count() - 1 ? 'bg-red-400' : 'bg-red-600')); ?>"
                                 style="width: <?php echo e($maxIngresos > 0 ? round(($item['total_ingresos'] / $maxIngresos) * 100) : 0); ?>%">
                            </div>
                        </div>
                        <span class="text-xs font-mono text-gray-400 w-8 text-right">
                            <?php echo e($maxIngresos > 0 ? round(($item['total_ingresos'] / $maxIngresos) * 100) : 0); ?>%
                        </span>
                    </div>
                </td>
            </tr>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </tbody>
    </table>
    <div class="px-5 py-3 border-t border-gray-100 bg-gray-50 flex items-center gap-4 text-xs font-mono text-gray-400">
        <span>🥇 Mayor actividad del mes</span>
        <span class="text-red-400">🔴 Menor actividad del mes</span>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
 
<?php $__env->stopSection(); ?>
 
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Projects\techportal\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>