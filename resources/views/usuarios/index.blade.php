<x-app-layout>

    

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gestión de Usuarios
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                
                <div class="p-6 text-gray-900">
                    
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold">Usuarios del Sistema</h1>
                        <a href="{{ route('usuarios.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            + Nuevo Usuario
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rol</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($usuarios as $usuario)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        {{ $usuario->name }}
                                        @if($usuario->id === auth()->id())
                                            <span class="text-blue-600 text-xs">(Tú)</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $usuario->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($usuario->rol === 'Administrador')
                                            <span class="px-2 py-1 text-xs font-semibold rounded bg-red-100 text-red-800">
                                                👑 Administrador
                                            </span>
                                        @elseif($usuario->rol === 'Coordinador')
                                            <span class="px-2 py-1 text-xs font-semibold rounded bg-blue-100 text-blue-800">
                                                📋 Coordinador
                                            </span>
                                        @elseif($usuario->rol === 'Capturista')
                                            <span class="px-2 py-1 text-xs font-semibold rounded bg-green-100 text-green-800">
                                                ✏️ Capturista
                                            </span>
                                        @else
                                            <span class="px-2 py-1 text-xs font-semibold rounded bg-gray-100 text-gray-800">
                                                👁️ Consulta
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <a href="{{ route('usuarios.edit', $usuario) }}" class="text-blue-600 hover:text-blue-900 mr-3">Editar</a>
                                        @if($usuario->id !== auth()->id())
                                            <form method="POST" action="{{ route('usuarios.destroy', $usuario) }}" class="inline" onsubmit="return confirm('¿Eliminar?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">No hay usuarios</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($usuarios->hasPages())
                        <div class="mt-4">{{ $usuarios->links() }}</div>
                    @endif

                    <div class="mt-8 bg-gray-50 p-4 rounded">
                        <h3 class="font-bold mb-2">📊 Permisos por Rol</h3>
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="border-b">
                                    <th class="text-left py-2">Acción</th>
                                    <th class="text-center py-2">👑 Admin</th>
                                    <th class="text-center py-2">📋 Coord</th>
                                    <th class="text-center py-2">✏️ Capt</th>
                                    <th class="text-center py-2">👁️ Cons</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b"><td class="py-2">Ver Maestros</td><td class="text-center">✓</td><td class="text-center">✓</td><td class="text-center">✓</td><td class="text-center">✓</td></tr>
                                <tr class="border-b"><td class="py-2">Crear Maestros</td><td class="text-center">✓</td><td class="text-center">✓</td><td class="text-center">✓</td><td class="text-center">✗</td></tr>
                                <tr class="border-b"><td class="py-2">Editar Maestros</td><td class="text-center">✓</td><td class="text-center">✓</td><td class="text-center">✓</td><td class="text-center">✗</td></tr>
                                <tr class="border-b"><td class="py-2">Eliminar Maestros</td><td class="text-center">✓</td><td class="text-center">✗</td><td class="text-center">✗</td><td class="text-center">✗</td></tr>
                                <tr><td class="py-2">Gestionar Usuarios</td><td class="text-center">✓</td><td class="text-center">✗</td><td class="text-center">✗</td><td class="text-center">✗</td></tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
```

### 3. Guarda y recarga:
```
http://127.0.0.1:8000/usuarios