{{-- resources/views/usuarios/edit.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Usuario
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-8">
        <div class="max-w-lg mx-auto bg-white shadow-md rounded-lg overflow-hidden">

            <div class="bg-yellow-500 text-white px-6 py-4">
                <h2 class="text-lg font-bold">Editar: {{ $usuario->name }}</h2>
            </div>

            <div class="p-6">
                <form method="POST" action="{{ route('usuarios.update', $usuario) }}">
                    @csrf
                    @method('PUT')

                    {{-- Nombre --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Nombre Completo *
                        </label>
                        <input type="text"
                               name="name"
                               value="{{ old('name', $usuario->name) }}"
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
                               value="{{ old('email', $usuario->email) }}"
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
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                            @foreach($roles as $rol)
                                <option value="{{ $rol }}" {{ old('rol', $usuario->rol) == $rol ? 'selected' : '' }}>
                                    {{ $rol }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Contraseña (opcional) --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Nueva Contraseña
                            <span class="text-xs text-gray-500">(dejar vacío para no cambiar)</span>
                        </label>
                        <input type="password"
                               name="password"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Confirmar Contraseña --}}
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Confirmar Nueva Contraseña
                        </label>
                        <input type="password"
                               name="password_confirmation"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    {{-- Botones --}}
                    <div class="flex justify-between">
                        <a href="{{ route('usuarios.index') }}"
                           class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded">
                            ← Cancelar
                        </a>
                        <button type="submit"
                                class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-bold rounded">
                            💾 Actualizar Usuario
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
