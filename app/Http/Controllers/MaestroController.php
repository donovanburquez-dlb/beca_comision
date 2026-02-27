<?php

// Namespace: Ubicación del archivo
namespace App\Http\Controllers;

// Importamos las clases que necesitaremos
use App\Models\Maestro;              // Modelo de Maestros
use App\Models\PersonalCatalogo;     // Modelo del catálogo de personal
use Illuminate\Http\Request;         // Clase para manejar peticiones HTTP

/**
 * CONTROLADOR: MaestroController
 * 
 * PROPÓSITO:
 * Este controlador maneja TODAS las operaciones relacionadas con maestros:
 * - Ver lista de maestros (index)
 * - Mostrar formulario de crear (create)
 * - Guardar nuevo maestro (store)
 * - Ver detalle de un maestro (show)
 * - Mostrar formulario de editar (edit)
 * - Actualizar maestro (update)
 * - Eliminar maestro (destroy)
 * - Buscar por RFC para autocompletar (buscarPorRfc)
 * 
 * FLUJO TÍPICO:
 * 1. Usuario va a /maestros → método index()
 * 2. Usuario da clic en "Nuevo" → método create()
 * 3. Usuario ingresa RFC y da "Buscar" → método buscarPorRfc() [AJAX]
 * 4. Usuario llena formulario y da "Guardar" → método store()
 * 5. Sistema muestra el maestro guardado → método show()
 */
class MaestroController extends Controller
{
    /**
     * ============================================
     * MÉTODO: index
     * ============================================
     * 
     * PROPÓSITO:
     * Muestra la lista de TODOS los maestros registrados
     * 
     * RUTA: GET /maestros
     * 
     * QUÉ HACE:
     * 1. Obtiene todos los maestros de la base de datos
     * 2. Los ordena por apellido (alfabéticamente)
     * 3. Aplica paginación (20 registros por página)
     * 4. Envía los datos a la vista
     * 
     * RETORNA:
     * Vista 'maestros.index' con la lista de maestros
     */
    public function index(Request $request)
    {
        // Iniciamos la consulta a la base de datos
        // Maestro::query() crea un constructor de consultas
        $query = Maestro::query();

        // ============================================
        // BÚSQUEDA (si el usuario escribió algo)
        // ============================================
        
        // $request->search contiene lo que el usuario escribió en el buscador
        // filled() verifica si el campo existe Y tiene valor (no está vacío)
        if ($request->filled('search')) {
            // Obtenemos el texto de búsqueda
            $search = $request->search;
            
            // Usamos el scope 'buscar' que definimos en el modelo
            // Este scope busca en RFC, CURP, nombres y apellido
            $query->buscar($search);
        }

        // ============================================
        // FILTRO POR NIVEL (si el usuario seleccionó uno)
        // ============================================
        
        if ($request->filled('nivel')) {
            // Filtramos por el nivel seleccionado
            $query->where('nivel', $request->nivel);
        }

        // ============================================
        // FILTRO POR ESTADO (activo/inactivo)
        // ============================================
        
        if ($request->filled('activo')) {
            // $request->activo será '1' (activo) o '0' (inactivo)
            $query->where('activo', $request->activo);
        }

        // ============================================
        // ORDENAMIENTO Y PAGINACIÓN
        // ============================================
        
        // Ordenamos por apellido de forma ascendente (A-Z)
        // orderBy('campo', 'dirección')
        // Dirección puede ser: 'asc' (ascendente) o 'desc' (descendente)
        $query->orderBy('apellido_paterno', 'asc');
        $query->orderBy('apellido_materno', 'asc');
        
        // Agregamos ordenamiento secundario por nombres
        // Si dos personas tienen el mismo apellido, se ordenan por nombre
        $query->orderBy('nombres', 'asc');

        // paginate(20) divide los resultados en páginas de 20 registros
        // Automáticamente detecta en qué página está el usuario
        // También genera los enlaces de navegación (1, 2, 3, ...)
        $maestros = $query->paginate(20);

        // ============================================
        // OBTENER NIVELES ÚNICOS (para el filtro)
        // ============================================
        
        // Obtenemos todos los niveles distintos que existen
        // pluck('nivel') obtiene solo la columna 'nivel'
        // unique() elimina duplicados
        // filter() elimina valores null/vacíos
        // sort() ordena alfabéticamente
        // values() reindexca el array
        $niveles = Maestro::pluck('nivel')
                          ->unique()
                          ->filter()
                          ->sort()
                          ->values();

        // ============================================
        // RETORNAR LA VISTA
        // ============================================
        
        // view() carga una vista (archivo blade.php)
        // El primer parámetro es la ruta de la vista: resources/views/maestros/index.blade.php
        // compact() crea un array asociativo con las variables
        // Es equivalente a: ['maestros' => $maestros, 'niveles' => $niveles]
        return view('maestros.index', compact('maestros', 'niveles'));
        
        // En la vista podremos usar: $maestros y $niveles
    }

    /**
     * ============================================
     * MÉTODO: create
     * ============================================
     * 
     * PROPÓSITO:
     * Muestra el formulario para CREAR un nuevo maestro
     * 
     * RUTA: GET /maestros/create
     * 
     * QUÉ HACE:
     * Simplemente muestra el formulario vacío
     * 
     * RETORNA:
     * Vista 'maestros.create' con el formulario
     */
    public function create()
    {
        // Retornamos la vista del formulario de creación
        // resources/views/maestros/create.blade.php
        return view('maestros.create');
    }

    /**
     * ============================================
     * MÉTODO: buscarPorRfc (AJAX)
     * ============================================
     * 
     * PROPÓSITO:
     * Busca un empleado en el catálogo de personal por RFC
     * y retorna sus datos en formato JSON
     * 
     * RUTA: POST /maestros/buscar-rfc (AJAX)
     * 
     * FLUJO:
     * 1. Operador escribe RFC en el formulario
     * 2. Operador da clic en botón "Buscar"
     * 3. JavaScript hace petición AJAX a este método
     * 4. Este método busca en personal_catalogo
     * 5. Retorna los datos en JSON
     * 6. JavaScript llena automáticamente el formulario
     * 
     * PARÁMETROS:
     * Request $request - Contiene los datos enviados (incluyendo 'rfc')
     * 
     * RETORNA:
     * JSON con los datos del empleado o mensaje de error
     */
    public function buscarPorRfc(Request $request)
    {
        // ============================================
        // VALIDACIÓN DEL RFC
        // ============================================
        
        // validate() verifica que los datos cumplan las reglas
        // Si no cumplen, automáticamente retorna un error 422
        $request->validate([
            // Campo 'rfc' es:
            // - required: obligatorio (no puede estar vacío)
            // - string: debe ser texto
            // - max:13: máximo 13 caracteres
            'rfc' => 'required|string|max:13'
        ]);

        // ============================================
        // OBTENER Y LIMPIAR EL RFC
        // ============================================
        
        // Obtenemos el RFC del request
        // trim() quita espacios al inicio y final
        // strtoupper() convierte a mayúsculas
        $rfc = strtoupper(trim($request->rfc));

        // ============================================
        // BUSCAR EN EL CATÁLOGO
        // ============================================
        
        // Buscamos el RFC en la tabla personal_catalogo
        // porRfc() es un scope que definimos en el modelo
        // first() obtiene el primer (y único) resultado
        // Si no encuentra nada, $personal será null
        $personal = PersonalCatalogo::porRfc($rfc)->first();

        // ============================================
        // VERIFICAR SI SE ENCONTRÓ
        // ============================================
        
        if ($personal) {
            // ¡SÍ SE ENCONTRÓ!
            
            // Retornamos una respuesta JSON exitosa
            // response()->json() convierte el array a JSON
            return response()->json([
                'success' => true,  // Indica que fue exitoso
                'message' => 'RFC encontrado',  // Mensaje
                'data' => $personal->datosParaAutocompletar()  // Los datos
            ]);
            
            // La respuesta JSON se verá así:
            // {
            //   "success": true,
            //   "message": "RFC encontrado",
            //   "data": {
            //     "rfc": "BAVE750815I64",
            //     "nombres": "MARIA ELVIRA",
            //     "apellido": "BLANCAS VARGAS",
            //     ...
            //   }
            // }
        }

        // ============================================
        // NO SE ENCONTRÓ
        // ============================================
        
        // Retornamos una respuesta JSON de error
        return response()->json([
            'success' => false,  // Indica que falló
            'message' => 'RFC no encontrado en el catálogo de personal'
        ], 404);  // 404 = Not Found
        
        // El 404 es un código HTTP que indica "no encontrado"
    }

    /**
     * ============================================
     * MÉTODO: store
     * ============================================
     * 
     * PROPÓSITO:
     * Guarda un NUEVO maestro en la base de datos
     * 
     * RUTA: POST /maestros
     * 
     * FLUJO:
     * 1. Usuario llena el formulario
     * 2. Usuario da clic en "Guardar"
     * 3. Formulario envía datos a este método
     * 4. Validamos los datos
     * 5. Guardamos en la base de datos
     * 6. Redirigimos al detalle del maestro
     * 
     * PARÁMETROS:
     * Request $request - Contiene todos los datos del formulario
     * 
     * RETORNA:
     * Redirección a la página de detalle del maestro
     */
    public function store(Request $request)
{
    // ============================================
    // VALIDACIÓN INTEGRAL DE DATOS
    // ============================================
    $validated = $request->validate([
        // Datos Personales
        'rfc'                => 'required|string|max:13|unique:maestros',
        'curp'               => 'required|string|max:18',
        'apellido_paterno'   => 'required|string|max:50',
        'apellido_materno'   => 'required|string|max:50',
        'nombres'            => 'required|string|max:50',
        'sexo'               => 'nullable|string|in:M,F',
        'edad'               => 'nullable|integer',
        'correo_electronico' => 'nullable|email|max:100',
        'tel_particular'     => 'nullable|string|max:20',
        'dom_particular'     => 'nullable|string',

        // Datos de Adscripción (AQUÍ ESTÁ LA CLAVE)
        'clave_plaza'        => 'nullable|string', // Antes se perdía porque no estaba aquí
        'cct'                => 'nullable|string|max:15',
        'nivel'              => 'nullable|string|max:50',
        'adscripcion'        => 'nullable|string|max:255',
        'turno'              => 'nullable|string|max:50',
        'localidad'          => 'nullable|string|max:100',
        'municipio'          => 'nullable|string|max:100',
        'asignatura'         => 'nullable|string|max:100',
        'horas'              => 'nullable|integer',

        // Programa de estudios
        'instituto'          => 'required|string|max:255',
        'realizar_estudios'  => 'nullable|string',
        'nivel_academico'    => 'nullable|string',
        'pais'               => 'nullable|string|in:NACIONAL,EXTRANJERO',
        
        // Otros
        'observaciones'      => 'nullable|string'
    ]);

    // Como ahora sí validamos TODOS los campos, 
    // Laravel guardará la clave_plaza y demás sin problemas.
    $maestro = Maestro::create($validated);

    return redirect()
        ->route('maestros.show', $maestro)
        ->with('success', 'Maestro registrado exitosamente');
}

    /**
     * ============================================
     * MÉTODO: show
     * ============================================
     * 
     * PROPÓSITO:
     * Muestra los DETALLES completos de un maestro específico
     * 
     * RUTA: GET /maestros/{id}
     * 
     * PARÁMETROS:
     * Maestro $maestro - Laravel automáticamente busca el maestro por ID
     *                    Esto se llama "Route Model Binding"
     * 
     * RETORNA:
     * Vista con los detalles del maestro
     */
    public function show(Maestro $maestro)
    {
        // Laravel automáticamente buscó el maestro
        // Si no existe, retorna error 404 automáticamente
        // Si existe, $maestro contiene el registro completo
        
        // Retornamos la vista con los datos del maestro
        return view('maestros.show', compact('maestro'));
        
        // En la vista podremos acceder a: $maestro
    }

    /**
     * ============================================
     * MÉTODO: edit
     * ============================================
     * 
     * PROPÓSITO:
     * Muestra el formulario para EDITAR un maestro existente
     * 
     * RUTA: GET /maestros/{id}/edit
     * 
     * PARÁMETROS:
     * Maestro $maestro - El maestro a editar
     * 
     * RETORNA:
     * Vista con el formulario lleno de datos actuales
     */
    public function edit(Maestro $maestro)
    {
        // Retornamos la vista del formulario de edición
        // Pasamos el maestro para que el formulario se llene con sus datos
        return view('maestros.edit', compact('maestro'));
    }

    /**
     * ============================================
     * MÉTODO: update
     * ============================================
     * 
     * PROPÓSITO:
     * Actualiza los datos de un maestro existente
     * 
     * RUTA: PUT/PATCH /maestros/{id}
     * 
     * PARÁMETROS:
     * Request $request - Los nuevos datos
     * Maestro $maestro - El maestro a actualizar
     * 
     * RETORNA:
     * Redirección al detalle del maestro actualizado
     */
    public function update(Request $request, Maestro $maestro)
    {
        // ============================================
        // VALIDACIÓN (similar a store)
        // ============================================
        
        $validated = $request->validate([
            // RFC debe ser único EXCEPTO para este maestro
            // unique:maestros,rfc,' . $maestro->id
            // significa: único en la tabla maestros, columna rfc,
            // pero ignora el registro con id = $maestro->id
            'rfc' => [
                'required',
                'string',
                'max:13',
                'unique:maestros,rfc,' . $maestro->id
            ],
            
            'curp' => [
                'required',
                'string',
                'max:18',
                'unique:maestros,curp,' . $maestro->id
            ],
            
            // ... (las mismas validaciones que en store)
            'apellido_paterno' => 'required|string|max:50',
            'apellido_materno' => 'required|string|max:50',
            'nombres' => 'required|string|max:100',
            'sexo' => 'nullable|in:M,F',
            'edad' => 'nullable|integer|min:18|max:100',
            'correo_electronico' => 'nullable|email|max:150',
            'tel_particular' => 'nullable|string|max:15',
            'nivel' => 'nullable|string|max:100',
            'cct' => 'nullable|string|max:15',
            'adscripcion' => 'nullable|string|max:200',
            'instituto' => 'required|string|max:200',
            'fechini' => 'required|date',
            'fechterm' => 'required|date|after:fechini',
            // ... (resto de validaciones)
        ]);

        // ============================================
        // ACTUALIZAR EL MAESTRO
        // ============================================
        
        // update() actualiza el registro en la BD
        // Recibe un array con los nuevos valores
        $maestro->update($validated);
        
        // Los cambios ya están guardados en la BD

        // ============================================
        // REDIRECCIONAR CON MENSAJE
        // ============================================
        
        return redirect()
            ->route('maestros.show', $maestro)
            ->with('success', 'Maestro actualizado exitosamente');
    }

    /**
     * ============================================
     * MÉTODO: destroy
     * ============================================
     * 
     * PROPÓSITO:
     * Elimina un maestro de la base de datos
     * 
     * RUTA: DELETE /maestros/{id}
     * 
     * PARÁMETROS:
     * Maestro $maestro - El maestro a eliminar
     * 
     * RETORNA:
     * Redirección a la lista de maestros
     */
    public function destroy(Maestro $maestro)
    {
        // Guardamos el nombre antes de eliminar
        // (para mostrarlo en el mensaje)
        $nombre = $maestro->nombre_completo;

        // ============================================
        // ELIMINAR EL MAESTRO
        // ============================================
        
        // delete() elimina el registro de la BD
        // Esta acción NO se puede deshacer
        $maestro->delete();

        // ============================================
        // REDIRECCIONAR CON MENSAJE
        // ============================================
        
        return redirect()
            ->route('maestros.index')
            ->with('success', "Maestro {$nombre} eliminado exitosamente");
    }
}