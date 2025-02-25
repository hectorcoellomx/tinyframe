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

        <ul>
            @foreach($books as $book)
                <li>
                    <a href="/books/{{$book -> id}}">{{$book -> title}}</a>
                </li>

            @endforeach
        </ul>

        {{-- <table class="table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Título</th>
                    <th>Portada</th>
                    <th>Descripción</th>
                    <th>Año</th>
                    <th>Estatus</th>
                </tr>
            </thead>
            <tbody>
                @foreach($books as $book)
                    <tr>
                        <td>{{ $book->id }}</td>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->cover_photo }}</td>
                        <td>{{ $book->description }}</td>
                        <td>{{ $book->year }}</td>
                        <td>{{ $book->status }}</td>
                        {{-- <td>
                            <a href="{{ route('books.edit', $book->id) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('books.destroy', $book->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </td> }}
                    </tr>
                @endforeach
            </tbody>
        </table> --}}
    </div>
@endsection