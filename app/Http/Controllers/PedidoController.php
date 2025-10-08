<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Producto;
use App\Models\Cliente;
use App\Models\DetallePedido;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pedidos = Pedido::with(['cliente', 'detallePedidos'])
                        ->withCount('detallePedidos')
                        ->orderBy('created_at', 'desc')
                        ->get();
        
        if (request()->wantsJson()) {
            return response()->json($pedidos);
        }
        
        return view('pedidos.index', compact('pedidos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clientes = Cliente::orderBy('name')->get();
        $productos = Producto::where('stock', '>', 0)->orderBy('name')->get();
        
        return view('pedidos.create', compact('clientes', 'productos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'fecha' => 'required|date',
            'productos' => 'required|array',
            'productos.*.producto_id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1'
        ]);

        try {
            DB::beginTransaction();

            // Verificar stock disponible para todos los productos
            foreach ($request->productos as $item) {
                $producto = Producto::findOrFail($item['producto_id']);
                if ($producto->stock < $item['cantidad']) {
                    
                    if (request()->wantsJson()) {
                        return response()->json([
                            'error' => "Stock insuficiente para el producto: {$producto->name}. Stock disponible: {$producto->stock}"
                        ], 400);
                    }
                    
                    return redirect()->back()
                                   ->withInput()
                                   ->with('error', "Stock insuficiente para el producto: {$producto->name}. Stock disponible: {$producto->stock}");
                }
            }

            // Crear el pedido
            $pedido = Pedido::create([
                'cliente_id' => $request->cliente_id,
                'fecha' => $request->fecha,
                'total' => 0,
                'estado' => 'pendiente'
            ]);

            $total = 0;

            // Crear detalles del pedido y actualizar stock
            foreach ($request->productos as $item) {
                $producto = Producto::findOrFail($item['producto_id']);
                $subtotal = $producto->price * $item['cantidad'];

                DetallePedido::create([
                    'pedido_id' => $pedido->id,
                    'producto_id' => $producto->id,
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $producto->price,
                    'subtotal' => $subtotal
                ]);

                // Actualizar stock
                $producto->decrement('stock', $item['cantidad']);
                $total += $subtotal;
            }

            // Actualizar total del pedido
            $pedido->update(['total' => $total]);

            DB::commit();

            $pedido->load(['cliente', 'detallePedidos.producto']);

            if (request()->wantsJson()) {
                return response()->json([
                    'message' => 'Pedido creado exitosamente',
                    'pedido' => $pedido
                ], 201);
            }

            return redirect()->route('pedidos.index')->with('success', 'Pedido creado exitosamente');

        } catch (\Exception $e) {
            DB::rollBack();
            
            if (request()->wantsJson()) {
                return response()->json([
                    'error' => 'Error al crear el pedido: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Error al crear el pedido: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pedido = Pedido::with(['cliente', 'detallePedidos.producto'])->findOrFail($id);
        
        if (request()->wantsJson()) {
            return response()->json($pedido);
        }
        
        return view('pedidos.show', compact('pedido'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pedido = Pedido::with(['cliente', 'detallePedidos.producto'])->findOrFail($id);
        $clientes = Cliente::orderBy('name')->get();
        
        return view('pedidos.edit', compact('pedido', 'clientes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pedido = Pedido::findOrFail($id);

        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'fecha' => 'required|date',
            'estado' => 'required|in:pendiente,completado,cancelado'
        ]);

        // Si se cancela el pedido, restaurar stock
        if ($request->estado === 'cancelado' && $pedido->estado !== 'cancelado') {
            foreach ($pedido->detallePedidos as $detalle) {
                $detalle->producto->increment('stock', $detalle->cantidad);
            }
        }
        
        // Si se reactiva un pedido cancelado, reducir stock nuevamente
        if ($pedido->estado === 'cancelado' && $request->estado !== 'cancelado') {
            foreach ($pedido->detallePedidos as $detalle) {
                $detalle->producto->decrement('stock', $detalle->cantidad);
            }
        }

        $pedido->update($request->only(['cliente_id', 'fecha', 'estado']));

        if (request()->wantsJson()) {
            return response()->json([
                'message' => 'Pedido actualizado exitosamente',
                'pedido' => $pedido->load(['cliente', 'detallePedidos.producto'])
            ]);
        }

        return redirect()->route('pedidos.index')->with('success', 'Pedido actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();

            $pedido = Pedido::with('detallePedidos')->findOrFail($id);

            // Restaurar stock si el pedido no está cancelado
            if ($pedido->estado !== 'cancelado') {
                foreach ($pedido->detallePedidos as $detalle) {
                    $detalle->producto->increment('stock', $detalle->cantidad);
                }
            }

            $pedido->delete();

            DB::commit();

            if (request()->wantsJson()) {
                return response()->json([
                    'message' => 'Pedido eliminado exitosamente'
                ]);
            }

            return redirect()->route('pedidos.index')->with('success', 'Pedido eliminado exitosamente');

        } catch (\Exception $e) {
            DB::rollBack();
            
            if (request()->wantsJson()) {
                return response()->json([
                    'error' => 'Error al eliminar el pedido: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Error al eliminar el pedido: ' . $e->getMessage());
        }
    }
}
