@extends('layouts.app')

@section('title', 'Editar Cliente')
@section('page-title', 'Editar Cliente')
@section('page-subtitle', $cliente->nombre)

@section('content')

<div class="max-w-2xl">
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">

        <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center text-white font-bold flex-shrink-0"
                 style="background-color: {{ $cliente->color }}">
                {{ $cliente->iniciales }}
            </div>
            <div>
                <div class="font-bold text-gray-900">{{ $cliente->nombre }}</div>
                <div class="text-xs text-gray-400 font-mono">{{ $cliente->codigo }}</div>
            </div>
        </div>

        <form method="POST" action="{{ route('clientes.update', $cliente) }}" class="p-6">
            @csrf
            @method('PUT')

            @if ($errors->any())
                <div class="mb-4 bg-red-50 border border-red-200 text-red-700 rounded-lg px-4 py-3 text-sm">
                    <strong>Por favor corrige los siguientes errores:</strong>
                    <ul class="mt-1 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">

                {{-- Nombre --}}
                <div class="sm:col-span-2">
                    <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">
                        Nombre <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nombre" value="{{ old('nombre', $cliente->nombre) }}" required
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all {{ $errors->has('nombre') ? 'border-red-400' : '' }}">
                    @error('nombre')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Código --}}
                <div>
                    <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">
                        Código <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="codigo" value="{{ old('codigo', $cliente->codigo) }}" required
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm font-mono focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all {{ $errors->has('codigo') ? 'border-red-400' : '' }}">
                    @error('codigo')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Color --}}
                <div>
                    <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">Color Avatar</label>
                    <div class="flex items-center gap-3">
                        <input type="color" name="color" value="{{ old('color', $cliente->color) }}"
                               class="w-10 h-10 rounded-lg border border-gray-200 cursor-pointer p-1">
                        <span class="text-xs text-gray-400">Color del avatar del cliente</span>
                    </div>
                </div>

                {{-- Contacto --}}
                <div>
                    <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">Contacto</label>
                    <input type="text" name="contacto" value="{{ old('contacto', $cliente->contacto) }}"
                           placeholder="Nombre del contacto"
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all">
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', $cliente->email) }}"
                           placeholder="contacto@empresa.com"
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all">
                </div>

                {{-- Teléfono --}}
                <div>
                    <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">Teléfono</label>
                    <input type="text" name="telefono" value="{{ old('telefono', $cliente->telefono) }}"
                           placeholder="+56 9 1234 5678"
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all">
                </div>

                {{-- Estado --}}
                <div>
                    <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">Estado</label>
                    <select name="estado"
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all">
                        <option value="activo"   {{ old('estado', $cliente->estado) === 'activo'   ? 'selected' : '' }}>Activo</option>
                        <option value="inactivo" {{ old('estado', $cliente->estado) === 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>

                {{-- Notas --}}
                <div class="sm:col-span-2">
                    <label class="block text-xs font-mono text-gray-500 uppercase tracking-wider mb-1">Notas</label>
                    <textarea name="notas" rows="3"
                              placeholder="Información adicional del cliente..."
                              class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all resize-none">{{ old('notas', $cliente->notas) }}</textarea>
                </div>

            </div>

            {{-- ══════════════════════════════════════ --}}
            {{-- SECCIÓN SLA                           --}}
            {{-- ══════════════════════════════════════ --}}
            @php $tieneSla = old('tiene_sla', $slas->isNotEmpty()); @endphp

            <div class="border-t border-gray-100 pt-5 mb-4">

                <div class="flex items-center justify-between mb-4">
                    <div>
                        <div class="font-bold text-gray-900 text-sm">Acuerdo de Nivel de Servicio (SLA)</div>
                        <div class="text-xs text-gray-400 mt-0.5">¿Este cliente cuenta con un SLA definido?</div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="tiene_sla" value="1" id="toggle_sla"
                               {{ $tieneSla ? 'checked' : '' }}
                               class="sr-only peer"
                               onchange="toggleSla(this.checked)">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer
                                    peer-checked:bg-red-600 transition-colors
                                    after:content-[''] after:absolute after:top-[2px] after:left-[2px]
                                    after:bg-white after:rounded-full after:h-5 after:w-5
                                    after:transition-all peer-checked:after:translate-x-5"></div>
                        <span class="ml-3 text-sm font-semibold text-gray-700" id="sla_label">
                            {{ $tieneSla ? 'Sí' : 'No' }}
                        </span>
                    </label>
                </div>

                <div id="sla_campos" class="{{ $tieneSla ? '' : 'hidden' }}">

                    <div class="bg-blue-50 border border-blue-100 rounded-lg px-4 py-3 mb-4 text-xs text-blue-700">
                        ℹ️ Define los tiempos en <strong>horas</strong> para cada nivel de prioridad. Si no aplica un compromiso, ingresa <strong>0</strong>.
                    </div>

                    <div class="border border-gray-200 rounded-lg overflow-hidden">

                        {{-- Header --}}
                        <div class="grid grid-cols-4 bg-gray-50 border-b border-gray-200">
                            <div class="px-4 py-2.5 text-xs font-bold text-gray-500 uppercase tracking-wider">Prioridad</div>
                            <div class="px-4 py-2.5 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Tiempo respuesta (hrs)</div>
                            <div class="px-4 py-2.5 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Tiempo resolución (hrs)</div>
                            <div class="px-4 py-2.5 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Cambio de equipo (hrs)</div>
                        </div>

                        {{-- Fila Alta --}}
                        <div class="grid grid-cols-4 border-b border-gray-100 items-center">
                            <div class="px-4 py-3 flex items-center gap-2">
                                <span class="inline-block w-2 h-2 rounded-full bg-red-500"></span>
                                <span class="text-sm font-semibold text-gray-700">Alta</span>
                            </div>
                            <div class="px-3 py-2">
                                <input type="number" name="sla[alta][horas_respuesta]"
                                       value="{{ old('sla.alta.horas_respuesta', $slas['alta']->horas_respuesta ?? 0) }}"
                                       min="0"
                                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm font-mono text-center focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all">
                            </div>
                            <div class="px-3 py-2">
                                <input type="number" name="sla[alta][horas_resolucion]"
                                       value="{{ old('sla.alta.horas_resolucion', $slas['alta']->horas_resolucion ?? 0) }}"
                                       min="0"
                                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm font-mono text-center focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all">
                            </div>
                            <div class="px-3 py-2">
                                <input type="number" name="sla[alta][horas_cambio_equipo]"
                                       value="{{ old('sla.alta.horas_cambio_equipo', $slas['alta']->horas_cambio_equipo ?? 0) }}"
                                       min="0"
                                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm font-mono text-center focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all">
                            </div>
                        </div>

                        {{-- Fila Media --}}
                        <div class="grid grid-cols-4 border-b border-gray-100 items-center bg-gray-50/50">
                            <div class="px-4 py-3 flex items-center gap-2">
                                <span class="inline-block w-2 h-2 rounded-full bg-amber-500"></span>
                                <span class="text-sm font-semibold text-gray-700">Media</span>
                            </div>
                            <div class="px-3 py-2">
                                <input type="number" name="sla[media][horas_respuesta]"
                                       value="{{ old('sla.media.horas_respuesta', $slas['media']->horas_respuesta ?? 0) }}"
                                       min="0"
                                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm font-mono text-center focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all">
                            </div>
                            <div class="px-3 py-2">
                                <input type="number" name="sla[media][horas_resolucion]"
                                       value="{{ old('sla.media.horas_resolucion', $slas['media']->horas_resolucion ?? 0) }}"
                                       min="0"
                                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm font-mono text-center focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all">
                            </div>
                            <div class="px-3 py-2">
                                <input type="number" name="sla[media][horas_cambio_equipo]"
                                       value="{{ old('sla.media.horas_cambio_equipo', $slas['media']->horas_cambio_equipo ?? 0) }}"
                                       min="0"
                                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm font-mono text-center focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all">
                            </div>
                        </div>

                        {{-- Fila Baja --}}
                        <div class="grid grid-cols-4 items-center">
                            <div class="px-4 py-3 flex items-center gap-2">
                                <span class="inline-block w-2 h-2 rounded-full bg-green-500"></span>
                                <span class="text-sm font-semibold text-gray-700">Baja</span>
                            </div>
                            <div class="px-3 py-2">
                                <input type="number" name="sla[baja][horas_respuesta]"
                                       value="{{ old('sla.baja.horas_respuesta', $slas['baja']->horas_respuesta ?? 0) }}"
                                       min="0"
                                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm font-mono text-center focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all">
                            </div>
                            <div class="px-3 py-2">
                                <input type="number" name="sla[baja][horas_resolucion]"
                                       value="{{ old('sla.baja.horas_resolucion', $slas['baja']->horas_resolucion ?? 0) }}"
                                       min="0"
                                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm font-mono text-center focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all">
                            </div>
                            <div class="px-3 py-2">
                                <input type="number" name="sla[baja][horas_cambio_equipo]"
                                       value="{{ old('sla.baja.horas_cambio_equipo', $slas['baja']->horas_cambio_equipo ?? 0) }}"
                                       min="0"
                                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm font-mono text-center focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all">
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Botones --}}
            <div class="flex items-center gap-3 pt-2 border-t border-gray-100">
                <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-2.5 rounded-lg text-sm transition-colors">
                    Guardar Cambios
                </button>
                <a href="{{ route('clientes.show', $cliente) }}"
                   class="text-sm text-gray-500 hover:text-gray-700 border border-gray-200 px-6 py-2.5 rounded-lg transition-colors">
                    Cancelar
                </a>
                <a href="{{ route('clientes.index') }}"
                   class="text-sm text-gray-400 hover:text-gray-600 ml-auto">
                    ← Volver al listado
                </a>
            </div>

        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
function toggleSla(checked) {
    document.getElementById('sla_campos').classList.toggle('hidden', !checked);
    document.getElementById('sla_label').textContent = checked ? 'Sí' : 'No';
}
</script>
@endpush
