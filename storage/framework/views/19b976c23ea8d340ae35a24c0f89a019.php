

<?php $__env->startSection('title', 'Clientes'); ?>
<?php $__env->startSection('page-title', 'Clientes'); ?>
<?php $__env->startSection('page-subtitle', $clientes->count() . ' clientes registrados'); ?>

<?php $__env->startSection('topbar-actions'); ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->hasRole('admin')): ?>
    <a href="<?php echo e(route('clientes.create')); ?>"
       class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors">
        + Nuevo Cliente
    </a>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($clientes->isEmpty()): ?>
    <div class="bg-white border border-gray-200 rounded-xl p-16 text-center">
        <div class="text-5xl mb-4">🏢</div>
        <div class="text-gray-500 text-sm">No hay clientes registrados aún.</div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if (\Illuminate\Support\Facades\Blade::check('role', 'admin')): ?>
        <a href="<?php echo e(route('clientes.create')); ?>"
           class="inline-block mt-4 bg-red-600 text-white text-sm font-semibold px-6 py-2 rounded-lg hover:bg-red-700">
            + Crear primer cliente
        </a>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
<?php else: ?>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $clientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cliente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all">

        
        <div class="p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white font-bold text-lg flex-shrink-0"
                 style="background-color: <?php echo e($cliente->color); ?>">
                <?php echo e($cliente->iniciales); ?>

            </div>
            <div class="flex-1 min-w-0">
                <div class="font-bold text-gray-900 truncate"><?php echo e($cliente->nombre); ?></div>
                <div class="text-xs text-gray-400 font-mono"><?php echo e($cliente->codigo); ?></div>
            </div>
            <span class="text-xs font-mono font-semibold px-2 py-1 rounded
                <?php echo e($cliente->estado === 'activo' ? 'bg-green-50 text-green-600' : 'bg-gray-100 text-gray-400'); ?>">
                <?php echo e($cliente->estado); ?>

            </span>
        </div>

        
        <div class="px-5 py-3 bg-gray-50 border-t border-gray-100 grid grid-cols-3 gap-2">
            <div class="text-center">
                <div class="text-lg font-bold text-gray-900">
                    <?php echo e($cliente->documentos()->where('categoria', 'documento')->count()); ?>

                </div>
                <div class="text-xs text-gray-400 font-mono uppercase">Docs</div>
            </div>
            <div class="text-center">
                <div class="text-lg font-bold text-gray-900">
                    <?php echo e($cliente->documentos()->where('categoria', 'procedimiento')->count()); ?>

                </div>
                <div class="text-xs text-gray-400 font-mono uppercase">Procs</div>
            </div>
            <div class="text-center">
                <div class="text-lg font-bold text-gray-900">
                    <?php echo e($cliente->documentos()->where('categoria', 'imagen')->count()); ?>

                </div>
                <div class="text-xs text-gray-400 font-mono uppercase">Imgs</div>
            </div>
        </div>

        
        <div class="px-5 py-3 border-t border-gray-100 flex items-center justify-end gap-2">
            <a href="<?php echo e(route('clientes.show', $cliente)); ?>"
   class="flex items-center gap-1 bg-red-600 hover:bg-red-700 text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition-colors">
    Ver repositorio →
</a>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if (\Illuminate\Support\Facades\Blade::check('role', 'admin')): ?>
            <div class="flex gap-2">
                <a href="<?php echo e(route('clientes.edit', $cliente)); ?>"
                   class="text-xs text-gray-400 hover:text-gray-600 border border-gray-200 rounded px-2 py-1 transition-colors">
                    ✏️ Editar
                </a>
                <form method="POST" action="<?php echo e(route('clientes.destroy', $cliente)); ?>"
                      onsubmit="return confirm('¿Eliminar <?php echo e($cliente->nombre); ?>?')">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button class="text-xs text-red-400 hover:text-red-600 border border-red-100 rounded px-2 py-1 transition-colors">
                        🗑️
                    </button>
                </form>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
</div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Projects\techportal\resources\views/clientes/index.blade.php ENDPATH**/ ?>