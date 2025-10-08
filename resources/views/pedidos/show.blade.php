@extends('layouts.app')

@section('title', 'Detalles del Pedido')

@section('content')
<h2>Pedido #{{ $pedido->id }}</h2>

<div class="row">
    <div class="col-md-6">
        <h4>Información del Pedido</h4>
        <p><strong>Cliente:</strong> {{ $pedido->cliente->name }}</p>
        <p><strong>Email:</strong> {{ $pedido->cliente->email }}</p>
        <p><strong>Teléfono:</strong> {{ $pedido->cliente->phone }}</p>
        <p><strong>Fecha:</strong> {{ $pedido->fecha }}</p>
        <p><strong>Estado:</strong> {{ ucfirst($pedido->estado) }}</p>
        <p><strong>Total:</strong> ${{ number_format($pedido->total, 2) }}</p>
    </div>
</div>

<h4>Productos</h4>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio Unitario</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pedido->detalles as $detalle)
        <tr>
            <td>{{ $detalle->producto->name }}</td>
            <td>{{ $detalle->cantidad }}</td>
            <td>${{ number_format($detalle->precio_unitario, 2) }}</td>
            <td>${{ number_format($detalle->subtotal, 2) }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th colspan="3">Total:</th>
            <th>${{ number_format($pedido->total, 2) }}</th>
        </tr>
    </tfoot>
</table>

<div class="d-flex gap-2">
    <a href="{{ route('pedidos.index') }}" class="btn btn-secondary">Volver</a>
    <a href="{{ route('pedidos.edit', $pedido) }}" class="btn btn-primary">Editar</a>
</div>
@endsection