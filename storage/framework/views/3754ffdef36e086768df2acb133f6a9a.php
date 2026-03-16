

<?php $__env->startSection('title', 'Nueva Orden de Mantención'); ?>
<?php $__env->startSection('page-title', 'Nueva Orden de Mantención'); ?>
<?php $__env->startSection('page-subtitle', 'Mantención preventiva · Todos los campos son obligatorios'); ?>

<?php $__env->startSection('topbar-actions'); ?>
    <a href="<?php echo e(route('mantencion.index')); ?>"
       class="text-sm text-gray-500 hover:text-gray-700 border border-gray-200 px-4 py-2 rounded-lg transition-colors">
        ← Volver
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<form id="formChecklist" method="POST" action="<?php echo e(route('mantencion.store')); ?>" enctype="multipart/form-data">
<?php echo csrf_field(); ?>


<div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden mb-5">
    <div class="px-5 py-3 border-b border-gray-100 bg-gray-50 flex items-center gap-2">
        <span>📋</span>
        <span class="font-bold text-gray-900 text-sm">1. Datos del Servicio</span>
    </div>
    <div class="p-5 grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div>
            <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">Fecha <span class="text-red-500">*</span></label>
            <input type="text" name="fecha" id="fechaHoy" readonly
                class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm bg-gray-50 text-gray-500 cursor-not-allowed select-none focus:outline-none">
        </div>
        <div>
            <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">Hora inicio <span class="text-red-500">*</span></label>
            <input type="time" name="hora_inicio" required
                class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all">
        </div>
        <div>
            <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">Hora término</label>
            <input type="text" readonly
                class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm bg-gray-50 text-gray-400 cursor-not-allowed select-none focus:outline-none"
                placeholder="Se registra al enviar">
        </div>
    </div>
</div>


<div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden mb-5">
    <div class="px-5 py-3 border-b border-gray-100 bg-gray-50 flex items-center gap-2">
        <span>🏢</span>
        <span class="font-bold text-gray-900 text-sm">2. Datos del Cliente</span>
    </div>
    <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="sm:col-span-2">
            <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">Cliente <span class="text-red-500">*</span></label>
            <select name="cliente_id" required
                class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all">
                <option value="">— Seleccionar cliente —</option>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $clientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cliente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                    <option value="<?php echo e($cliente->id); ?>"><?php echo e($cliente->nombre); ?></option>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </select>
        </div>
        <div>
            <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">Código local <span class="text-red-500">*</span></label>
            <input type="text" name="codigo_local" required placeholder="Ej: LOC-001"
                class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all">
        </div>
        <div>
            <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">Ciudad <span class="text-red-500">*</span></label>
            <input type="text" name="ciudad" required placeholder="Ej: Santiago"
                class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all">
        </div>
        <div class="sm:col-span-2">
            <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">Dirección <span class="text-red-500">*</span></label>
            <input type="text" name="direccion" required placeholder="Ej: Av. Providencia 1234"
                class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all">
        </div>
    </div>
</div>


<div id="equiposContainer"></div>

<button type="button" onclick="agregarEquipo()"
    class="w-full mb-5 border-2 border-dashed border-gray-300 hover:border-red-400 text-gray-400 hover:text-red-500 rounded-xl py-4 text-sm font-semibold transition-all flex items-center justify-center gap-2">
    <span class="text-xl">＋</span> Agregar otro equipo
</button>


<div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden mb-5">
    <div class="px-5 py-3 border-b border-gray-100 bg-gray-50 flex items-center gap-2">
        <span>✍️</span>
        <span class="font-bold text-gray-900 text-sm">Recepción del Servicio</span>
    </div>
    <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">Nombre receptor <span class="text-red-500">*</span></label>
            <input type="text" name="firma_nombre" required placeholder="Nombre completo"
                class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all">
        </div>
        <div>
            <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">Cargo <span class="text-red-500">*</span></label>
            <input type="text" name="firma_cargo" required placeholder="Cargo del receptor"
                class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all">
        </div>
        <div class="sm:col-span-2">
            <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">Firma <span class="text-red-500">*</span></label>
            <div class="border border-gray-200 rounded-lg p-3 bg-gray-50">
                <div class="border-2 border-dashed border-gray-300 rounded-lg overflow-hidden bg-white mb-2" style="touch-action:none; height:100px;">
                    <canvas id="firmaCanvas" class="w-full h-full block cursor-crosshair"></canvas>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-xs text-gray-400">Dibuja la firma con el dedo o mouse</span>
                    <div class="flex gap-2">
                        <button type="button" onclick="limpiarFirma()"
                            class="text-xs text-gray-400 hover:text-red-500 border border-gray-200 px-3 py-1 rounded transition-colors">
                            🗑 Limpiar
                        </button>
                        <button type="button" onclick="abrirModalFirma()"
                            class="text-xs text-gray-600 hover:text-gray-800 border border-gray-300 px-3 py-1 rounded transition-colors">
                            ⛶ Ampliar
                        </button>
                    </div>
                </div>
            </div>
            <input type="hidden" name="firma_imagen" id="firmaData">
        </div>
    </div>
</div>


<div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
    <div class="p-5 flex flex-col sm:flex-row gap-3">
        <button type="button" onclick="enviarFormulario()"
            class="flex-1 flex items-center justify-center gap-2 bg-red-600 hover:bg-red-700 text-white font-semibold py-3 rounded-lg text-sm transition-colors shadow-sm">
            📤 Enviar Orden
        </button>
        <a href="<?php echo e(route('mantencion.index')); ?>"
            class="flex-1 flex items-center justify-center gap-2 border border-gray-300 hover:border-gray-400 text-gray-600 font-semibold py-3 rounded-lg text-sm transition-colors">
            Cancelar
        </a>
    </div>
    <div class="px-5 pb-4 text-center">
        <p class="text-xs text-gray-400 font-mono">Todos los campos marcados con <span class="text-red-500">*</span> son obligatorios · La hora de término se registra automáticamente al enviar</p>
    </div>
</div>

</form>


<div id="modalFirma" class="fixed inset-0 bg-black/70 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <div class="font-bold text-gray-900">✍️ Firma del receptor</div>
            <div class="flex gap-2">
                <button type="button" onclick="limpiarFirmaModal()"
                    class="text-sm text-gray-500 hover:text-red-500 border border-gray-200 px-3 py-1.5 rounded-lg transition-colors">
                    🗑 Limpiar
                </button>
                <button type="button" onclick="guardarFirmaModal()"
                    class="text-sm bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-1.5 rounded-lg transition-colors">
                    ✓ Guardar firma
                </button>
            </div>
        </div>
        <div class="p-5">
            <div class="border-2 border-dashed border-gray-300 rounded-xl overflow-hidden bg-gray-50" style="touch-action:none; height:220px;">
                <canvas id="firmaModalCanvas" class="w-full h-full block cursor-crosshair"></canvas>
            </div>
            <p class="text-xs text-gray-400 text-center mt-2">Dibuja la firma con el dedo o mouse</p>
        </div>
    </div>
</div>


<div id="toast" class="fixed bottom-6 right-6 z-50 hidden">
    <div id="toastInner" class="px-5 py-3 rounded-xl shadow-lg text-sm font-semibold flex items-center gap-2"></div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// ═══════════════════════════════════════
// CHECKLIST DATA
// ═══════════════════════════════════════
const ITEMS = <?php echo json_encode($items, 15, 512) ?>;

const TIPOS = {
    impresora_sin_adf:   'IMPRESORA SIN ADF',
    impresora_con_adf:   'IMPRESORA CON ADF',
    impresora_termica:   'IMPRESORA TÉRMICA',
    computador_aio:      'COMPUTADOR ALL IN ONE',
    computador_desktop:  'COMPUTADOR DESKTOP',
    computador_notebook: 'COMPUTADOR NOTEBOOK',
};

const OPCIONES_A = ['operativo','defectuoso','no_aplica'];
const OPCIONES_B = ['realizado','no_realizado','no_aplica'];
const LABEL_OPCIONES = {
    operativo:'Operativo', defectuoso:'Defectuoso', no_aplica:'No aplica',
    realizado:'Realizado', no_realizado:'No realizado'
};
const COLOR_OPCIONES = {
    operativo:'peer-checked:bg-green-50 peer-checked:text-green-700 peer-checked:border-green-400',
    defectuoso:'peer-checked:bg-red-50 peer-checked:text-red-700 peer-checked:border-red-400',
    no_aplica:'peer-checked:bg-gray-100 peer-checked:text-gray-600 peer-checked:border-gray-400',
    realizado:'peer-checked:bg-blue-50 peer-checked:text-blue-700 peer-checked:border-blue-400',
    no_realizado:'peer-checked:bg-amber-50 peer-checked:text-amber-700 peer-checked:border-amber-400',
};

let equipoCount = 0;

// ═══════════════════════════════════════
// FECHA AUTOMÁTICA
// ═══════════════════════════════════════
document.addEventListener('DOMContentLoaded', () => {
    const hoy = new Date();
    const dia = String(hoy.getDate()).padStart(2,'0');
    const mes = String(hoy.getMonth()+1).padStart(2,'0');
    const anio = hoy.getFullYear();
    document.getElementById('fechaHoy').value = `${dia}/${mes}/${anio}`;

    // Agregar primer equipo automáticamente
    agregarEquipo();
    initFirma();
});

// ═══════════════════════════════════════
// EQUIPOS
// ═══════════════════════════════════════
function agregarEquipo() {
    equipoCount++;
    const idx = equipoCount;
    const container = document.getElementById('equiposContainer');
    const div = document.createElement('div');
    div.id = `equipo-${idx}`;
    div.className = 'bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden mb-5';
    div.innerHTML = `
        <div class="px-5 py-3 border-b border-gray-100 bg-gray-50 flex items-center gap-2">
            <span>🖥️</span>
            <span class="font-bold text-gray-900 text-sm">Equipo ${idx}</span>
            <span class="ml-auto text-xs font-mono bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full" id="badge-${idx}">Sin completar</span>
            ${idx > 1 ? `<button type="button" onclick="eliminarEquipo(${idx})"
                class="ml-2 text-xs text-red-400 hover:text-red-600 border border-red-100 rounded px-2 py-0.5 transition-colors">✕ Eliminar</button>` : ''}
        </div>

        <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-4 border-b border-gray-100">
            <div class="sm:col-span-2">
                <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">Tipo de equipo <span class="text-red-500">*</span></label>
                <select name="equipos[${idx}][tipo]" id="tipo-${idx}" required onchange="cargarChecklist(${idx})"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all">
                    <option value="">— Seleccionar tipo —</option>
                    <optgroup label="Impresoras">
                        <option value="impresora_sin_adf">IMPRESORA SIN ADF</option>
                        <option value="impresora_con_adf">IMPRESORA CON ADF</option>
                        <option value="impresora_termica">IMPRESORA TÉRMICA</option>
                    </optgroup>
                    <optgroup label="Computadores">
                        <option value="computador_aio">COMPUTADOR ALL IN ONE</option>
                        <option value="computador_desktop">COMPUTADOR DESKTOP</option>
                        <option value="computador_notebook">COMPUTADOR NOTEBOOK</option>
                    </optgroup>
                </select>
            </div>
            <div>
                <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">Marca <span class="text-red-500">*</span></label>
                <input type="text" name="equipos[${idx}][marca]" required placeholder="Ej: HP"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-red-400 transition-all">
            </div>
            <div>
                <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">Modelo <span class="text-red-500">*</span></label>
                <input type="text" name="equipos[${idx}][modelo]" required placeholder="Ej: LaserJet M404"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-red-400 transition-all">
            </div>
            <div class="sm:col-span-2">
                <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">Número de serie <span class="text-red-500">*</span></label>
                <input type="text" name="equipos[${idx}][serie]" required placeholder="Ej: VNB3R12345"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-red-400 transition-all">
            </div>
        </div>

        <div id="checklist-${idx}" class="hidden"></div>

        <div class="p-5 border-t border-gray-100">
            <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">Observaciones <span class="text-red-500">*</span></label>
            <textarea name="equipos[${idx}][observaciones]" required rows="2"
                placeholder="Notas técnicas, hallazgos, recomendaciones..."
                class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-red-400 transition-all resize-none"></textarea>
        </div>

        <div class="px-5 pb-5">
            <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-3">Estado final <span class="text-red-500">*</span></label>
            <div id="alerta-estado-${idx}" class="hidden mb-3 bg-red-50 border border-red-200 text-red-700 rounded-lg px-4 py-2.5 text-xs flex items-start gap-2">
                <span>⚠️</span><span id="alerta-msg-${idx}"></span>
            </div>
            <div class="grid grid-cols-3 gap-3">
                <label class="cursor-pointer" id="btn-op-${idx}">
                    <input type="radio" name="equipos[${idx}][estado_final]" value="operativo" class="sr-only peer"
                        onchange="onEstadoChange(${idx})">
                    <div class="border-2 border-gray-200 rounded-xl p-3 text-center peer-checked:border-green-500 peer-checked:bg-green-50 hover:border-gray-300 transition-all">
                        <div class="text-xl mb-1">✅</div>
                        <div class="text-xs font-semibold text-gray-900">Operativo</div>
                    </div>
                </label>
                <label class="cursor-pointer" id="btn-obs-${idx}">
                    <input type="radio" name="equipos[${idx}][estado_final]" value="operativo_con_observaciones" class="sr-only peer"
                        onchange="onEstadoChange(${idx})">
                    <div class="border-2 border-gray-200 rounded-xl p-3 text-center peer-checked:border-amber-500 peer-checked:bg-amber-50 hover:border-gray-300 transition-all">
                        <div class="text-xl mb-1">⚠️</div>
                        <div class="text-xs font-semibold text-gray-900">Operativo c/obs.</div>
                    </div>
                </label>
                <label class="cursor-pointer" id="btn-def-${idx}">
                    <input type="radio" name="equipos[${idx}][estado_final]" value="defectuoso" class="sr-only peer"
                        onchange="onEstadoChange(${idx})">
                    <div class="border-2 border-gray-200 rounded-xl p-3 text-center peer-checked:border-red-500 peer-checked:bg-red-50 hover:border-gray-300 transition-all">
                        <div class="text-xl mb-1">❌</div>
                        <div class="text-xs font-semibold text-gray-900">Defectuoso</div>
                    </div>
                </label>
            </div>
        </div>

        <div class="px-5 pb-5 grid grid-cols-2 gap-4 border-t border-gray-100 pt-4">
            <div>
                <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">Foto del equipo <span class="text-red-500">*</span></label>
                <input type="file" name="equipos[${idx}][foto_equipo]" accept="image/*" capture="environment" required
                    class="w-full text-sm text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-red-50 file:text-red-600 hover:file:bg-red-100 transition-all">
            </div>
            <div>
                <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">Foto número de serie <span class="text-red-500">*</span></label>
                <input type="file" name="equipos[${idx}][foto_serie]" accept="image/*" capture="environment" required
                    class="w-full text-sm text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-red-50 file:text-red-600 hover:file:bg-red-100 transition-all">
            </div>
        </div>`;

    container.appendChild(div);
}

function eliminarEquipo(idx) {
    if (!confirm('¿Eliminar este equipo?')) return;
    document.getElementById(`equipo-${idx}`)?.remove();
}

// ═══════════════════════════════════════
// CHECKLIST
// ═══════════════════════════════════════
function cargarChecklist(idx) {
    const tipo = document.getElementById(`tipo-${idx}`).value;
    if (!tipo || !ITEMS[tipo]) return;

    const secciones = {};
    ITEMS[tipo].forEach(item => {
        if (!secciones[item.seccion]) secciones[item.seccion] = [];
        secciones[item.seccion].push(item);
    });

    let html = '';
    Object.entries(secciones).forEach(([seccion, items]) => {
        html += `<div class="px-5 py-2 bg-gray-50 border-y border-gray-100">
            <span class="font-bold text-gray-700 text-xs uppercase tracking-wider">${seccion}</span>
        </div>`;

        items.forEach(item => {
            const opciones = item.tipo_respuesta === 'A' ? OPCIONES_A : OPCIONES_B;
            html += `
            <div class="px-5 py-3 border-b border-gray-50 last:border-b-0">
                <div class="text-sm text-gray-800 font-medium mb-2 flex items-center gap-2">
                    ${item.descripcion}
                    ${item.es_critico ? '<span class="text-xs font-mono bg-amber-50 text-amber-600 border border-amber-200 px-2 py-0.5 rounded-full">Crítico</span>' : ''}
                </div>
                <div class="flex gap-2 flex-wrap" id="opciones-${idx}-${item.id}">
                    ${opciones.map(op => `
                    <label class="cursor-pointer">
                        <input type="radio" name="equipos[${idx}][checklist][${item.id}]" value="${op}" class="sr-only peer"
                            onchange="onRespuestaChange(${idx}, '${op}', ${item.es_critico ? 'true' : 'false'}, '${item.descripcion}')">
                        <span class="inline-block px-3 py-1.5 rounded-lg text-xs font-semibold border-2 border-gray-200 text-gray-400 ${COLOR_OPCIONES[op]} transition-all hover:border-gray-300">
                            ${LABEL_OPCIONES[op]}
                        </span>
                    </label>`).join('')}
                </div>
                <div id="alerta-item-${idx}-${item.id}" class="hidden mt-1.5 text-xs text-red-600 font-mono">⚠️ <span></span></div>
            </div>`;
        });
    });

    const checkDiv = document.getElementById(`checklist-${idx}`);
    checkDiv.innerHTML = html;
    checkDiv.classList.remove('hidden');
}

// ═══════════════════════════════════════
// LÓGICA ESTADO
// ═══════════════════════════════════════
function onRespuestaChange(idx, valor, esCritico, nombre) {
    if (valor !== 'defectuoso') {
        recalcularEstado(idx);
        return;
    }

    forzarDefectuoso(idx, nombre, esCritico);
}

function forzarDefectuoso(idx, nombre, esCritico) {
    const radio = document.querySelector(`input[name="equipos[${idx}][estado_final]"][value="defectuoso"]`);
    if (radio) radio.checked = true;

    bloquearBtn(`btn-op-${idx}`, `"${nombre}" está Defectuoso. No se puede seleccionar Operativo.`);
    bloquearBtn(`btn-obs-${idx}`, `"${nombre}" está Defectuoso. No se puede seleccionar Operativo con observaciones.`);

    const alerta = document.getElementById(`alerta-estado-${idx}`);
    document.getElementById(`alerta-msg-${idx}`).textContent =
        `Hay ítems marcados como Defectuoso. El estado final fue configurado automáticamente.`;
    alerta.classList.remove('hidden');

    actualizarBadge(idx);
}

function bloquearBtn(btnId, msg) {
    const label = document.getElementById(btnId);
    if (!label) return;
    label.querySelector('div').style.opacity = '0.4';
    label.querySelector('input').disabled = true;
    label.onclick = (e) => { e.preventDefault(); mostrarToast(msg, 'error'); };
}

function desbloquearBtn(btnId) {
    const label = document.getElementById(btnId);
    if (!label) return;
    label.querySelector('div').style.opacity = '1';
    label.querySelector('input').disabled = false;
    label.onclick = null;
}

function recalcularEstado(idx) {
    const tipo = document.getElementById(`tipo-${idx}`)?.value;
    if (!tipo || !ITEMS[tipo]) return;

    let hayDefectuoso = false;
    ITEMS[tipo].forEach(item => {
        const checked = document.querySelector(`input[name="equipos[${idx}][checklist][${item.id}]"]:checked`);
        if (checked?.value === 'defectuoso') hayDefectuoso = true;
    });

    if (!hayDefectuoso) {
        desbloquearBtn(`btn-op-${idx}`);
        desbloquearBtn(`btn-obs-${idx}`);
        document.getElementById(`alerta-estado-${idx}`).classList.add('hidden');
        const radio = document.querySelector(`input[name="equipos[${idx}][estado_final]"][value="defectuoso"]`);
        if (radio?.checked) radio.checked = false;
    }
    actualizarBadge(idx);
}

function onEstadoChange(idx) { actualizarBadge(idx); }

function actualizarBadge(idx) {
    const badge = document.getElementById(`badge-${idx}`);
    if (!badge) return;
    const checked = document.querySelector(`input[name="equipos[${idx}][estado_final]"]:checked`);
    if (!checked) return;
    const labels = { operativo:'✅ Operativo', operativo_con_observaciones:'⚠️ Con obs.', defectuoso:'❌ Defectuoso' };
    const colors = { operativo:'bg-green-50 text-green-700', operativo_con_observaciones:'bg-amber-50 text-amber-700', defectuoso:'bg-red-50 text-red-700' };
    badge.textContent = labels[checked.value];
    badge.className = `ml-auto text-xs font-mono px-2 py-0.5 rounded-full ${colors[checked.value]}`;
}

// ═══════════════════════════════════════
// FIRMA
// ═══════════════════════════════════════
let firmaCtx, firmaDibujando = false, firmaLastX = 0, firmaLastY = 0;
let firmaModalCtx, firmaModalDibujando = false, firmaModalLastX = 0, firmaModalLastY = 0;

function initFirma() {
    const canvas = document.getElementById('firmaCanvas');
    canvas.width = canvas.offsetWidth;
    canvas.height = canvas.offsetHeight || 100;
    firmaCtx = canvas.getContext('2d');
    setupCanvas(canvas, firmaCtx, (x,y) => { firmaLastX=x; firmaLastY=y; }, (x,y) => { drawLine(firmaCtx,firmaLastX,firmaLastY,x,y); firmaLastX=x; firmaLastY=y; });
}

function setupCanvas(canvas, ctx, onStart, onMove) {
    const getPos = (e) => {
        const rect = canvas.getBoundingClientRect();
        const scaleX = canvas.width / rect.width;
        const scaleY = canvas.height / rect.height;
        if (e.touches) return { x:(e.touches[0].clientX-rect.left)*scaleX, y:(e.touches[0].clientY-rect.top)*scaleY };
        return { x:(e.clientX-rect.left)*scaleX, y:(e.clientY-rect.top)*scaleY };
    };
    let drawing = false;
    canvas.addEventListener('mousedown', e => { drawing=true; const p=getPos(e); onStart(p.x,p.y); });
    canvas.addEventListener('mousemove', e => { if(!drawing) return; const p=getPos(e); onMove(p.x,p.y); });
    canvas.addEventListener('mouseup', () => drawing=false);
    canvas.addEventListener('mouseleave', () => drawing=false);
    canvas.addEventListener('touchstart', e => { e.preventDefault(); drawing=true; const p=getPos(e); onStart(p.x,p.y); }, {passive:false});
    canvas.addEventListener('touchmove', e => { e.preventDefault(); if(!drawing) return; const p=getPos(e); onMove(p.x,p.y); }, {passive:false});
    canvas.addEventListener('touchend', () => drawing=false);
}

function drawLine(ctx, x1, y1, x2, y2) {
    ctx.beginPath(); ctx.moveTo(x1,y1); ctx.lineTo(x2,y2);
    ctx.strokeStyle='#1f2937'; ctx.lineWidth=2; ctx.lineCap='round'; ctx.stroke();
}

function limpiarFirma() {
    const canvas = document.getElementById('firmaCanvas');
    firmaCtx.clearRect(0,0,canvas.width,canvas.height);
    document.getElementById('firmaData').value = '';
}

function abrirModalFirma() {
    const modal = document.getElementById('modalFirma');
    modal.classList.remove('hidden');
    modal.classList.add('flex');

    setTimeout(() => {
        const canvas = document.getElementById('firmaModalCanvas');
        canvas.width = canvas.offsetWidth;
        canvas.height = canvas.offsetHeight || 220;
        firmaModalCtx = canvas.getContext('2d');

        // Copiar firma existente si hay
        const src = document.getElementById('firmaCanvas');
        if (src) firmaModalCtx.drawImage(src, 0, 0, canvas.width, canvas.height);

        setupCanvas(canvas, firmaModalCtx,
            (x,y) => { firmaModalLastX=x; firmaModalLastY=y; },
            (x,y) => { drawLine(firmaModalCtx,firmaModalLastX,firmaModalLastY,x,y); firmaModalLastX=x; firmaModalLastY=y; }
        );
    }, 50);
}

function limpiarFirmaModal() {
    const canvas = document.getElementById('firmaModalCanvas');
    firmaModalCtx.clearRect(0,0,canvas.width,canvas.height);
}

function guardarFirmaModal() {
    const modalCanvas = document.getElementById('firmaModalCanvas');
    const mainCanvas = document.getElementById('firmaCanvas');
    firmaCtx.clearRect(0,0,mainCanvas.width,mainCanvas.height);
    firmaCtx.drawImage(modalCanvas, 0, 0, mainCanvas.width, mainCanvas.height);
    document.getElementById('firmaData').value = mainCanvas.toDataURL('image/png');
    cerrarModalFirma();
}

function cerrarModalFirma() {
    const modal = document.getElementById('modalFirma');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

document.getElementById('modalFirma').addEventListener('click', function(e) {
    if (e.target === this) cerrarModalFirma();
});

// ═══════════════════════════════════════
// VALIDAR Y ENVIAR
// ═══════════════════════════════════════
function enviarFormulario() {
    // Guardar firma
    const canvas = document.getElementById('firmaCanvas');
    document.getElementById('firmaData').value = canvas.toDataURL('image/png');

    // Guardar fecha real para el servidor
    const hoy = new Date();
    const fechaInput = document.createElement('input');
    fechaInput.type = 'hidden';
    fechaInput.name = 'fecha';
    fechaInput.value = hoy.toISOString().split('T')[0];
    document.getElementById('formChecklist').appendChild(fechaInput);

    document.getElementById('formChecklist').submit();
}

function mostrarToast(msg, tipo='success') {
    const toast = document.getElementById('toast');
    const inner = document.getElementById('toastInner');
    inner.textContent = msg;
    inner.className = `px-5 py-3 rounded-xl shadow-lg text-sm font-semibold flex items-center gap-2 ${
        tipo === 'error' ? 'bg-red-600 text-white' : 'bg-green-600 text-white'
    }`;
    toast.classList.remove('hidden');
    setTimeout(() => toast.classList.add('hidden'), 3500);
}
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Projects\techportal\resources\views/mantencion/create.blade.php ENDPATH**/ ?>