<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\PedidoController;

// Página principal
Route::get('/', function () {
    return view('home');
});

// Rutas Web para Clientes
Route::resource('clientes', ClienteController::class);

// Rutas Web para Productos
Route::resource('productos', ProductoController::class);
Route::patch('/productos/{id}/stock', [ProductoController::class, 'updateStock'])->name('productos.updateStock');

// Rutas Web para Pedidos
Route::resource('pedidos', PedidoController::class);

// Rutas API para Clientes
Route::prefix('api/clientes')->group(function () {
    Route::get('/', [ClienteController::class, 'index']);
    Route::post('/', [ClienteController::class, 'store']);
    Route::get('/{id}', [ClienteController::class, 'show']);
    Route::put('/{id}', [ClienteController::class, 'update']);
    Route::delete('/{id}', [ClienteController::class, 'destroy']);
});

// Rutas API para Productos
Route::prefix('api/productos')->group(function () {
    Route::get('/', [ProductoController::class, 'index']);
    Route::post('/', [ProductoController::class, 'store']);
    Route::get('/{id}', [ProductoController::class, 'show']);
    Route::put('/{id}', [ProductoController::class, 'update']);
    Route::delete('/{id}', [ProductoController::class, 'destroy']);
    Route::patch('/{id}/stock', [ProductoController::class, 'updateStock']);
});

// Rutas API para Pedidos
Route::prefix('api/pedidos')->group(function () {
    Route::get('/', [PedidoController::class, 'index']);
    Route::post('/', [PedidoController::class, 'store']);
    Route::get('/{id}', [PedidoController::class, 'show']);
    Route::put('/{id}', [PedidoController::class, 'update']);
    Route::delete('/{id}', [PedidoController::class, 'destroy']);
});
