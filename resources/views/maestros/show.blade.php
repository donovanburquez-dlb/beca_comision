{{--
    VISTA: maestros/show.blade.php
    
    PROPÓSITO:
    Muestra TODOS los detalles de un maestro específico
    
    RUTA: GET /maestros/{id}
    CONTROLADOR: MaestroController@show
    
    VARIABLE DISPONIBLE:
    - $maestro: Objeto con todos los datos del maestro
--}}

<x-app-layout>
<div class="container mx-auto px-4 py-8">
    
    {{-- ============================================
         ENCABEZADO CON BOTONES DE ACCIÓN
         ============================================ --}}
    
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                {{ $maestro->nombre_completo }}
            </h1>
            <p class="text-gray-600 mt-1">RFC: {{ $maestro->rfc }}</p>
        </div>
        
        <div class="flex gap-2">
            {{-- Botón Volver --}}
            <a href="{{ route('maestros.index') }}" 
               class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded">
                ← Volver
            </a>
            
            {{-- Botón Editar --}}
            <a href="{{ route('maestros.edit', $maestro) }}" 
               class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded">
                ✏️ Editar
            </a>
        </div>
    </div>

    {{-- Mensaje de éxito --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- ============================================
         TARJETAS DE INFORMACIÓN
         ============================================ --}}
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- COLUMNA IZQUIERDA (2 columnas) --}}
        <div class="lg:col-span-2 space-y-6">
            
            {{-- CARD: DATOS PERSONALES --}}
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="bg-blue-600 text-white px-6 py-3">
                    <h2 class="text-lg font-bold">📋 Datos Personales</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">RFC</p>
                            <p class="font-semibold">{{ $maestro->rfc }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">CURP</p>
                            <p class="font-semibold">{{ $maestro->curp }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Apellido Paterno</p>
                            <p class="font-semibold">{{ $maestro->apellido_paterno }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Apellido Materno</p>
                            <p class="font-semibold">{{ $maestro->apellido_materno }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Nombre(s)</p>
                            <p class="font-semibold">{{ $maestro->nombres }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Sexo</p>
                            <p class="font-semibold">
                                @if($maestro->sexo == 'M')
                                    Masculino
                                @elseif($maestro->sexo == 'F')
                                    Femenino
                                @else
                                    No especificado
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Edad</p>
                            <p class="font-semibold">{{ $maestro->edad ?? 'N/A' }} años</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Correo Electrónico</p>
                            <p class="font-semibold">{{ $maestro->correo_electronico ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Teléfono</p>
                            <p class="font-semibold">{{ $maestro->tel_particular ?? 'N/A' }}</p>
                        </div>
                        @if($maestro->dom_particular)
                        <div class="col-span-2">
                            <p class="text-sm text-gray-500">Domicilio</p>
                            <p class="font-semibold">{{ $maestro->dom_particular }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- CARD: ADSCRIPCIÓN --}}
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="bg-green-600 text-white px-6 py-3">
                    <h2 class="text-lg font-bold">🏫 Adscripción</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Nivel</p>
                            <p class="font-semibold">{{ $maestro->nivel ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">CCT</p>
                            <p class="font-semibold">{{ $maestro->cct ?? 'N/A' }}</p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-sm text-gray-500">Centro de Trabajo</p>
                            <p class="font-semibold">{{ $maestro->adscripcion ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Localidad</p>
                            <p class="font-semibold">{{ $maestro->localidad ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Municipio</p>
                            <p class="font-semibold">{{ $maestro->municipio ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Turno</p>
                            <p class="font-semibold">{{ $maestro->turno ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Asignatura</p>
                            <p class="font-semibold">{{ $maestro->asignatura ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Horas</p>
                            <p class="font-semibold">{{ $maestro->horas }} hrs</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CARD: PROGRAMA DE ESTUDIOS --}}
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="bg-purple-600 text-white px-6 py-3">
                    <h2 class="text-lg font-bold">🎓 Programa de Estudios</h2>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-500">Instituto/Universidad</p>
                            <p class="font-semibold">{{ $maestro->instituto ?? 'N/A' }}</p>
                        </div>
                        @if($maestro->realizar_estudios)
                        <div>
                            <p class="text-sm text-gray-500">Programa</p>
                            <p class="font-semibold">{{ $maestro->realizar_estudios }}</p>
                        </div>
                        @endif
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Nivel Académico</p>
                                <p class="font-semibold">{{ $maestro->nivel_academico ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">País</p>
                                <p class="font-semibold">{{ $maestro->pais ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- COLUMNA DERECHA --}}
        <div class="space-y-6">
            
            {{-- CARD: ESTADO --}}
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="bg-gray-700 text-white px-6 py-3">
                    <h2 class="text-lg font-bold">📊 Estado</h2>
                </div>
                <div class="p-6">
                    <div class="text-center">
                        @if($maestro->activo)
                            <span class="inline-block px-4 py-2 bg-green-100 text-green-800 rounded-full font-bold text-lg">
                                ✓ ACTIVO
                            </span>
                        @else
                            <span class="inline-block px-4 py-2 bg-red-100 text-red-800 rounded-full font-bold text-lg">
                                ✗ INACTIVO
                            </span>
                        @endif
                    </div>
                    
                    {{-- Verificar si está en beca actualmente --}}
                    <div class="mt-4 text-center">
                        @if($maestro->estaEnBeca())
                            <p class="text-green-600 font-semibold">🎓 En Beca Actualmente</p>
                            <p class="text-sm text-gray-600 mt-2">
                                Días restantes: <strong>{{ $maestro->diasRestantes() }}</strong>
                            </p>
                        @else
                            <p class="text-gray-600">No está en beca actualmente</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- CARD: PERIODO DE LA BECA --}}
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="bg-orange-600 text-white px-6 py-3">
                    <h2 class="text-lg font-bold">📅 Periodo</h2>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-500">Fecha de Inicio</p>
                            <p class="font-semibold text-lg">
                                {{ $maestro->fechini ? $maestro->fechini->format('d/m/Y') : 'N/A' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Fecha de Término</p>
                            <p class="font-semibold text-lg">
                                {{ $maestro->fechterm ? $maestro->fechterm->format('d/m/Y') : 'N/A' }}
                            </p>
                        </div>
                        @if($maestro->fechini && $maestro->fechterm)
                        <div class="pt-3 border-t">
                            <p class="text-sm text-gray-500">Duración Total</p>
                            <p class="font-semibold text-lg">
                                {{ $maestro->duracion_meses }} meses
                            </p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- ============================================
                CARD: SUSTITUTOS ASIGNADOS
                ============================================ --}}
            <div class="bg-white shadow-md rounded-lg overflow-hidden mt-6">
                <div class="bg-teal-600 text-white px-6 py-3 flex justify-between items-center">
                    <h2 class="text-lg font-bold">🔄 Sustitutos Asignados</h2>
                    
                    {{-- Botón Activado para abrir el Modal --}}
                    <button onclick="document.getElementById('modalSustituto').classList.remove('hidden')" 
                            class="bg-white text-teal-700 px-4 py-1.5 rounded-md text-sm font-bold hover:bg-teal-50 shadow transition">
                        + Asignar Sustituto
                    </button>
                </div>
                
                <div class="p-6">
                    @if($maestro->sustitutos && $maestro->sustitutos->count() > 0)
                        <div class="space-y-4">
                            @foreach($maestro->sustitutos as $sustituto)
                                <div class="border-l-4 border-teal-500 pl-4 py-2 bg-gray-50 rounded-r-md">
                                    <p class="font-bold text-gray-800 text-lg">{{ $sustituto->nombre_completo }}</p>
                                    <div class="flex gap-4 mt-1 text-sm text-gray-600">
                                        <p>📅 <strong>Del:</strong> {{ $sustituto->fecha_inicio->format('d/m/Y') }} <strong>Al:</strong> {{ $sustituto->fecha_termino->format('d/m/Y') }}</p>
                                        <p>📌 <strong>Estatus:</strong> 
                                            <span class="{{ $sustituto->estatus == 'ACTIVO' ? 'text-green-600' : 'text-gray-500' }} font-bold">
                                                {{ $sustituto->estatus }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        {{-- TEXTO CORREGIDO: text-gray-800 para que resalte sobre el fondo blanco --}}
                        <div class="text-center py-6 text-gray-800 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                            <p class="font-medium text-lg">No hay sustitutos asignados a este maestro actualmente.</p>
                            <p class="text-sm text-gray-500 mt-1">Haz clic en "+ Asignar Sustituto" para registrar uno nuevo.</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- CARD: CALIFICACIONES (si existen) --}}
            @if($maestro->calif1 || $maestro->calif2 || $maestro->calif3)
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="bg-indigo-600 text-white px-6 py-3">
                    <h2 class="text-lg font-bold">📈 Calificaciones</h2>
                </div>
                <div class="p-6">
                    <div class="space-y-2">
                        @if($maestro->calif1)
                            <div class="flex justify-between">
                                <span>Periodo 1:</span>
                                <strong>{{ $maestro->calif1 }}</strong>
                            </div>
                        @endif
                        @if($maestro->calif2)
                            <div class="flex justify-between">
                                <span>Periodo 2:</span>
                                <strong>{{ $maestro->calif2 }}</strong>
                            </div>
                        @endif
                        @if($maestro->calif3)
                            <div class="flex justify-between">
                                <span>Periodo 3:</span>
                                <strong>{{ $maestro->calif3 }}</strong>
                            </div>
                        @endif
                        @if($maestro->promedioCalificaciones() > 0)
                        <div class="pt-2 border-t">
                            <div class="flex justify-between text-lg">
                                <span class="font-bold">Promedio:</span>
                                <strong class="text-blue-600">{{ $maestro->promedioCalificaciones() }}</strong>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>

    {{-- OBSERVACIONES (si existen) --}}
    @if($maestro->observaciones)
    <div class="mt-6 bg-white shadow-md rounded-lg overflow-hidden">
        <div class="bg-gray-600 text-white px-6 py-3">
            <h2 class="text-lg font-bold">📝 Observaciones</h2>
        </div>
        <div class="p-6">
            <p class="text-gray-700 whitespace-pre-line">{{ $maestro->observaciones }}</p>
        </div>
    </div>
    @endif

    {{-- INFORMACIÓN ADICIONAL --}}
    <div class="mt-6 bg-gray-50 rounded-lg p-4">
        <div class="text-sm text-gray-600">
            <p><strong>Registrado:</strong> {{ $maestro->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Última actualización:</strong> {{ $maestro->updated_at->format('d/m/Y H:i') }}</p>
        </div>
    </div>

</div>

{{-- ============================================
     MODAL FLOTANTE: ASIGNAR SUSTITUTO
     ============================================ --}}
<div id="modalSustituto" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-60 backdrop-blur-sm transition-opacity">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl mx-4 overflow-hidden">
        
        {{-- Encabezado del Modal --}}
        <div class="bg-teal-600 px-6 py-4 flex justify-between items-center text-white">
            <h3 class="font-bold text-xl">Registrar Sustituto</h3>
            <button onclick="document.getElementById('modalSustituto').classList.add('hidden')" class="text-white hover:text-gray-200 text-2xl leading-none font-bold">
                &times;
            </button>
        </div>

        {{-- Formulario --}}
        <form action="{{ route('sustitutos.store', $maestro) }}" method="POST">
            @csrf
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-gray-700 mb-1">Nombre Completo del Sustituto *</label>
                    <input type="text" name="nombre_completo" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-teal-500 focus:border-teal-500">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">RFC (Opcional)</label>
                    <input type="text" name="rfc" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-teal-500 focus:border-teal-500">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Teléfono</label>
                    <input type="text" name="telefono" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-teal-500 focus:border-teal-500">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Fecha de Inicio *</label>
                    <input type="date" name="fecha_inicio" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-teal-500 focus:border-teal-500">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Fecha de Término *</label>
                    <input type="date" name="fecha_termino" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-teal-500 focus:border-teal-500">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-gray-700 mb-1">Observaciones</label>
                    <textarea name="observaciones" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-teal-500 focus:border-teal-500"></textarea>
                </div>
            </div>

            {{-- Botones de Acción --}}
            <div class="bg-gray-50 px-6 py-4 flex justify-end gap-3 border-t">
                <button type="button" onclick="document.getElementById('modalSustituto').classList.add('hidden')" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md font-bold hover:bg-gray-400 transition">
                    Cancelar
                </button>
                <button type="submit" class="px-6 py-2 bg-teal-600 text-white rounded-md font-bold hover:bg-teal-700 shadow-md transition">
                    💾 Guardar Sustituto
                </button>
            </div>
        </form>
    </div>
</div>

</x-app-layout>