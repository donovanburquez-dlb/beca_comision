<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * MIDDLEWARE: VerificarRol
 *
 * PROPÓSITO:
 * Verifica que el usuario tenga el rol necesario
 * para acceder a una ruta específica.
 *
 * USO EN RUTAS:
 * Route::get('/usuarios', ...)->middleware('rol:Administrador');
 * Route::get('/maestros', ...)->middleware('rol:Administrador,Coordinador');
 */
class VerificarRol
{
    /**
     * Handle: Se ejecuta en cada petición
     *
     * @param Request $request - La petición del usuario
     * @param Closure $next    - La siguiente acción
     * @param string ...$roles - Los roles permitidos
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Verificamos que el usuario esté logueado
        if (!auth()->check()) {
            return redirect('/login');
        }

        // Obtenemos el rol del usuario actual
        $rolUsuario = auth()->user()->rol;

        // Verificamos si el rol del usuario está en los roles permitidos
        // in_array busca si $rolUsuario existe en el array $roles
        if (!in_array($rolUsuario, $roles)) {
            // Si no tiene permiso, redirigimos con mensaje de error
            abort(403, 'No tienes permiso para acceder a esta sección.');
        }

        // Si tiene permiso, continuamos con la petición
        return $next($request);
    }
}