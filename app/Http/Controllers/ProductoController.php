<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = Producto::all();
        
        if (request()->wantsJson()) {
            return response()->json($productos);
        }
        
        return view('productos.index', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('productos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0'
        ]);

        $producto = Producto::create($request->all());

        if (request()->wantsJson()) {
            return response()->json([
                'message' => 'Producto creado exitosamente',
                'producto' => $producto
            ], 201);
        }

        return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $producto = Producto::with('detallePedidos.pedido.cliente')->findOrFail($id);
        
        if (request()->wantsJson()) {
            return response()->json($producto);
        }
        
        return view('productos.show', compact('producto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $producto = Producto::findOrFail($id);
        return view('productos.edit', compact('producto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $producto = Producto::findOrFail($id);

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'sometimes|required|numeric|min:0',
            'stock' => 'sometimes|required|integer|min:0'
        ]);

        $producto->update($request->all());

        if (request()->wantsJson()) {
            return response()->json([
                'message' => 'Producto actualizado exitosamente',
                'producto' => $producto
            ]);
        }

        return redirect()->route('productos.index')->with('success', 'Producto actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();

        if (request()->wantsJson()) {
            return response()->json([
                'message' => 'Producto eliminado exitosamente'
            ]);
        }

        return redirect()->route('productos.index')->with('success', 'Producto eliminado exitosamente');
    }

    /**
     * Actualizar stock del producto
     */
    public function updateStock(Request $request, string $id)
    {
        $producto = Producto::findOrFail($id);

        $request->validate([
            'stock' => 'required|integer|min:0'
        ]);

        $producto->update(['stock' => $request->stock]);

        if (request()->wantsJson()) {
            return response()->json([
                'message' => 'Stock actualizado exitosamente',
                'producto' => $producto
            ]);
        }

        return redirect()->back()->with('success', 'Stock actualizado exitosamente');
    }
}
