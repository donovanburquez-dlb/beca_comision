<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('sustitutos', function (Blueprint $table) {
        $table->id();
        
        // La "Llave Foránea" que conecta al sustituto con el maestro que se fue de beca
        $table->foreignId('maestro_id')->constrained('maestros')->onDelete('cascade');
        
        // Datos del Sustituto
        $table->string('rfc')->nullable(); // Opcional, pero recomendado
        $table->string('nombre_completo'); // Equivalente a la columna SUSTITUTOS de tu Access
        
        // El periodo que va a cubrir (Equivalente a DESDE y HASTA)
        $table->date('fecha_inicio');
        $table->date('fecha_termino');
        
        // Datos extra útiles
        $table->string('telefono')->nullable();
        $table->string('estatus')->default('ACTIVO'); // ACTIVO, BAJA, FINALIZADO
        $table->text('observaciones')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sustitutos');
    }
};
