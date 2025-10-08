@extends('layouts.app')

@section('title', 'Crear Pedido')

@section('content')
<h2>Crear Nuevo Pedido</h2>

<form action="{{ route('pedidos.store') }}" method="POST">
    @csrf
    
    <div class="mb-3">
        <label for="cliente_id" class="form-label">Cliente *</label>
        <select class="form-select" id="cliente_id" name="cliente_id" required>
            <option value="">Seleccionar cliente...</option>
            @foreach($clientes as $cliente)
                <option value="{{ $cliente->id }}">{{ $cliente->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="fecha" class="form-label">Fecha *</label>
        <input type="date" class="form-control" id="fecha" name="fecha" value="{{ date('Y-m-d') }}" required>
    </div>

    <h4>Producto</h4>
    <div class="mb-3">
        <label for="producto_id" class="form-label">Producto *</label>
        <select class="form-select" name="productos[0][producto_id]" required>
            <option value="">Seleccionar producto...</option>
            @foreach($productos as $producto)
                <option value="{{ $producto->id }}">
                    {{ $producto->name }} - ${{ number_format($producto->price, 2) }} (Stock: {{ $producto->stock }})
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="cantidad" class="form-label">Cantidad *</label>
        <input type="number" class="form-control" name="productos[0][cantidad]" min="1" value="1" required>
    </div>

    <div class="d-flex gap-2">
        <a href="{{ route('pedidos.index') }}" class="btn btn-secondary">Volver</a>
        <button type="submit" class="btn btn-primary">Crear Pedido</button>
    </div>
</form>
@endsection