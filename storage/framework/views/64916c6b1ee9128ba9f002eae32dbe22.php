
 
<?php $__env->startSection('title', 'Hardware'); ?>
<?php $__env->startSection('page-title', 'Hardware'); ?>
<?php $__env->startSection('page-subtitle', 'Repositorio de manuales, firmware y recursos técnicos'); ?>
 
<?php $__env->startSection('topbar-actions'); ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if (\Illuminate\Support\Facades\Blade::check('role', 'admin')): ?>
    <button x-data @click="$dispatch('abrir-modal-tipo')"
            class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors">
        + Nuevo Tipo
    </button>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php $__env->stopSection(); ?>
 
<?php $__env->startSection('content'); ?>
 

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
<div class="mb-4 bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-xl">
    ✅ <?php echo e(session('success')); ?>

</div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
 

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if (\Illuminate\Support\Facades\Blade::check('role', 'admin')): ?>
<div x-data="{ abierto: false }"
     @abrir-modal-tipo.window="abierto = true"
     x-show="abierto"
     class="fixed inset-0 z-50 flex items-center justify-center bg-black/40"
     x-cloak>
    <div class="bg-white rounded-xl shadow-xl p-6 w-full max-w-sm mx-4" @click.outside="abierto = false">
        <h3 class="font-bold text-gray-900 mb-4">Nuevo Tipo de Hardware</h3>
        <form method="POST" action="<?php echo e(route('hardware.tipos.store')); ?>">
            <?php echo csrf_field(); ?>
            <div class="flex flex-col gap-3">
                <div>
                    <label class="block text-xs font-mono text-gray-500 uppercase mb-1">Nombre *</label>
                    <input type="text" name="nombre" required placeholder="Ej: Computador"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-400">
                </div>
                <div>
                    <label class="block text-xs font-mono text-gray-500 uppercase mb-1">Icono (emoji)</label>
                    <input type="text" name="icono" placeholder="🖥️"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-400">
                </div>
            </div>
            <div class="flex gap-2 mt-4">
                <button type="submit" class="flex-1 bg-red-600 text-white font-semibold py-2 rounded-lg text-sm hover:bg-red-700">Crear</button>
                <button type="button" @click="abierto = false" class="flex-1 border border-gray-200 text-gray-500 py-2 rounded-lg text-sm hover:bg-gray-50">Cancelar</button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
 

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tipos->isEmpty()): ?>
<div class="bg-white border border-gray-200 rounded-xl p-16 text-center">
    <div class="text-5xl mb-4">🖥️</div>
    <div class="text-gray-500 text-sm">No hay tipos de hardware registrados.</div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if (\Illuminate\Support\Facades\Blade::check('role', 'admin')): ?>
    <button x-data @click="$dispatch('abrir-modal-tipo')"
            class="inline-block mt-4 bg-red-600 text-white text-sm font-semibold px-6 py-2 rounded-lg hover:bg-red-700">
        + Crear primer tipo
    </button>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
 

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $tipos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
<div class="mb-6" x-data="{ expandido: true }">
 
    
    <div class="flex items-center gap-3 mb-3">
        <button @click="expandido = !expandido"
                class="flex items-center gap-3 flex-1 bg-gray-900 text-white rounded-xl px-5 py-3 hover:bg-gray-800 transition-colors text-left">
            <span class="text-xl"><?php echo e($tipo->icono ?? '🖥️'); ?></span>
            <span class="font-bold text-base"><?php echo e($tipo->nombre); ?></span>
            <span class="text-xs text-gray-400 font-mono ml-1"><?php echo e($tipo->marcas->count()); ?> marcas</span>
            <span class="ml-auto text-gray-400 text-sm" x-text="expandido ? '▲' : '▼'"></span>
        </button>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if (\Illuminate\Support\Facades\Blade::check('role', 'admin')): ?>
        <form method="POST" action="<?php echo e(route('hardware.tipos.destroy', $tipo)); ?>"
              onsubmit="return confirm('¿Eliminar tipo <?php echo e($tipo->nombre); ?> y todo su contenido?')">
            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
            <button class="text-xs text-red-400 border border-red-100 rounded-lg px-3 py-3 hover:text-red-600 hover:bg-red-50 transition-colors">
                🗑️
            </button>
        </form>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
 
    <div x-show="expandido" x-transition class="pl-4">
 
        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $tipo->marcas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $marca): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
        <div class="mb-4" x-data="{ expandidoMarca: true }">
 
            
            <div class="flex items-center gap-3 mb-2">
                <button @click="expandidoMarca = !expandidoMarca"
                        class="flex items-center gap-3 flex-1 bg-white border border-gray-200 rounded-xl px-4 py-2.5 hover:bg-gray-50 transition-colors text-left shadow-sm">
                    <span class="text-lg"><?php echo e($marca->icono ?? '🏭'); ?></span>
                    <span class="font-semibold text-gray-900"><?php echo e($marca->nombre); ?></span>
                    <span class="text-xs text-gray-400 font-mono"><?php echo e($marca->modelos->count()); ?> modelos</span>
                    <span class="ml-auto text-gray-400 text-sm" x-text="expandidoMarca ? '▲' : '▼'"></span>
                </button>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if (\Illuminate\Support\Facades\Blade::check('role', 'admin')): ?>
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open"
                            class="text-xs border border-gray-200 rounded-lg px-3 py-2.5 text-gray-500 hover:bg-gray-50 transition-colors block">
                        + Modelo
                    </button>
                    <div x-show="open" @click.outside="open = false"
                         class="absolute right-0 top-full mt-1 bg-white border border-gray-200 rounded-xl shadow-xl p-4 w-72 z-20">
                        <form method="POST" action="<?php echo e(route('hardware.modelos.store')); ?>">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="hardware_marca_id" value="<?php echo e($marca->id); ?>">
                            <div class="flex flex-col gap-2">
                                <input type="text" name="nombre" required placeholder="Nombre del modelo *"
                                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-400">
                                <input type="text" name="numero_parte" placeholder="Número de parte"
                                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-400">
                                <textarea name="descripcion" rows="2" placeholder="Descripción (opcional)"
                                          class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-400 resize-none"></textarea>
                                <button type="submit" class="w-full bg-red-600 text-white font-semibold py-2 rounded-lg text-sm hover:bg-red-700">
                                    Crear Modelo
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <form method="POST" action="<?php echo e(route('hardware.marcas.destroy', $marca)); ?>"
                      onsubmit="return confirm('¿Eliminar marca <?php echo e($marca->nombre); ?>?')">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button class="text-xs text-red-400 border border-red-100 rounded-lg px-3 py-2.5 hover:text-red-600 hover:bg-red-50 transition-colors">
                        🗑️
                    </button>
                </form>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
 
            <div x-show="expandidoMarca" x-transition class="pl-4">
 
                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $marca->modelos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $modelo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <div class="mb-3" x-data="{ expandidoModelo: false }">
 
                    
                    <div class="flex items-center gap-2 mb-2">
                        <button @click="expandidoModelo = !expandidoModelo"
                                class="flex items-center gap-3 flex-1 bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 hover:bg-gray-100 transition-colors text-left">
                            <span class="text-base">🖥️</span>
                            <span class="font-medium text-gray-900 text-sm"><?php echo e($modelo->nombre); ?></span>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($modelo->numero_parte): ?>
                            <span class="text-xs text-gray-400 font-mono"><?php echo e($modelo->numero_parte); ?></span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <span class="text-xs bg-red-50 text-red-600 font-mono px-2 py-0.5 rounded-full">
                                <?php echo e($modelo->recursos->count()); ?> recursos
                            </span>
                            <span class="ml-auto text-gray-400 text-xs" x-text="expandidoModelo ? '▲' : '▼'"></span>
                        </button>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if (\Illuminate\Support\Facades\Blade::check('role', 'admin')): ?>
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open"
                                    class="text-xs border border-gray-200 rounded-lg px-3 py-2.5 text-gray-500 hover:bg-gray-50 transition-colors block">
                                ↑ Recurso
                            </button>
                            <div x-show="open" @click.outside="open = false"
                                 class="absolute right-0 top-full mt-1 bg-white border border-gray-200 rounded-xl shadow-xl p-4 w-80 z-20">
                                <div class="font-semibold text-gray-900 text-sm mb-3">Subir recurso para <?php echo e($modelo->nombre); ?></div>
                                <form method="POST"
                                      action="<?php echo e(route('hardware.recursos.store', $modelo)); ?>"
                                      enctype="multipart/form-data">
                                    <?php echo csrf_field(); ?>
                                    <div class="flex flex-col gap-2">
                                        <input type="text" name="nombre" required placeholder="Nombre del recurso *"
                                               class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-400">
                                        <select name="categoria" required
                                                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-400">
                                            <option value="">Categoría *</option>
                                            <option value="manual_tecnico">📄 Manual Técnico</option>
                                            <option value="list_part">🔩 List Part</option>
                                            <option value="firmware">💾 Firmware</option>
                                            <option value="procedimiento">📋 Procedimiento</option>
                                        </select>
                                        <select name="tipo" required
                                                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-400">
                                            <option value="">Tipo de archivo *</option>
                                            <option value="PDF">PDF</option>
                                            <option value="ISO">ISO</option>
                                            <option value="EXE">EXE</option>
                                            <option value="ZIP">ZIP</option>
                                            <option value="LINK">LINK</option>
                                        </select>
                                        <input type="text" name="version" placeholder="Versión"
                                               class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-400">
                                        <input type="url" name="url" placeholder="URL externa (opcional)"
                                               class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-400">
                                        <label class="border-2 border-dashed border-gray-200 rounded-lg p-3 text-center cursor-pointer hover:border-red-300 transition-colors">
                                            <div class="text-xs text-gray-500">📁 Seleccionar archivo</div>
                                            <input type="file" name="archivo" class="hidden"
                                                   onchange="this.previousElementSibling.textContent = this.files[0]?.name ?? '📁 Seleccionar archivo'">
                                        </label>
                                        <button type="submit" class="w-full bg-red-600 text-white font-semibold py-2 rounded-lg text-sm hover:bg-red-700">
                                            ↑ Subir
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <form method="POST" action="<?php echo e(route('hardware.modelos.destroy', $modelo)); ?>"
                              onsubmit="return confirm('¿Eliminar modelo <?php echo e($modelo->nombre); ?>?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button class="text-xs text-red-400 border border-red-100 rounded-lg px-3 py-2.5 hover:text-red-600 hover:bg-red-50 transition-colors">
                                🗑️
                            </button>
                        </form>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
 
                    
                    <div x-show="expandidoModelo" x-transition class="pl-4">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($modelo->recursos->isEmpty()): ?>
                            <div class="text-xs text-gray-400 font-mono px-4 py-3 bg-gray-50 rounded-xl">
                                Sin recursos cargados.
                            </div>
                        <?php else: ?>
                        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                            <table class="w-full">
                                <thead>
                                    <tr class="bg-gray-50 border-b border-gray-100">
                                        <th class="text-left px-4 py-2.5 text-xs font-mono text-gray-400 uppercase">Recurso</th>
                                        <th class="text-left px-4 py-2.5 text-xs font-mono text-gray-400 uppercase hidden sm:table-cell">Categoría</th>
                                        <th class="text-left px-4 py-2.5 text-xs font-mono text-gray-400 uppercase hidden md:table-cell">Versión</th>
                                        <th class="text-right px-4 py-2.5 text-xs font-mono text-gray-400 uppercase">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $modelo->recursos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recurso): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-4 py-2.5">
                                            <div class="flex items-center gap-2">
                                                <span class="text-lg"><?php echo e($recurso->icono ?? '📄'); ?></span>
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900"><?php echo e($recurso->nombre); ?></div>
                                                    <span class="text-xs font-mono font-bold px-1.5 py-0.5 rounded
                                                        <?php echo e($recurso->tipo === 'PDF' ? 'bg-red-50 text-red-600' : ''); ?>

                                                        <?php echo e($recurso->tipo === 'ISO' ? 'bg-purple-50 text-purple-600' : ''); ?>

                                                        <?php echo e($recurso->tipo === 'EXE' ? 'bg-green-50 text-green-600' : ''); ?>

                                                        <?php echo e($recurso->tipo === 'ZIP' ? 'bg-blue-50 text-blue-600' : ''); ?>

                                                        <?php echo e($recurso->tipo === 'LINK' ? 'bg-gray-100 text-gray-600' : ''); ?>">
                                                        <?php echo e($recurso->tipo); ?>

                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-2.5 hidden sm:table-cell">
                                            <span class="text-xs text-gray-500 font-mono">
                                                <?php echo e(match($recurso->categoria) {
                                                    'manual_tecnico' => '📄 Manual Técnico',
                                                    'list_part'      => '🔩 List Part',
                                                    'firmware'       => '💾 Firmware',
                                                    'procedimiento'  => '📋 Procedimiento',
                                                    default          => $recurso->categoria
                                                }); ?>

                                            </span>
                                        </td>
                                        <td class="px-4 py-2.5 hidden md:table-cell">
                                            <span class="text-xs text-gray-400 font-mono"><?php echo e($recurso->version ?? '—'); ?></span>
                                        </td>
                                        <td class="px-4 py-2.5">
                                            <div class="flex items-center justify-end gap-1.5">
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($recurso->tipo === 'PDF'): ?>
                                                <a href="<?php echo e(route('hardware.recursos.ver', $recurso)); ?>"
                                                   class="text-xs bg-red-50 text-red-600 border border-red-100 rounded px-2 py-1 hover:bg-red-600 hover:text-white transition-colors font-semibold">
                                                    📖 Leer
                                                </a>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($recurso->archivo || $recurso->url): ?>
                                                <a href="<?php echo e($recurso->url ?? route('hardware.recursos.descargar', $recurso)); ?>"
                                                   class="text-xs bg-gray-50 text-gray-600 border border-gray-200 rounded px-2 py-1 hover:bg-gray-600 hover:text-white transition-colors"
                                                   <?php echo e($recurso->url ? 'target=_blank' : ''); ?>>
                                                    ⬇ Bajar
                                                </a>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if (\Illuminate\Support\Facades\Blade::check('role', 'admin')): ?>
                                                <a href="<?php echo e(route('hardware.recursos.edit', $recurso)); ?>"
                                                   class="text-xs text-gray-400 border border-gray-200 rounded px-2 py-1 hover:text-gray-600 transition-colors">
                                                    ✏️
                                                </a>
                                                <form method="POST" action="<?php echo e(route('hardware.recursos.destroy', $recurso)); ?>"
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
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
 
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
 
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if (\Illuminate\Support\Facades\Blade::check('role', 'admin')): ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($marca->modelos->isEmpty()): ?>
                <div class="text-xs text-gray-400 font-mono px-2 py-1">Sin modelos aún.</div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
 
            </div>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
 
        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if (\Illuminate\Support\Facades\Blade::check('role', 'admin')): ?>
        <div x-data="{ open: false }" class="mt-2">
            <button @click="open = !open"
                    class="text-xs text-gray-500 border border-dashed border-gray-300 rounded-lg px-4 py-2 hover:border-red-400 hover:text-red-600 transition-colors">
                + Agregar marca a <?php echo e($tipo->nombre); ?>

            </button>
            <div x-show="open" @click.outside="open = false"
                 class="mt-2 bg-white border border-gray-200 rounded-xl shadow-lg p-4 w-72 z-20">
                <form method="POST" action="<?php echo e(route('hardware.marcas.store')); ?>">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="hardware_tipo_id" value="<?php echo e($tipo->id); ?>">
                    <div class="flex flex-col gap-2">
                        <input type="text" name="nombre" required placeholder="Nombre de la marca *"
                               class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-400">
                        <input type="text" name="icono" placeholder="Icono emoji (opcional)"
                               class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-400">
                        <button type="submit" class="w-full bg-red-600 text-white font-semibold py-2 rounded-lg text-sm hover:bg-red-700">
                            Crear Marca
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
 
    </div>
</div>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
 
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Projects\techportal\resources\views/hardware/index.blade.php ENDPATH**/ ?>