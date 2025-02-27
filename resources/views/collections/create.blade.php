@extends('layouts.app')

@section('title', 'Agregar Coleccion')

@section('content')
    <div class="container">
        <a href="/collections" class="btn btn-primary mb-3">Volver</a>
        <h2>Crear Coleccion</h2>
        <form method="POST">
            @csrf
            <div class="form-group">
                <label for="title">Nombre</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="description">Descripción:</label>
                <textarea name="description" class="form-control" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
@endsection