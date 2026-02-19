<x-app-layout>
<div class="container mx-auto px-4 py-8">
    
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Editar Registro</h1>
        <p class="text-gray-600 mt-2">Maestro: <strong>{{ $maestro->apellido_paterno }} {{ $maestro->apellido_materno }} {{ $maestro->nombres }}</strong></p>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="p-6">
            <form method="POST" action="{{ route('maestros.update', $maestro) }}">
                @csrf
                @method('PUT')

                {{-- SECCIÓN 1: DATOS PERSONALES (BLOQUEADA) --}}
                <h2 class="text-xl font-bold text-gray-400 mb-4 uppercase text-sm tracking-widest">📋 Datos Personales (Solo Lectura)</h2>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase">RFC</label>
                        <input type="text" value="{{ $maestro->rfc }}" class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100 cursor-not-allowed" readonly>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase">CURP</label>
                        <input type="text" value="{{ $maestro->curp }}" class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100 cursor-not-allowed" readonly>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase">Sexo</label>
                        <input type="text" value="{{ $maestro->sexo == 'M' ? 'Masculino' : 'Femenino' }}" class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100 cursor-not-allowed" readonly>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase">Edad</label>
                        <input type="text" value="{{ $maestro->edad }}" class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100 cursor-not-allowed" readonly>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase">Apellido Paterno</label>
                        <input type="text" value="{{ $maestro->apellido_paterno }}" class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100 cursor-not-allowed" readonly>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase">Apellido Materno</label>
                        <input type="text" value="{{ $maestro->apellido_materno }}" class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100 cursor-not-allowed" readonly>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-500 uppercase">Nombre(s)</label>
                        <input type="text" value="{{ $maestro->nombres }}" class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100 cursor-not-allowed" readonly>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-500 uppercase">Correo Electrónico</label>
                        <input type="text" value="{{ $maestro->correo_electronico }}" class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100 cursor-not-allowed" readonly>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase">Teléfono</label>
                        <input type="text" value="{{ $maestro->tel_particular }}" class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100 cursor-not-allowed" readonly>
                    </div>
                    <div class="md:col-span-4">
                        <label class="block text-xs font-bold text-gray-500 uppercase">Domicilio Particular</label>
                        <input type="text" value="{{ $maestro->dom_particular }}" class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100 cursor-not-allowed" readonly>
                    </div>
                </div>

                <hr class="my-6">

                {{-- SECCIÓN 2: ADSCRIPCIÓN (BLOQUEADA) --}}
                <h2 class="text-xl font-bold text-gray-400 mb-4 uppercase text-sm tracking-widest">🏫 Datos de Adscripción (Solo Lectura)</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase">Plaza</label>
                        <input type="text" value="{{ $maestro->plaza }}" class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100 cursor-not-allowed" readonly>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase">Nivel</label>
                        <input type="text" value="{{ $maestro->nivel }}" class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100 cursor-not-allowed" readonly>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase">CCT</label>
                        <input type="text" value="{{ $maestro->cct }}" class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100 cursor-not-allowed" readonly>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-500 uppercase">Centro de Trabajo</label>
                        <input type="text" value="{{ $maestro->adscripcion }}" class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100 cursor-not-allowed" readonly>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase">Turno</label>
                        <input type="text" value="{{ $maestro->turno }}" class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100 cursor-not-allowed" readonly>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase">Localidad</label>
                        <input type="text" value="{{ $maestro->localidad }}" class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100 cursor-not-allowed" readonly>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase">Municipio</label>
                        <input type="text" value="{{ $maestro->municipio }}" class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100 cursor-not-allowed" readonly>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase">Asignatura</label>
                        <input type="text" value="{{ $maestro->asignatura }}" class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100 cursor-not-allowed" readonly>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase">Horas</label>
                        <input type="text" value="{{ $maestro->horas }}" class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100 cursor-not-allowed" readonly>
                    </div>
                </div>

                <hr class="my-6 border-blue-200 border-2">

                {{-- SECCIÓN 3: PROGRAMA DE ESTUDIOS (EDITABLE) --}}
                <h2 class="text-xl font-bold text-blue-700 mb-4 uppercase text-sm tracking-widest">🎓 Programa de Estudios y Observaciones (EDITABLE)</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8 p-6 bg-blue-50 rounded-lg border border-blue-200 shadow-inner">
                    <div class="md:col-span-2">
                        <label for="instituto" class="block text-sm font-bold text-gray-700 mb-1">Instituto/Universidad *</label>
                        <input type="text" id="instituto" name="instituto" value="{{ old('instituto', $maestro->instituto) }}"
                               class="w-full px-3 py-2 border border-blue-400 rounded-md focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <div class="md:col-span-2">
                        <label for="realizar_estudios" class="block text-sm font-bold text-gray-700 mb-1">Programa a Realizar</label>
                        <textarea id="realizar_estudios" name="realizar_estudios" rows="2"
                                  class="w-full px-3 py-2 border border-blue-400 rounded-md focus:ring-2 focus:ring-blue-500">{{ old('realizar_estudios', $maestro->realizar_estudios) }}</textarea>
                    </div>
                    <div>
                        <label for="nivel_academico" class="block text-sm font-bold text-gray-700 mb-1">Nivel Académico</label>
                        <select id="nivel_academico" name="nivel_academico" class="w-full px-3 py-2 border border-blue-400 rounded-md focus:ring-2 focus:ring-blue-500">
                            <option value="">Seleccione...</option>
                            <option value="LICENCIATURA" {{ old('nivel_academico', $maestro->nivel_academico) == 'LICENCIATURA' ? 'selected' : '' }}>Licenciatura</option>
                            <option value="MAESTRIA" {{ old('nivel_academico', $maestro->nivel_academico) == 'MAESTRIA' ? 'selected' : '' }}>Maestría</option>
                            <option value="DOCTORADO" {{ old('nivel_academico', $maestro->nivel_academico) == 'DOCTORADO' ? 'selected' : '' }}>Doctorado</option>
                        </select>
                    </div>
                    <div>
                        <label for="pais" class="block text-sm font-bold text-gray-700 mb-1">País</label>
                        <select id="pais" name="pais" class="w-full px-3 py-2 border border-blue-400 rounded-md focus:ring-2 focus:ring-blue-500">
                            <option value="NACIONAL" {{ old('pais', $maestro->pais) == 'NACIONAL' ? 'selected' : '' }}>Nacional</option>
                            <option value="EXTRANJERO" {{ old('pais', $maestro->pais) == 'EXTRANJERO' ? 'selected' : '' }}>Extranjero</option>
                        </select>
                    </div>

                    {{-- ESTA ES LA PARTE QUE SOLICITASTE MODIFICAR --}}
                    <div class="md:col-span-2">
                        <label for="observaciones" class="block text-sm font-bold text-gray-700 mb-1">Observaciones</label>
                        <textarea id="observaciones" name="observaciones" rows="3"
                                  class="w-full px-3 py-2 border border-blue-400 rounded-md focus:ring-2 focus:ring-blue-500 bg-white"
                                  placeholder="Escriba aquí las observaciones...">{{ old('observaciones', $maestro->observaciones) }}</textarea>
                    </div>
                </div>

                <hr class="my-6">

                {{-- SECCIÓN 4: FECHAS (BLOQUEADA) --}}
                <h2 class="text-xl font-bold text-gray-400 mb-4 uppercase text-sm tracking-widest">📅 Fechas de Beca (Solo Lectura)</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase">Fecha Inicio</label>
                        <input type="text" value="{{ $maestro->fechini?->format('d/m/Y') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100 cursor-not-allowed" readonly>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase">Fecha Término</label>
                        <input type="text" value="{{ $maestro->fechterm?->format('d/m/Y') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100 cursor-not-allowed" readonly>
                    </div>
                </div>

                <div class="flex justify-between items-center pt-6 border-t border-gray-100">
                    <a href="{{ route('maestros.index') }}" 
                       class="px-6 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold rounded-md transition">
                        ← Cancelar
                    </a>
                    
                    <button type="submit" 
                            class="px-8 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-md shadow-md transition transform hover:scale-105">
                        💾 Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</x-app-layout>