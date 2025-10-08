@extends('layouts.app')

@section('title', 'Dashboard - Sistema de Gestión')

@section('content')
<div class="row">
    <div class="col-12">
        <h1><i class="fas fa-tachometer-alt"></i> Dashboard</h1>
        <p class="lead">Bienvenido al sistema de gestión de productos, pedidos y clientes</p>
    </div>
</div>

<div class="row">
    <!-- Estadísticas de Clientes -->
    <div class="col-md-4 mb-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title">{{ $totalClientes }}</h4>
                        <p class="card-text">Total Clientes</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                </div>
                <a href="{{ route('clientes.index') }}" class="btn btn-light btn-sm mt-2">
                    Ver Clientes <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Estadísticas de Productos -->
    <div class="col-md-4 mb-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title">{{ $totalProductos }}</h4>
                        <p class="card-text">Total Productos</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-box fa-2x"></i>
                    </div>
                </div>
                <a href="{{ route('productos.index') }}" class="btn btn-light btn-sm mt-2">
                    Ver Productos <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Estadísticas de Pedidos -->
    <div class="col-md-4 mb-4">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title">{{ $totalPedidos }}</h4>
                        <p class="card-text">Total Pedidos</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-shopping-cart fa-2x"></i>
                    </div>
                </div>
                <a href="{{ route('pedidos.index') }}" class="btn btn-light btn-sm mt-2">
                    Ver Pedidos <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Productos con Stock Bajo -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-exclamation-triangle text-warning"></i> Productos con Stock Bajo</h5>
            </div>
            <div class="card-body">
                @if($productosStockBajo->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Stock</th>
                                    <th>Precio</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($productosStockBajo as $producto)
                                <tr>
                                    <td>{{ $producto->name }}</td>
                                    <td>
                                        <span class="badge bg-warning">{{ $producto->stock }}</span>
                                    </td>
                                    <td>${{ number_format($producto->price, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted">No hay productos con stock bajo</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Pedidos Recientes -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-clock"></i> Pedidos Recientes</h5>
            </div>
            <div class="card-body">
                @if($pedidosRecientes->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Cliente</th>
                                    <th>Fecha</th>
                                    <th>Total</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pedidosRecientes as $pedido)
                                <tr>
                                    <td>{{ $pedido->cliente->name }}</td>
                                    <td>{{ $pedido->fecha->format('d/m/Y') }}</td>
                                    <td>${{ number_format($pedido->total, 2) }}</td>
                                    <td>
                                        <span class="badge bg-{{ $pedido->estado == 'pendiente' ? 'warning' : ($pedido->estado == 'entregado' ? 'success' : 'info') }}">
                                            {{ ucfirst($pedido->estado) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted">No hay pedidos recientes</p>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-rocket"></i> Acciones Rápidas</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <a href="{{ route('clientes.create') }}" class="btn btn-primary btn-lg w-100">
                            <i class="fas fa-user-plus"></i><br>
                            Nuevo Cliente
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="{{ route('productos.create') }}" class="btn btn-success btn-lg w-100">
                            <i class="fas fa-plus"></i><br>
                            Nuevo Producto
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="{{ route('pedidos.create') }}" class="btn btn-warning btn-lg w-100">
                            <i class="fas fa-shopping-cart"></i><br>
                            Nuevo Pedido
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection