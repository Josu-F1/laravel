@extends('layouts.app')

@section('title', 'Sistema Simple')

@section('content')
<div class="text-center">
    <h1>Sistema de Gestión Simple</h1>
    <p class="lead">Selecciona una opción para comenzar:</p>
    
    <div class="row mt-5">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <h5>Clientes</h5>
                    <p>Gestionar información de clientes</p>
                    <a href="{{ route('clientes.index') }}" class="btn btn-primary">Ir a Clientes</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <h5>Productos</h5>
                    <p>Gestionar inventario y productos</p>
                    <a href="{{ route('productos.index') }}" class="btn btn-primary">Ir a Productos</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <h5>Pedidos</h5>
                    <p>Gestionar pedidos de clientes</p>
                    <a href="{{ route('pedidos.index') }}" class="btn btn-primary">Ir a Pedidos</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection