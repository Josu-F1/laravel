@extends('layouts.app')

@section('title', 'Detalle Cliente')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-user"></i> Información del Cliente</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
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

                <div class="d-flex gap-2">
                    <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <a href="{{ route('clientes.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5><i class="fas fa-shopping-cart"></i> Historial de Pedidos</h5>
                <a href="{{ route('pedidos.create') }}?cliente_id={{ $cliente->id }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus"></i> Nuevo Pedido
                </a>
            </div>
            <div class="card-body">
                @if($cliente->pedidos->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
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
                                    <td>
                                        <span class="badge bg-{{ $pedido->estado == 'pendiente' ? 'warning' : ($pedido->estado == 'entregado' ? 'success' : 'info') }}">
                                            {{ ucfirst($pedido->estado) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $pedido->detallePedidos->count() }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('pedidos.show', $pedido->id) }}" class="btn btn-sm btn-outline-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Este cliente no tiene pedidos aún</p>
                        <a href="{{ route('pedidos.create') }}?cliente_id={{ $cliente->id }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Crear Primer Pedido
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection