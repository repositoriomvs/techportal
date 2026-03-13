

<?php $__env->startSection('title', 'Usuarios'); ?>
<?php $__env->startSection('page-title', 'Usuarios'); ?>
<?php $__env->startSection('page-subtitle', $usuarios->count() . ' usuarios registrados'); ?>

<?php $__env->startSection('topbar-actions'); ?>
    <a href="<?php echo e(route('usuarios.create')); ?>"
       class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors">
        + Nuevo Usuario
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
    <table class="w-full">
        <thead>
            <tr class="bg-gray-50 border-b border-gray-100">
                <th class="text-left px-5 py-3 text-xs font-mono text-gray-400 uppercase tracking-wider">Usuario</th>
                <th class="text-left px-5 py-3 text-xs font-mono text-gray-400 uppercase tracking-wider hidden sm:table-cell">Email</th>
                <th class="text-left px-5 py-3 text-xs font-mono text-gray-400 uppercase tracking-wider">Rol</th>
                <th class="text-left px-5 py-3 text-xs font-mono text-gray-400 uppercase tracking-wider hidden md:table-cell">Creado</th>
                <th class="text-right px-5 py-3 text-xs font-mono text-gray-400 uppercase tracking-wider">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $usuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usuario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-5 py-3">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-red-600 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                            <?php echo e(strtoupper(substr($usuario->name, 0, 2))); ?>

                        </div>
                        <div class="font-medium text-sm text-gray-900">
                            <?php echo e($usuario->name); ?>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($usuario->id === auth()->id()): ?>
                                <span class="text-xs text-gray-400 font-mono">(vos)</span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                </td>
                <td class="px-5 py-3 hidden sm:table-cell">
                    <span class="text-sm text-gray-500 font-mono"><?php echo e($usuario->email); ?></span>
                </td>
                <td class="px-5 py-3">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $usuario->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                        <span class="text-xs font-mono font-bold px-2 py-1 rounded
                            <?php echo e($role->name === 'admin' ? 'bg-red-50 text-red-600' : 'bg-blue-50 text-blue-600'); ?>">
                            <?php echo e($role->name === 'admin' ? '🛡️ Admin' : '🔧 Técnico'); ?>

                        </span>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </td>
                <td class="px-5 py-3 hidden md:table-cell">
                    <span class="text-xs text-gray-400 font-mono"><?php echo e($usuario->created_at->format('d/m/Y')); ?></span>
                </td>
                <td class="px-5 py-3">
                    <div class="flex items-center justify-end gap-2">
                        <a href="<?php echo e(route('usuarios.edit', $usuario)); ?>"
                           class="text-xs text-gray-400 border border-gray-200 rounded px-2 py-1 hover:text-gray-600 transition-colors">
                            ✏️ Editar
                        </a>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($usuario->id !== auth()->id()): ?>
                        <form method="POST" action="<?php echo e(route('usuarios.destroy', $usuario)); ?>"
                              onsubmit="return confirm('¿Eliminar a <?php echo e($usuario->name); ?>?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button class="text-xs text-red-400 border border-red-100 rounded px-2 py-1 hover:text-red-600 transition-colors">
                                🗑️
                            </button>
                        </form>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </td>
            </tr>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </tbody>
    </table>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Projects\techportal\resources\views/usuarios/index.blade.php ENDPATH**/ ?>