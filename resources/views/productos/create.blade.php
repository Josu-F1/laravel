@extends('layouts.app')

@section('title', 'Crear Producto')

@section('content')
<h2>Crear Nuevo Producto</h2>

<form action="{{ route('productos.store') }}" method="POST">
    @csrf
    
    <p>
        <label for="name">Nombre *</label><br>
        <input type="text" id="name" name="name" value="{{ old('name') }}" required>
        @error('name')
            <br><span style="color: red;">{{ $message }}</span>
        @enderror
    </p>

    <p>
        <label for="description">Descripción</label><br>
        <textarea id="description" name="description" rows="3">{{ old('description') }}</textarea>
        @error('description')
            <br><span style="color: red;">{{ $message }}</span>
        @enderror
    </p>

    <p>
        <label for="price">Precio *</label><br>
        <input type="number" step="0.01" id="price" name="price" value="{{ old('price') }}" required>
        @error('price')
            <br><span style="color: red;">{{ $message }}</span>
        @enderror
    </p>

    <p>
        <label for="stock">Stock *</label><br>
        <input type="number" id="stock" name="stock" value="{{ old('stock', 0) }}" required>
        @error('stock')
            <br><span style="color: red;">{{ $message }}</span>
        @enderror
    </p>

    <p>
        <a href="{{ route('productos.index') }}">Volver</a> | 
        <button type="submit">Crear Producto</button>
    </p>
</form>
@endsection