@extends('layouts.app') <!-- Extiende el layout principal -->

@section('title', 'Listado Colecciones') <!-- Define el título de la página -->

@section('content') <!-- Define el contenido dinámico -->
    <div class="container">
        <h2>Detalles</h2>
        <a href="/collections" class="btn btn-primary mb-3">Volver</a>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                </tr>
            </thead>
            <tbody>
               
                    <tr>
                        <td>{{ $collection->id }}</td>
                        <td>{{ $collection->name }}</td>
                    </tr>
               
            </tbody>
        </table>
    </div>
@endsection