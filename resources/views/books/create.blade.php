@extends('layouts.app')

@section('title', 'Crear Libro')

@section('content')
    <div class="container">
        <h2>Crear Libro</h2>
        <form action="/books" method="POST">
            @csrf
            <div class="form-group">
                <label for="title">Título:</label>
                <input type="text" name="title" id="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="cover_photo">Portada:</label>
                <input type="file" name="cover_photo" id="cover_photo" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="description">Descripción:</label>
                <textarea name="description" id="description" class="form-control" required></textarea>
            </div>
            <div>
                <label for="file">Archivo PDF</label>
                <input type="file" name="file" id="file" accept="application/pdf" required>
            </div>
            <div class="form-group">
                <label for="year">Año:</label>
                <input type="number" name="year" id="year" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="keywords">Palabras clave:</label>
                <input type="text" name="keywords" id="keywords" class="form-control" required>
            </div>
            <div>
                <label for="collections">Colecciones:</label>
                <select name="collections" id="collections" multiple>
                    @foreach($collections as $collection)
                        <option value="{{ $collection->id }}">{{ $collection->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
@endsection