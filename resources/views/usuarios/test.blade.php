<!DOCTYPE html>
<html>
<head>
    <title>Test Usuarios</title>
</head>
<body>
    <h1>TEST DE USUARIOS</h1>
    <p>Total de usuarios: {{ $usuarios->count() }}</p>
    
    <table border="1">
        <tr>
            <th>Nombre</th>
            <th>Email</th>
            <th>Rol</th>
        </tr>
        @foreach($usuarios as $usuario)
        <tr>
            <td>{{ $usuario->name }}</td>
            <td>{{ $usuario->email }}</td>
            <td>{{ $usuario->rol }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>