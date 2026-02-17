<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * CONTROLADOR: UsuarioController
 *
 * PROPÓSITO:
 * Gestiona los usuarios del sistema y sus roles.
 * Solo accesible para Administradores.
 */
class UsuarioController extends Controller
{
    /**
     * Lista todos los usuarios
     * RUTA: GET /usuarios
     */
    public function index()
    {
        // Obtenemos todos los usuarios ordenados por nombre
        $usuarios = User::orderBy('name')->paginate(20);

        // Lista de roles disponibles (para filtros)
        $roles = ['Administrador', 'Coordinador', 'Capturista', 'Consulta'];

        return view('usuarios.index', compact('usuarios', 'roles'));
    }

    /**
     * Muestra formulario para crear usuario
     * RUTA: GET /usuarios/create
     */
    public function create()
    {
        // Lista de roles para el select del formulario
        $roles = ['Administrador', 'Coordinador', 'Capturista', 'Consulta'];

        return view('usuarios.create', compact('roles'));
    }

    /**
     * Guarda un nuevo usuario
     * RUTA: POST /usuarios
     */
    public function store(Request $request)
    {
        // Validamos los datos
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users|max:255',
            'password' => 'required|min:8|confirmed',
            // confirmed = debe existir un campo password_confirmation igual
            'rol'      => 'required|in:Administrador,Coordinador,Capturista,Consulta',
        ], [
            // Mensajes de error en español
            'name.required'     => 'El nombre es obligatorio',
            'email.required'    => 'El correo es obligatorio',
            'email.unique'      => 'Este correo ya está registrado',
            'password.required' => 'La contraseña es obligatoria',
            'password.min'      => 'La contraseña debe tener al menos 8 caracteres',
            'password.confirmed'=> 'Las contraseñas no coinciden',
            'rol.required'      => 'El rol es obligatorio',
        ]);

        // Creamos el usuario
        // Hash::make() encripta la contraseña
        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'rol'      => $validated['rol'],
        ]);

        return redirect()
            ->route('usuarios.index')
            ->with('success', 'Usuario creado exitosamente');
    }

    /**
     * Muestra formulario para editar usuario
     * RUTA: GET /usuarios/{id}/edit
     */
    public function edit(User $usuario)
    {
        $roles = ['Administrador', 'Coordinador', 'Capturista', 'Consulta'];

        return view('usuarios.edit', compact('usuario', 'roles'));
    }

    /**
     * Actualiza un usuario
     * RUTA: PUT /usuarios/{id}
     */
    public function update(Request $request, User $usuario)
    {
        $rules = [
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $usuario->id,
            'rol'   => 'required|in:Administrador,Coordinador,Capturista,Consulta',
        ];

        // La contraseña es opcional al editar
        // Solo se valida si se proporciona
        if ($request->filled('password')) {
            $rules['password'] = 'min:8|confirmed';
        }

        $validated = $request->validate($rules);

        // Actualizamos los datos
        $usuario->name  = $validated['name'];
        $usuario->email = $validated['email'];
        $usuario->rol   = $validated['rol'];

        // Solo actualizamos la contraseña si se proporcionó una nueva
        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->password);
        }

        $usuario->save();

        return redirect()
            ->route('usuarios.index')
            ->with('success', 'Usuario actualizado exitosamente');
    }

    /**
     * Elimina un usuario
     * RUTA: DELETE /usuarios/{id}
     */
    public function destroy(User $usuario)
    {
        // No permitir eliminar al usuario actual
        if ($usuario->id === auth()->id()) {
            return redirect()
                ->route('usuarios.index')
                ->with('error', 'No puedes eliminar tu propio usuario');
        }

        $usuario->delete();

        return redirect()
            ->route('usuarios.index')
            ->with('success', 'Usuario eliminado exitosamente');
    }
}