@extends('layouts.app')

@section('title', 'Productos')

@section('content')
<h2>Lista de Productos</h2>
<p>
    <a href="{{ url('/') }}">Inicio</a> | 
    <a href="{{ route('productos.create') }}">Nuevo Producto</a>
</p>

<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Stock</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($productos as $producto)
        <tr>
            <td>{{ $producto->id }}</td>
            <td>{{ $producto->name }}</td>
            <td>${{ number_format($producto->price, 2) }}</td>
            <td>{{ $producto->stock }}</td>
            <td>
                <a href="{{ route('productos.show', $producto->id) }}">Ver</a> | 
                <a href="{{ route('productos.edit', $producto->id) }}">Editar</a> | 
                <form method="POST" action="{{ route('productos.destroy', $producto->id) }}" style="display: inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('¿Eliminar producto?')">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@if($productos->isEmpty())
    <p>No hay productos registrados</p>
    <p><a href="{{ route('productos.create') }}">Crear Primer Producto</a></p>
@endif
@endsection