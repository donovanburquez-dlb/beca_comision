<?php

use App\Http\Controllers\MaestroController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

// ============================================
// RUTA PÚBLICA
// ============================================

Route::get('/', function () {
    return view('welcome');
});

// ============================================
// RUTAS PROTEGIDAS (requieren login)
// ============================================

Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // ============================================
    // RUTAS DE MAESTROS
    // Accesibles para TODOS los roles
    // ============================================

    // Buscar por RFC (AJAX) - todos pueden buscar
    Route::post('/maestros/buscar-rfc', [MaestroController::class, 'buscarPorRfc'])
        ->name('maestros.buscar-rfc');

    // Ver lista y detalle - todos los roles
    Route::get('/maestros', [MaestroController::class, 'index'])
        ->name('maestros.index');
    
        // Crear - Solo Administrador, Coordinador y Capturista
    Route::get('/maestros/create', [MaestroController::class, 'create'])
        ->middleware('rol:Administrador,Coordinador,Capturista')
        ->name('maestros.create');

    Route::post('/maestros', [MaestroController::class, 'store'])
        ->middleware('rol:Administrador,Coordinador,Capturista')
        ->name('maestros.store');

    // Editar - Solo Administrador, Coordinador y Capturista
    Route::get('/maestros/{maestro}/edit', [MaestroController::class, 'edit'])
        ->middleware('rol:Administrador,Coordinador,Capturista')
        ->name('maestros.edit');

    Route::put('/maestros/{maestro}', [MaestroController::class, 'update'])
        ->middleware('rol:Administrador,Coordinador,Capturista')
        ->name('maestros.update');

    // Ruta para guardar sustitutos de un maestro específico
    Route::post('/maestros/{maestro}/sustitutos', [App\Http\Controllers\SustitutoController::class, 'store'])
        ->middleware('rol:Administrador,Coordinador,Capturista')
        ->name('sustitutos.store');

    // Eliminar - Solo Administrador
    Route::delete('/maestros/{maestro}', [MaestroController::class, 'destroy'])
        ->middleware('rol:Administrador')
        ->name('maestros.destroy');

    // 🔹 SHOW (AL FINAL SIEMPRE)
    Route::get('/maestros/{maestro}', [MaestroController::class, 'show'])
        ->name('maestros.show');

    // ============================================
    // RUTAS DE USUARIOS
    // Solo Administrador puede gestionar usuarios
    // ============================================

    Route::resource('usuarios', UsuarioController::class)
        ->middleware('rol:Administrador');

    // Rutas de perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__.'/auth.php';