@extends('layouts.app')

@section('title', 'Crear Libro')

@section('content')
    <div class="container">
        <h2>Crear Libro</h2>
        <form method="POST">
            @csrf
            <div class="form-group">
                <label for="title">Título:</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="year">Portada:</label>
                <input type="number" name="cover_photo" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="description">Descripción:</label>
                <textarea name="description" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label for="year">Año:</label>
                <input type="number" name="year" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="year">Keywords:</label>
                <input type="number" name="keywords" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="year">Estatus:</label>
                <input type="number" name="status" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
@endsection