<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\AuthController;

// Ruta raíz → redirige al login
Route::get('/', function () {
    return redirect()->route('login');
});

// Auth (sin middleware)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas protegidas (todos los usuarios autenticados)
Route::middleware('auth')->group(function () {

    // Dashboard general
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Buscador
    Route::get('/buscar', [App\Http\Controllers\BuscadorController::class, 'index'])->name('buscar');
    Route::get('/buscar/ajax', [App\Http\Controllers\BuscadorController::class, 'ajax'])->name('buscar.ajax');

    // Historial (debe estar dentro de auth)
    Route::post('/historial/pagina', [App\Http\Controllers\HistorialController::class, 'actualizarPagina'])
        ->name('historial.pagina');

    // Avisos (dentro de auth)
    Route::resource('avisos', App\Http\Controllers\AvisoController::class);

    // Clientes
    Route::resource('clientes', App\Http\Controllers\ClienteController::class);

    // Herramientas — ver y descargar para todos
Route::get('/herramientas', [App\Http\Controllers\HerramientaController::class, 'index'])
    ->name('herramientas.index');
Route::get('/herramientas/{herramienta}/descargar', [App\Http\Controllers\HerramientaController::class, 'descargar'])
    ->name('herramientas.descargar');

// Herramientas — gestión solo admin
Route::middleware('role:admin')->group(function () {
    Route::post('/herramientas', [App\Http\Controllers\HerramientaController::class, 'store'])
        ->name('herramientas.store');
    Route::put('/herramientas/{herramienta}', [App\Http\Controllers\HerramientaController::class, 'update'])
        ->name('herramientas.update');
    Route::delete('/herramientas/{herramienta}', [App\Http\Controllers\HerramientaController::class, 'destroy'])
        ->name('herramientas.destroy');
});

    // Documentos
    Route::get('/clientes/{cliente}/documentos/create', [App\Http\Controllers\DocumentoController::class, 'create'])
        ->name('documentos.create');
    Route::post('/clientes/{cliente}/documentos', [App\Http\Controllers\DocumentoController::class, 'store'])
        ->name('documentos.store');
    Route::get('/documentos/{documento}/ver', [App\Http\Controllers\DocumentoController::class, 'ver'])
        ->name('documentos.ver');
    Route::get('/documentos/{documento}/descargar', [App\Http\Controllers\DocumentoController::class, 'descargar'])
        ->name('documentos.descargar');
    Route::get('/documentos/{documento}/edit', [App\Http\Controllers\DocumentoController::class, 'edit'])
        ->name('documentos.edit');
    Route::put('/documentos/{documento}', [App\Http\Controllers\DocumentoController::class, 'update'])
        ->name('documentos.update');
    Route::delete('/documentos/{documento}', [App\Http\Controllers\DocumentoController::class, 'destroy'])
        ->name('documentos.destroy');

    // Hardware — visible para todos
    Route::get('/hardware', [App\Http\Controllers\HardwareController::class, 'index'])
        ->name('hardware.index');
    Route::get('/hardware/recursos/{recurso}/ver', [App\Http\Controllers\HardwareRecursoController::class, 'ver'])
        ->name('hardware.recursos.ver');
    Route::get('/hardware/recursos/{recurso}/descargar', [App\Http\Controllers\HardwareRecursoController::class, 'descargar'])
        ->name('hardware.recursos.descargar');

    // Solo admin
    Route::middleware('role:admin')->group(function () {

        Route::get('/admin-dashboard', [App\Http\Controllers\AdminDashboardController::class, 'index'])
            ->name('admin.dashboard');

        Route::resource('usuarios', App\Http\Controllers\UsuarioController::class);

        // Hardware — gestión
        Route::post('/hardware/tipos', [App\Http\Controllers\HardwareController::class, 'storeTipo'])
            ->name('hardware.tipos.store');
        Route::delete('/hardware/tipos/{tipo}', [App\Http\Controllers\HardwareController::class, 'destroyTipo'])
            ->name('hardware.tipos.destroy');
        Route::post('/hardware/marcas', [App\Http\Controllers\HardwareController::class, 'storeMarca'])
            ->name('hardware.marcas.store');
        Route::delete('/hardware/marcas/{marca}', [App\Http\Controllers\HardwareController::class, 'destroyMarca'])
            ->name('hardware.marcas.destroy');
        Route::post('/hardware/modelos', [App\Http\Controllers\HardwareController::class, 'storeModelo'])
            ->name('hardware.modelos.store');
        Route::delete('/hardware/modelos/{modelo}', [App\Http\Controllers\HardwareController::class, 'destroyModelo'])
            ->name('hardware.modelos.destroy');
        Route::post('/hardware/modelos/{modelo}/recursos', [App\Http\Controllers\HardwareRecursoController::class, 'store'])
            ->name('hardware.recursos.store');
        Route::delete('/hardware/recursos/{recurso}', [App\Http\Controllers\HardwareRecursoController::class, 'destroy'])
            ->name('hardware.recursos.destroy');
        Route::get('/hardware/recursos/{recurso}/edit', [App\Http\Controllers\HardwareRecursoController::class, 'edit'])
            ->name('hardware.recursos.edit');
        Route::put('/hardware/recursos/{recurso}', [App\Http\Controllers\HardwareRecursoController::class, 'update'])
            ->name('hardware.recursos.update');
    });
});