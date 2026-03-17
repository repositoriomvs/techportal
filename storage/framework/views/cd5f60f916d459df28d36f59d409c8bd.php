

<?php $__env->startSection('title', 'Gestión de Clientes'); ?>
<?php $__env->startSection('page-title', 'Gestión de Clientes'); ?>
<?php $__env->startSection('page-subtitle', $clientes->count() . ' clientes registrados'); ?>

<?php $__env->startSection('topbar-actions'); ?>
    <a href="<?php echo e(route('clientes.create')); ?>"
       class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors">
        + Agregar Cliente
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($clientes->isEmpty()): ?>
    <div class="bg-white border border-gray-200 rounded-xl p-16 text-center">
        <div class="text-5xl mb-4">🏢</div>
        <div class="text-gray-500 text-sm mb-4">No hay clientes registrados aún.</div>
        <a href="<?php echo e(route('clientes.create')); ?>"
           class="inline-block bg-red-600 text-white text-sm font-semibold px-6 py-2 rounded-lg hover:bg-red-700">
            + Crear primer cliente
        </a>
    </div>
<?php else: ?>
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Cliente</th>
                    <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Código</th>
                    <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Contacto</th>
                    <th class="px-5 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Estado</th>
                    <th class="px-5 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">SLA</th>
                    <th class="px-5 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Recursos</th>
                    <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $clientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cliente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl flex items-center justify-center text-white font-bold text-sm flex-shrink-0"
                                 style="background-color: <?php echo e($cliente->color); ?>">
                                <?php echo e($cliente->iniciales); ?>

                            </div>
                            <div>
                                <div class="font-semibold text-gray-900"><?php echo e($cliente->nombre); ?></div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($cliente->email): ?>
                                <div class="text-xs text-gray-400 font-mono"><?php echo e($cliente->email); ?></div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-3">
                        <span class="font-mono text-xs text-gray-600"><?php echo e($cliente->codigo); ?></span>
                    </td>
                    <td class="px-5 py-3 text-gray-500 text-xs">
                        <?php echo e($cliente->contacto ?? '—'); ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($cliente->telefono): ?>
                        <div class="font-mono text-gray-400"><?php echo e($cliente->telefono); ?></div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </td>
                    <td class="px-5 py-3 text-center">
                        <span class="text-xs font-mono font-semibold px-2 py-1 rounded
                            <?php echo e($cliente->estado === 'activo' ? 'bg-green-50 text-green-600' : 'bg-gray-100 text-gray-400'); ?>">
                            <?php echo e($cliente->estado); ?>

                        </span>
                    </td>
                    <td class="px-5 py-3 text-center">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($cliente->tiene_sla): ?>
                            <span class="text-xs font-mono font-semibold px-2 py-1 rounded bg-blue-50 text-blue-600">✓ SLA</span>
                        <?php else: ?>
                            <span class="text-xs text-gray-300">—</span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </td>
                    <td class="px-5 py-3 text-center">
                        <span class="text-xs font-mono text-gray-500"><?php echo e($cliente->documentos_count); ?></span>
                    </td>
                    <td class="px-5 py-3">
                        <div class="flex items-center justify-end gap-2">
                            <a href="<?php echo e(route('clientes.show', $cliente)); ?>"
                               class="text-xs text-gray-400 hover:text-gray-600 border border-gray-200 rounded px-2 py-1 transition-colors">
                                👁 Ver
                            </a>
                            <a href="<?php echo e(route('clientes.edit', $cliente)); ?>"
                               class="text-xs text-gray-400 hover:text-gray-600 border border-gray-200 rounded px-2 py-1 transition-colors">
                                ✏️ Editar
                            </a>
                            <form method="POST" action="<?php echo e(route('clientes.destroy', $cliente)); ?>"
                                  onsubmit="return confirm('¿Eliminar <?php echo e($cliente->nombre); ?>? Esta acción no se puede deshacer.')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button class="text-xs text-red-400 hover:text-red-600 border border-red-100 rounded px-2 py-1 transition-colors">
                                    🗑️
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Projects\techportal\resources\views/admin/gestionclientes.blade.php ENDPATH**/ ?>