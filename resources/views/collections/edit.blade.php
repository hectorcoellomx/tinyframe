@extends('layouts.app')

@section('title', 'Editar coleccion')

@section('content')
    <div class="container">
        <h2>Editar Colección</h2>
        <form action="/collections/{{$collection->id}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Nombre:</label>
                <input type="text" name="name" id="name" class="form-control" value="{{$collection->name}}" required>
            </div>
            
            {{-- <div>
                <label for="collections">Colecciones:</label>
                <select name="collections" id="collections" multiple>
                    @foreach($collections as $collection)
                        <option value="{{ $collection->id }}">{{ $collection->name }}</option>
                    @endforeach
                </select>
            </div> --}}

            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
@endsection