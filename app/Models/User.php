<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'rol',  // ← Agregamos el campo rol
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ============================================
    // MÉTODOS DE ROLES
    // ============================================

    /**
     * ¿Es Administrador?
     * Tiene acceso TOTAL al sistema
     *
     * USO: if (auth()->user()->esAdministrador()) { ... }
     */
    public function esAdministrador(): bool
    {
        return $this->rol === 'Administrador';
    }

    /**
     * ¿Es Coordinador?
     * Puede ver, crear y editar, pero NO eliminar
     * ni gestionar usuarios
     */
    public function esCoordinador(): bool
    {
        return $this->rol === 'Coordinador';
    }

    /**
     * ¿Es Capturista?
     * Solo puede crear y editar registros
     */
    public function esCapturista(): bool
    {
        return $this->rol === 'Capturista';
    }

    /**
     * ¿Es Consulta?
     * Solo puede VER registros, no modificar nada
     */
    public function esConsulta(): bool
    {
        return $this->rol === 'Consulta';
    }

    // ============================================
    // MÉTODOS DE PERMISOS
    // ============================================

    /**
     * ¿Puede ver maestros?
     * Todos los roles pueden ver
     */
    public function puedeVerMaestros(): bool
    {
        return in_array($this->rol, [
            'Administrador',
            'Coordinador',
            'Capturista',
            'Consulta'
        ]);
    }

    /**
     * ¿Puede crear maestros?
     * Todos menos Consulta
     */
    public function puedeCrearMaestros(): bool
    {
        return in_array($this->rol, [
            'Administrador',
            'Coordinador',
            'Capturista'
        ]);
    }

    /**
     * ¿Puede editar maestros?
     * Todos menos Consulta
     */
    public function puedeEditarMaestros(): bool
    {
        return in_array($this->rol, [
            'Administrador',
            'Coordinador',
            'Capturista'
        ]);
    }

    /**
     * ¿Puede eliminar maestros?
     * Solo Administrador
     */
    public function puedeEliminarMaestros(): bool
    {
        return $this->rol === 'Administrador';
    }

    /**
     * ¿Puede gestionar usuarios?
     * Solo Administrador
     */
    public function puedeGestionarUsuarios(): bool
    {
        return $this->rol === 'Administrador';
    }
}