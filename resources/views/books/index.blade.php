@extends('layouts.app')

@section('title', 'Listado de Libros')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Listado de Libros</h2>
            <a href="/books/create" class="btn btn-primary">Agregar Libro</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tabla -->
        <table class="table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Título</th>
                    <th>Portada</th>
                    <th>Descripción</th>
                    <th>Año</th>
                    <th>Calificación</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                    <th>Detalles</th>
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
                        <td>{{ number_format($book->calificacion, 1) }}</td> <!-- Mostrar el promedio -->
                        <td>
                            <a href="/books/{{$book->id}}/edit" class="btn btn-warning">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                        </td>
                        <td>
                            <x-delete-confirmation 
                                :actionUrl="'/books/' . $book->id" 
                                :itemName="$book->title" 
                                :itemId="$book->id" 
                            />
                        </td>
                        <td>
                            <a href="/books/{{$book->id}}" class="btn btn-success">
                                <i class="bi bi-eye-fill"></i>
                            </a>
                            
                            {{-- @if($book->file) <!-- Verifica si el archivo existe -->
                                <a href="{{ asset('storage/' . $book->file) }}" class="btn btn-success" download>
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                            @else
                                <span class="text-muted">No disponible</span>
                            @endif --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{$books->links()}}
@endsection