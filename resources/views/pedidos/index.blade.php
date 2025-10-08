@extends('layouts.app')

@section('title', 'Pedidos')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Gestión de Pedidos</h1>
    <div>
        <a href="{{ url('/') }}" class="btn btn-secondary">Inicio</a>
        <a href="{{ route('pedidos.create') }}" class="btn btn-primary">Nuevo Pedido</a>
    </div>
</div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Fecha</th>
            <th>Productos</th>
            <th>Total</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pedidos as $pedido)
        <tr>
            <td>#{{ $pedido->id }}</td>
            <td>{{ $pedido->cliente->name }}</td>
            <td>{{ $pedido->fecha }}</td>
            <td>{{ $pedido->detallePedidos->count() }} items</td>
            <td>${{ number_format($pedido->total, 2) }}</td>
            <td>{{ ucfirst($pedido->estado) }}</td>
            <td>
                <div class="d-flex gap-1">
                    <a href="{{ route('pedidos.show', $pedido) }}" class="btn btn-sm btn-info">Ver</a>
                    <a href="{{ route('pedidos.edit', $pedido) }}" class="btn btn-sm btn-warning">Editar</a>
                    @if($pedido->estado === 'pendiente')
                    <form action="{{ route('pedidos.destroy', $pedido) }}" method="POST" style="display: inline;" onsubmit="return confirm('¿Estás seguro de eliminar este pedido?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                    </form>
                    @endif
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@if($pedidos->isEmpty())
    <div class="text-center py-4">
        <p class="text-muted">No hay pedidos registrados</p>
        <a href="{{ route('pedidos.create') }}" class="btn btn-primary">Crear Primer Pedido</a>
    </div>
@endif
@endsection