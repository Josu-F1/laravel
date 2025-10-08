@extends('layouts.app')

@section('title', 'Detalle Cliente')

@section('content')
<h2>Información del Cliente</h2>

<table border="1">
    <tr>
        <th>ID:</th>
        <td>{{ $cliente->id }}</td>
    </tr>
    <tr>
        <th>Nombre:</th>
        <td>{{ $cliente->name }}</td>
    </tr>
    <tr>
        <th>Email:</th>
        <td>{{ $cliente->email }}</td>
    </tr>
    <tr>
        <th>Teléfono:</th>
        <td>{{ $cliente->phone ?? '-' }}</td>
    </tr>
    <tr>
        <th>Dirección:</th>
        <td>{{ $cliente->address ?? '-' }}</td>
    </tr>
    <tr>
        <th>Registrado:</th>
        <td>{{ $cliente->created_at->format('d/m/Y H:i') }}</td>
    </tr>
</table>

<p>
    <a href="{{ route('clientes.edit', $cliente->id) }}">Editar</a> | 
    <a href="{{ route('clientes.index') }}">Volver</a>
</p>

<h3>Historial de Pedidos</h3>
<p><a href="{{ route('pedidos.create') }}?cliente_id={{ $cliente->id }}">Nuevo Pedido</a></p>

@if($cliente->pedidos->count() > 0)
<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Fecha</th>
            <th>Total</th>
            <th>Estado</th>
            <th>Productos</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($cliente->pedidos as $pedido)
        <tr>
            <td>{{ $pedido->id }}</td>
            <td>{{ $pedido->fecha->format('d/m/Y') }}</td>
            <td>${{ number_format($pedido->total, 2) }}</td>
            <td>{{ ucfirst($pedido->estado) }}</td>
            <td>{{ $pedido->detallePedidos->count() }}</td>
            <td>
                <a href="{{ route('pedidos.show', $pedido->id) }}">Ver</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<p>Este cliente no tiene pedidos aún</p>
<p><a href="{{ route('pedidos.create') }}?cliente_id={{ $cliente->id }}">Crear Primer Pedido</a></p>
@endif
@endsection