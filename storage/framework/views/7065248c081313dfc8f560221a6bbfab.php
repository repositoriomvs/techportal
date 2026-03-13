

<?php $__env->startSection('title', 'Nuevo Cliente'); ?>
<?php $__env->startSection('page-title', 'Nuevo Cliente'); ?>
<?php $__env->startSection('page-subtitle', 'Completá los datos del cliente'); ?>

<?php $__env->startSection('content'); ?>

<div class="max-w-2xl">
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">

        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="font-bold text-gray-900">Datos del Cliente</h2>
        </div>

        <form method="POST" action="<?php echo e(route('clientes.store')); ?>" class="p-6">
            <?php echo csrf_field(); ?>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">

                
                <div class="sm:col-span-2">
                    <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">
                        Nombre <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nombre" value="<?php echo e(old('nombre')); ?>" required
                           placeholder="Ej: ACME Corporation"
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all
                                  <?php echo e($errors->has('nombre') ? 'border-red-400' : ''); ?>">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                
                <div>
                    <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">
                        Código <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="codigo" value="<?php echo e(old('codigo')); ?>" required
                           placeholder="Ej: CLI-001"
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm font-mono focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all
                                  <?php echo e($errors->has('codigo') ? 'border-red-400' : ''); ?>">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['codigo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                
                <div>
                    <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">
                        Color Avatar
                    </label>
                    <div class="flex items-center gap-3">
                        <input type="color" name="color" value="<?php echo e(old('color', '#c84b2f')); ?>"
                               class="w-10 h-10 rounded-lg border border-gray-200 cursor-pointer p-1">
                        <span class="text-xs text-gray-400">Color del avatar del cliente</span>
                    </div>
                </div>

                
                <div>
                    <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">
                        Contacto
                    </label>
                    <input type="text" name="contacto" value="<?php echo e(old('contacto')); ?>"
                           placeholder="Nombre del contacto"
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all">
                </div>

                
                <div>
                    <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">
                        Email
                    </label>
                    <input type="email" name="email" value="<?php echo e(old('email')); ?>"
                           placeholder="contacto@empresa.com"
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all">
                </div>

                
                <div>
                    <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">
                        Teléfono
                    </label>
                    <input type="text" name="telefono" value="<?php echo e(old('telefono')); ?>"
                           placeholder="+56 9 1234 5678"
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all">
                </div>

                
                <div>
                    <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">
                        Estado
                    </label>
                    <select name="estado"
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all">
                        <option value="activo" <?php echo e(old('estado') === 'activo' ? 'selected' : ''); ?>>Activo</option>
                        <option value="inactivo" <?php echo e(old('estado') === 'inactivo' ? 'selected' : ''); ?>>Inactivo</option>
                    </select>
                </div>

                
                <div class="sm:col-span-2">
                    <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">
                        Notas
                    </label>
                    <textarea name="notas" rows="3"
                              placeholder="Información adicional del cliente..."
                              class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all resize-none"><?php echo e(old('notas')); ?></textarea>
                </div>

            </div>

            <div class="flex items-center gap-3 pt-2 border-t border-gray-100">
                <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-2.5 rounded-lg text-sm transition-colors">
                    Guardar Cliente
                </button>
                <a href="<?php echo e(route('clientes.index')); ?>"
                   class="text-sm text-gray-500 hover:text-gray-700 border border-gray-200 px-6 py-2.5 rounded-lg transition-colors">
                    Cancelar
                </a>
            </div>

        </form>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Projects\techportal\resources\views/clientes/create.blade.php ENDPATH**/ ?>