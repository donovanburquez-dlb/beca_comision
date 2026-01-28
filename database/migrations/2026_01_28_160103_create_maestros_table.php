<?php

// Importamos las clases necesarias para crear migraciones
use Illuminate\Database\Migrations\Migration;  // Clase base para migraciones
use Illuminate\Database\Schema\Blueprint;      // Clase para definir estructura de tablas
use Illuminate\Support\Facades\Schema;         // Clase para interactuar con el esquema de la BD

// Creamos una migración anónima (nueva forma de Laravel)
return new class extends Migration
{
    /**
     * Run the migrations.
     * Este método se ejecuta cuando corremos: php artisan migrate
     * Aquí CREAMOS la tabla
     */
    public function up(): void
    {
        // Schema::create crea una nueva tabla llamada 'maestros'
        Schema::create('maestros', function (Blueprint $table) {
            
            // ============================================
            // CAMPO ID (Clave primaria autoincremental)
            // ============================================
            // Este campo se crea automáticamente como:
            // - Unsigned Big Integer (número entero grande sin signo)
            // - Auto incrementable (1, 2, 3, 4...)
            // - Primary Key (llave primaria única)
            $table->id();
            
            
            // ============================================
            // SECCIÓN 1: DATOS PERSONALES DEL MAESTRO
            // ============================================
            
            // RFC: Registro Federal de Contribuyentes
            // - string('nombre_campo', tamaño_máximo)
            // - unique() = No se pueden repetir RFCs
            // Ejemplo: 'BAVE750815I64'
            $table->string('rfc', 13)->unique();
            
            // CURP: Clave Única de Registro de Población
            // - 18 caracteres máximo
            // - También debe ser único
            // Ejemplo: 'BAVE750815MHGLRL03'
            $table->string('curp', 18)->unique();
            
            // Apellidos del maestro
            // Ejemplo: 'BLANCAS VARGAS'
            $table->string('apellido', 100);
            
            // Nombres del maestro
            // Ejemplo: 'MARIA ELVIRA'
            $table->string('nombres', 100);
            
            // Sexo del maestro
            // - enum = campo que solo acepta valores específicos
            // - nullable() = puede estar vacío
            // Valores permitidos: 'M' o 'F'
            $table->enum('sexo', ['M', 'F'])->nullable();
            
            // Edad del maestro
            // - integer = número entero
            // - nullable() = puede estar vacío
            $table->integer('edad')->nullable();
            
            // Teléfono particular del maestro
            // Ejemplo: '7711542147'
            $table->string('tel_particular', 15)->nullable();
            
            // Correo electrónico
            // Ejemplo: 'blancaselvira0@gmail.com'
            $table->string('correo_electronico', 150)->nullable();
            
            // Domicilio particular
            // - text = campo de texto largo (sin límite específico)
            // Ejemplo: '132 FRACC. VISTA HERMOSA PACHUCA HGO.'
            $table->text('dom_particular')->nullable();
            
            
            // ============================================
            // SECCIÓN 2: NIVEL Y ADSCRIPCIÓN (DONDE TRABAJA)
            // ============================================
            
            // Número de nivel
            // Ejemplo: '4'
            $table->string('no_nivel', 10)->nullable();
            
            // Nivel educativo
            // Ejemplo: 'SECUNDARIAS GENERALES'
            $table->string('nivel', 100)->nullable();
            
            // Centro de trabajo donde está adscrito
            // Ejemplo: 'ESC. SEC. GRAL. "VICENTE GUERRERO"'
            $table->string('adscripcion', 200)->nullable();
            
            // Localidad donde trabaja
            // Ejemplo: 'CHICAVASCO'
            $table->string('localidad', 100)->nullable();
            
            // Municipio
            // Ejemplo: 'ACTOPAN'
            $table->string('municipio', 100)->nullable();
            
            // CCT: Clave de Centro de Trabajo
            // Ejemplo: '13DES0085R'
            $table->string('cct', 15)->nullable();
            
            // Teléfono del centro de adscripción
            $table->string('tel_adsc', 15)->nullable();
            
            // Domicilio del centro de trabajo
            $table->string('domicilio_ct', 250)->nullable();
            
            // Turno de trabajo
            // Ejemplo: 'MATUTINO', 'VESPERTINO', 'NOCTURNO'
            $table->string('turno', 20)->nullable();
            
            
            // ============================================
            // SECCIÓN 3: DATOS DE LA PLAZA
            // ============================================
            
            // Tipo de función que desempeña
            $table->string('tipo_funcion', 100)->nullable();
            
            // Antigüedad en la función
            // Ejemplo: '6 AÑOS'
            $table->string('antiguedad_funcion', 50)->nullable();
            
            // Antigüedad en el centro de trabajo
            // Ejemplo: '9 MESES'
            $table->string('antiguedad_ct', 50)->nullable();
            
            // Asignatura que imparte
            $table->string('asignatura', 150)->nullable();
            
            // Número de horas
            // - integer = número entero
            // - default(0) = si no se proporciona, vale 0
            // Ejemplo: 16
            $table->integer('horas')->default(0);
            
            // Tipo de plaza
            $table->string('tipo_plaza', 50)->nullable();
            
            // Tipo de sostenimiento (federal, estatal, particular)
            $table->string('tipo_sostenimiento', 50)->nullable();
            
            // Clave de la categoría
            // Ejemplo: 'E0363'
            $table->string('clave_categoria', 50)->nullable();
            
            // Clave de la plaza
            // Ejemplo: '078613E036316.0130094'
            $table->string('clave_plaza', 50)->nullable();
            
            
            // ============================================
            // SECCIÓN 4: INSTITUTO Y PROGRAMA DE ESTUDIOS
            // ============================================
            
            // Instituto donde realizará los estudios
            // Ejemplo: 'UNIVERSIDAD INTERAMERICANA PARA EL DESARROLLO'
            $table->string('instituto', 200)->nullable();
            
            // Descripción de los estudios a realizar
            // - text = campo largo para descripciones
            // Ejemplo: 'REALIZAR ESTUDIOS DE...'
            $table->text('realizar_estudios')->nullable();
            
            // País donde estudiará
            // - default('NACIONAL') = por defecto es NACIONAL
            $table->string('pais', 50)->default('NACIONAL');
            
            // Institución nacional
            $table->string('inst_nacion', 200)->nullable();
            
            // Nombre de la escuela de posgrado
            $table->string('nombre_escuela_posgrado', 250)->nullable();
            
            // CCT de la escuela de posgrado
            // Ejemplo: '13PSU01420'
            $table->string('cct_escuela_posgrado', 20)->nullable();
            
            // Domicilio de la escuela de posgrado
            $table->text('domicilio_escuela_posgrado')->nullable();
            
            
            // ============================================
            // SECCIÓN 5: NIVEL ACADÉMICO Y TIPO DE PROGRAMA
            // ============================================
            
            // Nivel académico a cursar
            // Ejemplo: 'DOCTORADO', 'MAESTRIA', 'LICENCIATURA'
            $table->string('nivel_academico', 100)->nullable();
            
            // Clasificación del reconocimiento
            $table->string('clasificacion_reconocimiento', 100)->nullable();
            
            // Perfil del aspirante
            // Ejemplo: 'MAESTRA EN EDUCACION'
            $table->string('perfil_aspirante', 200)->nullable();
            
            // Periodicidad del programa
            // Ejemplo: 'SEMESTRE', 'CUATRIMESTRE'
            $table->string('periodicidad_programa', 50)->nullable();
            
            // Periodo de duración del módulo
            // Ejemplo: '2 AÑOS 6 MESES'
            $table->string('periodo_duracion_modulo', 50)->nullable();
            
            // ¿Es escolarizado?
            // - boolean = campo verdadero/falso (true/false)
            // - default(true) = por defecto es verdadero
            $table->boolean('escolarizado')->default(true);
            
            // Tipo de anuencia
            $table->string('tipo_anuencia', 50)->nullable();
            
            // REVOE: Reconocimiento de Validez Oficial de Estudios
            $table->string('revoe', 100)->nullable();
            
            
            // ============================================
            // SECCIÓN 6: FECHAS IMPORTANTES
            // ============================================
            
            // Fecha de inicio de la beca
            // - date = campo de tipo fecha (YYYY-MM-DD)
            // - nullable() = puede estar vacío
            // Ejemplo: '2024-06-01'
            $table->date('fechini')->nullable();
            
            // Fecha de término de la beca
            // Ejemplo: '2024-12-31'
            $table->date('fechterm')->nullable();
            
            // Fecha de primera prórroga
            $table->date('fechprorr')->nullable();
            
            // Fecha de segunda prórroga
            $table->date('fechprorr2')->nullable();
            
            // Fecha de tercera prórroga
            $table->date('fechprorr3')->nullable();
            
            // Fecha de cuarta prórroga
            $table->date('fechprorr4')->nullable();
            
            // Fecha de inicio general
            $table->date('fecha_ini_gral')->nullable();
            
            // Fecha de fin general
            $table->date('fecha_fin_gral')->nullable();
            
            // Fecha de inicio total
            $table->date('iniciototal')->nullable();
            
            // Fecha de término total
            $table->date('terminototal')->nullable();
            
            // Fecha de término de estudios
            $table->date('fecha_termest')->nullable();
            
            
            // ============================================
            // SECCIÓN 7: DOCUMENTACIÓN Y OFICIOS
            // ============================================
            
            // Oficio de autorización
            $table->string('oficio_autorizacion', 100)->nullable();
            
            // Número de oficio
            // Ejemplo: '1987'
            $table->string('num_of', 50)->nullable();
            
            // Fecha de elaboración del oficio
            // Ejemplo: '2025-12-02'
            $table->date('fecha_elab')->nullable();
            
            // Carta compromiso
            $table->string('carta_compromiso', 100)->nullable();
            
            // Requisitos
            // Ejemplo: 'CARTA DE ACEPTACIÓN COMO ALUMNO REGULAR'
            $table->string('requisitos', 200)->nullable();
            
            // Anuencia
            $table->string('anuencia', 100)->nullable();
            
            // Folio
            $table->string('folio', 50)->nullable();
            
            
            // ============================================
            // SECCIÓN 8: DOCUMENTOS ACADÉMICOS DEL MAESTRO
            // ============================================
            
            // Cédula profesional
            $table->string('cedula_profesional', 50)->nullable();
            
            // Carta de pasante
            $table->string('carta_pasante', 100)->nullable();
            
            // ¿No está titulado?
            // - boolean = verdadero/falso
            // - default(false) = por defecto NO (sí está titulado)
            $table->boolean('no_titulado')->default(false);
            
            // Nombre de la escuela de egreso (licenciatura)
            $table->string('nombre_escuela_egreso', 200)->nullable();
            
            // CCT de la escuela de egreso
            $table->string('cct_escuela_egreso', 20)->nullable();
            
            // Facultad de egreso
            // Ejemplo: 'EDUCACION'
            $table->string('facultad_egreso', 150)->nullable();
            
            // Nombre de la licenciatura de egreso
            // Ejemplo: 'MAESTRIA EN EDUCACION'
            $table->string('nombre_licenciatura_egreso', 200)->nullable();
            
            
            // ============================================
            // SECCIÓN 9: CALIFICACIONES
            // ============================================
            
            // Calificación 1
            // - decimal(5, 2) = número decimal con 5 dígitos totales, 2 después del punto
            // - Puede almacenar: 999.99
            // - nullable() = puede estar vacío
            // Ejemplo: 9.30, 10.00
            $table->decimal('calif1', 5, 2)->nullable();
            $table->decimal('calif2', 5, 2)->nullable();
            $table->decimal('calif3', 5, 2)->nullable();
            $table->decimal('calif4', 5, 2)->nullable();
            $table->decimal('calif5', 5, 2)->nullable();
            $table->decimal('calif6', 5, 2)->nullable();
            $table->decimal('calif7', 5, 2)->nullable();
            $table->decimal('calif8', 5, 2)->nullable();
            
            
            // ============================================
            // SECCIÓN 10: AVANCES
            // ============================================
            
            // Avance 1, 2, 3... (porcentajes o estados de avance)
            $table->string('avan_1', 100)->nullable();
            $table->string('avan_2', 100)->nullable();
            $table->string('avan_3', 100)->nullable();
            $table->string('avan_4', 100)->nullable();
            $table->string('avan_5', 100)->nullable();
            $table->string('avan_6', 100)->nullable();
            
            
            // ============================================
            // SECCIÓN 11: INFORMES SEMESTRALES
            // ============================================
            
            // Informe semestral 1, 2, 3...
            $table->string('infsem_1', 100)->nullable();
            $table->string('infsem_2', 100)->nullable();
            $table->string('infsem_3', 100)->nullable();
            $table->string('infsem_4', 100)->nullable();
            $table->string('infsem_5', 100)->nullable();
            $table->string('infsem_6', 100)->nullable();
            $table->string('infsem_7', 100)->nullable();
            $table->string('infsem_8', 100)->nullable();
            $table->string('infsem_9', 100)->nullable();
            $table->string('infsem_10', 100)->nullable();
            
            // Número de informes por entregar
            // - integer = número entero
            // - default(0) = por defecto 0
            $table->integer('num_inf_entregar')->default(0);
            
            
            // ============================================
            // SECCIÓN 12: PERIODOS Y QUINQUENIOS
            // ============================================
            
            // Periodo quinquenal 1
            // Ejemplo: 'ene26', 'jun26'
            $table->string('periodoqna1', 50)->nullable();
            
            // Periodo quinquenal 2
            $table->string('periodoqna2', 50)->nullable();
            
            // Periodo de beca anterior
            $table->string('periodo_beca_anterior', 100)->nullable();
            
            // Ciclo escolar anterior
            $table->string('ciclo_escolar_anterior', 50)->nullable();
            
            // Periodo de licencia
            // Ejemplo: '01-06-2024 / 31-07-2026'
            $table->string('periodo_licencia', 100)->nullable();
            
            
            // ============================================
            // SECCIÓN 13: ESTADOS Y CONTROL
            // ============================================
            
            // Tipo de movimiento
            // Ejemplo: 'PRÓRROGA', 'NUEVA', 'RENOVACIÓN'
            $table->string('movimiento', 50)->nullable();
            
            // ¿Está activo?
            // - boolean = verdadero/falso
            // - default(true) = por defecto está activo
            $table->boolean('activo')->default(true);
            
            // Motivo de la beca
            // Ejemplo: 'BECA'
            $table->string('mot_bec', 100)->nullable();
            
            // ¿Es beca?
            $table->boolean('beca')->default(true);
            
            // ¿Está inactivo en nómina?
            $table->boolean('inact_nomina')->default(false);
            
            // Etiqueta de clasificación
            $table->string('etiqueta', 100)->nullable();
            
            
            // ============================================
            // SECCIÓN 14: OBSERVACIONES
            // ============================================
            
            // Observaciones generales
            // - text = campo de texto largo (sin límite específico)
            // Puedes escribir párrafos completos
            $table->text('observaciones')->nullable();
            
            // Observación adicional
            $table->text('observ')->nullable();
            
            // Observación 2
            $table->text('observ_2')->nullable();
            
            // Observación general del expediente
            $table->text('observ_general')->nullable();
            
            // Observación del comité
            $table->text('observacion_comite')->nullable();
            
            
            // ============================================
            // SECCIÓN 15: CAMPOS ADICIONALES
            // ============================================
            
            // Quién propone
            // Ejemplo: 'Roberto Rodriguez Chabelas.- Director de Educación Secundaria General'
            $table->string('propone', 100)->nullable();
            
            // Nombre del archivo adjunto
            $table->string('archivo', 150)->nullable();
            
            // Layout de algún documento
            $table->string('layout', 100)->nullable();
            
            // Título obtenido o a obtener
            $table->string('titulo', 200)->nullable();
            
            
            // ============================================
            // TIMESTAMPS (Marcas de tiempo automáticas)
            // ============================================
            
            // Esto crea DOS campos automáticamente:
            // - created_at: fecha/hora cuando se CREA el registro
            // - updated_at: fecha/hora cuando se ACTUALIZA el registro
            // Laravel actualiza estos campos automáticamente
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * Este método se ejecuta cuando corremos: php artisan migrate:rollback
     * Aquí ELIMINAMOS la tabla
     */
    public function down(): void
    {
        // Schema::dropIfExists elimina la tabla si existe
        // Se usa en rollback para revertir los cambios
        Schema::dropIfExists('maestros');
    }
};