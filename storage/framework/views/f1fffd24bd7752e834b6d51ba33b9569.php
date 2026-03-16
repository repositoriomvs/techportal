
<?php $__env->startSection('title', 'Nueva Incidencia'); ?>
<?php $__env->startSection('page-title', 'Nueva Incidencia'); ?>
<?php $__env->startSection('page-subtitle', 'Complete los campos para registrar la incidencia'); ?>

<?php $__env->startSection('topbar-actions'); ?>
<span class="text-xs font-mono text-gray-400 bg-gray-100 px-3 py-1.5 rounded-lg">INC-<?php echo e(now()->year); ?>-XXXX</span>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<form method="POST" action="<?php echo e(route('incidencias.store')); ?>" enctype="multipart/form-data" id="form-incidencia">
<?php echo csrf_field(); ?>


<div class="bg-white border border-gray-200 rounded-xl p-5 mb-4">
    <div class="flex items-center gap-2 mb-4 pb-3 border-b border-gray-100">
        <div class="w-1 h-4 bg-red-600 rounded"></div>
        <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Datos del servicio</span>
    </div>
    <div class="grid grid-cols-4 gap-4">
        <div>
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Fecha</label>
            <input type="text" readonly value="<?php echo e(now()->format('d/m/Y')); ?>"
                class="w-full border border-gray-100 bg-gray-50 rounded-lg px-3 py-2 text-sm text-gray-400 cursor-not-allowed">
        </div>
        <div>
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Hora creación</label>
            <div id="hora-live" class="w-full border border-gray-100 bg-gray-50 rounded-lg px-3 py-2 text-sm text-gray-700 font-mono font-bold"></div>
            <p class="text-xs text-gray-400 mt-1">Se registra al enviar</p>
        </div>
        <div>
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Agente</label>
            <input type="text" readonly value="<?php echo e(auth()->user()->name); ?>"
                class="w-full border border-gray-100 bg-gray-50 rounded-lg px-3 py-2 text-sm text-gray-400 cursor-not-allowed">
        </div>
        <div>
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Canal de ingreso *</label>
            <select name="canal_ingreso" required class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-500">
                <option value="">Seleccionar...</option>
                <option>Teléfono</option>
                <option>Email</option>
                <option>Portal cliente</option>
                <option>Presencial</option>
            </select>
        </div>
    </div>
</div>


<div class="bg-white border border-gray-200 rounded-xl p-5 mb-4">
    <div class="flex items-center gap-2 mb-4 pb-3 border-b border-gray-100">
        <div class="w-1 h-4 bg-red-600 rounded"></div>
        <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Datos del cliente</span>
    </div>

    <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Cliente / Empresa *</label>
            <select name="cliente_id" id="sel-cliente" required
                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-500">
                <option value="">Seleccionar cliente...</option>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $clientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cliente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <option value="<?php echo e($cliente->id); ?>"><?php echo e($cliente->nombre); ?></option>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </select>
        </div>
        <div>
    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Código local *</label>
    <input type="hidden" name="local_id" id="inp-local-id">
    <div class="flex gap-2 relative">
        <div class="flex-1 relative">
            <input type="text" id="campo-codigo"
                placeholder="Seleccione cliente primero"
                disabled
                autocomplete="off"
                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-500 disabled:bg-gray-50 disabled:text-gray-400 disabled:cursor-not-allowed"
                oninput="buscarCodigoInline()">
            <div id="dropdown-codigos" style="display:none;"
                class="absolute top-full left-0 right-0 mt-1 bg-white border border-gray-200 rounded-lg shadow-lg z-40 max-h-48 overflow-y-auto">
            </div>
        </div>
        <button type="button" id="btn-buscar-local" onclick="abrirModal()" disabled
            class="px-3 py-2 bg-gray-200 text-gray-400 text-xs font-bold rounded-lg cursor-not-allowed whitespace-nowrap border border-gray-200">
            Búsqueda avanzada
        </button>
    </div>
</div>
    </div>

    <div class="grid grid-cols-3 gap-4 mb-4">
        <div>
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Dirección</label>
            <input type="text" id="campo-direccion" readonly
                class="w-full border border-gray-100 bg-gray-50 rounded-lg px-3 py-2 text-sm text-gray-400 cursor-not-allowed"
                placeholder="Se completa al seleccionar local">
        </div>
        <div>
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Ciudad</label>
            <input type="text" id="campo-ciudad" readonly
                class="w-full border border-gray-100 bg-gray-50 rounded-lg px-3 py-2 text-sm text-gray-400 cursor-not-allowed"
                placeholder="Se completa al seleccionar local">
        </div>
        <div>
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Región</label>
            <input type="text" id="campo-region" readonly
                class="w-full border border-gray-100 bg-gray-50 rounded-lg px-3 py-2 text-sm text-gray-400 cursor-not-allowed"
                placeholder="Se completa al seleccionar local">
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Nombre quien reporta *</label>
            <input type="text" name="nombre_contacto" required placeholder="Nombre completo"
                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-500">
        </div>
        <div>
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Teléfono quien reporta *</label>
            <input type="text" name="telefono_contacto" required placeholder="+56 9 XXXX XXXX"
                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-500">
        </div>
    </div>

    <div id="sla-info" style="display:none;" class="grid grid-cols-2 gap-3 mt-4">
        <div class="bg-gray-50 border border-gray-100 rounded-lg p-3">
            <div class="text-xs text-gray-400 uppercase tracking-wide mb-1">SLA Respuesta</div>
            <div id="sla-resp" class="text-sm font-bold text-gray-700">—</div>
        </div>
        <div class="bg-gray-50 border border-gray-100 rounded-lg p-3">
            <div class="text-xs text-gray-400 uppercase tracking-wide mb-1">SLA Resolución</div>
            <div id="sla-res" class="text-sm font-bold text-gray-700">—</div>
        </div>
    </div>
</div>


<div class="bg-white border border-gray-200 rounded-xl p-5 mb-4">
    <div class="flex items-center gap-2 mb-4 pb-3 border-b border-gray-100">
        <div class="w-1 h-4 bg-red-600 rounded"></div>
        <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Datos del equipo</span>
    </div>
    <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Categoría *</label>
            <select name="categoria_equipo" id="sel-cat" required onchange="updateTipos()"
                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-500">
                <option value="">Seleccionar...</option>
                <option value="computador">Computador</option>
                <option value="impresora">Impresora</option>
                <option value="pos">POS</option>
                <option value="periferico">Periférico</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Tipo *</label>
            <select name="tipo_equipo" id="sel-tipo" required
                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-500">
                <option value="">Seleccione categoría primero...</option>
            </select>
        </div>
    </div>
    <div class="grid grid-cols-3 gap-4 mb-4">
        <div>
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Marca</label>
            <input type="text" name="marca_equipo" placeholder="Ej: HP"
                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-500">
        </div>
        <div>
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Modelo</label>
            <input type="text" name="modelo_equipo" placeholder="Ej: LaserJet Pro"
                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-500">
        </div>
        <div>
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">N° Serie</label>
            <div class="flex gap-2">
                <input type="text" name="serie_equipo" id="inp-serie" placeholder="Número de serie"
                    class="flex-1 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-500">
                <button type="button" onclick="generarSerie()"
                    class="px-3 py-2 bg-gray-100 border border-gray-200 rounded-lg text-xs font-bold text-gray-600 hover:bg-amber-50 hover:border-amber-300 hover:text-amber-700 whitespace-nowrap">
                    No sé la serie
                </button>
            </div>
            <input type="hidden" name="serie_temporal" id="inp-serie-temporal" value="0">
            <p id="serie-aviso" class="hidden text-xs text-amber-600 font-mono mt-1 bg-amber-50 px-2 py-1 rounded">
                Serie temporal — el técnico debe confirmar en terreno
            </p>
        </div>
    </div>
    <div>
        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Ubicación dentro del local</label>
        <input type="text" name="ubicacion_equipo" placeholder="Ej: Caja 3, sala servidores, mesón de atención..."
            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-500">
    </div>
</div>


<div class="bg-white border border-gray-200 rounded-xl p-5 mb-4">
    <div class="flex items-center gap-2 mb-4 pb-3 border-b border-gray-100">
        <div class="w-1 h-4 bg-red-600 rounded"></div>
        <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Incidencia reportada</span>
    </div>
    <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Tipo de ticket *</label>
            <select name="tipo_ticket" required
                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-500">
                <option value="">Seleccionar...</option>
                <option value="incidencia_hardware">Incidencia — Hardware</option>
                <option value="incidencia_software">Incidencia — Software</option>
                <option value="requerimiento">Requerimiento</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Asunto *</label>
            <input type="text" name="asunto" required placeholder="Ej: Impresora no enciende en caja 3"
                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-500">
        </div>
    </div>
    <div class="mb-4">
        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Comentario de falla *</label>
        <textarea name="descripcion_falla" required rows="4"
            placeholder="Describa el problema: síntomas, cuándo ocurrió, frecuencia, mensajes de error..."
            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-500"></textarea>
    </div>
    <div>
        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Adjuntar archivo o foto</label>
        <input type="file" name="adjunto" accept=".png,.jpg,.jpeg,.pdf"
            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm">
        <p class="text-xs text-gray-400 mt-1">PNG, JPG, PDF hasta 5MB</p>
    </div>
</div>


<div class="bg-white border border-gray-200 rounded-xl p-5 mb-6">
    <div class="flex items-center gap-2 mb-4 pb-3 border-b border-gray-100">
        <div class="w-1 h-4 bg-red-600 rounded"></div>
        <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Asignación y prioridad</span>
    </div>
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Prioridad *</label>
            <select name="prioridad" id="sel-prioridad" required onchange="updatePrioridad()"
                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-500">
                <option value="">Seleccionar...</option>
                <option value="alta">Alta</option>
                <option value="media" selected>Media</option>
                <option value="baja">Baja</option>
            </select>
            <span id="badge-prioridad" class="inline-block mt-1 px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800">Media</span>
        </div>
        <div>
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Técnico asignado</label>
            <select name="tecnico_id"
                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-500">
                <option value="">Sin asignar — queda en Abierto</option>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $tecnicos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tecnico): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <option value="<?php echo e($tecnico->id); ?>"><?php echo e($tecnico->name); ?></option>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </select>
            <p class="text-xs text-gray-400 mt-1">Opcional — puede asignarse después</p>
        </div>
    </div>
</div>

<div class="flex justify-end gap-3">
    <a href="<?php echo e(route('incidencias.index')); ?>"
        class="px-5 py-2 border border-gray-200 rounded-lg text-sm font-bold text-gray-600 hover:bg-gray-50">
        Cancelar
    </a>
    <button type="submit"
        class="px-5 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-bold rounded-lg">
        Guardar incidencia
    </button>
</div>

</form>


<div id="modal-bg" class="hidden fixed inset-0 z-50 flex items-center justify-center" style="background: rgba(0,0,0,0.5);">
    <div class="bg-white rounded-xl w-full max-w-md overflow-hidden">

        <div id="vista-busqueda">
            <div class="bg-gray-900 text-white px-5 py-4 flex items-center justify-between">
                <h3 class="font-bold text-sm">Buscar local</h3>
                <button onclick="cerrarModal()" class="text-gray-400 hover:text-white text-xl leading-none">×</button>
            </div>
            <div class="p-5">
                <div class="flex gap-2 mb-4">
                    <input type="text" id="modal-input" placeholder="Buscar por dirección o código..."
                        oninput="buscarLocal()"
                        class="flex-1 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-500">
                    <button onclick="buscarLocal()"
                        class="px-4 py-2 bg-red-600 text-white text-sm font-bold rounded-lg hover:bg-red-700">
                        Buscar
                    </button>
                </div>
                <div id="local-list" class="max-h-52 overflow-y-auto"></div>
                <button id="btn-nuevo-local" onclick="mostrarFormNuevo()"
                    class="hidden w-full mt-3 py-2 border-2 border-dashed border-gray-200 rounded-lg text-sm font-bold text-gray-500 hover:border-red-400 hover:text-red-600">
                    + No está registrado — agregar nuevo local
                </button>
            </div>
        </div>

        <div id="vista-nuevo" class="hidden">
            <div class="bg-gray-900 text-white px-5 py-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <button onclick="volverBusqueda()" class="text-gray-400 hover:text-white text-sm">← Volver</button>
                    <h3 class="font-bold text-sm">Agregar nuevo local</h3>
                </div>
                <button onclick="cerrarModal()" class="text-gray-400 hover:text-white text-xl leading-none">×</button>
            </div>
            <div class="p-5">
                <div class="grid grid-cols-2 gap-3 mb-3">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Código local</label>
                        <input type="text" id="nf-codigo" placeholder="Opcional"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Dirección *</label>
                        <input type="text" id="nf-dir" placeholder="Av. Principal 123"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-500">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3 mb-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Ciudad *</label>
                        <input type="text" id="nf-ciudad" placeholder="Ciudad"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Región *</label>
                        <select id="nf-region"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-500">
                            <option value="">Seleccionar...</option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['Región Metropolitana','Valparaíso','Biobío','La Araucanía','Los Lagos','Antofagasta','Coquimbo','O\'Higgins','Maule','Ñuble','Los Ríos','Arica y Parinacota','Tarapacá','Atacama','Aysén','Magallanes']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <option><?php echo e($r); ?></option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </select>
                    </div>
                </div>
                <div class="flex justify-end gap-2 pt-3 border-t border-gray-100">
                    <button onclick="volverBusqueda()"
                        class="px-4 py-2 border border-gray-200 rounded-lg text-sm font-bold text-gray-600">Cancelar</button>
                    <button onclick="guardarNuevoLocal()"
                        class="px-4 py-2 bg-red-600 text-white text-sm font-bold rounded-lg hover:bg-red-700">
                        Guardar y seleccionar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
let clienteId = null;
let localesData = [];

document.getElementById('sel-cliente').addEventListener('change', function() {
    clienteId = this.value;
    const btn = document.getElementById('btn-buscar-local');
    const codigo = document.getElementById('campo-codigo');

    document.getElementById('inp-local-id').value = '';
    document.getElementById('campo-codigo').value = '';
    document.getElementById('campo-direccion').value = '';
    document.getElementById('campo-ciudad').value = '';
    document.getElementById('campo-region').value = '';
    document.getElementById('dropdown-codigos').style.display = 'none';

    if (clienteId) {
        btn.disabled = false;
        btn.className = 'px-3 py-2 bg-gray-800 hover:bg-gray-900 text-white text-xs font-bold rounded-lg cursor-pointer whitespace-nowrap border border-gray-800';
        codigo.disabled = false;
        codigo.placeholder = 'Escriba el código o use búsqueda avanzada...';
        // Cargar locales del cliente
        fetch(`/locales/por-cliente/${clienteId}`)
            .then(r => r.json())
            .then(data => { localesData = data; });
        cargarSLA();
    } else {
        btn.disabled = true;
        btn.className = 'px-3 py-2 bg-gray-200 text-gray-400 text-xs font-bold rounded-lg cursor-not-allowed whitespace-nowrap border border-gray-200';
        codigo.disabled = true;
        codigo.placeholder = 'Seleccione cliente primero';
    }
});

function buscarCodigoInline() {
    const q = document.getElementById('campo-codigo').value.toLowerCase();
    const dropdown = document.getElementById('dropdown-codigos');

    if (q.length < 1) {
        dropdown.style.display = 'none';
        return;
    }

    const filtrados = localesData.filter(l =>
        (l.codigo && l.codigo.toLowerCase().includes(q)) ||
        l.direccion.toLowerCase().includes(q)
    );

    if (!filtrados.length) {
        dropdown.style.display = 'none';
        return;
    }

    dropdown.innerHTML = filtrados.map(l => `
        <div onclick="seleccionarLocal(${l.id},'${l.codigo || ''}','${l.direccion}','${l.ciudad}','${l.region}')"
             class="px-3 py-2 hover:bg-red-50 cursor-pointer border-b border-gray-50 last:border-0">
            <div class="text-xs font-mono font-bold text-gray-700">${l.codigo || 'Sin código'}</div>
            <div class="text-xs text-gray-400">${l.direccion} — ${l.ciudad}</div>
        </div>`).join('');
    dropdown.style.display = 'block';
}

function seleccionarLocal(id, codigo, dir, ciudad, region) {
    document.getElementById('inp-local-id').value = id;
    document.getElementById('campo-codigo').value = codigo || 'Sin código';
    document.getElementById('campo-direccion').value = dir;
    document.getElementById('campo-ciudad').value = ciudad;
    document.getElementById('campo-region').value = region;
    document.getElementById('dropdown-codigos').style.display = 'none';
    cerrarModal();
}

// Cerrar dropdown al hacer click fuera
document.addEventListener('click', function(e) {
    if (!document.getElementById('campo-codigo').contains(e.target)) {
        document.getElementById('dropdown-codigos').style.display = 'none';
    }
});

function seleccionarLocal(id, codigo, dir, ciudad, region) {
    document.getElementById('inp-local-id').value = id;
    document.getElementById('campo-codigo').value = codigo || 'Sin código';
    document.getElementById('campo-direccion').value = dir;
    document.getElementById('campo-ciudad').value = ciudad;
    document.getElementById('campo-region').value = region;
    cerrarModal();
}

function cargarSLA() {
    const prioridad = document.getElementById('sel-prioridad').value || 'media';
    fetch(`/incidencias/sla/${clienteId}/${prioridad}`)
        .then(r => r.json())
        .then(data => {
            if (data) {
                document.getElementById('sla-info').style.display = 'grid';
                document.getElementById('sla-resp').textContent = data.horas_respuesta + ' horas hábiles';
                document.getElementById('sla-res').textContent = data.horas_resolucion + ' horas hábiles';
            }
        }).catch(() => {});
}

function abrirModal() {
    if (!clienteId) return;
    document.getElementById('modal-bg').classList.remove('hidden');
    document.getElementById('modal-input').value = '';
    document.getElementById('btn-nuevo-local').classList.add('hidden');
    mostrarVistaBusqueda();
    fetch(`/locales/por-cliente/${clienteId}`)
        .then(r => r.json())
        .then(data => { localesData = data; renderLocales(data); });
}

function cerrarModal() {
    document.getElementById('modal-bg').classList.add('hidden');
}

function mostrarVistaBusqueda() {
    document.getElementById('vista-busqueda').classList.remove('hidden');
    document.getElementById('vista-nuevo').classList.add('hidden');
}

function mostrarFormNuevo() {
    document.getElementById('vista-busqueda').classList.add('hidden');
    document.getElementById('vista-nuevo').classList.remove('hidden');
    document.getElementById('nf-codigo').value = '';
    document.getElementById('nf-dir').value = '';
    document.getElementById('nf-ciudad').value = '';
    document.getElementById('nf-region').value = '';
}

function volverBusqueda() {
    mostrarVistaBusqueda();
}

function buscarLocal() {
    const q = document.getElementById('modal-input').value.toLowerCase();
    const filtrados = localesData.filter(l =>
        l.direccion.toLowerCase().includes(q) ||
        (l.codigo && l.codigo.toLowerCase().includes(q)) ||
        l.ciudad.toLowerCase().includes(q)
    );
    renderLocales(filtrados);
    document.getElementById('btn-nuevo-local').classList.toggle('hidden', q.length < 2);
}

function renderLocales(lista) {
    const el = document.getElementById('local-list');
    if (!lista.length) {
        el.innerHTML = '<div class="text-center text-gray-400 text-sm py-4">No se encontraron locales</div>';
        return;
    }
    el.innerHTML = lista.map(l => `
        <div onclick="seleccionarLocal(${l.id},'${l.codigo || ''}','${l.direccion}','${l.ciudad}','${l.region}')"
             class="p-3 border border-gray-100 rounded-lg mb-2 cursor-pointer hover:bg-red-50 hover:border-red-200">
            <div class="text-xs font-mono text-gray-400">${l.codigo || 'Sin código'}</div>
            <div class="text-sm font-bold text-gray-800 mt-0.5">${l.direccion}</div>
            <div class="text-xs text-gray-500">${l.ciudad} — ${l.region}</div>
        </div>`).join('');
}

function seleccionarLocal(id, codigo, dir, ciudad, region) {
    document.getElementById('inp-local-id').value = id;
    document.getElementById('campo-codigo').value = codigo || 'Sin código';
    document.getElementById('campo-direccion').value = dir;
    document.getElementById('campo-ciudad').value = ciudad;
    document.getElementById('campo-region').value = region;
    document.getElementById('dropdown-codigos').style.display = 'none';
    
    // Asegurarse que el botón NO cambia
    const btn = document.getElementById('btn-buscar-local');
    btn.textContent = 'Búsqueda avanzada';
    
    cerrarModal();
}

function guardarNuevoLocal() {
    const dir    = document.getElementById('nf-dir').value.trim();
    const ciudad = document.getElementById('nf-ciudad').value.trim();
    const region = document.getElementById('nf-region').value;
    const codigo = document.getElementById('nf-codigo').value.trim();

    if (!dir)       { alert('Ingresa la dirección'); return; }
    if (!ciudad)    { alert('Ingresa la ciudad'); return; }
    if (!region)    { alert('Selecciona la región'); return; }
    if (!clienteId) { alert('No hay cliente seleccionado'); return; }

    const token = document.querySelector('meta[name="csrf-token"]');
    if (!token) { alert('Error: CSRF token no encontrado'); return; }

    fetch('/locales', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token.content,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            cliente_id: clienteId,
            codigo: codigo || null,
            direccion: dir,
            ciudad: ciudad,
            region: region
        })
    })
    .then(r => {
        if (!r.ok) return r.json().then(err => { throw new Error(JSON.stringify(err)); });
        return r.json();
    })
    .then(local => {
        seleccionarLocal(local.id, local.codigo, local.direccion, local.ciudad, local.region);
    })
    .catch(err => {
        console.error('Error:', err);
        alert('Error al guardar: ' + err.message);
    });
}

const tipos = {
    computador: ['AIO','Desktop','Notebook'],
    impresora:  ['Sin ADF','Con ADF','Térmica'],
    pos:        ['Caja','Self Checkout'],
    periferico: ['Monitor','Escáner','Otro']
};

function updateTipos() {
    const cat = document.getElementById('sel-cat').value;
    const sel = document.getElementById('sel-tipo');
    sel.innerHTML = '<option value="">Seleccionar tipo...</option>';
    if (tipos[cat]) tipos[cat].forEach(t => {
        const o = document.createElement('option');
        o.value = t; o.textContent = t;
        sel.appendChild(o);
    });
}

function generarSerie() {
    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    let s = 'TMP-';
    for (let i = 0; i < 8; i++) s += chars[Math.floor(Math.random() * chars.length)];
    document.getElementById('inp-serie').value = s;
    document.getElementById('inp-serie').classList.add('border-amber-300','bg-amber-50');
    document.getElementById('inp-serie-temporal').value = '1';
    document.getElementById('serie-aviso').classList.remove('hidden');
}

const prioColors = {
    alta:  'bg-red-100 text-red-800',
    media: 'bg-amber-100 text-amber-800',
    baja:  'bg-green-100 text-green-800'
};
const prioLabels = { alta: 'Alta', media: 'Media', baja: 'Baja' };

function updatePrioridad() {
    const val = document.getElementById('sel-prioridad').value;
    const b = document.getElementById('badge-prioridad');
    b.className = 'inline-block mt-1 px-3 py-1 rounded-full text-xs font-bold ' + (prioColors[val] || '');
    b.textContent = prioLabels[val] || '';
    if (clienteId) cargarSLA();
}

function updateClock() {
    const now = new Date();
    document.getElementById('hora-live').textContent =
        now.getHours().toString().padStart(2,'0') + ':' +
        now.getMinutes().toString().padStart(2,'0') + ':' +
        now.getSeconds().toString().padStart(2,'0');
}
updateClock();
setInterval(updateClock, 1000);
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Projects\techportal\resources\views/incidencias/create.blade.php ENDPATH**/ ?>