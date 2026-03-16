

<?php $__env->startSection('title', 'Órdenes de Mantención'); ?>
<?php $__env->startSection('page-title', 'Órdenes de Mantención'); ?>
<?php $__env->startSection('page-subtitle', $ordenes->count() . ' órdenes registradas'); ?>

<?php $__env->startSection('topbar-actions'); ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->hasRole('tecnico') || auth()->user()->hasRole('admin')): ?>
    <a href="<?php echo e(route('mantencion.create')); ?>"
       class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors">
        + Nueva Orden
    </a>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($ordenes->isEmpty()): ?>
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-12 text-center">
        <div class="text-4xl mb-3">📋</div>
        <div class="text-gray-500 text-sm">No hay órdenes registradas.</div>
        <a href="<?php echo e(route('mantencion.create')); ?>"
           class="inline-block mt-4 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-5 py-2 rounded-lg transition-colors">
            + Crear primera orden
        </a>
    </div>
<?php else: ?>
<div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
    <table class="w-full">
        <thead>
            <tr class="bg-gray-50 border-b border-gray-100">
                <th class="text-left px-5 py-3 text-xs font-mono text-gray-400 uppercase tracking-wider">N° Orden</th>
                <th class="text-left px-5 py-3 text-xs font-mono text-gray-400 uppercase tracking-wider hidden sm:table-cell">Cliente</th>
                <th class="text-left px-5 py-3 text-xs font-mono text-gray-400 uppercase tracking-wider hidden md:table-cell">Técnico</th>
                <th class="text-left px-5 py-3 text-xs font-mono text-gray-400 uppercase tracking-wider hidden md:table-cell">Fecha</th>
                <th class="text-left px-5 py-3 text-xs font-mono text-gray-400 uppercase tracking-wider">Equipos</th>
                <th class="text-left px-5 py-3 text-xs font-mono text-gray-400 uppercase tracking-wider">Estado</th>
                <th class="text-right px-5 py-3 text-xs font-mono text-gray-400 uppercase tracking-wider">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $ordenes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $orden): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-5 py-3">
                    <span class="text-sm font-mono font-bold text-gray-900"><?php echo e($orden->numero_orden); ?></span>
                </td>
                <td class="px-5 py-3 hidden sm:table-cell">
                    <span class="text-sm text-gray-700"><?php echo e($orden->cliente->nombre); ?></span>
                </td>
                <td class="px-5 py-3 hidden md:table-cell">
                    <span class="text-sm text-gray-500"><?php echo e($orden->user->name); ?></span>
                </td>
                <td class="px-5 py-3 hidden md:table-cell">
                    <span class="text-xs font-mono text-gray-400"><?php echo e($orden->fecha->format('d/m/Y')); ?></span>
                </td>
                <td class="px-5 py-3">
                    <span class="text-xs font-mono bg-gray-100 text-gray-600 px-2 py-1 rounded-full">
                        <?php echo e($orden->equipos->count()); ?> equipo(s)
                    </span>
                </td>
                <td class="px-5 py-3">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($orden->estado === 'enviada'): ?>
                        <span class="text-xs font-mono font-bold px-2 py-1 rounded bg-green-50 text-green-600">
                            ✓ Enviada
                        </span>
                    <?php else: ?>
                        <span class="text-xs font-mono font-bold px-2 py-1 rounded bg-amber-50 text-amber-600">
                            Borrador
                        </span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
                <td class="px-5 py-3">
                    <div class="flex items-center justify-end gap-2">
                        <a href="<?php echo e(route('mantencion.show', $orden)); ?>"
                           class="text-xs text-gray-400 border border-gray-200 rounded px-2 py-1 hover:text-gray-600 transition-colors">
                            👁 Ver
                        </a>
                        <a href="<?php echo e(route('mantencion.pdf', $orden)); ?>"
                           class="text-xs text-white bg-red-600 hover:bg-red-700 rounded px-2 py-1 transition-colors">
                            ⬇ PDF
                        </a>
                    </div>
                </td>
            </tr>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </tbody>
    </table>
</div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Projects\techportal\resources\views/mantencion/index.blade.php ENDPATH**/ ?>