@extends('layouts.app') <!-- Extiende el layout principal -->

@section('title', 'Listado de Autores') <!-- Define el título de la página -->

@section('content') <!-- Define el contenido dinámico -->
    <div class="container">
        <h2>Listado de Autores</h2>
        <a href="/authors" class="btn btn-primary mb-3">
            <i class="bi bi-arrow-left"></i>
        </a>
        <table class="table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nombre Autor</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $author->id }}</td>
                    <td>{{ $author->name }}</td>
                </tr>
             
            </tbody>
        </table>
    </div>
@endsection