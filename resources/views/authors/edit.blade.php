@extends('layouts.app')

@section('title', 'Editar Autor')

@section('content')
    <div class="container">
        <h2>Editar Libro</h2>
        <form action="/authors/{{$author->id}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="title">Nombre</label>
                <input type="text" name="name" id="name" class="form-control" value="{{$author->name}}">
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
@endsection