
<?php $__env->startSection('title', 'Mis Tickets'); ?>
<?php $__env->startSection('page-title', 'Mis Tickets'); ?>
<?php $__env->startSection('page-subtitle', 'Listado de incidencias'); ?>

<?php $__env->startSection('topbar-actions'); ?>
<a href="<?php echo e(route('incidencias.create')); ?>"
   class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors">
    + Nueva Incidencia
</a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>


<div class="bg-white border border-gray-200 rounded-xl p-4 mb-4">
    <form method="GET" action="<?php echo e(route('incidencias.index')); ?>" class="grid grid-cols-6 gap-3">
        <div>
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Estado</label>
            <select name="estado" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-500">
                <option value="">Todos</option>
                <option value="abierto"           <?php echo e(request('estado') == 'abierto'            ? 'selected' : ''); ?>>Abierto</option>
                <option value="en_gestion"        <?php echo e(request('estado') == 'en_gestion'         ? 'selected' : ''); ?>>En gestión</option>
                <option value="asignado"          <?php echo e(request('estado') == 'asignado'           ? 'selected' : ''); ?>>Asignado</option>
                <option value="pendiente_cliente" <?php echo e(request('estado') == 'pendiente_cliente'  ? 'selected' : ''); ?>>Pendiente cliente</option>
                <option value="cancelado_cliente" <?php echo e(request('estado') == 'cancelado_cliente'  ? 'selected' : ''); ?>>Cancelado</option>
                <option value="cerrado"           <?php echo e(request('estado') == 'cerrado'            ? 'selected' : ''); ?>>Cerrado</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Prioridad</label>
            <select name="prioridad" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-500">
                <option value="">Todas</option>
                <option value="alta"  <?php echo e(request('prioridad') == 'alta'  ? 'selected' : ''); ?>>Alta</option>
                <option value="media" <?php echo e(request('prioridad') == 'media' ? 'selected' : ''); ?>>Media</option>
                <option value="baja"  <?php echo e(request('prioridad') == 'baja'  ? 'selected' : ''); ?>>Baja</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Cliente</label>
            <select name="cliente_id" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-500">
                <option value="">Todos</option>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $clientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <option value="<?php echo e($c->id); ?>" <?php echo e(request('cliente_id') == $c->id ? 'selected' : ''); ?>><?php echo e($c->nombre); ?></option>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </select>
        </div>
        <div>
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Desde</label>
            <input type="date" name="desde" value="<?php echo e(request('desde')); ?>"
                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-500">
        </div>
        <div>
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Hasta</label>
            <input type="date" name="hasta" value="<?php echo e(request('hasta')); ?>"
                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-500">
        </div>
        <div class="flex items-end gap-2">
            <button type="submit"
                class="flex-1 bg-red-600 hover:bg-red-700 text-white text-sm font-bold px-4 py-2 rounded-lg">
                Filtrar
            </button>
            <a href="<?php echo e(route('incidencias.index')); ?>"
                class="px-3 py-2 border border-gray-200 rounded-lg text-sm text-gray-500 hover:bg-gray-50">
                ✕
            </a>
        </div>
    </form>
</div>


<div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="bg-gray-50 border-b border-gray-200">
                <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wide">Ticket</th>
                <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wide">Cliente</th>
                <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wide">Asunto</th>
                <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wide">Prioridad</th>
                <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wide">Estado</th>
                <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wide">Técnico</th>
                <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wide">Creado</th>
                <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wide">SLA</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $incidencias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-4 py-3">
                    <span class="font-mono text-xs font-bold text-gray-700"><?php echo e($inc->numero_ticket); ?></span>
                </td>
                <td class="px-4 py-3">
                    <div class="font-semibold text-gray-800 text-xs"><?php echo e($inc->cliente->nombre); ?></div>
                    <div class="text-xs text-gray-400"><?php echo e($inc->local->codigo ?? '—'); ?></div>
                </td>
                <td class="px-4 py-3">
                    <div class="text-sm text-gray-700 max-w-xs truncate"><?php echo e($inc->asunto); ?></div>
                    <div class="text-xs text-gray-400"><?php echo e($inc->tipo_equipo); ?> — <?php echo e($inc->categoria_equipo); ?></div>
                </td>
                <td class="px-4 py-3">
                    <?php
                        $prio = [
                            'alta'  => 'bg-red-100 text-red-700',
                            'media' => 'bg-amber-100 text-amber-700',
                            'baja'  => 'bg-green-100 text-green-700',
                        ];
                    ?>
                    <span class="px-2 py-1 rounded-full text-xs font-bold <?php echo e($prio[$inc->prioridad] ?? ''); ?>">
                        <?php echo e(ucfirst($inc->prioridad)); ?>

                    </span>
                </td>
                <td class="px-4 py-3">
                    <?php
                        $estados = [
                            'abierto'            => 'bg-blue-100 text-blue-700',
                            'en_gestion'         => 'bg-purple-100 text-purple-700',
                            'asignado'           => 'bg-amber-100 text-amber-700',
                            'pendiente_cliente'  => 'bg-orange-100 text-orange-700',
                            'cancelado_cliente'  => 'bg-gray-100 text-gray-500',
                            'cerrado'            => 'bg-green-100 text-green-700',
                        ];
                        $labels = [
                            'abierto'            => 'Abierto',
                            'en_gestion'         => 'En gestión',
                            'asignado'           => 'Asignado',
                            'pendiente_cliente'  => 'Pend. cliente',
                            'cancelado_cliente'  => 'Cancelado',
                            'cerrado'            => 'Cerrado',
                        ];
                    ?>
                    <span class="px-2 py-1 rounded-full text-xs font-bold <?php echo e($estados[$inc->estado_mesa] ?? 'bg-gray-100 text-gray-500'); ?>">
                        <?php echo e($labels[$inc->estado_mesa] ?? $inc->estado_mesa); ?>

                    </span>
                </td>

<td class="px-4 py-3">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($inc->tecnico): ?>
        <div class="flex items-center gap-2">
            <div class="w-6 h-6 rounded-full bg-red-100 flex items-center justify-center text-red-700 font-bold text-xs flex-shrink-0">
                <?php echo e(strtoupper(substr($inc->tecnico->name, 0, 1))); ?>

            </div>
            <span class="text-xs text-gray-700 font-semibold"><?php echo e($inc->tecnico->name); ?></span>
        </div>
    <?php else: ?>
        <button onclick="abrirModalAsignar(<?php echo e($inc->id); ?>, '<?php echo e(addslashes($inc->numero_ticket)); ?>')"
            class="text-xs text-red-600 hover:text-red-700 font-bold border border-red-200 hover:border-red-400 bg-red-50 hover:bg-red-100 px-2 py-1 rounded-lg transition-colors">
            + Asignar
        </button>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</td>
 

<td class="px-4 py-3">
    <a href="<?php echo e(route('incidencias.show', $inc)); ?>"
        class="inline-flex items-center gap-1 text-xs font-bold text-white bg-red-600 hover:bg-red-700 px-3 py-1.5 rounded-lg transition-colors">
        Ver <span class="text-xs">→</span>
    </a>
</td>
 
                <td class="px-4 py-3 text-xs text-gray-500">
                    <?php echo e($inc->created_at->format('d/m/Y')); ?><br>
                    <span class="text-gray-400"><?php echo e($inc->created_at->format('H:i')); ?></span>
                </td>
                <td class="px-4 py-3">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($inc->fecha_limite_resolucion): ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($inc->closed_at): ?>
                            <span class="text-xs font-bold <?php echo e($inc->slaResolucionCumplido() ? 'text-green-600' : 'text-red-600'); ?>">
                                <?php echo e($inc->slaResolucionCumplido() ? '✓ Cumplido' : '✕ Incumplido'); ?>

                            </span>
                        <?php elseif(now()->gt($inc->fecha_limite_resolucion)): ?>
                            <span class="text-xs font-bold text-red-600">⚠ Vencido</span>
                        <?php else: ?>
                            <span class="text-xs text-amber-600 font-bold">
                                <?php echo e(now()->diffForHumans($inc->fecha_limite_resolucion, true)); ?>

                            </span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php else: ?>
                        <span class="text-xs text-gray-400">Sin SLA</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
                <td class="px-4 py-3">
                    <a href="<?php echo e(route('incidencias.show', $inc)); ?>"
                        class="text-xs font-bold text-red-600 hover:text-red-700">Ver →</a>
                </td>
            </tr>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <tr>
                <td colspan="9" class="px-4 py-12 text-center text-gray-400 text-sm">
                    No hay incidencias que coincidan con los filtros.
                </td>
            </tr>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </tbody>
    </table>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($incidencias->hasPages()): ?>
    <div class="px-4 py-3 border-t border-gray-100">
        <?php echo e($incidencias->appends(request()->query())->links()); ?>

    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>



<div id="modal-asignar-index" class="hidden fixed inset-0 z-50 flex items-center justify-center">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"
         onclick="cerrarModalAsignar()"></div>

    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 p-6">
        <div class="flex items-center justify-between mb-1">
            <h3 class="text-base font-bold text-gray-900">Asignar Técnico</h3>
            <button onclick="cerrarModalAsignar()" class="text-gray-400 hover:text-gray-600 text-xl leading-none">&times;</button>
        </div>
        <p id="modal-ticket-label" class="text-xs text-gray-400 mb-4"></p>

        <div class="mb-3">
            <input type="text" id="buscar-tecnico-index" placeholder="Buscar técnico por nombre..."
                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-500"
                oninput="filtrarTecnicosIndex(this.value)">
        </div>

        <div id="lista-tecnicos-index" class="max-h-56 overflow-y-auto space-y-1 mb-5">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $tecnicos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
            <label class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-gray-50 cursor-pointer border border-transparent has-[:checked]:border-red-200 has-[:checked]:bg-red-50 transition-colors tecnico-index-item"
                   data-nombre="<?php echo e(strtolower($tec->name)); ?>">
                <input type="radio" name="tecnico_index" value="<?php echo e($tec->id); ?>" class="accent-red-600">
                <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center text-red-700 font-bold text-xs flex-shrink-0">
                    <?php echo e(strtoupper(substr($tec->name, 0, 1))); ?>

                </div>
                <div>
                    <div class="text-sm font-semibold text-gray-800"><?php echo e($tec->name); ?></div>
                    <div class="text-xs text-gray-400"><?php echo e($tec->email); ?></div>
                </div>
            </label>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>

        <form method="POST" id="form-asignar-index" action="">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PATCH'); ?>
            <input type="hidden" name="tecnico_id" id="tecnico_id_index_hidden">
            <div class="flex gap-2">
                <button type="button" onclick="cerrarModalAsignar()"
                    class="flex-1 border border-gray-200 text-gray-600 text-sm font-semibold px-4 py-2.5 rounded-lg hover:bg-gray-50 transition-colors">
                    Cancelar
                </button>
                <button type="button" onclick="confirmarAsignacionIndex()"
                    class="flex-1 bg-red-600 hover:bg-red-700 text-white text-sm font-bold px-4 py-2.5 rounded-lg transition-colors">
                    Confirmar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function abrirModalAsignar(id, ticket) {
    document.getElementById('modal-ticket-label').textContent = 'Ticket: ' + ticket;
    document.getElementById('form-asignar-index').action = '/incidencias/' + id + '/asignar';
    // Reset
    document.querySelectorAll('input[name="tecnico_index"]').forEach(r => r.checked = false);
    document.getElementById('buscar-tecnico-index').value = '';
    filtrarTecnicosIndex('');
    document.getElementById('modal-asignar-index').classList.remove('hidden');
}

function cerrarModalAsignar() {
    document.getElementById('modal-asignar-index').classList.add('hidden');
}

function filtrarTecnicosIndex(query) {
    const q = query.toLowerCase().trim();
    document.querySelectorAll('.tecnico-index-item').forEach(item => {
        item.style.display = item.dataset.nombre.includes(q) ? '' : 'none';
    });
}

function confirmarAsignacionIndex() {
    const sel = document.querySelector('input[name="tecnico_index"]:checked');
    if (!sel) { alert('Selecciona un técnico.'); return; }
    document.getElementById('tecnico_id_index_hidden').value = sel.value;
    document.getElementById('form-asignar-index').submit();
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Projects\techportal\resources\views/incidencias/index.blade.php ENDPATH**/ ?>