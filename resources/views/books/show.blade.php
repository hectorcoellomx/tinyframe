@extends('layouts.app') <!-- Extiende el layout principal -->

@section('title', 'Listado de Libros') <!-- Define el título de la página -->

@section('content') <!-- Define el contenido dinámico -->
    <div class="container">
        <h2>Listado de Libros</h2>
        <a href="/books" class="btn btn-primary mb-3">Volver</a>
        <table class="table">
            <thead>
                <tr>
                    <th>Titulo</th>
                    <th>Descripcion</th>
                    <th>Año</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
               
                    <tr>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->description }}</td>
                        <td>{{ $book->year }}</td>
                        <td>{{ $book->status }}</td>
                    </tr>
               
            </tbody>
        </table>
    </div>
@endsection