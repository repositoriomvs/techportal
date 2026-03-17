@extends('layouts.app')

@section('title', 'Continuar Orden Parcial')
@section('page-title', 'Continuar Orden Parcial')
@section('page-subtitle', $mantencion->numero_orden . ' · Guardado parcial pendiente')

@section('topbar-actions')
    <a href="{{ route('mantencion.index') }}"
       class="text-sm text-gray-500 hover:text-gray-700 border border-gray-200 px-4 py-2 rounded-lg transition-colors">
        ← Volver
    </a>
@endsection

@section('content')

{{-- AVISO PARCIAL --}}
<div class="bg-amber-50 border border-amber-200 text-amber-800 rounded-xl px-5 py-4 mb-5 text-sm flex items-center gap-3">
    <span class="text-xl">⚠️</span>
    <div>
        <strong>Orden guardada parcialmente.</strong>
        Completa los datos faltantes y firma para enviar la orden definitivamente.
    </div>
</div>

@if ($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl px-5 py-4 mb-5 text-sm">
        <strong>Por favor corrige los siguientes errores:</strong>
        <ul class="mt-2 list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form id="formChecklist" method="POST" action="{{ route('mantencion.store') }}" enctype="multipart/form-data">
@csrf
{{-- ✅ ID de la orden parcial para que store() la actualice en vez de crear nueva --}}
<input type="hidden" name="orden_parcial_id" value="{{ $mantencion->id }}">

{{-- DATOS DEL SERVICIO --}}
<div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden mb-5">
    <div class="px-5 py-3 border-b border-gray-100 bg-gray-50 flex items-center gap-2">
        <span>📋</span>
        <span class="font-bold text-gray-900 text-sm">1. Datos del Servicio</span>
    </div>
    <div class="p-5 grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div>
            <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">Fecha <span class="text-red-500">*</span></label>
            <input type="text" name="fecha_display" id="fechaHoy" readonly
                value="{{ $mantencion->fecha->format('d/m/Y') }}"
                class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm bg-gray-50 text-gray-500 cursor-not-allowed select-none focus:outline-none">
            <input type="hidden" name="fecha" id="fechaReal" value="{{ $mantencion->fecha->format('Y-m-d') }}">
        </div>
        <div>
            <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">Hora inicio <span class="text-red-500">*</span></label>
            <input type="text" name="hora_inicio" id="horaInicio" readonly
                value="{{ $mantencion->hora_inicio }}"
                class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm bg-gray-50 text-gray-500 cursor-not-allowed select-none focus:outline-none">
        </div>
        <div>
            <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">Hora término</label>
            <input type="text" readonly
                class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm bg-gray-50 text-gray-400 cursor-not-allowed select-none focus:outline-none"
                placeholder="Se registra al enviar">
        </div>
    </div>
</div>

{{-- DATOS DEL CLIENTE --}}
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
                @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}" {{ $mantencion->cliente_id == $cliente->id ? 'selected' : '' }}>
                        {{ $cliente->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">Código local <span class="text-red-500">*</span></label>
            <input type="text" name="codigo_local" required value="{{ $mantencion->codigo_local }}"
                class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all">
        </div>
        <div>
            <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">Ciudad <span class="text-red-500">*</span></label>
            <input type="text" name="ciudad" required value="{{ $mantencion->ciudad }}"
                class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all">
        </div>
        <div class="sm:col-span-2">
            <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">Dirección <span class="text-red-500">*</span></label>
            <input type="text" name="direccion" required value="{{ $mantencion->direccion }}"
                class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all">
        </div>
    </div>
</div>

{{-- EQUIPOS GUARDADOS PREVIAMENTE --}}
@if($mantencion->equipos->isNotEmpty())
<div class="bg-amber-50 border border-amber-200 rounded-xl px-5 py-3 mb-3 text-sm text-amber-700">
    ℹ️ Los equipos guardados anteriormente se muestran abajo. Puedes agregar más o modificarlos.
</div>
@endif

<div id="equiposContainer">
    {{-- Los equipos guardados se renderizan via JS con datos precargados --}}
</div>

{{-- FIRMA --}}
<div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden mb-5">
    <div class="px-5 py-3 border-b border-gray-100 bg-gray-50 flex items-center gap-2">
        <span>✍️</span>
        <span class="font-bold text-gray-900 text-sm">Recepción del Servicio</span>
    </div>
    <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">Nombre receptor <span class="text-red-500">*</span></label>
            <input type="text" name="firma_nombre" id="firma_nombre" required placeholder="Nombre completo"
                class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all">
        </div>
        <div>
            <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">Cargo <span class="text-red-500">*</span></label>
            <input type="text" name="firma_cargo" id="firma_cargo" required placeholder="Cargo del receptor"
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

{{-- ACCIONES --}}
<div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
    <div class="p-5 flex flex-col sm:flex-row gap-3">
        <button type="button" onclick="enviarFormulario()" id="btnEnviar"
            class="flex-1 flex items-center justify-center gap-2 bg-red-600 hover:bg-red-700 text-white font-semibold py-3 rounded-lg text-sm transition-colors shadow-sm">
            📤 Enviar Orden
        </button>
        <button type="button" onclick="guardarParcial()" id="btnParcial"
            class="flex-1 flex items-center justify-center gap-2 bg-amber-500 hover:bg-amber-600 text-white font-semibold py-3 rounded-lg text-sm transition-colors shadow-sm">
            💾 Actualizar Parcial
        </button>
        <a href="{{ route('mantencion.index') }}"
            class="flex-1 flex items-center justify-center gap-2 border border-gray-300 hover:border-gray-400 text-gray-600 font-semibold py-3 rounded-lg text-sm transition-colors">
            Cancelar
        </a>
    </div>
    <div class="px-5 pb-4 text-center">
        <p class="text-xs text-gray-400 font-mono">
            📤 Enviar Orden requiere firma del receptor ·
            💾 Actualizar Parcial guarda sin firma para continuar después
        </p>
    </div>
</div>

</form>

{{-- MODAL FIRMA AMPLIADA --}}
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

{{-- TOAST --}}
<div id="toast" class="fixed bottom-6 right-6 z-50 hidden">
    <div id="toastInner" class="px-5 py-3 rounded-xl shadow-lg text-sm font-semibold flex items-center gap-2"></div>
</div>

@endsection

@push('scripts')
<script>
const ITEMS = @json($items);

const EQUIPOS_GUARDADOS = @json($equiposGuardados);


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

document.addEventListener('DOMContentLoaded', () => {
    initFirma();

    // Cargar equipos guardados previamente
    if (EQUIPOS_GUARDADOS.length > 0) {
        EQUIPOS_GUARDADOS.forEach((equipo, i) => {
            agregarEquipo(equipo);
        });
    } else {
        agregarEquipo();
    }
});

// ═══════════════════════════════════════
// EQUIPOS
// ═══════════════════════════════════════
function agregarEquipo(datosGuardados = null) {
    equipoCount++;
    const idx = equipoCount;
    const container = document.getElementById('equiposContainer');
    const div = document.createElement('div');
    div.id = `equipo-${idx}`;
    div.className = 'bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden mb-5';

    const tipoVal   = datosGuardados?.tipo          || '';
    const marcaVal  = datosGuardados?.marca         || '';
    const modeloVal = datosGuardados?.modelo        || '';
    const serieVal  = datosGuardados?.serie         || '';
    const obsVal    = datosGuardados?.observaciones || '';
    const estadoVal = datosGuardados?.estado_final  || '';

    div.innerHTML = `
        <div class="px-5 py-3 border-b border-gray-100 bg-gray-50 flex items-center gap-2">
            <span>🖥️</span>
            <span class="font-bold text-gray-900 text-sm">Equipo ${idx}</span>
            <span class="ml-auto text-xs font-mono bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full" id="badge-${idx}">
                ${datosGuardados ? '✓ Guardado' : 'Sin completar'}
            </span>
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
                        <option value="impresora_sin_adf" ${tipoVal==='impresora_sin_adf'?'selected':''}>IMPRESORA SIN ADF</option>
                        <option value="impresora_con_adf" ${tipoVal==='impresora_con_adf'?'selected':''}>IMPRESORA CON ADF</option>
                        <option value="impresora_termica" ${tipoVal==='impresora_termica'?'selected':''}>IMPRESORA TÉRMICA</option>
                    </optgroup>
                    <optgroup label="Computadores">
                        <option value="computador_aio"      ${tipoVal==='computador_aio'?'selected':''}>COMPUTADOR ALL IN ONE</option>
                        <option value="computador_desktop"  ${tipoVal==='computador_desktop'?'selected':''}>COMPUTADOR DESKTOP</option>
                        <option value="computador_notebook" ${tipoVal==='computador_notebook'?'selected':''}>COMPUTADOR NOTEBOOK</option>
                    </optgroup>
                </select>
            </div>
            <div>
                <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">Marca <span class="text-red-500">*</span></label>
                <input type="text" name="equipos[${idx}][marca]" required value="${marcaVal}" placeholder="Ej: HP"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-red-400 transition-all">
            </div>
            <div>
                <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">Modelo <span class="text-red-500">*</span></label>
                <input type="text" name="equipos[${idx}][modelo]" required value="${modeloVal}" placeholder="Ej: LaserJet M404"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-red-400 transition-all">
            </div>
            <div class="sm:col-span-2">
                <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">Número de serie <span class="text-red-500">*</span></label>
                <input type="text" name="equipos[${idx}][serie]" required value="${serieVal}" placeholder="Ej: VNB3R12345"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-red-400 transition-all">
            </div>
        </div>
        <div id="checklist-${idx}" class="hidden"></div>
        <div class="p-5 border-t border-gray-100">
            <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">Observaciones <span class="text-red-500">*</span></label>
            <textarea name="equipos[${idx}][observaciones]" required rows="2"
                placeholder="Notas técnicas, hallazgos, recomendaciones..."
                class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-red-400 transition-all resize-none">${obsVal}</textarea>
        </div>
        <div class="px-5 pb-5">
            <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-3">Estado final <span class="text-red-500">*</span></label>
            <div id="alerta-estado-${idx}" class="hidden mb-3 bg-red-50 border border-red-200 text-red-700 rounded-lg px-4 py-2.5 text-xs flex items-start gap-2">
                <span>⚠️</span><span id="alerta-msg-${idx}"></span>
            </div>
            <div class="grid grid-cols-3 gap-3">
                <label class="cursor-pointer" id="btn-op-${idx}">
                    <input type="radio" name="equipos[${idx}][estado_final]" value="operativo" class="sr-only peer"
                        ${estadoVal==='operativo'?'checked':''} onchange="onEstadoChange(${idx})">
                    <div class="border-2 border-gray-200 rounded-xl p-3 text-center peer-checked:border-green-500 peer-checked:bg-green-50 hover:border-gray-300 transition-all">
                        <div class="text-xl mb-1">✅</div>
                        <div class="text-xs font-semibold text-gray-900">Operativo</div>
                    </div>
                </label>
                <label class="cursor-pointer" id="btn-obs-${idx}">
                    <input type="radio" name="equipos[${idx}][estado_final]" value="operativo_con_observaciones" class="sr-only peer"
                        ${estadoVal==='operativo_con_observaciones'?'checked':''} onchange="onEstadoChange(${idx})">
                    <div class="border-2 border-gray-200 rounded-xl p-3 text-center peer-checked:border-amber-500 peer-checked:bg-amber-50 hover:border-gray-300 transition-all">
                        <div class="text-xl mb-1">⚠️</div>
                        <div class="text-xs font-semibold text-gray-900">Operativo c/obs.</div>
                    </div>
                </label>
                <label class="cursor-pointer" id="btn-def-${idx}">
                    <input type="radio" name="equipos[${idx}][estado_final]" value="defectuoso" class="sr-only peer"
                        ${estadoVal==='defectuoso'?'checked':''} onchange="onEstadoChange(${idx})">
                    <div class="border-2 border-gray-200 rounded-xl p-3 text-center peer-checked:border-red-500 peer-checked:bg-red-50 hover:border-gray-300 transition-all">
                        <div class="text-xl mb-1">❌</div>
                        <div class="text-xs font-semibold text-gray-900">Defectuoso</div>
                    </div>
                </label>
            </div>
        </div>
        <div class="px-5 pb-5 grid grid-cols-2 gap-4 border-t border-gray-100 pt-4">
            <div>
                <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">Foto del equipo</label>
                <input type="file" name="equipos[${idx}][foto_equipo]" accept="image/*" capture="environment"
                    class="w-full text-sm text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-red-50 file:text-red-600 hover:file:bg-red-100 transition-all">
            </div>
            <div>
                <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">Foto número de serie</label>
                <input type="file" name="equipos[${idx}][foto_serie]" accept="image/*" capture="environment"
                    class="w-full text-sm text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-red-50 file:text-red-600 hover:file:bg-red-100 transition-all">
            </div>
        </div>
        <div class="px-5 pb-5 pt-2 flex gap-3 border-t border-gray-100">
            <button type="button" onclick="agregarEquipo()"
                class="flex-1 flex items-center justify-center gap-2 border-2 border-dashed border-gray-300 hover:border-red-400 text-gray-400 hover:text-red-500 rounded-lg py-2.5 text-sm font-semibold transition-all">
                ＋ Agregar otro equipo
            </button>
        </div>`;

    container.appendChild(div);

    // Si tiene datos guardados, cargar checklist y marcar respuestas
    if (datosGuardados && datosGuardados.tipo) {
        setTimeout(() => {
            cargarChecklist(idx);
            // Marcar respuestas guardadas
            if (datosGuardados.checklist) {
                setTimeout(() => {
                    Object.entries(datosGuardados.checklist).forEach(([itemId, respuesta]) => {
                        const radio = document.querySelector(`input[name="equipos[${idx}][checklist][${itemId}]"][value="${respuesta}"]`);
                        if (radio) radio.checked = true;
                    });
                }, 100);
            }
            // Actualizar badge
            if (estadoVal) actualizarBadge(idx);
        }, 50);
    }
}

function eliminarEquipo(idx) {
    if (!confirm('¿Eliminar este equipo?')) return;
    document.getElementById(`equipo-${idx}`)?.remove();
}

function guardarEquipo(idx) {
    const tipo   = document.getElementById(`tipo-${idx}`)?.value;
    const marca  = document.querySelector(`input[name="equipos[${idx}][marca]"]`)?.value;
    const modelo = document.querySelector(`input[name="equipos[${idx}][modelo]"]`)?.value;
    const serie  = document.querySelector(`input[name="equipos[${idx}][serie]"]`)?.value;
    const estado = document.querySelector(`input[name="equipos[${idx}][estado_final]"]:checked`)?.value;
    const obs    = document.querySelector(`textarea[name="equipos[${idx}][observaciones]"]`)?.value;

    if (!tipo || !marca || !modelo || !serie || !estado || !obs) {
        mostrarToast('Completa todos los campos del equipo antes de guardar.', 'error');
        return;
    }

    const badge = document.getElementById(`badge-${idx}`);
    badge.textContent = '✓ Guardado';
    badge.className = 'ml-auto text-xs font-mono bg-green-100 text-green-700 px-2 py-0.5 rounded-full';

    const btnGuardar = document.querySelector(`#equipo-${idx} button[onclick="guardarEquipo(${idx})"]`);
    if (btnGuardar) {
        btnGuardar.disabled = true;
        btnGuardar.innerHTML = '✓ Equipo guardado';
        btnGuardar.className = 'flex-1 flex items-center justify-center gap-2 bg-green-600 text-white font-semibold py-2.5 rounded-lg text-sm cursor-not-allowed opacity-75';
    }

    mostrarToast(`Equipo ${idx} guardado correctamente.`, 'success');
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
                <div class="flex gap-2 flex-wrap">
                    ${opciones.map(op => `
                    <label class="cursor-pointer">
                        <input type="radio" name="equipos[${idx}][checklist][${item.id}]" value="${op}" class="sr-only peer"
                            onchange="onRespuestaChange(${idx}, '${op}', ${item.es_critico ? 'true' : 'false'}, '${item.descripcion}')">
                        <span class="inline-block px-3 py-1.5 rounded-lg text-xs font-semibold border-2 border-gray-200 text-gray-400 ${COLOR_OPCIONES[op]} transition-all hover:border-gray-300">
                            ${LABEL_OPCIONES[op]}
                        </span>
                    </label>`).join('')}
                </div>
            </div>`;
        });
    });

    const checkDiv = document.getElementById(`checklist-${idx}`);
    checkDiv.innerHTML = html;
    checkDiv.classList.remove('hidden');
}

function onRespuestaChange(idx, valor, esCritico, nombre) {
    if (valor !== 'defectuoso') { recalcularEstado(idx); return; }
    forzarDefectuoso(idx, nombre, esCritico);
}

function forzarDefectuoso(idx, nombre, esCritico) {
    const radio = document.querySelector(`input[name="equipos[${idx}][estado_final]"][value="defectuoso"]`);
    if (radio) radio.checked = true;
    bloquearBtn(`btn-op-${idx}`, `"${nombre}" está Defectuoso.`);
    bloquearBtn(`btn-obs-${idx}`, `"${nombre}" está Defectuoso.`);
    document.getElementById(`alerta-msg-${idx}`).textContent = `Hay ítems marcados como Defectuoso. Estado configurado automáticamente.`;
    document.getElementById(`alerta-estado-${idx}`).classList.remove('hidden');
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
    const badge   = document.getElementById(`badge-${idx}`);
    if (!badge) return;
    const checked = document.querySelector(`input[name="equipos[${idx}][estado_final]"]:checked`);
    if (!checked) return;
    const labels = { operativo:'✅ Operativo', operativo_con_observaciones:'⚠️ Con obs.', defectuoso:'❌ Defectuoso' };
    const colors  = { operativo:'bg-green-50 text-green-700', operativo_con_observaciones:'bg-amber-50 text-amber-700', defectuoso:'bg-red-50 text-red-700' };
    badge.textContent = labels[checked.value];
    badge.className   = `ml-auto text-xs font-mono px-2 py-0.5 rounded-full ${colors[checked.value]}`;
}

// ═══════════════════════════════════════
// FIRMA
// ═══════════════════════════════════════
let firmaCtx, firmaModalCtx;
let firmaModalLastX = 0, firmaModalLastY = 0;

function initFirma() {
    const canvas  = document.getElementById('firmaCanvas');
    canvas.width  = canvas.offsetWidth;
    canvas.height = canvas.offsetHeight || 100;
    firmaCtx      = canvas.getContext('2d');
    setupCanvas(canvas, firmaCtx,
        (x,y) => { firmaCtx._lastX=x; firmaCtx._lastY=y; },
        (x,y) => { drawLine(firmaCtx, firmaCtx._lastX, firmaCtx._lastY, x, y); firmaCtx._lastX=x; firmaCtx._lastY=y; }
    );
}

function setupCanvas(canvas, ctx, onStart, onMove) {
    const getPos = (e) => {
        const rect   = canvas.getBoundingClientRect();
        const scaleX = canvas.width  / rect.width;
        const scaleY = canvas.height / rect.height;
        if (e.touches) return { x:(e.touches[0].clientX-rect.left)*scaleX, y:(e.touches[0].clientY-rect.top)*scaleY };
        return { x:(e.clientX-rect.left)*scaleX, y:(e.clientY-rect.top)*scaleY };
    };
    let drawing = false;
    canvas.addEventListener('mousedown',  e => { drawing=true;  const p=getPos(e); onStart(p.x,p.y); });
    canvas.addEventListener('mousemove',  e => { if(!drawing) return; const p=getPos(e); onMove(p.x,p.y); });
    canvas.addEventListener('mouseup',    () => drawing=false);
    canvas.addEventListener('mouseleave', () => drawing=false);
    canvas.addEventListener('touchstart', e => { e.preventDefault(); drawing=true; const p=getPos(e); onStart(p.x,p.y); }, {passive:false});
    canvas.addEventListener('touchmove',  e => { e.preventDefault(); if(!drawing) return; const p=getPos(e); onMove(p.x,p.y); }, {passive:false});
    canvas.addEventListener('touchend',   () => drawing=false);
}

function drawLine(ctx, x1, y1, x2, y2) {
    ctx.beginPath(); ctx.moveTo(x1,y1); ctx.lineTo(x2,y2);
    ctx.strokeStyle='#1f2937'; ctx.lineWidth=2; ctx.lineCap='round'; ctx.stroke();
}

function limpiarFirma() {
    const canvas = document.getElementById('firmaCanvas');
    firmaCtx.clearRect(0, 0, canvas.width, canvas.height);
    document.getElementById('firmaData').value = '';
}

function abrirModalFirma() {
    const modal = document.getElementById('modalFirma');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    setTimeout(() => {
        const canvas  = document.getElementById('firmaModalCanvas');
        canvas.width  = canvas.offsetWidth;
        canvas.height = canvas.offsetHeight || 220;
        firmaModalCtx = canvas.getContext('2d');
        const src = document.getElementById('firmaCanvas');
        if (src) firmaModalCtx.drawImage(src, 0, 0, canvas.width, canvas.height);
        setupCanvas(canvas, firmaModalCtx,
            (x,y) => { firmaModalLastX=x; firmaModalLastY=y; },
            (x,y) => { drawLine(firmaModalCtx, firmaModalLastX, firmaModalLastY, x, y); firmaModalLastX=x; firmaModalLastY=y; }
        );
    }, 50);
}

function limpiarFirmaModal() {
    const canvas = document.getElementById('firmaModalCanvas');
    firmaModalCtx.clearRect(0, 0, canvas.width, canvas.height);
}

function guardarFirmaModal() {
    const modalCanvas = document.getElementById('firmaModalCanvas');
    const mainCanvas  = document.getElementById('firmaCanvas');
    firmaCtx.clearRect(0, 0, mainCanvas.width, mainCanvas.height);
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

function firmaEstaVacia() {
    const canvas = document.getElementById('firmaCanvas');
    const ctx    = canvas.getContext('2d');
    const data   = ctx.getImageData(0, 0, canvas.width, canvas.height).data;
    for (let i = 3; i < data.length; i += 4) {
        if (data[i] > 0) return false;
    }
    return true;
}

function enviarFormulario() {
    const canvas = document.getElementById('firmaCanvas');
    document.getElementById('firmaData').value = canvas.toDataURL('image/png');

    const btn = document.getElementById('btnEnviar');
    btn.disabled = true;
    btn.innerHTML = '⏳ Enviando...';
    btn.className = btn.className.replace('bg-red-600 hover:bg-red-700', 'bg-gray-400 cursor-not-allowed');

    document.getElementById('formChecklist').submit();
}

function guardarParcial() {
    if (!firmaEstaVacia()) {
        mostrarToast('No puedes guardar parcialmente cuando ya hay una firma. Usa "Enviar Orden" para finalizar.', 'error');
        return;
    }

    // Quitar required para permitir envío parcial
    document.querySelectorAll('#formChecklist input[required], #formChecklist textarea[required], #formChecklist select[required]').forEach(el => {
        el.removeAttribute('required');
    });

    const form = document.getElementById('formChecklist');
    form.action = '{{ route("mantencion.store.parcial") }}';

    const btn = document.getElementById('btnParcial');
    btn.disabled = true;
    btn.innerHTML = '⏳ Guardando...';

    form.submit();
}

function mostrarToast(msg, tipo='success') {
    const toast = document.getElementById('toast');
    const inner = document.getElementById('toastInner');
    inner.textContent = msg;
    inner.className = `px-5 py-3 rounded-xl shadow-lg text-sm font-semibold flex items-center gap-2 ${
        tipo === 'error' ? 'bg-red-600 text-white' : 'bg-green-600 text-white'
    }`;
    toast.classList.remove('hidden');
    setTimeout(() => toast.classList.add('hidden'), 4000);
}
</script>
@endpush