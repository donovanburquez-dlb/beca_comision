{{-- resources/views/usuarios/create.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nuevo Usuario
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-8">
        <div class="max-w-lg mx-auto bg-white shadow-md rounded-lg overflow-hidden">

            <div class="bg-blue-600 text-white px-6 py-4">
                <h2 class="text-lg font-bold">Crear Nuevo Usuario</h2>
            </div>

            <div class="p-6">
                <form method="POST" action="{{ route('usuarios.store') }}">
                    @csrf

                    {{-- Nombre --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Nombre Completo *
                        </label>
                        <input type="text"
                               name="name"
                               value="{{ old('name') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror"
                               required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Correo --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Correo Electrónico *
                        </label>
                        <input type="email"
                               name="email"
                               value="{{ old('email') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror"
                               required>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Rol --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Rol *
                        </label>
                        <select name="rol"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('rol') border-red-500 @enderror"
                                required>
                            <option value="">Seleccione un rol...</option>
                            @foreach($roles as $rol)
                                <option value="{{ $rol }}" {{ old('rol') == $rol ? 'selected' : '' }}>
                                    {{ $rol }}
                                </option>
                            @endforeach
                        </select>
                        @error('rol')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror

                        {{-- Descripción de los roles --}}
                        <div class="mt-2 text-xs text-gray-500 space-y-1">
                            <p>👑 <strong>Administrador:</strong> Acceso total al sistema</p>
                            <p>📋 <strong>Coordinador:</strong> Ver, crear y editar</p>
                            <p>✏️ <strong>Capturista:</strong> Solo crear y editar</p>
                            <p>👁️ <strong>Consulta:</strong> Solo ver</p>
                        </div>
                    </div>

                    {{-- Contraseña --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Contraseña * <span class="text-xs text-gray-500">(mínimo 8 caracteres)</span>
                        </label>
                        <input type="password"
                               name="password"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror"
                               required>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Confirmar Contraseña --}}
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Confirmar Contraseña *
                        </label>
                        <input type="password"
                               name="password_confirmation"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               required>
                    </div>

                    {{-- Botones --}}
                    <div class="flex justify-between">
                        <a href="{{ route('usuarios.index') }}"
                           class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded">
                            ← Cancelar
                        </a>
                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded">
                            💾 Guardar Usuario
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
