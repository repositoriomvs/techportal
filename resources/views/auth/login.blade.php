<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechPortal — Ingresar</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-900 flex items-center justify-center p-4">

    <div class="w-full max-w-md">

        {{-- Logo --}}
        <div class="flex items-center gap-3 mb-8 justify-center">
            <div class="w-12 h-12 bg-red-600 rounded-2xl flex items-center justify-center text-2xl shadow-lg">
                ⚙️
            </div>
            <div>
                <div class="text-white font-bold text-2xl leading-tight">TechPortal</div>
                <div class="text-gray-500 text-xs font-mono uppercase tracking-widest">Sistema Técnico</div>
            </div>
        </div>

        {{-- Card --}}
        <div class="bg-gray-800 border border-gray-700 rounded-2xl p-8 shadow-2xl">

            <h1 class="text-white text-xl font-bold mb-1">Bienvenido</h1>
            <p class="text-gray-400 text-sm mb-6">Ingresá tus credenciales para acceder</p>

            {{-- Errores --}}
            @if($errors->any())
                <div class="bg-red-900/30 border border-red-700 text-red-400 rounded-lg px-4 py-3 text-sm mb-4">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email --}}
                <div class="mb-4">
                    <label class="block text-xs font-mono text-gray-400 uppercase tracking-wider mb-2">
                        Usuario / Email
                    </label>
                    <input type="email"
                           name="email"
                           value="{{ old('email') }}"
                           required
                           autofocus
                           placeholder="tecnico@empresa.com"
                           class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white text-sm placeholder-gray-500
                                  focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-500/20 transition-all">
                </div>

                {{-- Password --}}
                <div class="mb-6">
                    <label class="block text-xs font-mono text-gray-400 uppercase tracking-wider mb-2">
                        Contraseña
                    </label>
                    <input type="password"
                           name="password"
                           required
                           placeholder="••••••••"
                           class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white text-sm placeholder-gray-500
                                  focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-500/20 transition-all">
                </div>

                {{-- Recordarme --}}
                <div class="flex items-center gap-2 mb-6">
                    <input type="checkbox" name="remember" id="remember"
                           class="w-4 h-4 rounded border-gray-600 bg-gray-700 text-red-600 focus:ring-red-500">
                    <label for="remember" class="text-sm text-gray-400 cursor-pointer">
                        Recordar sesión
                    </label>
                </div>

                <button type="submit"
                        class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-3 rounded-lg text-sm transition-colors">
                    Ingresar al Portal →
                </button>
            </form>
        </div>

        <div class="text-center mt-4 text-xs text-gray-600 font-mono">
            TechPortal v1.0 · Solo personal autorizado
        </div>
    </div>

</body>
</html>