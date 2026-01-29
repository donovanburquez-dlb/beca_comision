{{--
    VISTA: maestros/index.blade.php
    
    PROPÓSITO:
    Muestra la lista de todos los maestros registrados
    con búsqueda, filtros y paginación
    
    RUTA: GET /maestros
    CONTROLADOR: MaestroController@index
    
    VARIABLES DISPONIBLES:
    - $maestros: Colección paginada de maestros
    - $niveles: Lista de niveles únicos (para filtro)
--}}

{{-- 
    @extends indica que esta vista hereda de otra
    'layouts.app' busca el archivo: resources/views/layouts/app.blade.php
    Esa vista tiene la estructura HTML base (head, body, nav, etc.)
--}}
{{-- @extends('layouts.app')--}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Maestros
        </h2>
    </x-slot>

    <!-- CONTENIDO DEL CRUD -->
    <p>Listado de maestros</p>
</x-app-layout>


{{--
    @section define una sección que se insertará en el layout
    'content' es el nombre de la sección
    En layouts/app.blade.php hay un @yield('content') donde se insertará esto
--}}
@section('content')

{{-- Container: Centra y limita el ancho del contenido --}}
<div class="container mx-auto px-4 py-8">
    
    {{-- ============================================
         ENCABEZADO CON TÍTULO Y BOTÓN
         ============================================ --}}
    
    <div class="flex justify-between items-center mb-6">
        {{-- Título de la página --}}
        <h1 class="text-3xl font-bold text-gray-800">
            Maestros en Beca-Comisión
        </h1>
        
        {{-- 
            Botón para crear nuevo maestro
            route('maestros.create') genera la URL: /maestros/create
        --}}
        <a href="{{ route('maestros.create') }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            + Nuevo Maestro
        </a>
    </div>

    {{-- ============================================
         MENSAJE DE ÉXITO (Flash Message)
         ============================================ --}}
    
    {{--
        session('success') verifica si hay un mensaje de éxito en la sesión
        Estos mensajes se crean cuando guardamos/actualizamos/eliminamos
        Ejemplo: ->with('success', 'Maestro guardado')
    --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- ============================================
         CARD PRINCIPAL
         ============================================ --}}
    
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        
        {{-- ============================================
             FORMULARIO DE BÚSQUEDA Y FILTROS
             ============================================ --}}
        
        <div class="p-4 bg-gray-50 border-b">
            {{--
                Formulario GET para búsqueda
                method="GET" envía los datos en la URL
                Ejemplo: /maestros?search=MARIA&nivel=SECUNDARIA
            --}}
            <form method="GET" action="{{ route('maestros.index') }}" class="space-y-4">
                
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    
                    {{-- Campo de búsqueda por texto --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Buscar
                        </label>
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="RFC, CURP, Nombre..."
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        {{--
                            request('search') obtiene el valor actual del parámetro 'search' en la URL
                            Así mantiene el texto cuando recargas la página
                        --}}
                    </div>

                    {{-- Filtro por nivel --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Nivel
                        </label>
                        <select name="nivel" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Todos los niveles</option>
                            
                            {{--
                                @foreach recorre un array
                                $niveles viene del controlador
                            --}}
                            @foreach($niveles as $nivel)
                                <option value="{{ $nivel }}" 
                                    {{ request('nivel') == $nivel ? 'selected' : '' }}>
                                    {{-- 
                                        {{ }} imprime el valor
                                        request('nivel') == $nivel ? 'selected' : ''
                                        Si el nivel actual coincide con el filtro, marca como selected
                                    --}}
                                    {{ $nivel }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Filtro por estado (activo/inactivo) --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Estado
                        </label>
                        <select name="activo" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Todos</option>
                            <option value="1" {{ request('activo') == '1' ? 'selected' : '' }}>
                                Activos
                            </option>
                            <option value="0" {{ request('activo') == '0' ? 'selected' : '' }}>
                                Inactivos
                            </option>
                        </select>
                    </div>

                    {{-- Botones --}}
                    <div class="flex items-end space-x-2">
                        {{-- Botón Buscar --}}
                        <button type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Buscar
                        </button>
                        
                        {{-- Botón Limpiar filtros --}}
                        <a href="{{ route('maestros.index') }}" 
                           class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                            Limpiar
                        </a>
                    </div>
                </div>
            </form>
        </div>

        {{-- ============================================
             TABLA DE MAESTROS
             ============================================ --}}
        
        <div class="overflow-x-auto">
            {{-- overflow-x-auto permite scroll horizontal en móviles --}}
            
            <table class="min-w-full divide-y divide-gray-200">
                {{-- Encabezado de la tabla --}}
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            RFC
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nombre Completo
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nivel
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Centro de Trabajo
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Programa
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Periodo
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Estado
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                
                {{-- Cuerpo de la tabla --}}
                <tbody class="bg-white divide-y divide-gray-200">
                    {{--
                        @forelse es como @foreach pero con un @empty al final
                        Si $maestros está vacío, muestra el @empty
                    --}}
                    @forelse($maestros as $maestro)
                        <tr class="hover:bg-gray-50">
                            {{-- RFC --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $maestro->rfc }}
                            </td>
                            
                            {{-- Nombre Completo --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{-- 
                                    $maestro->nombre_completo usa el accessor que definimos
                                    en el modelo (getNombreCompletoAttribute)
                                --}}
                                {{ $maestro->nombre_completo }}
                            </td>
                            
                            {{-- Nivel --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $maestro->nivel ?? 'N/A' }}
                                {{-- ?? 'N/A' significa: si es null, muestra 'N/A' --}}
                            </td>
                            
                            {{-- Centro de Trabajo --}}
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ Str::limit($maestro->adscripcion, 40) ?? 'N/A' }}
                                {{-- Str::limit() corta el texto a 40 caracteres --}}
                            </td>
                            
                            {{-- Programa --}}
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $maestro->nivel_academico ?? 'N/A' }}
                            </td>
                            
                            {{-- Periodo --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{-- 
                                    @if verifica una condición
                                    Si ambas fechas existen, las mostramos formateadas
                                --}}
                                @if($maestro->fechini && $maestro->fechterm)
                                    {{-- 
                                        format('d/m/Y') formatea la fecha
                                        d = día, m = mes, Y = año con 4 dígitos
                                    --}}
                                    {{ $maestro->fechini->format('d/m/Y') }}
                                    <br>
                                    al
                                    <br>
                                    {{ $maestro->fechterm->format('d/m/Y') }}
                                @else
                                    N/A
                                @endif
                            </td>
                            
                            {{-- Estado --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($maestro->activo)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Activo
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Inactivo
                                    </span>
                                @endif
                            </td>
                            
                            {{-- Acciones --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    {{-- Botón Ver --}}
                                    <a href="{{ route('maestros.show', $maestro) }}" 
                                       class="text-blue-600 hover:text-blue-900"
                                       title="Ver detalles">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    
                                    {{-- Botón Editar --}}
                                    <a href="{{ route('maestros.edit', $maestro) }}" 
                                       class="text-yellow-600 hover:text-yellow-900"
                                       title="Editar">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    
                    {{-- 
                        @empty se ejecuta si $maestros está vacío
                        Es decir, si no hay ningún maestro registrado
                    --}}
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                                <div class="text-lg">
                                    No hay maestros registrados
                                </div>
                                <a href="{{ route('maestros.create') }}" 
                                   class="mt-4 inline-block text-blue-600 hover:text-blue-800">
                                    Registrar el primer maestro
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ============================================
             PAGINACIÓN
             ============================================ --}}
        
        {{--
            Si hay más de una página, mostramos los enlaces de paginación
            $maestros->links() genera automáticamente: << 1 2 3 4 5 >>
        --}}
        @if($maestros->hasPages())
            <div class="px-6 py-4 bg-gray-50">
                {{ $maestros->links() }}
            </div>
        @endif
    </div>

    {{-- ============================================
         ESTADÍSTICAS RÁPIDAS (Opcional)
         ============================================ --}}
    
    <div class="mt-6 grid grid-cols-1 md:grid-cols-4 gap-4">
        {{-- Total de maestros --}}
        <div class="bg-white p-4 rounded-lg shadow">
            <div class="text-sm text-gray-500">Total de Maestros</div>
            <div class="text-2xl font-bold text-gray-900">
                {{ $maestros->total() }}
            </div>
        </div>
        
        {{-- En esta página --}}
        <div class="bg-white p-4 rounded-lg shadow">
            <div class="text-sm text-gray-500">En esta página</div>
            <div class="text-2xl font-bold text-gray-900">
                {{ $maestros->count() }}
            </div>
        </div>
    </div>
</div>

@endsection
{{-- @endsection cierra la sección 'content' --}}