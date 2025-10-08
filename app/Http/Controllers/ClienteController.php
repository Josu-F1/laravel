<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Cliente::withCount('pedidos')->get();
        
        if (request()->wantsJson()) {
            return response()->json($clientes);
        }
        
        return view('clientes.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clientes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:clientes',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string'
        ]);

        $cliente = Cliente::create($request->all());

        if (request()->wantsJson()) {
            return response()->json([
                'message' => 'Cliente creado exitosamente',
                'cliente' => $cliente
            ], 201);
        }

        return redirect()->route('clientes.index')->with('success', 'Cliente creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cliente = Cliente::with('pedidos.detallePedidos')->findOrFail($id);
        
        if (request()->wantsJson()) {
            return response()->json($cliente);
        }
        
        return view('clientes.show', compact('cliente'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $cliente = Cliente::findOrFail($id);
        return view('clientes.edit', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $cliente = Cliente::findOrFail($id);

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:clientes,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string'
        ]);

        $cliente->update($request->all());

        if (request()->wantsJson()) {
            return response()->json([
                'message' => 'Cliente actualizado exitosamente',
                'cliente' => $cliente
            ]);
        }

        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->delete();

        if (request()->wantsJson()) {
            return response()->json([
                'message' => 'Cliente eliminado exitosamente'
            ]);
        }

        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado exitosamente');
    }
}
