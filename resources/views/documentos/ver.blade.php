@extends('layouts.app')

@section('title', $documento->nombre)
@section('page-title', $documento->nombre)
@section('page-subtitle', $documento->cliente->nombre . ' · ' . $documento->tipo . ' · ' . ($documento->tamanio ?? ''))

@section('topbar-actions')
    <a href="{{ route('clientes.show', $documento->cliente) }}"
       class="text-sm text-gray-500 hover:text-gray-700 border border-gray-200 px-4 py-2 rounded-lg transition-colors">
        ← Volver
    </a>
    <a href="{{ route('documentos.descargar', $documento) }}"
       class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors">
        ⬇ Descargar
    </a>
@endsection

@section('content')

<div class="flex gap-5" x-data="pdfViewer()">

    {{-- VISOR PRINCIPAL --}}
    <div class="flex-1 flex flex-col">

        {{-- Toolbar --}}
        <div class="bg-white border border-gray-200 rounded-xl px-4 py-2.5 mb-3 flex items-center gap-3 shadow-sm flex-wrap">

            {{-- Navegación páginas --}}
            <button @click="prevPage()"
                    :disabled="currentPage <= 1"
                    class="px-3 py-1.5 border border-gray-200 rounded-lg text-sm hover:bg-gray-50 disabled:opacity-40 disabled:cursor-not-allowed transition-colors">
                ◀
            </button>

            <div class="flex items-center gap-2 text-sm font-mono">
                <input type="number" x-model="currentPage" @change="goToPage()"
                       class="w-12 text-center border border-gray-200 rounded-lg px-2 py-1 text-sm focus:outline-none focus:border-red-400">
                <span class="text-gray-400">/ <span x-text="totalPages">0</span></span>
            </div>

            <button @click="nextPage()"
                    :disabled="currentPage >= totalPages"
                    class="px-3 py-1.5 border border-gray-200 rounded-lg text-sm hover:bg-gray-50 disabled:opacity-40 disabled:cursor-not-allowed transition-colors">
                ▶
            </button>

            <div class="w-px h-5 bg-gray-200 mx-1"></div>

            {{-- Zoom --}}
            <button @click="zoomOut()"
                    class="px-3 py-1.5 border border-gray-200 rounded-lg text-sm hover:bg-gray-50 transition-colors">
                🔍−
            </button>

            <span x-text="Math.round(scale * 100) + '%'"
                  class="text-xs font-mono text-gray-500 w-12 text-center">
            </span>

            <button @click="zoomIn()"
                    class="px-3 py-1.5 border border-gray-200 rounded-lg text-sm hover:bg-gray-50 transition-colors">
                🔍+
            </button>

            <button @click="fitWidth()"
                    class="px-3 py-1.5 border border-gray-200 rounded-lg text-sm hover:bg-gray-50 transition-colors hidden sm:block">
                ↔ Ajustar
            </button>

            <div class="w-px h-5 bg-gray-200 mx-1 hidden sm:block"></div>

            <button @click="printPdf()"
                    class="px-3 py-1.5 border border-gray-200 rounded-lg text-sm hover:bg-gray-50 transition-colors hidden sm:block">
                🖨️ Imprimir
            </button>

            {{-- Loading indicator --}}
            <div x-show="loading" class="ml-auto flex items-center gap-2 text-xs text-gray-400 font-mono">
                <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 22 6.477 22 12h-4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Cargando...
            </div>
        </div>

        {{-- Canvas --}}
        <div class="bg-gray-200 rounded-xl overflow-auto flex justify-center p-4"
             style="min-height: 600px;">
            <canvas id="pdfCanvas"
                    class="shadow-2xl rounded"
                    style="max-width: 100%;">
            </canvas>
        </div>
    </div>

    {{-- PANEL LATERAL --}}
    <div class="w-64 flex-shrink-0 hidden lg:flex flex-col gap-3">

        {{-- Info del documento --}}
        <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
            <div class="text-xs font-mono text-gray-400 uppercase tracking-wider mb-3">Documento</div>

            <div class="mb-2">
                <div class="text-xs text-gray-400 font-mono">Nombre</div>
                <div class="text-sm font-medium text-gray-900">{{ $documento->nombre }}</div>
            </div>
            <div class="mb-2">
                <div class="text-xs text-gray-400 font-mono">Cliente</div>
                <div class="text-sm text-gray-700">{{ $documento->cliente->nombre }}</div>
            </div>
            @if($documento->version)
            <div class="mb-2">
                <div class="text-xs text-gray-400 font-mono">Versión</div>
                <div class="text-sm text-gray-700">{{ $documento->version }}</div>
            </div>
            @endif
            @if($documento->tamanio)
            <div class="mb-2">
                <div class="text-xs text-gray-400 font-mono">Tamaño</div>
                <div class="text-sm text-gray-700 font-mono">{{ $documento->tamanio }}</div>
            </div>
            @endif
            <div class="mb-2">
                <div class="text-xs text-gray-400 font-mono">Páginas</div>
                <div class="text-sm text-gray-700 font-mono" x-text="totalPages + ' páginas'">—</div>
            </div>
            <div>
                <div class="text-xs text-gray-400 font-mono">Subido por</div>
                <div class="text-sm text-gray-700">{{ $documento->user->name ?? 'Sistema' }}</div>
            </div>
        </div>

        {{-- Miniaturas --}}
        <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm flex-1">
            <div class="text-xs font-mono text-gray-400 uppercase tracking-wider mb-3">Páginas</div>
            <div class="grid grid-cols-3 gap-2" id="thumbnails"></div>
        </div>

    </div>

</div>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script>
pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

let _pdfDoc = null;

function pdfViewer() {
    return {
        currentPage: 1,
        totalPages: 0,
        scale: 1.2,
        loading: true,
        visitaRegistrada: false,
        pdfUrl: '{{ $documento->archivo ? Storage::url($documento->archivo) : "" }}',

        async init() {
            if (!this.pdfUrl) return;
            try {
                this.loading = true;
                _pdfDoc = await pdfjsLib.getDocument(this.pdfUrl).promise;
                this.totalPages = _pdfDoc.numPages;

                const params = new URLSearchParams(window.location.search);
                const reanudar = parseInt(params.get('reanudar')) || 1;
                const paginaInicial = (reanudar >= 1 && reanudar <= this.totalPages) ? reanudar : 1;

                await this.renderThumbnails();
                await this.renderPage(paginaInicial);

                // Marcar visita DESPUÉS de renderizar la página inicial
                // sin guardar la página aún (el usuario no ha navegado)
                this.visitaRegistrada = true;

                this.loading = false;
            } catch (error) {
                console.error('Error cargando PDF:', error);
                this.loading = false;
            }
        },

        guardarPagina(num) {
            fetch('{{ route("historial.pagina") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    tipo:       'documento',
                    recurso_id: {{ $documento->id }},
                    pagina:     num,
                }),
            }).catch(() => {});
        },

        async renderPage(num) {
            if (!_pdfDoc) return;
            this.loading = true;
            const page = await _pdfDoc.getPage(num);
            const canvas = document.getElementById('pdfCanvas');
            const ctx = canvas.getContext('2d');
            const viewport = page.getViewport({ scale: this.scale });

            canvas.height = viewport.height;
            canvas.width = viewport.width;

            await page.render({ canvasContext: ctx, viewport }).promise;
            this.currentPage = num;
            this.loading = false;

            // Solo guarda si el usuario ya navegó (no durante la carga inicial)
            if (this.visitaRegistrada) {
                this.guardarPagina(num);
            }

            document.querySelectorAll('.thumb-btn').forEach((btn, i) => {
                btn.classList.toggle('border-red-500', i + 1 === num);
                btn.classList.toggle('border-gray-200', i + 1 !== num);
            });
        },

        async renderThumbnails() {
            if (!_pdfDoc) return;
            const container = document.getElementById('thumbnails');
            container.innerHTML = '';
            const maxThumbs = Math.min(this.totalPages, 12);
            for (let i = 1; i <= maxThumbs; i++) {
                const page = await _pdfDoc.getPage(i);
                const viewport = page.getViewport({ scale: 0.2 });
                const canvas = document.createElement('canvas');
                canvas.width = viewport.width;
                canvas.height = viewport.height;
                await page.render({ canvasContext: canvas.getContext('2d'), viewport }).promise;
                const btn = document.createElement('button');
                btn.className = `thumb-btn border-2 rounded overflow-hidden w-full transition-colors border-gray-200`;
                btn.title = `Página ${i}`;
                btn.appendChild(canvas);
                btn.addEventListener('click', () => this.renderPage(i));
                container.appendChild(btn);
            }
        },

        async prevPage() { if (this.currentPage > 1) await this.renderPage(this.currentPage - 1); },
        async nextPage() { if (this.currentPage < this.totalPages) await this.renderPage(this.currentPage + 1); },
        async goToPage() {
            const p = parseInt(this.currentPage);
            if (p >= 1 && p <= this.totalPages) await this.renderPage(p);
        },
        async zoomIn() { this.scale = Math.min(this.scale + 0.2, 3); await this.renderPage(this.currentPage); },
        async zoomOut() { this.scale = Math.max(this.scale - 0.2, 0.5); await this.renderPage(this.currentPage); },
        async fitWidth() {
            if (!_pdfDoc) return;
            const canvas = document.getElementById('pdfCanvas');
            const page = await _pdfDoc.getPage(this.currentPage);
            const viewport = page.getViewport({ scale: 1 });
            this.scale = (canvas.parentElement.clientWidth - 32) / viewport.width;
            await this.renderPage(this.currentPage);
        },
        printPdf() { window.open(this.pdfUrl, '_blank'); }
    }
}
</script>
@endpush