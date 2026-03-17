<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('page-title', 'Dashboard'); ?>
<?php $__env->startSection('page-subtitle', 'Resumen general del sistema'); ?>



<?php $__env->startSection('content'); ?>


<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <span class="text-2xl">🏢</span>
            <span class="text-xs font-mono bg-green-50 text-green-600 border border-green-100 px-2 py-0.5 rounded-full">Activos</span>
        </div>
        <div class="text-3xl font-bold text-gray-900"><?php echo e($totalClientes); ?></div>
        <div class="text-xs text-gray-400 mt-1 uppercase tracking-wide font-mono">Clientes</div>
    </div>
    <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
        <div class="flex items-center justify-between mb-3"><span class="text-2xl">📄</span></div>
        <div class="text-3xl font-bold text-gray-900"><?php echo e($totalRecursos); ?></div>
        <div class="text-xs text-gray-400 mt-1 uppercase tracking-wide font-mono">Recursos Totales</div>
    </div>
    <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
        <div class="flex items-center justify-between mb-3"><span class="text-2xl">🔧</span></div>
        <div class="text-3xl font-bold text-gray-900"><?php echo e($totalHerramientas); ?></div>
        <div class="text-xs text-gray-400 mt-1 uppercase tracking-wide font-mono">Herramientas</div>
    </div>
    <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
        <div class="flex items-center justify-between mb-3"><span class="text-2xl">👥</span></div>
        <div class="text-3xl font-bold text-gray-900"><?php echo e($totalUsuarios); ?></div>
        <div class="text-xs text-gray-400 mt-1 uppercase tracking-wide font-mono">Técnicos</div>
    </div>
</div>


<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-4">

    
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100">
            <h2 class="font-bold text-gray-900">📖 Últimas visitas</h2>
            <p class="text-xs text-gray-400 font-mono mt-0.5">Continua tu última visita</p>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($ultimasVisitas->isEmpty()): ?>
            <div class="p-8 text-center">
                <div class="text-3xl mb-2">📂</div>
                <div class="text-sm text-gray-400">Aún no has visitado ningún recurso.</div>
                <a href="<?php echo e(route('clientes.index')); ?>" class="inline-block mt-3 text-xs text-red-600 font-semibold hover:text-red-700">Explorar clientes →</a>
            </div>
        <?php else: ?>
            <div class="divide-y divide-gray-50">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $ultimasVisitas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $visita): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <?php
                    $url = $visita->recurso_url;
                    if (!empty($visita->ultima_pagina) && $visita->ultima_pagina > 1) {
                        $url .= '?reanudar=' . $visita->ultima_pagina;
                    }
                ?>
                <a href="<?php echo e($url); ?>" class="flex items-center gap-3 px-5 py-3.5 hover:bg-gray-50 transition-colors group">
                    <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0 <?php echo e($visita->tipo === 'documento' ? 'bg-red-50' : 'bg-blue-50'); ?>">
                        <span class="text-lg"><?php echo e($visita->tipo === 'documento' ? '📄' : '🖥️'); ?></span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-sm font-medium text-gray-900 truncate group-hover:text-red-600 transition-colors"><?php echo e($visita->recurso_nombre); ?></div>
                        <div class="text-xs text-gray-400 font-mono flex items-center gap-2 mt-0.5">
                            <span><?php echo e($visita->tipo === 'documento' ? 'Documento' : 'Hardware'); ?></span>
                            <span class="text-gray-200">·</span>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($visita->ultima_pagina) && $visita->ultima_pagina > 1): ?>
                                <span class="text-amber-500 font-semibold">Pág. <?php echo e($visita->ultima_pagina); ?></span>
                            <?php else: ?>
                                <span>Pág. 1</span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <span class="text-gray-200">·</span>
                            <span><?php echo e($visita->visitado_at->diffForHumans()); ?></span>
                        </div>
                    </div>
                    <span class="text-gray-300 group-hover:text-red-400 transition-colors flex-shrink-0">→</span>
                </a>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden" x-data="{ abierto: false }">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h2 class="font-bold text-gray-900">📢 Avisos Importantes</h2>
                <p class="text-xs text-gray-400 font-mono mt-0.5">Novedades y actualizaciones</p>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->hasRole('admin')): ?>
            <button @click="abierto = true" class="text-xs bg-red-600 text-white font-semibold px-3 py-1.5 rounded-lg hover:bg-red-700 transition-colors">+ Nuevo</button>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($avisos->isEmpty()): ?>
            <div class="p-8 text-center">
                <div class="text-3xl mb-2">📭</div>
                <div class="text-sm text-gray-400">No hay avisos publicados.</div>
            </div>
        <?php else: ?>
            <div class="divide-y divide-gray-50">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $avisos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $aviso): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <div class="px-5 py-3.5 hover:bg-gray-50 transition-colors">
                    <div class="flex items-start gap-3">
                        <span class="text-lg flex-shrink-0 mt-0.5">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($aviso->tipo === 'advertencia'): ?> ⚠️
                            <?php elseif($aviso->tipo === 'actualizacion'): ?> 🔄
                            <?php else: ?> ℹ️
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </span>
                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-semibold text-gray-900"><?php echo e($aviso->titulo); ?></div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($aviso->contenido): ?>
                            <div class="text-xs text-gray-500 mt-0.5 line-clamp-2"><?php echo e($aviso->contenido); ?></div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <div class="flex items-center gap-3 mt-1.5 flex-wrap">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($aviso->url): ?>
                                <a href="<?php echo e($aviso->url); ?>" class="text-xs text-red-600 font-semibold hover:text-red-700 transition-colors"><?php echo e($aviso->url_texto ?? 'Ver recurso'); ?> →</a>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <span class="text-xs text-gray-400 font-mono"><?php echo e($aviso->publicado_at?->diffForHumans()); ?></span>
                                <span class="text-xs text-gray-300 font-mono">por <?php echo e($aviso->user->name ?? 'Admin'); ?></span>
                            </div>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->hasRole('admin')): ?>
                        <form method="POST" action="<?php echo e(route('avisos.destroy', $aviso)); ?>" onsubmit="return confirm('¿Eliminar este aviso?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="text-gray-300 hover:text-red-500 transition-colors text-sm leading-none mt-0.5">✕</button>
                        </form>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->hasRole('admin')): ?>
        <div x-show="abierto" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black/40" x-cloak @click.self="abierto = false" @keydown.escape.window="abierto = false">
            <div class="bg-white rounded-xl shadow-xl p-6 w-full max-w-md mx-4">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold text-gray-900">📢 Nuevo Aviso</h3>
                    <button @click="abierto = false" class="text-gray-400 hover:text-gray-600 transition-colors text-lg leading-none">✕</button>
                </div>
                <form method="POST" action="<?php echo e(route('avisos.store')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="flex flex-col gap-3">
                        <div>
                            <label class="block text-xs font-mono text-gray-500 uppercase tracking-wide mb-1">Título *</label>
                            <input type="text" name="titulo" required placeholder="Ej: Procedimiento actualizado" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-400">
                        </div>
                        <div>
                            <label class="block text-xs font-mono text-gray-500 uppercase tracking-wide mb-1">Tipo</label>
                            <select name="tipo" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-400">
                                <option value="info">ℹ️ Información</option>
                                <option value="actualizacion">🔄 Actualización</option>
                                <option value="advertencia">⚠️ Advertencia</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-mono text-gray-500 uppercase tracking-wide mb-1">Descripción</label>
                            <textarea name="contenido" rows="2" placeholder="Detalle del aviso..." class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-400 resize-none"></textarea>
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-xs font-mono text-gray-500 uppercase tracking-wide mb-1">URL del recurso</label>
                                <input type="text" name="url" placeholder="/clientes/1" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-400">
                            </div>
                            <div>
                                <label class="block text-xs font-mono text-gray-500 uppercase tracking-wide mb-1">Texto del link</label>
                                <input type="text" name="url_texto" placeholder="Ver manual" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-400">
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-2 mt-5">
                        <button type="submit" class="flex-1 bg-red-600 text-white font-semibold py-2.5 rounded-lg text-sm hover:bg-red-700 transition-colors">Publicar aviso</button>
                        <button type="button" @click="abierto = false" class="flex-1 border border-gray-200 text-gray-500 py-2.5 rounded-lg text-sm hover:bg-gray-50 transition-colors">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

</div>


<div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
    <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
        <h2 class="font-bold text-gray-900">Recursos Recientes</h2>
        <a href="<?php echo e(route('clientes.index')); ?>" class="text-sm text-red-600 font-semibold hover:text-red-700">Ver todos →</a>
    </div>
    <div class="divide-y divide-gray-50">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $recursosRecientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recurso): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
        <div class="px-5 py-3 flex items-center gap-3 hover:bg-gray-50 transition-colors">
            <div class="text-xl"><?php echo e($recurso->icono ?? '📄'); ?></div>
            <div class="flex-1 min-w-0">
                <div class="text-sm font-medium text-gray-900 truncate"><?php echo e($recurso->nombre); ?></div>
                <div class="text-xs text-gray-400 font-mono">
                    <?php echo e($recurso->cliente->nombre ?? 'Global'); ?> · <?php echo e($recurso->tipo); ?> · <?php echo e($recurso->tamanio); ?>

                </div>
            </div>
            <span class="text-xs font-mono font-bold px-2 py-1 rounded
                <?php echo e($recurso->tipo === 'PDF'  ? 'bg-red-50 text-red-600'       : ''); ?>

                <?php echo e($recurso->tipo === 'ISO'  ? 'bg-purple-50 text-purple-600' : ''); ?>

                <?php echo e($recurso->tipo === 'EXE'  ? 'bg-green-50 text-green-600'   : ''); ?>

                <?php echo e($recurso->tipo === 'IMG'  ? 'bg-amber-50 text-amber-600'   : ''); ?>

                <?php echo e($recurso->tipo === 'ZIP'  ? 'bg-blue-50 text-blue-600'     : ''); ?>

                <?php echo e($recurso->tipo === 'LINK' ? 'bg-gray-50 text-gray-600'     : ''); ?>">
                <?php echo e($recurso->tipo); ?>

            </span>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        <div class="px-5 py-8 text-center text-gray-400 text-sm">
            Aún no hay recursos cargados.
            <a href="<?php echo e(route('clientes.index')); ?>" class="text-red-600 font-semibold">Ver clientes →</a>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Projects\techportal\resources\views/dashboard.blade.php ENDPATH**/ ?>