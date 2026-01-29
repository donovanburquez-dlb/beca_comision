<?php

/**
 * ARCHIVO: routes/web.php
 * 
 * PROPÓSITO:
 * Este archivo define TODAS las rutas web de la aplicación.
 * Una ruta conecta una URL con un controlador/método.
 * 
 * EJEMPLO:
 * URL: http://localhost:8000/maestros
 * Ruta: Route::get('/maestros', [MaestroController::class, 'index'])
 * Ejecuta: MaestroController@index
 */

// ============================================
// IMPORTAR CLASES NECESARIAS
// ============================================

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MaestroController;  // Nuestro controlador de maestros
use Illuminate\Support\Facades\Route;        // Clase para definir rutas

// ============================================
// RUTA PÚBLICA: Página de Inicio
// ============================================

/**
 * Esta es la página principal cuando alguien visita:
 * http://localhost:8000/
 * 
 * No requiere login
 */
Route::get('/', function () {
    // Retorna la vista 'welcome'
    // Laravel busca: resources/views/welcome.blade.php
    return view('Hola, este es mi primer cambio en Laravel');
});

// ============================================
// RUTAS PROTEGIDAS (Requieren autenticación)
// ============================================

/**
 * middleware(['auth']) significa que TODAS las rutas
 * dentro de este grupo requieren que el usuario esté logueado.
 * 
 * Si no está logueado, Laravel lo redirige a /login
 * 
 * group(function() {...}) agrupa varias rutas
 */
Route::middleware(['auth'])->group(function () {
    
    // ============================================
    // DASHBOARD (Página de inicio después del login)
    // ============================================
    
    /**
     * URL: /dashboard
     * Método HTTP: GET
     * Requiere: Login
     * 
     * Esta ruta muestra el dashboard después de que
     * el usuario inicia sesión
     */
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    // ->name('dashboard') le da un nombre a la ruta
    // Así podemos usarla como: route('dashboard')

    // PERFIL DE USUARIO (Breeze)
Route::get('/profile', [ProfileController::class, 'edit'])
    ->name('profile.edit');

Route::patch('/profile', [ProfileController::class, 'update'])
    ->name('profile.update');

Route::delete('/profile', [ProfileController::class, 'destroy'])
    ->name('profile.destroy');


    // ============================================
    // RUTAS DE MAESTROS (CRUD Completo)
    // ============================================
    
    /**
     * RUTA ESPECIAL: Buscar por RFC (AJAX)
     * 
     * URL: /maestros/buscar-rfc
     * Método HTTP: POST
     * Controlador: MaestroController@buscarPorRfc
     * 
     * IMPORTANTE: Esta ruta DEBE ir ANTES de Route::resource()
     * Si va después, Laravel la confundirá con /maestros/{id}
     * 
     * CUÁNDO SE USA:
     * Cuando el usuario escribe un RFC en el formulario
     * y da clic en "Buscar", JavaScript hace una petición
     * POST a esta ruta.
     * 
     * EJEMPLO DE PETICIÓN AJAX (desde JavaScript):
     * fetch('/maestros/buscar-rfc', {
     *     method: 'POST',
     *     body: JSON.stringify({ rfc: 'BAVE750815I64' })
     * })
     */
    Route::post('/maestros/buscar-rfc', [MaestroController::class, 'buscarPorRfc'])
        ->name('maestros.buscar-rfc');
    
    /**
     * RUTAS RESOURCE: CRUD Automático
     * 
     * Route::resource() crea automáticamente 7 rutas:
     * 
     * 1. GET    /maestros              → index()    (Lista)
     * 2. GET    /maestros/create       → create()   (Formulario crear)
     * 3. POST   /maestros              → store()    (Guardar)
     * 4. GET    /maestros/{id}         → show()     (Ver detalle)
     * 5. GET    /maestros/{id}/edit    → edit()     (Formulario editar)
     * 6. PUT    /maestros/{id}         → update()   (Actualizar)
     * 7. DELETE /maestros/{id}         → destroy()  (Eliminar)
     * 
     * NOMBRES DE LAS RUTAS:
     * maestros.index
     * maestros.create
     * maestros.store
     * maestros.show
     * maestros.edit
     * maestros.update
     * maestros.destroy
     * 
     * USO EN VISTAS:
     * route('maestros.index')          → /maestros
     * route('maestros.create')         → /maestros/create
     * route('maestros.show', $maestro) → /maestros/5
     * route('maestros.edit', $maestro) → /maestros/5/edit
     */
    Route::resource('maestros', MaestroController::class);
    
    // EXPLICACIÓN DETALLADA DE CADA RUTA:
    
    /**
     * 1. maestros.index - GET /maestros
     * Muestra la lista de todos los maestros
     * Incluye búsqueda y paginación
     * Vista: resources/views/maestros/index.blade.php
     */
    
    /**
     * 2. maestros.create - GET /maestros/create
     * Muestra el formulario para crear un nuevo maestro
     * Vista: resources/views/maestros/create.blade.php
     */
    
    /**
     * 3. maestros.store - POST /maestros
     * Guarda un nuevo maestro en la base de datos
     * Recibe datos del formulario
     * Redirige a maestros.show después de guardar
     */
    
    /**
     * 4. maestros.show - GET /maestros/{id}
     * Muestra los detalles completos de un maestro
     * {id} es el ID del maestro (ejemplo: /maestros/5)
     * Vista: resources/views/maestros/show.blade.php
     */
    
    /**
     * 5. maestros.edit - GET /maestros/{id}/edit
     * Muestra el formulario para editar un maestro
     * El formulario viene pre-llenado con los datos actuales
     * Vista: resources/views/maestros/edit.blade.php
     */
    
    /**
     * 6. maestros.update - PUT /maestros/{id}
     * Actualiza los datos de un maestro en la base de datos
     * Recibe datos del formulario de edición
     * Redirige a maestros.show después de actualizar
     */
    
    /**
     * 7. maestros.destroy - DELETE /maestros/{id}
     * Elimina un maestro de la base de datos
     * Redirige a maestros.index después de eliminar
     */
    
    // ============================================
    // AQUÍ PUEDES AGREGAR MÁS RUTAS PROTEGIDAS
    // ============================================
    
    // Ejemplo: Si después quieres agregar rutas de becarios:
    // Route::resource('becarios', BecarioController::class);
    
    // Ejemplo: Si quieres una ruta de reportes:
    // Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');
    
});

// ============================================
// RUTAS DE AUTENTICACIÓN (Breeze)
// ============================================

/**
 * Este archivo contiene las rutas de:
 * - Login (/login)
 * - Registro (/register)
 * - Olvido de contraseña (/forgot-password)
 * - Logout (/logout)
 * - Etc.
 * 
 * Generadas automáticamente por Laravel Breeze
 */
require __DIR__.'/auth.php';