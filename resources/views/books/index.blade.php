@extends('layouts.app')

@section('title', 'Listado de Libros')

@section('content')
    <div class="container">
        <h2>Listado de Libros</h2>
        <a href="/books/create" class="btn btn-primary mb-3">Agregar Libro</a>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        

        <table class="table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Título</th>
                    <th>Portada</th>
                    <th>Descripción</th>
                    <th>Año</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                    <th>Descargar</th>
                </tr>
            </thead>
            <tbody>
                @foreach($books as $book)
                    <tr>
                        <td>{{ $book->id }}</td>
                        <td>{{ $book->title }}</td>
                        <td>
                            <img src="{{ asset('storage/' . $book->cover_photo) }}" class="img-thumbnail" width="300">
                        </td>
                        <td>{{ $book->description }}</td>
                        <td>{{ $book->year }}</td>
                        <td>
                            <a href="/books/{{$book -> id}}/edit" class="btn btn-warning mb-3" >
                                <i class="bi bi-pencil-square"></i>
                            </a>
                        </td>
                        <td>
                            <form action="/books/{{$book->id}}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger mb-3">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                        <td>
                            @if($book->file) <!-- Verifica si el archivo existe -->
                                <a href="{{ asset('storage/' . $book->file) }}" class="btn btn-success" download>
                                    <i class="bi bi-download"></i>
                                </a>
                            @else
                                <span class="text-muted">No disponible</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{$books->links()}}
@endsection