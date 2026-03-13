<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($recursos->isEmpty()): ?>
    <div class="bg-white border border-gray-200 rounded-xl p-12 text-center">
        <div class="text-4xl mb-3">📭</div>
        <div class="text-gray-400 text-sm">No hay <?php echo e($categoria); ?>s cargados aún.</div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if (\Illuminate\Support\Facades\Blade::check('role', 'admin')): ?>
        <a href="<?php echo e(route('documentos.create', $cliente)); ?>"
           class="inline-block mt-3 text-sm text-red-600 font-semibold hover:text-red-700">
            + Subir primero →
        </a>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
<?php else: ?>
<div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
    <table class="w-full">
        <thead>
            <tr class="bg-gray-50 border-b border-gray-100">
                <th class="text-left px-4 py-3 text-xs font-mono text-gray-400 uppercase tracking-wider">Nombre</th>
                <th class="text-left px-4 py-3 text-xs font-mono text-gray-400 uppercase tracking-wider hidden sm:table-cell">Tipo</th>
                <th class="text-left px-4 py-3 text-xs font-mono text-gray-400 uppercase tracking-wider hidden md:table-cell">Versión</th>
                <th class="text-left px-4 py-3 text-xs font-mono text-gray-400 uppercase tracking-wider hidden md:table-cell">Tamaño</th>
                <th class="text-right px-4 py-3 text-xs font-mono text-gray-400 uppercase tracking-wider">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $recursos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recurso): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-4 py-3">
                    <div class="flex items-center gap-3">
                        <span class="text-xl"><?php echo e($recurso->icono); ?></span>
                        <div>
                            <div class="text-sm font-medium text-gray-900"><?php echo e($recurso->nombre); ?></div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($recurso->descripcion): ?>
                            <div class="text-xs text-gray-400 truncate max-w-xs"><?php echo e($recurso->descripcion); ?></div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                </td>
                <td class="px-4 py-3 hidden sm:table-cell">
                    <span class="text-xs font-mono font-bold px-2 py-1 rounded
                        <?php echo e($recurso->tipo === 'PDF' ? 'bg-red-50 text-red-600' : ''); ?>

                        <?php echo e($recurso->tipo === 'ISO' ? 'bg-purple-50 text-purple-600' : ''); ?>

                        <?php echo e($recurso->tipo === 'EXE' ? 'bg-green-50 text-green-600' : ''); ?>

                        <?php echo e($recurso->tipo === 'IMG' ? 'bg-amber-50 text-amber-600' : ''); ?>

                        <?php echo e($recurso->tipo === 'ZIP' ? 'bg-blue-50 text-blue-600' : ''); ?>

                        <?php echo e($recurso->tipo === 'LINK' ? 'bg-gray-100 text-gray-600' : ''); ?>">
                        <?php echo e($recurso->tipo); ?>

                    </span>
                </td>
                <td class="px-4 py-3 hidden md:table-cell">
                    <span class="text-xs text-gray-400 font-mono"><?php echo e($recurso->version ?? '—'); ?></span>
                </td>
                <td class="px-4 py-3 hidden md:table-cell">
                    <span class="text-xs text-gray-400 font-mono"><?php echo e($recurso->tamanio ?? '—'); ?></span>
                </td>
                <td class="px-4 py-3">
                    <div class="flex items-center justify-end gap-2">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($recurso->tipo === 'PDF'): ?>
                        <a href="<?php echo e(route('documentos.ver', $recurso)); ?>"
                           class="text-xs bg-red-50 text-red-600 border border-red-100 rounded px-2 py-1 hover:bg-red-600 hover:text-white transition-colors font-semibold">
                            📖 Leer
                        </a>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($recurso->archivo || $recurso->url): ?>
                        <a href="<?php echo e($recurso->url ?? route('documentos.descargar', $recurso)); ?>"
                           class="text-xs bg-gray-50 text-gray-600 border border-gray-200 rounded px-2 py-1 hover:bg-gray-600 hover:text-white transition-colors"
                           <?php echo e($recurso->url ? 'target=_blank' : ''); ?>>
                            ⬇ Bajar
                        </a>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if (\Illuminate\Support\Facades\Blade::check('role', 'admin')): ?>
                        <a href="<?php echo e(route('documentos.edit', $recurso)); ?>"
                           class="text-xs text-gray-400 border border-gray-200 rounded px-2 py-1 hover:text-gray-600 transition-colors">
                            ✏️
                        </a>
                        <form method="POST" action="<?php echo e(route('documentos.destroy', $recurso)); ?>"
                              onsubmit="return confirm('¿Eliminar este recurso?')">
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
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?><?php /**PATH E:\Projects\techportal\resources\views/clientes/partials/tabla-recursos.blade.php ENDPATH**/ ?>