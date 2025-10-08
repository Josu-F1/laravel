<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistema Simple')</title>
</head>
<body>
    <header>
        <h1>Sistema de Gestión</h1>
        <nav>
            <a href="/">Inicio</a> | 
            <a href="/clientes">Clientes</a> | 
            <a href="/productos">Productos</a> | 
            <a href="/pedidos">Pedidos</a> | 
            <a href="/alumnos">Alumnos</a>
        </nav>
    </header>

    <main>
        @if(session('success'))
            <p><strong>Éxito:</strong> {{ session('success') }}</p>
        @endif

        @if(session('error'))
            <p><strong>Error:</strong> {{ session('error') }}</p>
        @endif

        @yield('content')
    </main>

    <footer>
        <p>© {{ date('Y') }} Sistema Simple</p>
    </footer>
</body>
</html>