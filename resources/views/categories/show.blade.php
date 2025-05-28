@extends('layouts.app') <!-- Extiende el layout principal -->

@section('title', 'Listado de Categorias') <!-- Define el título de la página -->

@section('content') <!-- Define el contenido dinámico -->
    <div class="container">
        <h2>Listado de Categorias</h2>
        <a href="{{ route('categories.index') }}" class="btn btn-primary mb-3">
            <i class="bi bi-arrow-left"></i>
        </a>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Categoria</th>

            </thead>
            <tbody>
                <tr>
                    <td>{{ $category->id}}</td>
                    <td>{{ $category->name}}</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection