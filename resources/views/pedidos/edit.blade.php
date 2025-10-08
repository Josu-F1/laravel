@extends('layouts.app')

@section('title', 'Editar Pedido')

@section('content')
<h2>Editar Pedido #{{ $pedido->id }}</h2>

<form action="{{ route('pedidos.update', $pedido) }}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="cliente_id" class="form-label">Cliente *</label>
                <select class="form-select @error('cliente_id') is-invalid @enderror" 
                        id="cliente_id" name="cliente_id" required>
                    <option value="">Seleccionar cliente...</option>
                    @foreach($clientes as $cliente)
                        <option value="{{ $cliente->id }}" {{ old('cliente_id', $pedido->cliente_id) == $cliente->id ? 'selected' : '' }}>
                            {{ $cliente->name }}
                        </option>
                    @endforeach
                </select>
                @error('cliente_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-md-3">
            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha *</label>
                <input type="date" class="form-control @error('fecha') is-invalid @enderror" 
                       id="fecha" name="fecha" value="{{ old('fecha', $pedido->fecha) }}" required>
                @error('fecha')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-md-3">
            <div class="mb-3">
                <label for="estado" class="form-label">Estado *</label>
                <select class="form-select @error('estado') is-invalid @enderror" 
                        id="estado" name="estado" required>
                    <option value="pendiente" {{ old('estado', $pedido->estado) == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="completado" {{ old('estado', $pedido->estado) == 'completado' ? 'selected' : '' }}>Completado</option>
                    <option value="cancelado" {{ old('estado', $pedido->estado) == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                </select>
                @error('estado')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <h4>Productos del Pedido</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio</th>
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
        <button type="submit" class="btn btn-primary">Actualizar Pedido</button>
    </div>
</form>
@endsection