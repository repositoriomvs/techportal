@push('scripts')
<script>
// ═══════════════════════════════════════
// CHECKLIST DATA (Con validación de objeto)
// ═══════════════════════════════════════
// Forzamos a que si ITEMS viene vacío o como array, se trate como objeto para evitar errores
let rawItems = @json($items);
const ITEMS = (Array.isArray(rawItems) && rawItems.length === 0) ? {} : rawItems;

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
// INICIALIZACIÓN
// ═══════════════════════════════════════
document.addEventListener('DOMContentLoaded', () => {
    // Fecha automática
    const hoy = new Date();
    const dia = String(hoy.getDate()).padStart(2,'0');
    const mes = String(hoy.getMonth()+1).padStart(2,'0');
    const anio = hoy.getFullYear();
    const fechaInput = document.getElementById('fechaHoy');
    if(fechaInput) fechaInput.value = `${dia}/${mes}/${anio}`;

    // Agregar primer equipo
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
    if(!container) return;

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
                    <input type="radio" name="equipos[${idx}][estado_final]" value="operativo" class="sr-only peer" onchange="onEstadoChange(${idx})">
                    <div class="border-2 border-gray-200 rounded-xl p-3 text-center peer-checked:border-green-500 peer-checked:bg-green-50 hover:border-gray-300 transition-all">
                        <div class="text-xl mb-1">✅</div>
                        <div class="text-xs font-semibold text-gray-900">Operativo</div>
                    </div>
                </label>
                <label class="cursor-pointer" id="btn-obs-${idx}">
                    <input type="radio" name="equipos[${idx}][estado_final]" value="operativo_con_observaciones" class="sr-only peer" onchange="onEstadoChange(${idx})">
                    <div class="border-2 border-gray-200 rounded-xl p-3 text-center peer-checked:border-amber-500 peer-checked:bg-amber-50 hover:border-gray-300 transition-all">
                        <div class="text-xl mb-1">⚠️</div>
                        <div class="text-xs font-semibold text-gray-900">Con obs.</div>
                    </div>
                </label>
                <label class="cursor-pointer" id="btn-def-${idx}">
                    <input type="radio" name="equipos[${idx}][estado_final]" value="defectuoso" class="sr-only peer" onchange="onEstadoChange(${idx})">
                    <div class="border-2 border-gray-200 rounded-xl p-3 text-center peer-checked:border-red-500 peer-checked:bg-red-50 hover:border-gray-300 transition-all">
                        <div class="text-xl mb-1">❌</div>
                        <div class="text-xs font-semibold text-gray-900">Defectuoso</div>
                    </div>
                </label>
            </div>
        </div>

        <div class="px-5 pb-5 grid grid-cols-2 gap-4 border-t border-gray-100 pt-4">
            <div>
                <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">Foto equipo <span class="text-red-500">*</span></label>
                <input type="file" name="equipos[${idx}][foto_equipo]" accept="image/*" capture="environment" required
                    class="w-full text-sm text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-red-50 file:text-red-600">
            </div>
            <div>
                <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">Foto serie <span class="text-red-500">*</span></label>
                <input type="file" name="equipos[${idx}][foto_serie]" accept="image/*" capture="environment" required
                    class="w-full text-sm text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-red-50 file:text-red-600">
            </div>
        </div>`;

    container.appendChild(div);
}

function eliminarEquipo(idx) {
    if (!confirm('¿Eliminar este equipo?')) return;
    document.getElementById(`equipo-${idx}`)?.remove();
}

// ═══════════════════════════════════════
// CHECKLIST (Corregido con validación de ITEMS)
// ═══════════════════════════════════════
function cargarChecklist(idx) {
    const tipo = document.getElementById(`tipo-${idx}`).value;
    const checkDiv = document.getElementById(`checklist-${idx}`);
    
    // Limpiar y ocultar si no hay tipo o ITEMS no tiene la llave
    if (!tipo || !ITEMS[tipo]) {
        checkDiv.innerHTML = '';
        checkDiv.classList.add('hidden');
        if(tipo && !ITEMS[tipo]) console.warn("No hay items cargados para el tipo: " + tipo);
        return;
    }

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
                <div class="flex gap-2 flex-wrap">
                    ${opciones.map(op => `
                    <label class="cursor-pointer">
                        <input type="radio" name="equipos[${idx}][checklist][${item.id}]" value="${op}" class="sr-only peer" required
                            onchange="onRespuestaChange(${idx}, '${op}', ${item.es_critico}, '${item.descripcion.replace(/'/g, "\\'")}')">
                        <span class="inline-block px-3 py-1.5 rounded-lg text-xs font-semibold border-2 border-gray-200 text-gray-400 ${COLOR_OPCIONES[op]} transition-all hover:border-gray-300">
                            ${LABEL_OPCIONES[op]}
                        </span>
                    </label>`).join('')}
                </div>
            </div>`;
        });
    });

    checkDiv.innerHTML = html;
    checkDiv.classList.remove('hidden');
}

// ═══════════════════════════════════════
// LOGICA DE ESTADOS Y FIRMA (Igual a la original)
// ═══════════════════════════════════════
function onRespuestaChange(idx, valor, esCritico, nombre) {
    if (valor === 'defectuoso') {
        forzarDefectuoso(idx, nombre, esCritico);
    } else {
        recalcularEstado(idx);
    }
}

function forzarDefectuoso(idx, nombre, esCritico) {
    const radio = document.querySelector(`input[name="equipos[${idx}][estado_final]"][value="defectuoso"]`);
    if (radio) radio.checked = true;
    bloquearBtn(`btn-op-${idx}`, `"${nombre}" está Defectuoso.`);
    bloquearBtn(`btn-obs-${idx}`, `"${nombre}" está Defectuoso.`);
    const alerta = document.getElementById(`alerta-estado-${idx}`);
    document.getElementById(`alerta-msg-${idx}`).textContent = `Configurado como Defectuoso por ítems del checklist.`;
    alerta.classList.remove('hidden');
    actualizarBadge(idx);
}

function bloquearBtn(btnId, msg) {
    const label = document.getElementById(btnId);
    if (!label) return;
    label.querySelector('div').classList.add('opacity-40');
    label.querySelector('input').disabled = true;
}

function desbloquearBtn(btnId) {
    const label = document.getElementById(btnId);
    if (!label) return;
    label.querySelector('div').classList.remove('opacity-40');
    label.querySelector('input').disabled = false;
}

function recalcularEstado(idx) {
    const tipo = document.getElementById(`tipo-${idx}`)?.value;
    if (!tipo || !ITEMS[tipo]) return;
    let hayDefectuoso = false;
    document.querySelectorAll(`input[name^="equipos[${idx}][checklist]"]:checked`).forEach(input => {
        if(input.value === 'defectuoso') hayDefectuoso = true;
    });
    if (!hayDefectuoso) {
        desbloquearBtn(`btn-op-${idx}`);
        desbloquearBtn(`btn-obs-${idx}`);
        document.getElementById(`alerta-estado-${idx}`).classList.add('hidden');
    }
    actualizarBadge(idx);
}

function onEstadoChange(idx) { actualizarBadge(idx); }

function actualizarBadge(idx) {
    const badge = document.getElementById(`badge-${idx}`);
    const checked = document.querySelector(`input[name="equipos[${idx}][estado_final]"]:checked`);
    if (!badge || !checked) return;
    const labels = { operativo:'✅ Operativo', operativo_con_observaciones:'⚠️ Con obs.', defectuoso:'❌ Defectuoso' };
    const colors = { operativo:'bg-green-50 text-green-700', operativo_con_observaciones:'bg-amber-50 text-amber-700', defectuoso:'bg-red-50 text-red-700' };
    badge.textContent = labels[checked.value];
    badge.className = `ml-auto text-xs font-mono px-2 py-0.5 rounded-full ${colors[checked.value]}`;
}

// Lógica de Firma simplificada para estabilidad
let firmaCtx;
function initFirma() {
    const canvas = document.getElementById('firmaCanvas');
    if(!canvas) return;
    canvas.width = canvas.offsetWidth;
    canvas.height = 100;
    firmaCtx = canvas.getContext('2d');
    setupCanvas(canvas, firmaCtx);
}

function setupCanvas(canvas, ctx) {
    let drawing = false;
    let lastX = 0; let lastY = 0;
    const getPos = (e) => {
        const rect = canvas.getBoundingClientRect();
        return {
            x: (e.clientX || e.touches[0].clientX) - rect.left,
            y: (e.clientY || e.touches[0].clientY) - rect.top
        };
    };
    const start = (e) => { drawing = true; const p = getPos(e); lastX = p.x; lastY = p.y; };
    const move = (e) => {
        if (!drawing) return;
        const p = getPos(e);
        ctx.beginPath(); ctx.moveTo(lastX, lastY); ctx.lineTo(p.x, p.y);
        ctx.strokeStyle = '#000'; ctx.lineWidth = 2; ctx.stroke();
        lastX = p.x; lastY = p.y;
    };
    canvas.addEventListener('mousedown', start); canvas.addEventListener('mousemove', move);
    window.addEventListener('mouseup', () => drawing = false);
    canvas.addEventListener('touchstart', (e) => { e.preventDefault(); start(e); });
    canvas.addEventListener('touchmove', (e) => { e.preventDefault(); move(e); });
}

function limpiarFirma() {
    const canvas = document.getElementById('firmaCanvas');
    firmaCtx.clearRect(0, 0, canvas.width, canvas.height);
    document.getElementById('firmaData').value = '';
}

function enviarFormulario() {
    const canvas = document.getElementById('firmaCanvas');
    document.getElementById('firmaData').value = canvas.toDataURL();
    document.getElementById('formChecklist').submit();
}
</script>
@endpush
