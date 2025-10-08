@extends('layouts.app')

@section('title', 'Clientes')

@section('content')
<h2>Lista de Clientes</h2>
<p>
    <a href="{{ url('/') }}">Inicio</a> | 
    <a href="{{ route('clientes.create') }}">Nuevo Cliente</a>
</p>

<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Teléfono</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($clientes as $cliente)
        <tr>
            <td>{{ $cliente->id }}</td>
            <td>{{ $cliente->name }}</td>
            <td>{{ $cliente->email }}</td>
            <td>{{ $cliente->phone ?? '-' }}</td>
            <td>
                <a href="{{ route('clientes.show', $cliente->id) }}">Ver</a> | 
                <a href="{{ route('clientes.edit', $cliente->id) }}">Editar</a> | 
                <form method="POST" action="{{ route('clientes.destroy', $cliente->id) }}" style="display: inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('¿Eliminar cliente?')">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@if($clientes->isEmpty())
    <p>No hay clientes registrados</p>
    <p><a href="{{ route('clientes.create') }}">Crear Primer Cliente</a></p>
@endif
@endsection