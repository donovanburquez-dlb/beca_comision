{{--
    VISTA: maestros/edit.blade.php
    
    PROPÓSITO:
    Formulario para EDITAR un maestro existente
    Similar al create.blade.php pero pre-lleno con datos actuales
    
    RUTA: GET /maestros/{id}/edit
    CONTROLADOR: MaestroController@edit
    
    VARIABLE DISPONIBLE:
    - $maestro: Objeto con todos los datos actuales del maestro
--}}

@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    
    {{-- ============================================
         ENCABEZADO
         ============================================ --}}
    
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Editar Maestro</h1>
        <p class="text-gray-600 mt-2">{{ $maestro->nombre_completo }} - RFC: {{ $maestro->rfc }}</p>
    </div>

    {{-- ============================================
         CARD DEL FORMULARIO
         ============================================ --}}
    
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="p-6">
            
            {{--
                Formulario de actualización
                method="POST" porque HTML solo soporta GET y POST
                @method('PUT') le dice a Laravel que realmente es PUT
            --}}
            <form method="POST" action="{{ route('maestros.update', $maestro) }}">
                @csrf
                @method('PUT')
                {{-- @method('PUT') genera un campo hidden con _method=PUT --}}

                {{-- ============================================
                     SECCIÓN 1: DATOS PERSONALES
                     ============================================ --}}
                
                <h2 class="text-xl font-bold text-gray-800 mb-4">📋 Datos Personales</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    
                    {{-- RFC (solo lectura, no se puede cambiar) --}}
                    <div>
                        <label for="rfc" class="block text-sm font-medium text-gray-700 mb-1">
                            RFC * <span class="text-xs text-gray-500">(No editable)</span>
                        </label>
                        <input type="text" 
                               id="rfc" 
                               name="rfc" 
                               value="{{ old('rfc', $maestro->rfc) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100"
                               readonly>
                        {{--
                            old('rfc', $maestro->rfc) significa:
                            - Si hay errores, usa old('rfc')
                            - Si no hay errores, usa $maestro->rfc
                        --}}
                    </div>

                    {{-- CURP --}}
                    <div>
                        <label for="curp" class="block text-sm font-medium text-gray-700 mb-1">
                            CURP *
                        </label>
                        <input type="text" 
                               id="curp" 
                               name="curp" 
                               value="{{ old('curp', $maestro->curp) }}"
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
                            value="{{ old('apellido_paterno', $maestro->apellido_paterno) }}"
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
                            value="{{ old('apellido_materno', $maestro->apellido_materno) }}"
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
                               value="{{ old('nombres', $maestro->nombres) }}"
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
                            <option value="M" {{ old('sexo', $maestro->sexo) == 'M' ? 'selected' : '' }}>Masculino</option>
                            <option value="F" {{ old('sexo', $maestro->sexo) == 'F' ? 'selected' : '' }}>Femenino</option>
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
                               value="{{ old('edad', $maestro->edad) }}"
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
                               value="{{ old('correo_electronico', $maestro->correo_electronico) }}"
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
                               value="{{ old('tel_particular', $maestro->tel_particular) }}"
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
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('dom_particular', $maestro->dom_particular) }}</textarea>
                    </div>
                </div>

                <hr class="my-6">

                {{-- ============================================
                     SECCIÓN 2: ADSCRIPCIÓN
                     ============================================ --}}
                
                <h2 class="text-xl font-bold text-gray-800 mb-4">🏫 Datos de Adscripción</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    
                    <div>
                        <label for="nivel" class="block text-sm font-medium text-gray-700 mb-1">
                            Nivel
                        </label>
                        <input type="text" 
                               id="nivel" 
                               name="nivel" 
                               value="{{ old('nivel', $maestro->nivel) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="cct" class="block text-sm font-medium text-gray-700 mb-1">
                            CCT
                        </label>
                        <input type="text" 
                               id="cct" 
                               name="cct" 
                               value="{{ old('cct', $maestro->cct) }}"
                               maxlength="15"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="md:col-span-2">
                        <label for="adscripcion" class="block text-sm font-medium text-gray-700 mb-1">
                            Centro de Trabajo
                        </label>
                        <input type="text" 
                               id="adscripcion" 
                               name="adscripcion" 
                               value="{{ old('adscripcion', $maestro->adscripcion) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="localidad" class="block text-sm font-medium text-gray-700 mb-1">
                            Localidad
                        </label>
                        <input type="text" 
                               id="localidad" 
                               name="localidad" 
                               value="{{ old('localidad', $maestro->localidad) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="municipio" class="block text-sm font-medium text-gray-700 mb-1">
                            Municipio
                        </label>
                        <input type="text" 
                               id="municipio" 
                               name="municipio" 
                               value="{{ old('municipio', $maestro->municipio) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="turno" class="block text-sm font-medium text-gray-700 mb-1">
                            Turno
                        </label>
                        <select id="turno" 
                                name="turno" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Seleccione...</option>
                            <option value="MATUTINO" {{ old('turno', $maestro->turno) == 'MATUTINO' ? 'selected' : '' }}>Matutino</option>
                            <option value="VESPERTINO" {{ old('turno', $maestro->turno) == 'VESPERTINO' ? 'selected' : '' }}>Vespertino</option>
                            <option value="NOCTURNO" {{ old('turno', $maestro->turno) == 'NOCTURNO' ? 'selected' : '' }}>Nocturno</option>
                        </select>
                    </div>

                    <div>
                        <label for="asignatura" class="block text-sm font-medium text-gray-700 mb-1">
                            Asignatura
                        </label>
                        <input type="text" 
                               id="asignatura" 
                               name="asignatura" 
                               value="{{ old('asignatura', $maestro->asignatura) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="horas" class="block text-sm font-medium text-gray-700 mb-1">
                            Horas
                        </label>
                        <input type="number" 
                               id="horas" 
                               name="horas" 
                               value="{{ old('horas', $maestro->horas) }}"
                               min="0" 
                               max="48"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <hr class="my-6">

                {{-- ============================================
                     SECCIÓN 3: PROGRAMA DE ESTUDIOS
                     ============================================ --}}
                
                <h2 class="text-xl font-bold text-gray-800 mb-4">🎓 Programa de Estudios</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    
                    <div class="md:col-span-2">
                        <label for="instituto" class="block text-sm font-medium text-gray-700 mb-1">
                            Instituto/Universidad *
                        </label>
                        <input type="text" 
                               id="instituto" 
                               name="instituto" 
                               value="{{ old('instituto', $maestro->instituto) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('instituto') border-red-500 @enderror"
                               required>
                        @error('instituto')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="realizar_estudios" class="block text-sm font-medium text-gray-700 mb-1">
                            Programa a Realizar
                        </label>
                        <textarea id="realizar_estudios" 
                                  name="realizar_estudios" 
                                  rows="2"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('realizar_estudios', $maestro->realizar_estudios) }}</textarea>
                    </div>

                    <div>
                        <label for="nivel_academico" class="block text-sm font-medium text-gray-700 mb-1">
                            Nivel Académico
                        </label>
                        <select id="nivel_academico" 
                                name="nivel_academico" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Seleccione...</option>
                            <option value="LICENCIATURA" {{ old('nivel_academico', $maestro->nivel_academico) == 'LICENCIATURA' ? 'selected' : '' }}>Licenciatura</option>
                            <option value="MAESTRIA" {{ old('nivel_academico', $maestro->nivel_academico) == 'MAESTRIA' ? 'selected' : '' }}>Maestría</option>
                            <option value="DOCTORADO" {{ old('nivel_academico', $maestro->nivel_academico) == 'DOCTORADO' ? 'selected' : '' }}>Doctorado</option>
                        </select>
                    </div>

                    <div>
                        <label for="pais" class="block text-sm font-medium text-gray-700 mb-1">
                            País
                        </label>
                        <select id="pais" 
                                name="pais" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="NACIONAL" {{ old('pais', $maestro->pais) == 'NACIONAL' ? 'selected' : '' }}>Nacional</option>
                            <option value="EXTRANJERO" {{ old('pais', $maestro->pais) == 'EXTRANJERO' ? 'selected' : '' }}>Extranjero</option>
                        </select>
                    </div>
                </div>

                <hr class="my-6">

                {{-- ============================================
                     SECCIÓN 4: PERIODO DE LA BECA
                     ============================================ --}}
                
                <h2 class="text-xl font-bold text-gray-800 mb-4">📅 Periodo de la Beca</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    
                    <div>
                        <label for="fechini" class="block text-sm font-medium text-gray-700 mb-1">
                            Fecha de Inicio *
                        </label>
                        <input type="date" 
                               id="fechini" 
                               name="fechini" 
                               value="{{ old('fechini', $maestro->fechini?->format('Y-m-d')) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('fechini') border-red-500 @enderror"
                               required>
                        @error('fechini')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="fechterm" class="block text-sm font-medium text-gray-700 mb-1">
                            Fecha de Término *
                        </label>
                        <input type="date" 
                               id="fechterm" 
                               name="fechterm" 
                               value="{{ old('fechterm', $maestro->fechterm?->format('Y-m-d')) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('fechterm') border-red-500 @enderror"
                               required>
                        @error('fechterm')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <hr class="my-6">

                {{-- ============================================
                     SECCIÓN 5: OBSERVACIONES
                     ============================================ --}}
                
                <h2 class="text-xl font-bold text-gray-800 mb-4">📝 Observaciones</h2>
                
                <div class="mb-6">
                    <textarea id="observaciones" 
                              name="observaciones" 
                              rows="4"
                              placeholder="Observaciones generales..."
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('observaciones', $maestro->observaciones) }}</textarea>
                </div>

                <hr class="my-6">

                {{-- ============================================
                     BOTONES DE ACCIÓN
                     ============================================ --}}
                
                <div class="flex justify-between items-center pt-4">
                    <a href="{{ route('maestros.show', $maestro) }}" 
                       class="px-6 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold rounded-md transition">
                        ← Cancelar
                    </a>
                    
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-md transition">
                        💾 Actualizar Maestro
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection