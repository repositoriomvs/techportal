{{-- ÚLTIMAS VISITAS --}}
<div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
    <div class="px-5 py-4 border-b border-gray-100">
        <h2 class="font-bold text-gray-900">📖 Últimas visitas</h2>
        <p class="text-xs text-gray-400 font-mono mt-0.5">Continuá donde lo dejaste</p>
    </div>
    @if($ultimasVisitas->isEmpty())
        <div class="p-8 text-center">
            <div class="text-3xl mb-2">📂</div>
            <div class="text-sm text-gray-400">Aún no has visitado ningún recurso.</div>
            <a href="{{ route('clientes.index') }}" class="inline-block mt-3 text-xs text-red-600 font-semibold hover:text-red-700">Explorar clientes →</a>
        </div>
    @else
        <div class="divide-y divide-gray-50">
            @foreach($ultimasVisitas as $visita)
            @php
                $url = $visita->recurso_url;
                if (!empty($visita->ultima_pagina) && $visita->ultima_pagina > 1) {
                    $url .= '?reanudar=' . $visita->ultima_pagina;
                }
            @endphp
            <a href="{{ $url }}" class="flex items-center gap-3 px-5 py-3.5 hover:bg-gray-50 transition-colors group">
                <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0 {{ $visita->tipo === 'documento' ? 'bg-red-50' : 'bg-blue-50' }}">
                    <span class="text-lg">{{ $visita->tipo === 'documento' ? '📄' : '🖥️' }}</span>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="text-sm font-medium text-gray-900 truncate group-hover:text-red-600 transition-colors">{{ $visita->recurso_nombre }}</div>
                    <div class="text-xs text-gray-400 font-mono flex items-center gap-2 mt-0.5">
                        <span>{{ $visita->tipo === 'documento' ? 'Documento' : 'Hardware' }}</span>
                        <span class="text-gray-200">·</span>
                        @if(!empty($visita->ultima_pagina) && $visita->ultima_pagina > 1)
                            <span class="text-amber-500 font-semibold">Pág. {{ $visita->ultima_pagina }}</span>
                        @else
                            <span>Pág. 1</span>
                        @endif
                        <span class="text-gray-200">·</span>
                        <span>{{ $visita->visitado_at->diffForHumans() }}</span>
                    </div>
                </div>
                <span class="text-gray-300 group-hover:text-red-400 transition-colors flex-shrink-0">→</span>
            </a>
            @endforeach
        </div>
    @endif
</div>

{{-- AVISOS IMPORTANTES --}}
<div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden" x-data="{ abierto: false }">
    <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
        <div>
            <h2 class="font-bold text-gray-900">📢 Avisos Importantes</h2>
            <p class="text-xs text-gray-400 font-mono mt-0.5">Novedades y actualizaciones</p>
        </div>
        @if(auth()->user()->hasRole('admin'))
        <button @click="abierto = true" class="text-xs bg-red-600 text-white font-semibold px-3 py-1.5 rounded-lg hover:bg-red-700 transition-colors">+ Nuevo</button>
        @endif
    </div>
    @if($avisos->isEmpty())
        <div class="p-8 text-center">
            <div class="text-3xl mb-2">📭</div>
            <div class="text-sm text-gray-400">No hay avisos publicados.</div>
        </div>
    @else
        <div class="divide-y divide-gray-50">
            @foreach($avisos as $aviso)
            <div class="px-5 py-3.5 hover:bg-gray-50 transition-colors">
                <div class="flex items-start gap-3">
                    <span class="text-lg flex-shrink-0 mt-0.5">
                        @if($aviso->tipo === 'advertencia') ⚠️
                        @elseif($aviso->tipo === 'actualizacion') 🔄
                        @else ℹ️
                        @endif
                    </span>
                    <div class="flex-1 min-w-0">
                        <div class="text-sm font-semibold text-gray-900">{{ $aviso->titulo }}</div>
                        @if($aviso->contenido)
                        <div class="text-xs text-gray-500 mt-0.5 line-clamp-2">{{ $aviso->contenido }}</div>
                        @endif
                        <div class="flex items-center gap-3 mt-1.5 flex-wrap">
                            @if($aviso->url)
                            <a href="{{ $aviso->url }}" class="text-xs text-red-600 font-semibold hover:text-red-700 transition-colors">{{ $aviso->url_texto ?? 'Ver recurso' }} →</a>
                            @endif
                            <span class="text-xs text-gray-400 font-mono">{{ $aviso->publicado_at?->diffForHumans() }}</span>
                            <span class="text-xs text-gray-300 font-mono">por {{ $aviso->user->name ?? 'Admin' }}</span>
                        </div>
                    </div>
                    @if(auth()->user()->hasRole('admin'))
                    <form method="POST" action="{{ route('avisos.destroy', $aviso) }}" onsubmit="return confirm('¿Eliminar este aviso?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-gray-300 hover:text-red-500 transition-colors text-sm leading-none mt-0.5" title="Eliminar aviso">✕</button>
                    </form>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    @endif

    @if(auth()->user()->hasRole('admin'))
    <div x-show="abierto" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black/40" x-cloak @click.self="abierto = false" @keydown.escape.window="abierto = false">
        <div class="bg-white rounded-xl shadow-xl p-6 w-full max-w-md mx-4">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-gray-900">📢 Nuevo Aviso</h3>
                <button @click="abierto = false" class="text-gray-400 hover:text-gray-600 transition-colors text-lg leading-none">✕</button>
            </div>
            <form method="POST" action="{{ route('avisos.store') }}">
                @csrf
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
    @endif
</div>
