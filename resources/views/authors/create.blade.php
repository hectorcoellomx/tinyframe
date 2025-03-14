@extends('layouts.app')

@section('title', 'Agregar Autor')

@section('content')
    <div class="container">
        <h2>Crear Autor</h2>
        <form action="/authors" method="POST">
            @csrf
            <div class="form-group">
                <label for="title">Nombre</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
@endsection