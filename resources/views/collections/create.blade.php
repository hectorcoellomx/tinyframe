@extends('layouts.app')

@section('title', 'Agregar Coleccion')

@section('content')
    <div class="container">
        <a href="/collections" class="btn btn-primary mb-3">Volver</a>
        <h2>Crear Coleccion</h2>
        <form method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
@endsection