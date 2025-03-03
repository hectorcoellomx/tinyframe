@extends('layouts.app')

@section('title', 'Agregar Categoría')

@section('content')
    <div class="container">
        <h2>Crear Categoría</h2>
        <form method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
@endsection