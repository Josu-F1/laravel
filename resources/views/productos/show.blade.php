@extends('layouts.app')

@section('title', 'Detalle Producto')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-box"></i> Información del Producto</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th>ID:</th>
                        <td>{{ $producto->id }}</td>
                    </tr>
                    <tr>
                        <th>Nombre:</th>
                        <td>{{ $producto->name }}</td>
                    </tr>
                    <tr>
                        <th>Precio:</th>
                        <td>${{ number_format($producto->price, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Stock:</th>
                        <td>
                            <span class="badge bg-{{ $producto->stock > 10 ? 'success' : ($producto->stock > 0 ? 'warning' : 'danger') }}">
                                {{ $producto->stock }} unidades
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Estado:</th>
                        <td>
                            @if($producto->stock > 10)
                                <span class="badge bg-success">Disponible</span>
                            @elseif($producto->stock > 0)
                                <span class="badge bg-warning">Stock Bajo</span>
                            @else
                                <span class="badge bg-danger">Agotado</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Creado:</th>
                        <td>{{ $producto->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                </table>

                @if($producto->description)
                    <div class="mt-3">
                        <h6>Descripción:</h6>
                        <p class="text-muted">{{ $producto->description }}</p>
                    </div>
                @endif

                <div class="d-flex gap-2">
                    <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <button type="button" class="btn btn-success" onclick="mostrarModalStock({{ $producto->id }}, '{{ $producto->name }}', {{ $producto->stock }})">
                        <i class="fas fa-boxes"></i> Stock
                    </button>
                    <a href="{{ route('productos.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-chart-line"></i> Historial de Ventas</h5>
            </div>
            <div class="card-body">
                @if($producto->detallePedidos->count() > 0)
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="card bg-info text-white">
                                <div class="card-body text-center">
                                    <h4>{{ $producto->detallePedidos->sum('cantidad') }}</h4>
                                    <p class="mb-0">Unidades Vendidas</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <h4>${{ number_format($producto->detallePedidos->sum('subtotal'), 2) }}</h4>
                                    <p class="mb-0">Total Ingresos</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-warning text-white">
                                <div class="card-body text-center">
                                    <h4>{{ $producto->detallePedidos->count() }}</h4>
                                    <p class="mb-0">Pedidos</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Pedido</th>
                                    <th>Cliente</th>
                                    <th>Fecha</th>
                                    <th>Cantidad</th>
                                    <th>Precio Unit.</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($producto->detallePedidos->sortByDesc('created_at') as $detalle)
                                <tr>
                                    <td>
                                        <a href="{{ route('pedidos.show', $detalle->pedido->id) }}">
                                            #{{ $detalle->pedido->id }}
                                        </a>
                                    </td>
                                    <td>{{ $detalle->pedido->cliente->name }}</td>
                                    <td>{{ $detalle->pedido->fecha->format('d/m/Y') }}</td>
                                    <td>{{ $detalle->cantidad }}</td>
                                    <td>${{ number_format($detalle->precio_unitario, 2) }}</td>
                                    <td>${{ number_format($detalle->subtotal, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Este producto no ha sido vendido aún</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal para Actualizar Stock -->
<div class="modal fade" id="modalStock" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Actualizar Stock</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formStock" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <p>Producto: <strong id="nombreProducto"></strong></p>
                    <div class="mb-3">
                        <label for="stock" class="form-label">Nuevo Stock</label>
                        <input type="number" class="form-control" id="stock" name="stock" min="0" required>
                        <div class="form-text">Stock actual: <span id="stockActual"></span></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Actualizar Stock</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function mostrarModalStock(productoId, nombreProducto, stockActual) {
    document.getElementById('nombreProducto').textContent = nombreProducto;
    document.getElementById('stockActual').textContent = stockActual;
    document.getElementById('stock').value = stockActual;
    
    const form = document.getElementById('formStock');
    form.action = `/productos/${productoId}/stock`;
    
    const modal = new bootstrap.Modal(document.getElementById('modalStock'));
    modal.show();
}
</script>
@endsection