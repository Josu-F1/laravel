@extends('layouts.app')

@section('title', 'Productos')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h2>Lista de Productos</h2>
    <div>
        <a href="{{ url('/') }}" class="btn btn-secondary">Inicio</a>
        <a href="{{ route('productos.create') }}" class="btn btn-primary">Nuevo Producto</a>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped">
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
                <td>
                    @if($producto->stock > 10)
                        <span class="badge bg-success">{{ $producto->stock }}</span>
                    @elseif($producto->stock > 0)
                        <span class="badge bg-warning">{{ $producto->stock }}</span>
                    @else
                        <span class="badge bg-danger">{{ $producto->stock }}</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('productos.show', $producto->id) }}" class="btn btn-sm btn-info">Ver</a>
                    <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-sm btn-warning">Editar</a>
                    <form method="POST" action="{{ route('productos.destroy', $producto->id) }}" style="display: inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar producto?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@if($productos->isEmpty())
    <div class="text-center">
        <p>No hay productos registrados</p>
        <a href="{{ route('productos.create') }}" class="btn btn-primary">Crear Primer Producto</a>
    </div>
@endif
@endsection