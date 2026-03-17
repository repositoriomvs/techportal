<?php $__env->startSection('title', $cliente->nombre); ?>
<?php $__env->startSection('page-title', $cliente->nombre); ?>
<?php $__env->startSection('page-subtitle', $cliente->codigo . ' · ' . $cliente->documentos->count() . ' recursos'); ?>

<?php $__env->startSection('topbar-actions'); ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if (\Illuminate\Support\Facades\Blade::check('role', 'admin')): ?>
    <a href="<?php echo e(route('documentos.create', $cliente)); ?>"
       class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors">
        + Subir Recurso
    </a>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>


<div class="bg-white border border-gray-200 rounded-xl p-5 mb-5 shadow-sm">
    <div class="flex items-center gap-4">
        <div class="w-14 h-14 rounded-xl flex items-center justify-center text-white font-bold text-xl flex-shrink-0"
             style="background-color: <?php echo e($cliente->color); ?>">
            <?php echo e($cliente->iniciales); ?>

        </div>
        <div class="flex-1">
            <div class="font-bold text-xl text-gray-900"><?php echo e($cliente->nombre); ?></div>
            <div class="text-sm text-gray-400 font-mono mt-0.5">
                <?php echo e($cliente->codigo); ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($cliente->contacto): ?> · <?php echo e($cliente->contacto); ?> <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($cliente->email): ?> · <?php echo e($cliente->email); ?> <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
        <div class="hidden sm:flex gap-6 text-center">
            <div>
                <div class="text-2xl font-bold text-gray-900"><?php echo e($documentos->count()); ?></div>
                <div class="text-xs text-gray-400 font-mono uppercase">Documentos</div>
            </div>
            <div>
                <div class="text-2xl font-bold text-gray-900"><?php echo e($procedimientos->count()); ?></div>
                <div class="text-xs text-gray-400 font-mono uppercase">Procedimientos</div>
            </div>
            <div>
                <div class="text-2xl font-bold text-gray-900"><?php echo e($imagenes->count()); ?></div>
                <div class="text-xs text-gray-400 font-mono uppercase">Imágenes</div>
            </div>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if (\Illuminate\Support\Facades\Blade::check('role', 'admin')): ?>
        <a href="<?php echo e(route('clientes.edit', $cliente)); ?>"
           class="text-sm text-gray-400 hover:text-gray-600 border border-gray-200 rounded-lg px-3 py-2 transition-colors">
            ✏️ Editar
        </a>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    
    <div class="mt-4 pt-4 border-t border-gray-100">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($cliente->tiene_sla): ?>
            <div class="flex items-center gap-2 mb-3">
                <span class="inline-flex items-center gap-1.5 bg-green-50 text-green-700 border border-green-200 text-xs font-semibold px-3 py-1 rounded-full">
                    ✓ Cuenta con SLA
                </span>
            </div>
            <div class="grid grid-cols-3 gap-3">

                <div class="bg-gray-50 border border-gray-100 rounded-lg px-4 py-3 text-center">
                    <div class="text-xs font-mono text-gray-400 uppercase tracking-wider mb-1">Tiempo respuesta</div>
                    <div class="text-2xl font-bold text-gray-900">
                        <?php echo e($cliente->sla_horas_respuesta > 0 ? $cliente->sla_horas_respuesta : '—'); ?>

                    </div>
                    <div class="text-xs text-gray-400 mt-0.5">
                        <?php echo e($cliente->sla_horas_respuesta > 0 ? 'hora' . ($cliente->sla_horas_respuesta !== 1 ? 's' : '') : 'sin compromiso'); ?>

                    </div>
                </div>

                <div class="bg-gray-50 border border-gray-100 rounded-lg px-4 py-3 text-center">
                    <div class="text-xs font-mono text-gray-400 uppercase tracking-wider mb-1">Tiempo resolución</div>
                    <div class="text-2xl font-bold text-gray-900">
                        <?php echo e($cliente->sla_horas_resolucion > 0 ? $cliente->sla_horas_resolucion : '—'); ?>

                    </div>
                    <div class="text-xs text-gray-400 mt-0.5">
                        <?php echo e($cliente->sla_horas_resolucion > 0 ? 'hora' . ($cliente->sla_horas_resolucion !== 1 ? 's' : '') : 'sin compromiso'); ?>

                    </div>
                </div>

                <div class="bg-gray-50 border border-gray-100 rounded-lg px-4 py-3 text-center">
                    <div class="text-xs font-mono text-gray-400 uppercase tracking-wider mb-1">Cambio de equipo</div>
                    <div class="text-2xl font-bold text-gray-900">
                        <?php echo e($cliente->sla_horas_cambio_equipo > 0 ? $cliente->sla_horas_cambio_equipo : '—'); ?>

                    </div>
                    <div class="text-xs text-gray-400 mt-0.5">
                        <?php echo e($cliente->sla_horas_cambio_equipo > 0 ? 'hora' . ($cliente->sla_horas_cambio_equipo !== 1 ? 's' : '') : 'sin compromiso'); ?>

                    </div>
                </div>

            </div>
        <?php else: ?>
            <span class="inline-flex items-center gap-1.5 bg-gray-50 text-gray-400 border border-gray-200 text-xs font-semibold px-3 py-1 rounded-full">
                — Sin SLA definido
            </span>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>


<div x-data="{ tab: 'documentos' }">

    <div class="flex gap-0 bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm mb-4">
        <button @click="tab = 'documentos'"
                :class="tab === 'documentos' ? 'bg-red-50 text-red-600 font-bold border-b-2 border-red-600' : 'text-gray-500 hover:bg-gray-50'"
                class="flex-1 px-4 py-3 text-sm transition-all flex items-center justify-center gap-2">
            📄 Documentos
            <span class="bg-gray-100 text-gray-600 text-xs font-mono px-2 py-0.5 rounded-full"><?php echo e($documentos->count()); ?></span>
        </button>
        <button @click="tab = 'procedimientos'"
                :class="tab === 'procedimientos' ? 'bg-red-50 text-red-600 font-bold border-b-2 border-red-600' : 'text-gray-500 hover:bg-gray-50'"
                class="flex-1 px-4 py-3 text-sm transition-all flex items-center justify-center gap-2 border-x border-gray-200">
            📋 Procedimientos
            <span class="bg-gray-100 text-gray-600 text-xs font-mono px-2 py-0.5 rounded-full"><?php echo e($procedimientos->count()); ?></span>
        </button>
        <button @click="tab = 'imagenes'"
                :class="tab === 'imagenes' ? 'bg-red-50 text-red-600 font-bold border-b-2 border-red-600' : 'text-gray-500 hover:bg-gray-50'"
                class="flex-1 px-4 py-3 text-sm transition-all flex items-center justify-center gap-2">
            🖼️ Imágenes
            <span class="bg-gray-100 text-gray-600 text-xs font-mono px-2 py-0.5 rounded-full"><?php echo e($imagenes->count()); ?></span>
        </button>
    </div>

    <div x-show="tab === 'documentos'">
        <?php echo $__env->make('clientes.partials.tabla-recursos', ['recursos' => $documentos, 'categoria' => 'documento'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
    <div x-show="tab === 'procedimientos'">
        <?php echo $__env->make('clientes.partials.tabla-recursos', ['recursos' => $procedimientos, 'categoria' => 'procedimiento'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
    <div x-show="tab === 'imagenes'">
        <?php echo $__env->make('clientes.partials.tabla-recursos', ['recursos' => $imagenes, 'categoria' => 'imagen'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>

</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Projects\techportal\resources\views/clientes/show.blade.php ENDPATH**/ ?>