<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} — @yield('title', 'Portal')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans" x-data="{ sidebarOpen: false }">

    {{-- SIDEBAR MÓVIL (overlay) --}}
    <div x-show="sidebarOpen"
         x-transition:enter="transition-opacity ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false"
         class="fixed inset-0 bg-black/50 z-20 lg:hidden">
    </div>

    {{-- SIDEBAR --}}
    <aside class="fixed top-0 left-0 h-full w-64 bg-gray-900 text-white z-30 flex flex-col
                  transform transition-transform duration-200
                  -translate-x-full lg:translate-x-0"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">

        {{-- Logo --}}
        <div class="flex items-center gap-3 px-5 py-4 border-b border-gray-700">
            <div class="w-9 h-9 bg-red-600 rounded-xl flex items-center justify-center text-lg flex-shrink-0">
                ⚙️
            </div>
            <div>
                <div class="font-bold text-base leading-tight">TECHZONE</div>
                <div class="text-xs text-gray-500 font-mono">v1.0.0</div>
            </div>
        </div>

        {{-- Navegación --}}
        <nav class="flex-1 px-3 py-4 overflow-y-auto">

        @php $user = auth()->user(); @endphp

        {{-- ══════════════════════════════════════ --}}
        {{-- BASE DE CONOCIMIENTO                  --}}
        {{-- Admin y Técnico                       --}}
        {{-- ══════════════════════════════════════ --}}
        @if($user->hasRole('admin') || $user->hasRole('tecnico'))
        <div class="text-xs font-mono text-gray-500 uppercase tracking-widest px-2 mb-2">
            Base de Conocimiento
        </div>

        <a href="{{ route('dashboard') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm mb-1 transition-colors
                  {{ request()->routeIs('dashboard') ? 'bg-red-600 text-white font-semibold' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
            <span class="text-base w-5 text-center">🏠</span> DASHBOARD
        </a>

        <a href="{{ route('clientes.index') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm mb-1 transition-colors
                  {{ request()->routeIs('clientes.index') || request()->routeIs('clientes.show') ? 'bg-red-600 text-white font-semibold' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
            <span class="text-base w-5 text-center">🏢</span> CLIENTES
            <span class="ml-auto bg-red-600 text-white text-xs font-mono px-2 py-0.5 rounded-full">{{ $totalClientes ?? 0 }}</span>
        </a>

        <a href="{{ route('herramientas.index') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm mb-1 transition-colors
                  {{ request()->routeIs('herramientas.*') ? 'bg-red-600 text-white font-semibold' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
            <span class="text-base w-5 text-center">🔧</span> HERRAMIENTAS
        </a>

        <a href="{{ route('hardware.index') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm mb-1 transition-colors
                  {{ request()->routeIs('hardware.*') ? 'bg-red-600 text-white font-semibold' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
            <span class="text-base w-5 text-center">🖥️</span> HARDWARE
        </a>
        @endif

        {{-- ══════════════════════════════════════ --}}
        {{-- SISTEMAS — MANTENCIÓN                 --}}
        {{-- Admin y Técnico                       --}}
        {{-- ══════════════════════════════════════ --}}
        @if($user->hasRole('admin') || $user->hasRole('tecnico'))
        <div class="text-xs font-mono text-gray-500 uppercase tracking-widest px-2 mb-2 mt-5">
            Sistemas
        </div>

        <a href="{{ route('mantencion.index') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm mb-1 transition-colors
                  {{ request()->routeIs('mantencion.index') ? 'bg-red-600 text-white font-semibold' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
            <span class="text-base w-5 text-center">📁</span>
            {{ $user->hasRole('admin') ? 'ÓRDENES' : 'MIS ÓRDENES' }}
        </a>

        <a href="{{ route('mantencion.create') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm mb-1 transition-colors
                  {{ request()->routeIs('mantencion.create') ? 'bg-red-600 text-white font-semibold' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
            <span class="text-base w-5 text-center">✅</span> CHECKLIST MANTENCIÓN
        </a>

        <div class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm mb-1 select-none cursor-default">
            <span class="text-base w-5 text-center opacity-30">📋</span>
            <span class="text-gray-600 opacity-50">CHECKLIST ROLLOUT</span>
            <span class="ml-auto text-xs font-mono bg-gray-800 text-gray-600 px-2 py-0.5 rounded-full">Pronto</span>
        </div>
        @endif

        {{-- ══════════════════════════════════════ --}}
        {{-- INCIDENCIAS                           --}}
        {{-- Admin, Supervisor, Agente             --}}
        {{-- ══════════════════════════════════════ --}}
        @if($user->hasRole('admin') || $user->hasRole('supervisor') || $user->hasRole('agente'))
        <div class="text-xs font-mono text-gray-500 uppercase tracking-widest px-2 mb-2 mt-5">
            Mesa de Ayuda
        </div>

        <a href="{{ route('incidencias.dashboard') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm mb-1 transition-colors
                  {{ request()->routeIs('incidencias.dashboard') ? 'bg-red-600 text-white font-semibold' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
            <span class="text-base w-5 text-center">📊</span> DASHBOARD
        </a>

        <a href="{{ route('incidencias.create') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm mb-1 transition-colors
                  {{ request()->routeIs('incidencias.create') ? 'bg-red-600 text-white font-semibold' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
            <span class="text-base w-5 text-center">🎫</span> NUEVA INCIDENCIA
        </a>

        <a href="{{ route('incidencias.index') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm mb-1 transition-colors
                  {{ request()->routeIs('incidencias.index') ? 'bg-red-600 text-white font-semibold' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
            <span class="text-base w-5 text-center">🗂️</span> MIS TICKETS
        </a>

        <a href="{{ route('incidencias.reportes') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm mb-1 transition-colors
                  {{ request()->routeIs('incidencias.reportes') ? 'bg-red-600 text-white font-semibold' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
            <span class="text-base w-5 text-center">📈</span> REPORTES
        </a>
        @endif

        {{-- ══════════════════════════════════════ --}}
        {{-- ADMINISTRACIÓN                        --}}
        {{-- Solo Admin y Soporte                  --}}
        {{-- ══════════════════════════════════════ --}}
        @if($user->hasRole('admin') || $user->hasRole('soporte'))
        <div class="text-xs font-mono text-gray-500 uppercase tracking-widest px-2 mb-2 mt-5">
            Administración
        </div>

        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm mb-1 transition-colors
                  {{ request()->routeIs('admin.dashboard') ? 'bg-red-600 text-white font-semibold' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
            <span class="text-base w-5 text-center">📉</span> MÉTRICAS
        </a>
        @endif

        @if($user->hasRole('admin'))
        {{-- ✅ CLIENTES — gestión admin (crear, editar, eliminar) --}}
        <a href="{{ route('admin.clientes') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm mb-1 transition-colors
                  {{ request()->routeIs('admin.clientes') ? 'bg-red-600 text-white font-semibold' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
            <span class="text-base w-5 text-center">🏢</span> CLIENTES
        </a>

        <a href="{{ route('usuarios.index') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm mb-1 transition-colors
                  {{ request()->routeIs('usuarios.*') ? 'bg-red-600 text-white font-semibold' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
            <span class="text-base w-5 text-center">👥</span> USUARIOS
        </a>

        <a href="/admin"
           class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm mb-1 text-gray-300 hover:bg-gray-800 hover:text-white transition-colors">
            <span class="text-base w-5 text-center">🛡️</span> PANEL ADMIN
        </a>
        @endif

        </nav>

        {{-- Usuario --}}
        <div class="px-4 py-3 border-t border-gray-700 flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-red-600 flex items-center justify-center text-sm font-bold flex-shrink-0">
                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
            </div>
            <div class="flex-1 min-w-0">
                <div class="text-sm font-semibold truncate">{{ auth()->user()->name }}</div>
                <div class="text-xs text-gray-500 font-mono truncate">{{ auth()->user()->email }}</div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-gray-500 hover:text-white transition-colors text-lg" title="Cerrar sesión">
                    ⇥
                </button>
            </form>
        </div>
    </aside>

    {{-- CONTENIDO PRINCIPAL --}}
    <div class="lg:ml-64 min-h-screen flex flex-col">

        {{-- TOPBAR --}}
        <header class="bg-white border-b border-gray-200 sticky top-0 z-10">
            <div class="flex items-center gap-4 px-5 h-16">
                <button @click="sidebarOpen = !sidebarOpen"
                        class="lg:hidden text-gray-500 hover:text-gray-800 text-xl">
                    ☰
                </button>
                <div>
                    <div class="font-bold text-gray-900 text-lg leading-tight">
                        @yield('page-title', 'Dashboard')
                    </div>
                    <div class="text-xs text-gray-400 font-mono">
                        @yield('page-subtitle', '')
                    </div>
                </div>

                {{-- Buscador global --}}
                <div class="ml-auto flex-1 max-w-sm relative hidden sm:block"
                     x-data="buscador()"
                     @click.outside="cerrar()">
                    <input type="text"
                           x-model="query"
                           @input.debounce.300ms="buscar()"
                           @keydown.enter="irAResultados()"
                           @keydown.escape="cerrar()"
                           placeholder="Buscar recursos, clientes..."
                           class="w-full bg-gray-100 border border-gray-200 rounded-lg px-4 py-2 text-sm focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all">
                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">🔍</span>

                    <div x-show="abierto && resultados.length > 0"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         class="absolute top-full left-0 right-0 mt-1 bg-white border border-gray-200 rounded-xl shadow-lg z-50 overflow-hidden">
                        <template x-for="r in resultados" :key="r.url + r.titulo">
                            <a :href="r.url"
                               class="flex items-center gap-3 px-4 py-2.5 hover:bg-gray-50 transition-colors border-b border-gray-50 last:border-b-0">
                                <span class="text-lg w-6 text-center flex-shrink-0" x-text="r.icono"></span>
                                <div class="flex-1 min-w-0">
                                    <div class="text-sm font-medium text-gray-900 truncate" x-text="r.titulo"></div>
                                    <div class="text-xs text-gray-400 font-mono truncate" x-text="r.subtitulo"></div>
                                </div>
                                <span class="text-xs font-mono font-bold px-2 py-0.5 rounded flex-shrink-0"
                                      :class="{
                                          'bg-red-50 text-red-600':       r.color === 'red',
                                          'bg-blue-50 text-blue-600':     r.color === 'blue',
                                          'bg-green-50 text-green-600':   r.color === 'green',
                                          'bg-purple-50 text-purple-600': r.color === 'purple'
                                      }"
                                      x-text="r.badge">
                                </span>
                            </a>
                        </template>
                        <div class="px-4 py-2 border-t border-gray-100 bg-gray-50">
                            <button @click="irAResultados()"
                                    class="text-xs text-red-600 font-semibold hover:text-red-700 w-full text-left">
                                Ver todos los resultados →
                            </button>
                        </div>
                    </div>

                    <div x-show="abierto && query.length > 1 && resultados.length === 0 && !cargando"
                         class="absolute top-full left-0 right-0 mt-1 bg-white border border-gray-200 rounded-xl shadow-lg z-50 p-4 text-center">
                        <div class="text-sm text-gray-400">Sin resultados para "<span x-text="query"></span>"</div>
                    </div>
                </div>

                <div class="flex items-center gap-2 ml-3">
                    @yield('topbar-actions')
                </div>
            </div>
        </header>

        {{-- Contenido --}}
        <main class="flex-1 p-5 md:p-6">
            @if(session('success'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-800 rounded-lg px-4 py-3 text-sm flex items-center gap-2">
                    ✅ {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 bg-red-50 border border-red-200 text-red-800 rounded-lg px-4 py-3 text-sm flex items-center gap-2">
                    ❌ {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script>
    function buscador() {
        return {
            query: '',
            resultados: [],
            abierto: false,
            cargando: false,
            async buscar() {
                if (this.query.length < 2) { this.resultados = []; this.abierto = false; return; }
                this.cargando = true; this.abierto = true;
                try {
                    const res = await fetch(`/buscar/ajax?q=${encodeURIComponent(this.query)}`);
                    this.resultados = await res.json();
                } catch (e) { this.resultados = []; }
                this.cargando = false;
            },
            irAResultados() {
                if (this.query.length > 1) window.location.href = `/buscar?q=${encodeURIComponent(this.query)}`;
            },
            cerrar() { this.abierto = false; }
        }
    }
    </script>

    @stack('scripts')
</body>
</html>