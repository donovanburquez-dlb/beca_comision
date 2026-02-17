<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * PROPÓSITO:
     * Agrega la columna 'rol' a la tabla users
     * para controlar qué puede hacer cada usuario
     *
     * ROLES DISPONIBLES:
     * - Administrador → Acceso total
     * - Coordinador   → Ver, crear, editar
     * - Capturista    → Solo crear y editar
     * - Consulta      → Solo ver
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Agregamos la columna 'rol' después de 'name'
            // enum = solo acepta los valores definidos
            // default('Consulta') = si no se especifica, es Consulta
            $table->enum('rol', [
                'Administrador',
                'Coordinador', 
                'Capturista',
                'Consulta'
            ])->default('Consulta')->after('name');
        });
    }

    /**
     * Revertir: eliminar la columna rol
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('rol');
        });
    }
};