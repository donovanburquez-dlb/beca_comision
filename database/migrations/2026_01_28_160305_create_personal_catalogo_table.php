<?php

// Importamos las clases necesarias
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * TABLA: personal_catalogo
     * 
     * PROPÓSITO: Esta tabla almacena el catálogo general de personal
     * Cuando el operador ingresa un RFC, el sistema busca aquí y
     * autocompleta los datos del maestro.
     * 
     * Es como una "base de datos maestra" de todos los empleados.
     */
    public function up(): void
    {
        Schema::create('personal_catalogo', function (Blueprint $table) {
            
            // ID único autoincremental
            $table->id();
            
            // ============================================
            // DATOS IDENTIFICADORES (ÚNICOS)
            // ============================================
            
            // RFC: Debe ser único, no se puede repetir
            // Cuando busquemos por RFC, encontraremos exactamente 1 registro
            $table->string('rfc', 13)->unique();
            
            // CURP: También único
            $table->string('curp', 18)->unique();
            
            
            // ============================================
            // DATOS PERSONALES BÁSICOS
            // ============================================
            
            // Apellidos del empleado
            $table->string('apellido_paterno', 50);
            $table->string('apellido_materno', 50);
            
            // Nombres del empleado
            $table->string('nombres', 100);
            
            // Sexo: M o F
            $table->enum('sexo', ['M', 'F']);
            
            // Edad (puede ser null si no se conoce)
            $table->integer('edad')->nullable();
            
            // Teléfono particular
            $table->string('tel_particular', 15)->nullable();
            
            // Correo electrónico
            $table->string('correo', 150)->nullable();
            
            // Domicilio completo
            $table->text('domicilio')->nullable();
            
            
            // ============================================
            // DATOS LABORALES (DONDE TRABAJA)
            // ============================================
            
            // CCT: Clave del Centro de Trabajo
            $table->string('cct', 15)->nullable();
            
            // Nombre del centro de trabajo
            // Ejemplo: "ESC. SEC. GRAL. VICENTE GUERRERO"
            $table->string('centro_trabajo', 200)->nullable();
            
            // Nivel educativo donde labora
            // Ejemplo: "SECUNDARIAS GENERALES"
            $table->string('nivel', 100)->nullable();
            
            // Localidad
            $table->string('localidad', 100)->nullable();
            
            // Municipio
            $table->string('municipio', 100)->nullable();
            
            // Turno de trabajo
            // Ejemplo: "MATUTINO", "VESPERTINO"
            $table->string('turno', 20)->nullable();
            
            // Asignatura que imparte
            $table->string('asignatura', 150)->nullable();
            
            // Número de horas de la plaza
            $table->integer('horas')->default(0);
            
            // Clave de la plaza
            $table->string('clave_plaza', 50)->nullable();
            
            
            // ============================================
            // TIMESTAMPS
            // ============================================
            
            // created_at y updated_at automáticos
            $table->timestamps();
        });
    }

    /**
     * Revertir la migración (eliminar la tabla)
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_catalogo');
    }
};