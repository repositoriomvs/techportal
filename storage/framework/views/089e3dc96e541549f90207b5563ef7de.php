

<?php $__env->startSection('title', 'Herramientas'); ?>
<?php $__env->startSection('page-title', 'Herramientas'); ?>
<?php $__env->startSection('page-subtitle', 'Software, booteables y utilidades globales'); ?>

<?php $__env->startSection('topbar-actions'); ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if (\Illuminate\Support\Facades\Blade::check('role', 'admin')): ?>
    <button onclick="document.getElementById('modal-nueva').classList.remove('hidden')"
            class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors">
        + Nueva Herramienta
    </button>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($categorias->isEmpty()): ?>
    <div class="bg-white border border-gray-200 rounded-xl p-16 text-center shadow-sm">
        <div class="text-5xl mb-4">🔧</div>
        <div class="text-gray-500 font-medium">No hay herramientas cargadas aún.</div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if (\Illuminate\Support\Facades\Blade::check('role', 'admin')): ?>
        <button onclick="document.getElementById('modal-nueva').classList.remove('hidden')"
                class="mt-4 inline-block bg-red-600 text-white text-sm font-semibold px-4 py-2 rounded-lg hover:bg-red-700 transition-colors">
            + Agregar primera herramienta
        </button>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
<?php else: ?>
    <div class="flex flex-col gap-6">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">

            
            <div class="px-5 py-3.5 border-b border-gray-100 flex items-center justify-between bg-gray-50">
                <div class="flex items-center gap-2">
                    <span class="text-base">📁</span>
                    <h2 class="font-bold text-gray-800 uppercase tracking-wide text-sm"><?php echo e($categoria); ?></h2>
                    <span class="text-xs font-mono text-gray-400 bg-gray-100 px-2 py-0.5 rounded-full">
                        <?php echo e($items->count()); ?>

                    </span>
                </div>
            </div>

            
            <div class="divide-y divide-gray-50">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $herramienta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <div class="px-5 py-3.5 flex items-center gap-4 hover:bg-gray-50 transition-colors group">

                    
                    <div class="text-2xl flex-shrink-0"><?php echo e($herramienta->icono); ?></div>

                    
                    <div class="flex-1 min-w-0">
                        <div class="text-sm font-semibold text-gray-900"><?php echo e($herramienta->nombre); ?></div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($herramienta->descripcion): ?>
                        <div class="text-xs text-gray-400 mt-0.5 truncate"><?php echo e($herramienta->descripcion); ?></div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <div class="flex items-center gap-3 mt-1 flex-wrap">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($herramienta->version): ?>
                            <span class="text-xs font-mono text-gray-400">v<?php echo e($herramienta->version); ?></span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($herramienta->tamanio): ?>
                            <span class="text-xs font-mono text-gray-400"><?php echo e($herramienta->tamanio); ?></span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <span class="text-xs font-mono font-bold px-2 py-0.5 rounded
                                <?php echo e($herramienta->tipo === 'ISO'  ? 'bg-purple-50 text-purple-600' : ''); ?>

                                <?php echo e($herramienta->tipo === 'EXE'  ? 'bg-green-50 text-green-600'   : ''); ?>

                                <?php echo e($herramienta->tipo === 'LINK' ? 'bg-blue-50 text-blue-600'     : ''); ?>

                                <?php echo e($herramienta->tipo === 'ZIP'  ? 'bg-amber-50 text-amber-600'   : ''); ?>

                                <?php echo e($herramienta->tipo === 'PDF'  ? 'bg-red-50 text-red-600'       : ''); ?>">
                                <?php echo e($herramienta->tipo); ?>

                            </span>
                        </div>
                    </div>

                    
                    <div class="flex items-center gap-2 flex-shrink-0">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($herramienta->tipo === 'LINK' && $herramienta->url): ?>
                            <a href="<?php echo e($herramienta->url); ?>" target="_blank"
                               class="text-xs border border-gray-200 px-3 py-1.5 rounded-lg hover:bg-gray-100 transition-colors font-medium text-gray-600">
                                🔗 Abrir
                            </a>
                        <?php elseif($herramienta->archivo): ?>
                            <a href="<?php echo e(route('herramientas.descargar', $herramienta)); ?>"
                               class="text-xs border border-gray-200 px-3 py-1.5 rounded-lg hover:bg-gray-100 transition-colors font-medium text-gray-600">
                                ⬇ Descargar
                            </a>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if (\Illuminate\Support\Facades\Blade::check('role', 'admin')): ?>
                        <button onclick="abrirEditar(<?php echo e($herramienta->id); ?>, <?php echo e($herramienta->toJson()); ?>)"
                                class="text-xs border border-gray-200 px-3 py-1.5 rounded-lg hover:bg-gray-100 transition-colors text-gray-500">
                            ✏️
                        </button>
                        <form method="POST" action="<?php echo e(route('herramientas.destroy', $herramienta)); ?>"
                              onsubmit="return confirm('¿Eliminar <?php echo e($herramienta->nombre); ?>?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit"
                                    class="text-xs border border-red-100 px-3 py-1.5 rounded-lg hover:bg-red-50 transition-colors text-red-400">
                                🗑️
                            </button>
                        </form>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
    </div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if (\Illuminate\Support\Facades\Blade::check('role', 'admin')): ?>
<div id="modal-nueva"
     class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40"
     onclick="if(event.target===this) this.classList.add('hidden')">
    <div class="bg-white rounded-xl shadow-xl p-6 w-full max-w-lg mx-4">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-bold text-gray-900">🔧 Nueva Herramienta</h3>
            <button onclick="document.getElementById('modal-nueva').classList.add('hidden')"
                    class="text-gray-400 hover:text-gray-600 text-lg leading-none">✕</button>
        </div>

        <form method="POST" action="<?php echo e(route('herramientas.store')); ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="flex flex-col gap-3">

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-mono text-gray-500 uppercase tracking-wide mb-1">Nombre *</label>
                        <input type="text" name="nombre" required
                               placeholder="Ej: Rufus"
                               class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-400">
                    </div>
                    <div>
                        <label class="block text-xs font-mono text-gray-500 uppercase tracking-wide mb-1">Versión</label>
                        <input type="text" name="version"
                               placeholder="Ej: 4.5.2"
                               class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-400">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-mono text-gray-500 uppercase tracking-wide mb-1">Categoría *</label>
                        <input type="text" name="categoria" required
                               list="categorias-list"
                               placeholder="Ej: Diagnóstico"
                               class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-400">
                        <datalist id="categorias-list">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $categorias->keys(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <option value="<?php echo e($cat); ?>">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </datalist>
                    </div>
                    <div>
                        <label class="block text-xs font-mono text-gray-500 uppercase tracking-wide mb-1">Tipo *</label>
                        <select name="tipo" id="tipo-select" onchange="toggleCampos()"
                                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-400">
                            <option value="EXE">📦 EXE — Software</option>
                            <option value="ISO">💿 ISO — Booteable</option>
                            <option value="ZIP">🗜️ ZIP — Comprimido</option>
                            <option value="PDF">📄 PDF — Documento</option>
                            <option value="LINK">🔗 LINK — Enlace</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-mono text-gray-500 uppercase tracking-wide mb-1">Descripción</label>
                    <textarea name="descripcion" rows="2"
                              placeholder="Breve descripción de la herramienta..."
                              class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-400 resize-none"></textarea>
                </div>

                
                <div id="campo-archivo">
                    <label class="block text-xs font-mono text-gray-500 uppercase tracking-wide mb-1">Archivo</label>
                    <input type="file" name="archivo"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-400">
                </div>

                
                <div id="campo-url" class="hidden">
                    <label class="block text-xs font-mono text-gray-500 uppercase tracking-wide mb-1">URL *</label>
                    <input type="url" name="url"
                           placeholder="https://..."
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-400">
                </div>

            </div>

            <div class="flex gap-2 mt-5">
                <button type="submit"
                        class="flex-1 bg-red-600 text-white font-semibold py-2.5 rounded-lg text-sm hover:bg-red-700 transition-colors">
                    Guardar herramienta
                </button>
                <button type="button"
                        onclick="document.getElementById('modal-nueva').classList.add('hidden')"
                        class="flex-1 border border-gray-200 text-gray-500 py-2.5 rounded-lg text-sm hover:bg-gray-50 transition-colors">
                    Cancelar
                </button>
            </div>
        </form>
    </div>
</div>


<div id="modal-editar"
     class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40"
     onclick="if(event.target===this) this.classList.add('hidden')">
    <div class="bg-white rounded-xl shadow-xl p-6 w-full max-w-lg mx-4">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-bold text-gray-900">✏️ Editar Herramienta</h3>
            <button onclick="document.getElementById('modal-editar').classList.add('hidden')"
                    class="text-gray-400 hover:text-gray-600 text-lg leading-none">✕</button>
        </div>

        <form id="form-editar" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
            <div class="flex flex-col gap-3">

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-mono text-gray-500 uppercase tracking-wide mb-1">Nombre *</label>
                        <input type="text" name="nombre" id="edit-nombre" required
                               class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-400">
                    </div>
                    <div>
                        <label class="block text-xs font-mono text-gray-500 uppercase tracking-wide mb-1">Versión</label>
                        <input type="text" name="version" id="edit-version"
                               class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-400">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-mono text-gray-500 uppercase tracking-wide mb-1">Categoría *</label>
                        <input type="text" name="categoria" id="edit-categoria" required
                               list="categorias-list"
                               class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-400">
                    </div>
                    <div>
                        <label class="block text-xs font-mono text-gray-500 uppercase tracking-wide mb-1">Tipo *</label>
                        <select name="tipo" id="edit-tipo"
                                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-400">
                            <option value="EXE">📦 EXE — Software</option>
                            <option value="ISO">💿 ISO — Booteable</option>
                            <option value="ZIP">🗜️ ZIP — Comprimido</option>
                            <option value="PDF">📄 PDF — Documento</option>
                            <option value="LINK">🔗 LINK — Enlace</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-mono text-gray-500 uppercase tracking-wide mb-1">Descripción</label>
                    <textarea name="descripcion" id="edit-descripcion" rows="2"
                              class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-400 resize-none"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-mono text-gray-500 uppercase tracking-wide mb-1">Reemplazar archivo</label>
                    <input type="file" name="archivo"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm">
                </div>

                <div>
                    <label class="block text-xs font-mono text-gray-500 uppercase tracking-wide mb-1">URL</label>
                    <input type="url" name="url" id="edit-url"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-400">
                </div>

            </div>

            <div class="flex gap-2 mt-5">
                <button type="submit"
                        class="flex-1 bg-red-600 text-white font-semibold py-2.5 rounded-lg text-sm hover:bg-red-700 transition-colors">
                    Guardar cambios
                </button>
                <button type="button"
                        onclick="document.getElementById('modal-editar').classList.add('hidden')"
                        class="flex-1 border border-gray-200 text-gray-500 py-2.5 rounded-lg text-sm hover:bg-gray-50 transition-colors">
                    Cancelar
                </button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function toggleCampos() {
    const tipo = document.getElementById('tipo-select').value;
    document.getElementById('campo-archivo').classList.toggle('hidden', tipo === 'LINK');
    document.getElementById('campo-url').classList.toggle('hidden', tipo !== 'LINK');
}

function abrirEditar(id, data) {
    document.getElementById('form-editar').action = `/herramientas/${id}`;
    document.getElementById('edit-nombre').value      = data.nombre     ?? '';
    document.getElementById('edit-version').value     = data.version    ?? '';
    document.getElementById('edit-categoria').value   = data.categoria  ?? '';
    document.getElementById('edit-tipo').value        = data.tipo       ?? 'EXE';
    document.getElementById('edit-descripcion').value = data.descripcion ?? '';
    document.getElementById('edit-url').value         = data.url        ?? '';
    document.getElementById('modal-editar').classList.remove('hidden');
}
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Projects\techportal\resources\views/herramientas/index.blade.php ENDPATH**/ ?>