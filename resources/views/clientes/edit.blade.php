@extends('layouts.app')

@section('title', 'Editar Cliente')

@section('content')
<h2>Editar Cliente</h2>

<form action="{{ route('clientes.update', $cliente) }}" method="POST">
    @csrf
    @method('PUT')
    
    <p>
        <label for="name">Nombre *</label><br>
        <input type="text" id="name" name="name" value="{{ old('name', $cliente->name) }}" required>
        @error('name')
            <br><span style="color: red;">{{ $message }}</span>
        @enderror
    </p>

    <p>
        <label for="email">Email *</label><br>
        <input type="email" id="email" name="email" value="{{ old('email', $cliente->email) }}" required>
        @error('email')
            <br><span style="color: red;">{{ $message }}</span>
        @enderror
    </p>

    <p>
        <label for="phone">Teléfono</label><br>
        <input type="text" id="phone" name="phone" value="{{ old('phone', $cliente->phone) }}">
        @error('phone')
            <br><span style="color: red;">{{ $message }}</span>
        @enderror
    </p>

    <p>
        <label for="address">Dirección</label><br>
        <textarea id="address" name="address" rows="3">{{ old('address', $cliente->address) }}</textarea>
        @error('address')
            <br><span style="color: red;">{{ $message }}</span>
        @enderror
    </p>

    <p>
        <a href="{{ route('clientes.index') }}">Volver</a> | 
        <button type="submit">Actualizar Cliente</button>
    </p>
</form>
@endsection