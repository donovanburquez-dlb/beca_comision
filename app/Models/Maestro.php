<?php

// Namespace: Ubicación del archivo dentro del proyecto
// Todos los modelos están en App\Models
namespace App\Models;

// Importamos las clases necesarias
use Illuminate\Database\Eloquent\Model;  // Clase base de todos los modelos
use Illuminate\Database\Eloquent\Factories\HasFactory;  // Para crear datos de prueba

/**
 * MODELO: Maestro
 * 
 * PROPÓSITO:
 * Este modelo representa la tabla 'maestros' en la base de datos.
 * Nos permite:
 * - Crear nuevos registros de maestros
 * - Leer datos de maestros
 * - Actualizar información de maestros
 * - Eliminar maestros
 * 
 * CÓMO SE USA:
 * - Maestro::all() → Obtiene todos los maestros
 * - Maestro::find(1) → Obtiene el maestro con ID 1
 * - Maestro::create([...]) → Crea un nuevo maestro
 * - $maestro->update([...]) → Actualiza un maestro
 * - $maestro->delete() → Elimina un maestro
 */
class Maestro extends Model
{
    use HasFactory;  // Trait para usar factories (datos de prueba)

    // ============================================
    // CONFIGURACIÓN DE LA TABLA
    // ============================================
    
    /**
     * El nombre de la tabla en la base de datos
     * 
     * Por defecto Laravel busca la tabla en plural del nombre del modelo.
     * Como el modelo se llama "Maestro", buscaría "maestros" automáticamente.
     * Pero es buena práctica especificarlo explícitamente.
     */
    protected $table = 'maestros';

    /**
     * Campos que se pueden llenar masivamente
     * 
     * $fillable es un array que indica qué campos de la tabla
     * pueden ser llenados cuando creamos o actualizamos registros.
     * 
     * EJEMPLO DE USO:
     * Maestro::create([
     *     'rfc' => 'BAVE750815I64',
     *     'nombres' => 'MARIA ELVIRA',
     *     'apellido' => 'BLANCAS VARGAS'
     * ]);
     * 
     * Solo funcionará si esos campos están en $fillable.
     * Es una protección de seguridad.
     */
    protected $fillable = [
        // Datos personales
        'rfc',                    // RFC del maestro
        'curp',                   // CURP del maestro
        'apellido_paterno',       // Apellido_paterno
        'apellido_materno',       // Apellido_materno
        'nombres',                // Nombres
        'sexo',                   // M o F
        'edad',                   // Edad en años
        'tel_particular',         // Teléfono de casa
        'correo_electronico',     // Email
        'dom_particular',         // Domicilio
        
        // Nivel y adscripción
        'no_nivel',               // Número de nivel
        'nivel',                  // Nivel educativo
        'adscripcion',            // Centro de trabajo
        'localidad',              // Localidad
        'municipio',              // Municipio
        'cct',                    // Clave de Centro de Trabajo
        'tel_adsc',               // Teléfono del CT
        'domicilio_ct',           // Domicilio del CT
        'turno',                  // Turno de trabajo
        
        // Datos de la plaza
        'tipo_funcion',           // Función que desempeña
        'antiguedad_funcion',     // Antigüedad en la función
        'antiguedad_ct',          // Antigüedad en el CT
        'asignatura',             // Materia que imparte
        'horas',                  // Número de horas
        'tipo_plaza',             // Tipo de plaza
        'tipo_sostenimiento',     // Sostenimiento
        'clave_categoria',        // Clave de categoría
        'clave_plaza',            // Clave de plaza
        
        // Instituto y programa
        'instituto',              // Universidad donde estudiará
        'realizar_estudios',      // Descripción del programa
        'pais',                   // País (NACIONAL/EXTRANJERO)
        'inst_nacion',            // Institución nacional
        'nombre_escuela_posgrado',  // Nombre de la escuela
        'cct_escuela_posgrado',   // CCT de la escuela
        'domicilio_escuela_posgrado',  // Domicilio
        
        // Nivel académico
        'nivel_academico',        // MAESTRIA, DOCTORADO, etc
        'clasificacion_reconocimiento',  // Clasificación
        'perfil_aspirante',       // Perfil del aspirante
        'periodicidad_programa',  // SEMESTRE, CUATRIMESTRE
        'periodo_duracion_modulo',  // Duración
        'escolarizado',           // true/false
        'tipo_anuencia',          // Tipo de anuencia
        'revoe',                  // REVOE
        
        // Fechas
        'fechini',                // Fecha inicio
        'fechterm',               // Fecha término
        'fechprorr',              // Primera prórroga
        'fechprorr2',             // Segunda prórroga
        'fechprorr3',             // Tercera prórroga
        'fechprorr4',             // Cuarta prórroga
        'fecha_ini_gral',         // Fecha inicio general
        'fecha_fin_gral',         // Fecha fin general
        'iniciototal',            // Inicio total
        'terminototal',           // Término total
        'fecha_termest',          // Fecha término estudios
        
        // Documentación
        'oficio_autorizacion',    // Oficio
        'num_of',                 // Número de oficio
        'fecha_elab',             // Fecha elaboración
        'carta_compromiso',       // Carta compromiso
        'requisitos',             // Requisitos
        'anuencia',               // Anuencia
        'folio',                  // Folio
        
        // Documentos académicos
        'cedula_profesional',     // Cédula
        'carta_pasante',          // Carta de pasante
        'no_titulado',            // ¿No titulado?
        'nombre_escuela_egreso',  // Escuela de egreso
        'cct_escuela_egreso',     // CCT egreso
        'facultad_egreso',        // Facultad
        'nombre_licenciatura_egreso',  // Licenciatura
        
        // Calificaciones
        'calif1', 'calif2', 'calif3', 'calif4',
        'calif5', 'calif6', 'calif7', 'calif8',
        
        // Avances
        'avan_1', 'avan_2', 'avan_3',
        'avan_4', 'avan_5', 'avan_6',
        
        // Informes
        'infsem_1', 'infsem_2', 'infsem_3', 'infsem_4', 'infsem_5',
        'infsem_6', 'infsem_7', 'infsem_8', 'infsem_9', 'infsem_10',
        'num_inf_entregar',       // Número de informes
        
        // Periodos
        'periodoqna1',            // Periodo quinquenal 1
        'periodoqna2',            // Periodo quinquenal 2
        'periodo_beca_anterior',  // Periodo beca anterior
        'ciclo_escolar_anterior', // Ciclo anterior
        'periodo_licencia',       // Periodo de licencia
        
        // Estados y control
        'movimiento',             // Tipo de movimiento
        'activo',                 // ¿Activo?
        'mot_bec',                // Motivo de beca
        'beca',                   // ¿Es beca?
        'inact_nomina',           // ¿Inactivo en nómina?
        'etiqueta',               // Etiqueta
        
        // Observaciones
        'observaciones',          // Observaciones
        'observ',                 // Observación 2
        'observ_2',               // Observación 3
        'observ_general',         // Observación general
        'observacion_comite',     // Observación del comité
        
        // Campos adicionales
        'propone',                // Quién propone
        'archivo',                // Archivo
        'layout',                 // Layout
        'titulo'                  // Título
    ];

    /**
     * Casts: Conversión automática de tipos de datos
     * 
     * Laravel automáticamente convertirá estos campos al tipo especificado
     * cuando los leas de la base de datos o los guardes.
     * 
     * EJEMPLOS:
     * - 'date' → Convierte string a objeto Carbon (fechas)
     * - 'boolean' → Convierte 0/1 a true/false
     * - 'decimal:2' → Convierte a número con 2 decimales
     * 
     * USO:
     * $maestro->fechini          // Retorna un objeto Carbon
     * $maestro->fechini->format('d/m/Y')  // "27/01/2026"
     * $maestro->activo           // Retorna true o false (no 1 o 0)
     */
    protected $casts = [
        // Convertir fechas a objetos Carbon
        // Carbon nos permite manipular fechas fácilmente
        'fechini' => 'date',
        'fechterm' => 'date',
        'fechprorr' => 'date',
        'fechprorr2' => 'date',
        'fechprorr3' => 'date',
        'fechprorr4' => 'date',
        'fecha_ini_gral' => 'date',
        'fecha_fin_gral' => 'date',
        'iniciototal' => 'date',
        'terminototal' => 'date',
        'fecha_termest' => 'date',
        'fecha_elab' => 'date',
        
        // Convertir a booleanos (true/false)
        'activo' => 'boolean',           // En BD: 1/0, en PHP: true/false
        'beca' => 'boolean',
        'inact_nomina' => 'boolean',
        'no_titulado' => 'boolean',
        'escolarizado' => 'boolean',
        
        // Convertir calificaciones a decimales con 2 decimales
        'calif1' => 'decimal:2',
        'calif2' => 'decimal:2',
        'calif3' => 'decimal:2',
        'calif4' => 'decimal:2',
        'calif5' => 'decimal:2',
        'calif6' => 'decimal:2',
        'calif7' => 'decimal:2',
        'calif8' => 'decimal:2',
    ];

    // ============================================
    // ACCESSORS (Atributos Computados)
    // ============================================
    
    /**
     * Accessor: Nombre Completo
     * 
     * Los accessors nos permiten crear atributos "virtuales"
     * que no existen en la base de datos pero que podemos usar.
     * 
     * CONVENCIÓN: get + NombreAtributo + Attribute
     * 
     * USO:
     * $maestro->nombre_completo  // "MARIA ELVIRA BLANCAS VARGAS"
     * 
     * NOTA: Aunque el método se llama getNombreCompletoAttribute,
     * accedemos al valor con $maestro->nombre_completo (en snake_case)
     */
    public function getNombreCompletoAttribute()
    {
        // Concatenamos nombres + apellido
        // trim() quita espacios al inicio y final
        return trim("{$this->nombres} {$this->apellido_paterno} {$this->apellido_materno}");
    }

    /**
     * Accessor: Duración en Meses
     * 
     * Calcula cuántos meses dura la beca
     * desde fechini hasta fechterm
     * 
     * USO:
     * $maestro->duracion_meses  // 24 (meses)
     */
    public function getDuracionMesesAttribute()
    {
        // Verificamos que existan ambas fechas
        if ($this->fechini && $this->fechterm) {
            // diffInMonths es un método de Carbon
            // Calcula la diferencia en meses entre dos fechas
            return $this->fechini->diffInMonths($this->fechterm);
        }
        
        // Si no hay fechas, retornamos 0
        return 0;
    }

    /**
     * Accessor: Periodo Formateado
     * 
     * Retorna el periodo en formato legible
     * 
     * USO:
     * $maestro->periodo_formateado  // "01/06/2024 - 31/12/2024"
     */
    public function getPeriodoFormateadoAttribute()
    {
        // Verificamos que existan las fechas
        if ($this->fechini && $this->fechterm) {
            // format('d/m/Y') formatea la fecha
            // d = día con 2 dígitos
            // m = mes con 2 dígitos
            // Y = año con 4 dígitos
            $inicio = $this->fechini->format('d/m/Y');
            $fin = $this->fechterm->format('d/m/Y');
            
            return "{$inicio} - {$fin}";
        }
        
        return 'Sin periodo definido';
    }

    // ============================================
    // SCOPES (Consultas Reutilizables)
    // ============================================
    
    /**
     * Scope: Activos
     * 
     * Los scopes son consultas reutilizables que podemos usar
     * para filtrar registros fácilmente.
     * 
     * CONVENCIÓN: scope + NombreScope
     * 
     * USO:
     * Maestro::activos()->get()  // Solo maestros activos
     * 
     * PARÁMETROS:
     * $query - El constructor de consultas de Eloquent
     */
    public function scopeActivos($query)
    {
        // where('activo', true) filtra solo los activos
        // Retorna la consulta para poder encadenar más métodos
        return $query->where('activo', true);
    }

    /**
     * Scope: Por Nivel
     * 
     * Filtra maestros por nivel educativo
     * 
     * USO:
     * Maestro::porNivel('SECUNDARIAS GENERALES')->get()
     */
    public function scopePorNivel($query, $nivel)
    {
        // where('nivel', $nivel) busca registros con ese nivel exacto
        return $query->where('nivel', $nivel);
    }

    /**
     * Scope: En Beca (periodo actual)
     * 
     * Filtra maestros que están actualmente en beca
     * (su periodo incluye la fecha de hoy)
     * 
     * USO:
     * Maestro::enBeca()->get()
     */
    public function scopeEnBeca($query)
    {
        // today() obtiene la fecha de hoy
        $hoy = today();
        
        // Filtramos donde:
        // - La fecha de inicio sea menor o igual a hoy
        // - La fecha de término sea mayor o igual a hoy
        // - Esté activo
        return $query->where('fechini', '<=', $hoy)
                    ->where('fechterm', '>=', $hoy)
                    ->where('activo', true);
    }

    /**
     * Scope: Buscar por Texto
     * 
     * Busca maestros por RFC, CURP, nombre o apellido
     * 
     * USO:
     * Maestro::buscar('MARIA')->get()
     */
    public function scopeBuscar($query, $texto)
    {
        // Si no hay texto, retornamos la consulta sin filtros
        if (empty($texto)) {
            return $query;
        }

        // Convertimos el texto a mayúsculas para buscar
        $texto = strtoupper($texto);

        // where(function($q) {...}) crea un grupo de condiciones
        // Es como poner paréntesis en SQL: WHERE (condicion1 OR condicion2 OR ...)
        return $query->where(function($q) use ($texto) {
            $q->where('rfc', 'LIKE', "%{$texto}%")           // Busca en RFC
              ->orWhere('curp', 'LIKE', "%{$texto}%")        // O en CURP
              ->orWhere('nombres', 'LIKE', "%{$texto}%")     // O en nombres
              ->orWhere('apellido_paterno', 'LIKE', "%{$texto}%")   // O en apellido_paterno
              ->orWhere('apellido_materno', 'LIKE', "%{$texto}%");   // O en apellido_materno
        });
        
        // LIKE "%texto%" busca el texto en cualquier parte del campo
        // Ejemplo: LIKE "%MARIA%" encuentra "MARIA", "MARIA ELVIRA", "ANA MARIA"
    }

    // ============================================
    // MÉTODOS AUXILIARES
    // ============================================
    
    /**
     * Verifica si el maestro está actualmente en beca
     * 
     * USO:
     * if ($maestro->estaEnBeca()) {
     *     echo "Está en beca actualmente";
     * }
     * 
     * RETORNA: boolean (true o false)
     */
    public function estaEnBeca()
    {
        // Si no tiene fechas, no está en beca
        if (!$this->fechini || !$this->fechterm) {
            return false;
        }

        // Obtenemos la fecha de hoy
        $hoy = today();

        // Verificamos si hoy está entre fechini y fechterm
        // isBetween es un método de Carbon
        return $hoy->isBetween($this->fechini, $this->fechterm) 
               && $this->activo;
    }

    /**
     * Calcula los días restantes de la beca
     * 
     * USO:
     * $maestro->diasRestantes()  // 180
     * 
     * RETORNA: int (número de días)
     */
    public function diasRestantes()
    {
        // Si no hay fecha de término o no está activo, retorna 0
        if (!$this->fechterm || !$this->activo) {
            return 0;
        }

        $hoy = today();

        // Si ya pasó la fecha de término, retorna 0
        if ($hoy->isAfter($this->fechterm)) {
            return 0;
        }

        // diffInDays calcula la diferencia en días
        return $hoy->diffInDays($this->fechterm);
    }

    /**
     * Obtiene el promedio de calificaciones
     * 
     * USO:
     * $maestro->promedioCalificaciones()  // 9.65
     * 
     * RETORNA: float (promedio con 2 decimales)
     */
    public function promedioCalificaciones()
    {
        // Creamos un array con todas las calificaciones
        $calificaciones = [
            $this->calif1,
            $this->calif2,
            $this->calif3,
            $this->calif4,
            $this->calif5,
            $this->calif6,
            $this->calif7,
            $this->calif8,
        ];

        // Filtramos solo las que no son null
        // array_filter elimina valores null/vacíos
        $calificaciones = array_filter($calificaciones, function($calif) {
            return $calif !== null;
        });

        // Si no hay calificaciones, retornamos 0
        if (empty($calificaciones)) {
            return 0;
        }

        // Calculamos el promedio
        // array_sum suma todos los valores
        // count cuenta cuántos elementos hay
        $promedio = array_sum($calificaciones) / count($calificaciones);

        // round redondea a 2 decimales
        return round($promedio, 2);
    }

    /**
     * RELACIÓN: Un maestro puede tener uno o varios sustitutos cubriendo su plaza
     */
    public function sustitutos()
    {
        return $this->hasMany(Sustituto::class);
    }

}