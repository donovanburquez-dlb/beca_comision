{{--
    VISTA: maestros/create.blade.php
    
    PROPÓSITO:
    Formulario para CREAR un nuevo maestro
    Incluye búsqueda por RFC que autocompleta los datos
    
    RUTA: GET /maestros/create
    CONTROLADOR: MaestroController@create
    
    FUNCIONALIDAD ESPECIAL:
    Cuando el usuario ingresa un RFC y da clic en "Buscar",
    JavaScript hace una petición AJAX al servidor,
    busca en la tabla personal_catalogo y autocompleta el formulario.
--}}

<x-app-layout>

<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Registrar Nuevo Maestro
    </h2>
</x-slot>

<div class="container mx-auto px-4 py-8">
    
    {{-- ============================================
         ENCABEZADO
         ============================================ --}}
    
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Registrar Nuevo Maestro</h1>
        <p class="text-gray-600 mt-2">Complete la información del maestro en beca-comisión</p>
    </div>

    {{-- ============================================
         CARD DEL FORMULARIO
         ============================================ --}}
    
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="p-6">
            
            {{--
                Formulario principal
                method="POST" - Envía datos por POST
                action - URL donde se enviarán los datos
                route('maestros.store') genera: /maestros
            --}}
            <form method="POST" action="{{ route('maestros.store') }}" id="formMaestro">
                
                {{--
                    @csrf es obligatorio en todos los formularios POST en Laravel
                    Genera un token de seguridad para prevenir ataques CSRF
                    Sin esto, Laravel rechaza el formulario
                --}}
                @csrf

                {{-- ============================================
                     PASO 1: BÚSQUEDA POR RFC
                     ============================================ --}}
                
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-700">
                                <strong>Paso 1:</strong> Ingresa el RFC y presiona "Buscar" para cargar datos del catálogo
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <div class="flex gap-4">
                        {{-- Campo RFC --}}
                        <div class="flex-1">
                            <label for="rfc" class="block text-sm font-medium text-gray-700 mb-1">
                                RFC * <span class="text-xs text-gray-500">(13 caracteres)</span>
                            </label>
                            <input type="text" 
                                   id="rfc" 
                                   name="rfc" 
                                   value="{{ old('rfc') }}"
                                   maxlength="13"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('rfc') border-red-500 @enderror"
                                   required>
                            {{--
                                old('rfc') mantiene el valor si hay errores de validación
                                @error('rfc') agrega clase 'border-red-500' si hay error
                            --}}
                            
                            {{-- Mostrar error de validación --}}
                            @error('rfc')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Botón Buscar --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">&nbsp;</label>
                            <button type="button" 
                                    id="btnBuscarRFC" 
                                    class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-md transition">
                                🔍 Buscar
                            </button>
                        </div>
                    </div>
                    
                    {{-- Mensaje de resultado de búsqueda --}}
                    <div id="mensajeBusqueda" class="mt-3 hidden"></div>
                </div>

                <hr class="my-6">

                {{-- ============================================
                     SECCIÓN 2: DATOS PERSONALES
                     ============================================ --}}
                
                <h2 class="text-xl font-bold text-gray-800 mb-4">📋 Datos Personales</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    
                    {{-- CURP --}}
                    <div>
                        <label for="curp" class="block text-sm font-medium text-gray-700 mb-1">
                            CURP * <span class="text-xs text-gray-500">(18 caracteres)</span>
                        </label>
                        <input type="text" 
                               id="curp" 
                               name="curp" 
                               value="{{ old('curp') }}"
                               maxlength="18"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('curp') border-red-500 @enderror"
                               required>
                        @error('curp')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Apellido Paterno --}}
                    <div>
                        <label for="apellido_paterno" class="block text-sm font-medium text-gray-700 mb-1">
                            Apellido Paterno *
                        </label>
                        <input type="text" 
                            id="apellido_paterno" 
                            name="apellido_paterno" 
                            value="{{ old('apellido_paterno') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('apellido_paterno') border-red-500 @enderror"
                            required>
                        @error('apellido_paterno')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Apellido Materno --}}
                    <div>
                        <label for="apellido_materno" class="block text-sm font-medium text-gray-700 mb-1">
                            Apellido Materno *
                        </label>
                        <input type="text" 
                            id="apellido_materno" 
                            name="apellido_materno" 
                            value="{{ old('apellido_materno') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('apellido_materno') border-red-500 @enderror"
                            required>
                        @error('apellido_materno')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>


                    {{-- Nombres --}}
                    <div>
                        <label for="nombres" class="block text-sm font-medium text-gray-700 mb-1">
                            Nombre(s) *
                        </label>
                        <input type="text" 
                               id="nombres" 
                               name="nombres" 
                               value="{{ old('nombres') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nombres') border-red-500 @enderror"
                               required>
                        @error('nombres')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Sexo --}}
                    <div>
                        <label for="sexo" class="block text-sm font-medium text-gray-700 mb-1">
                            Sexo
                        </label>
                        <select id="sexo" 
                                name="sexo" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Seleccione...</option>
                            <option value="M" {{ old('sexo') == 'M' ? 'selected' : '' }}>Masculino</option>
                            <option value="F" {{ old('sexo') == 'F' ? 'selected' : '' }}>Femenino</option>
                        </select>
                    </div>

                    {{-- Edad --}}
                    <div>
                        <label for="edad" class="block text-sm font-medium text-gray-700 mb-1">
                            Edad
                        </label>
                        <input type="number" 
                               id="edad" 
                               name="edad" 
                               value="{{ old('edad') }}"
                               min="18" 
                               max="100"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    {{-- Correo --}}
                    <div>
                        <label for="correo_electronico" class="block text-sm font-medium text-gray-700 mb-1">
                            Correo Electrónico
                        </label>
                        <input type="email" 
                               id="correo_electronico" 
                               name="correo_electronico" 
                               value="{{ old('correo_electronico') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    {{-- Teléfono --}}
                    <div>
                        <label for="tel_particular" class="block text-sm font-medium text-gray-700 mb-1">
                            Teléfono Particular
                        </label>
                        <input type="text" 
                               id="tel_particular" 
                               name="tel_particular" 
                               value="{{ old('tel_particular') }}"
                               maxlength="15"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    {{-- Domicilio --}}
                    <div class="md:col-span-2">
                        <label for="dom_particular" class="block text-sm font-medium text-gray-700 mb-1">
                            Domicilio Particular
                        </label>
                        <textarea id="dom_particular" 
                                  name="dom_particular" 
                                  rows="2"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('dom_particular') }}</textarea>
                    </div>
                </div>

                <hr class="my-6">

                {{-- ============================================
                     SECCIÓN 3: ADSCRIPCIÓN
                     ============================================ --}}
                
                <h2 class="text-xl font-bold text-gray-800 mb-4">🏫 Datos de Adscripción</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    
                    {{-- Nivel --}}
                    <div>
                        <label for="nivel" class="block text-sm font-medium text-gray-700 mb-1">
                            Nivel
                        </label>
                        <input type="text" 
                               id="nivel" 
                               name="nivel" 
                               value="{{ old('nivel') }}"
                               placeholder="Ej: SECUNDARIAS GENERALES"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    {{-- CCT --}}
                    <div>
                        <label for="cct" class="block text-sm font-medium text-gray-700 mb-1">
                            CCT
                        </label>
                        <input type="text" 
                               id="cct" 
                               name="cct" 
                               value="{{ old('cct') }}"
                               maxlength="15"
                               placeholder="Ej: 13DES0085R"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    {{-- Centro de Trabajo --}}
                    <div class="md:col-span-2">
                        <label for="adscripcion" class="block text-sm font-medium text-gray-700 mb-1">
                            Centro de Trabajo (Adscripción)
                        </label>
                        <input type="text" 
                               id="adscripcion" 
                               name="adscripcion" 
                               value="{{ old('adscripcion') }}"
                               placeholder="Ej: ESC. SEC. GRAL. VICENTE GUERRERO"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    {{-- Localidad --}}
                    <div>
                        <label for="localidad" class="block text-sm font-medium text-gray-700 mb-1">
                            Localidad
                        </label>
                        <input type="text" 
                               id="localidad" 
                               name="localidad" 
                               value="{{ old('localidad') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    {{-- Municipio --}}
                    <div>
                        <label for="municipio" class="block text-sm font-medium text-gray-700 mb-1">
                            Municipio
                        </label>
                        <input type="text" 
                               id="municipio" 
                               name="municipio" 
                               value="{{ old('municipio') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    {{-- Turno --}}
                    <div>
                        <label for="turno" class="block text-sm font-medium text-gray-700 mb-1">
                            Turno
                        </label>
                        <select id="turno" 
                                name="turno" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Seleccione...</option>
                            <option value="MATUTINO" {{ old('turno') == 'MATUTINO' ? 'selected' : '' }}>Matutino</option>
                            <option value="VESPERTINO" {{ old('turno') == 'VESPERTINO' ? 'selected' : '' }}>Vespertino</option>
                            <option value="NOCTURNO" {{ old('turno') == 'NOCTURNO' ? 'selected' : '' }}>Nocturno</option>
                        </select>
                    </div>

                    {{-- Asignatura --}}
                    <div>
                        <label for="asignatura" class="block text-sm font-medium text-gray-700 mb-1">
                            Asignatura
                        </label>
                        <input type="text" 
                               id="asignatura" 
                               name="asignatura" 
                               value="{{ old('asignatura') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    {{-- Horas --}}
                    <div>
                        <label for="horas" class="block text-sm font-medium text-gray-700 mb-1">
                            Horas
                        </label>
                        <input type="number" 
                               id="horas" 
                               name="horas" 
                               value="{{ old('horas', 0) }}"
                               min="0" 
                               max="48"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <hr class="my-6">

                {{-- ============================================
                     SECCIÓN 4: PROGRAMA DE ESTUDIOS
                     ============================================ --}}
                
                <h2 class="text-xl font-bold text-gray-800 mb-4">🎓 Programa de Estudios</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    
                    {{-- Instituto --}}
                    <div class="md:col-span-2">
                        <label for="instituto" class="block text-sm font-medium text-gray-700 mb-1">
                            Instituto/Universidad *
                        </label>
                        <input type="text" 
                               id="instituto" 
                               name="instituto" 
                               value="{{ old('instituto') }}"
                               placeholder="Ej: UNIVERSIDAD INTERAMERICANA PARA EL DESARROLLO"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('instituto') border-red-500 @enderror"
                               required>
                        @error('instituto')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Programa a Realizar --}}
                    <div class="md:col-span-2">
                        <label for="realizar_estudios" class="block text-sm font-medium text-gray-700 mb-1">
                            Programa a Realizar
                        </label>
                        <textarea id="realizar_estudios" 
                                  name="realizar_estudios" 
                                  rows="2"
                                  placeholder="Descripción del programa de estudios..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('realizar_estudios') }}</textarea>
                    </div>

                    {{-- Nivel Académico --}}
                    <div>
                        <label for="nivel_academico" class="block text-sm font-medium text-gray-700 mb-1">
                            Nivel Académico
                        </label>
                        <select id="nivel_academico" 
                                name="nivel_academico" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Seleccione...</option>
                            <option value="LICENCIATURA" {{ old('nivel_academico') == 'LICENCIATURA' ? 'selected' : '' }}>Licenciatura</option>
                            <option value="MAESTRIA" {{ old('nivel_academico') == 'MAESTRIA' ? 'selected' : '' }}>Maestría</option>
                            <option value="DOCTORADO" {{ old('nivel_academico') == 'DOCTORADO' ? 'selected' : '' }}>Doctorado</option>
                        </select>
                    </div>

                    {{-- País --}}
                    <div>
                        <label for="pais" class="block text-sm font-medium text-gray-700 mb-1">
                            País
                        </label>
                        <select id="pais" 
                                name="pais" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="NACIONAL" {{ old('pais', 'NACIONAL') == 'NACIONAL' ? 'selected' : '' }}>Nacional</option>
                            <option value="EXTRANJERO" {{ old('pais') == 'EXTRANJERO' ? 'selected' : '' }}>Extranjero</option>
                        </select>
                    </div>
                </div>

                <hr class="my-6">

                {{-- ============================================
                     SECCIÓN 5: PERIODO DE LA BECA
                     ============================================ --}}
                
                <h2 class="text-xl font-bold text-gray-800 mb-4">📅 Periodo de la Beca</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    
                    {{-- Fecha Inicio --}}
                    <div>
                        <label for="fechini" class="block text-sm font-medium text-gray-700 mb-1">
                            Fecha de Inicio *
                        </label>
                        <input type="date" 
                               id="fechini" 
                               name="fechini" 
                               value="{{ old('fechini') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('fechini') border-red-500 @enderror"
                               required>
                        @error('fechini')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Fecha Término --}}
                    <div>
                        <label for="fechterm" class="block text-sm font-medium text-gray-700 mb-1">
                            Fecha de Término *
                        </label>
                        <input type="date" 
                               id="fechterm" 
                               name="fechterm" 
                               value="{{ old('fechterm') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('fechterm') border-red-500 @enderror"
                               required>
                        @error('fechterm')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <hr class="my-6">

                {{-- ============================================
                     BOTONES DE ACCIÓN
                     ============================================ --}}
                
                <div class="flex justify-between items-center pt-4">
                    {{-- Botón Cancelar --}}
                    <a href="{{ route('maestros.index') }}" 
                       class="px-6 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold rounded-md transition">
                        ← Cancelar
                    </a>
                    
                    {{-- Botón Guardar --}}
                    <button type="submit" 
                            class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-bold rounded-md transition">
                        💾 Guardar Maestro
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

{{-- ============================================
     JAVASCRIPT PARA BÚSQUEDA POR RFC (AJAX)
     ============================================ --}}

{{--
    @push('scripts') agrega código al final de la página
    En layouts/app.blade.php debe haber un @stack('scripts')
--}}
@push('scripts')
<script>
// Esperamos a que el DOM esté completamente cargado
document.addEventListener('DOMContentLoaded', function() {
    
    // ============================================
    // OBTENER ELEMENTOS DEL DOM
    // ============================================
    
    // Obtenemos referencias a los elementos que vamos a usar
    const btnBuscar = document.getElementById('btnBuscarRFC');
    const inputRfc = document.getElementById('rfc');
    const mensajeBusqueda = document.getElementById('mensajeBusqueda');
    
    // ============================================
    // EVENTO: CLIC EN BOTÓN BUSCAR
    // ============================================
    
    // addEventListener('click', ...) ejecuta la función cuando se da clic
    btnBuscar.addEventListener('click', function() {
        
        // Obtenemos el RFC ingresado
        // trim() quita espacios al inicio y final
        // toUpperCase() convierte a mayúsculas
        const rfc = inputRfc.value.trim().toUpperCase();
        
        // Validar que el RFC no esté vacío
        if (!rfc) {
            mostrarMensaje('Por favor ingrese un RFC', 'error');
            return; // return detiene la ejecución
        }
        
        // Validar longitud del RFC (debe ser 13 caracteres)
        if (rfc.length !== 13) {
            mostrarMensaje('El RFC debe tener 13 caracteres', 'error');
            return;
        }
        
        // ============================================
        // DESHABILITAR BOTÓN MIENTRAS BUSCA
        // ============================================
        
        // Deshabilitamos el botón para evitar múltiples clics
        btnBuscar.disabled = true;
        btnBuscar.textContent = '⏳ Buscando...';
        
        // ============================================
        // PETICIÓN AJAX AL SERVIDOR
        // ============================================
        
        // fetch() hace una petición HTTP asíncrona
        // Es la forma moderna de hacer AJAX en JavaScript
        fetch('{{ route("maestros.buscar-rfc") }}', {
            method: 'POST',  // Método HTTP
            headers: {
                'Content-Type': 'application/json',  // Tipo de contenido
                'X-CSRF-TOKEN': '{{ csrf_token() }}',  // Token de seguridad Laravel
                'Accept': 'application/json'  // Aceptamos JSON como respuesta
            },
            body: JSON.stringify({ rfc: rfc })  // Enviamos el RFC en formato JSON
        })
        // .then() maneja la respuesta cuando llega
        .then(response => {
            // Verificamos si la respuesta fue exitosa
            if (!response.ok) {
                // Si no fue exitosa, lanzamos un error
                throw new Error('Error en la búsqueda');
            }
            // Convertimos la respuesta a JSON
            return response.json();
        })
        .then(data => {
            // ============================================
            // PROCESAR RESPUESTA EXITOSA
            // ============================================
            
            // data contiene la respuesta del servidor
            // {success: true, data: {...}}
            
            if (data.success) {
                // ¡SE ENCONTRÓ EL RFC!
                
                // Llenar el formulario con los datos recibidos
                llenarFormulario(data.data);
                
                // Mostrar mensaje de éxito
                mostrarMensaje('✓ RFC encontrado. Datos cargados correctamente.', 'success');
            } else {
                // NO SE ENCONTRÓ EL RFC
                mostrarMensaje('RFC no encontrado en el catálogo de personal', 'warning');
            }
        })
        .catch(error => {
            // ============================================
            // MANEJAR ERRORES
            // ============================================
            
            // catch() captura cualquier error que ocurra
            console.error('Error:', error);
            mostrarMensaje('Error al buscar el RFC. Intente nuevamente.', 'error');
        })
        .finally(() => {
            // ============================================
            // FINALMENTE (siempre se ejecuta)
            // ============================================
            
            // Rehabilitamos el botón
            btnBuscar.disabled = false;
            btnBuscar.textContent = '🔍 Buscar';
        });
    });
    
    // ============================================
    // FUNCIÓN: LLENAR FORMULARIO
    // ============================================
    
    /**
     * Llena los campos del formulario con los datos recibidos
     * @param {Object} datos - Objeto con los datos del personal
     */
    function llenarFormulario(datos) {
        // Para cada campo, si existe un valor, lo asignamos
        // El operador || asigna '' si el valor es null/undefined
        
        document.getElementById('curp').value = datos.curp || '';
        document.getElementById('apellido_paterno').value = datos.apellido_paterno || '';
        document.getElementById('apellido_materno').value = datos.apellido_materno || '';
        document.getElementById('nombres').value = datos.nombres || '';
        document.getElementById('sexo').value = datos.sexo || '';
        document.getElementById('edad').value = datos.edad || '';
        document.getElementById('correo_electronico').value = datos.correo || '';
        document.getElementById('tel_particular').value = datos.tel_particular || '';
        document.getElementById('dom_particular').value = datos.domicilio || '';
        
        // Datos de adscripción
        document.getElementById('nivel').value = datos.nivel || '';
        document.getElementById('cct').value = datos.cct || '';
        document.getElementById('adscripcion').value = datos.centro_trabajo || '';
        document.getElementById('localidad').value = datos.localidad || '';
        document.getElementById('municipio').value = datos.municipio || '';
        document.getElementById('turno').value = datos.turno || '';
        document.getElementById('asignatura').value = datos.asignatura || '';
        document.getElementById('horas').value = datos.horas || 0;
    }
    
    // ============================================
    // FUNCIÓN: MOSTRAR MENSAJE
    // ============================================
    
    /**
     * Muestra un mensaje de feedback al usuario
     * @param {string} texto - El mensaje a mostrar
     * @param {string} tipo - Tipo: 'success', 'error', 'warning'
     */
    function mostrarMensaje(texto, tipo) {
        // Definimos los colores según el tipo
        let clases = '';
        
        if (tipo === 'success') {
            clases = 'bg-green-100 border-green-400 text-green-700';
        } else if (tipo === 'error') {
            clases = 'bg-red-100 border-red-400 text-red-700';
        } else if (tipo === 'warning') {
            clases = 'bg-yellow-100 border-yellow-400 text-yellow-700';
        }
        
        // Creamos el HTML del mensaje
        mensajeBusqueda.className = `border-l-4 p-3 rounded ${clases}`;
        mensajeBusqueda.textContent = texto;
        mensajeBusqueda.classList.remove('hidden');
        
        // Ocultamos el mensaje después de 5 segundos
        setTimeout(() => {
            mensajeBusqueda.classList.add('hidden');
        }, 5000);
    }
});
</script>
@endpush

</x-app-layout>
