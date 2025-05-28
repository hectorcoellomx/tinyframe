@extends('layouts.app')

@section('title', 'Agregar Categoría')

@section('content')
    <div class="container">
        <a href="{{ route('categories.index') }}" class="btn btn-primary mb-3">Volver</a>
        <h2>Crear Categoría</h2>
        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
@endsection