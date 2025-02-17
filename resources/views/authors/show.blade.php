@extends('layouts.app') <!-- Extiende el layout principal -->

@section('title', 'Listado de Usuarios') <!-- Define el título de la página -->

@section('content') <!-- Define el contenido dinámico -->
    <div class="container">
        <h2>Listado de Libros</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Nombre Autor</th>
                    <th>Libros</th>
                    <th>Anio</th>
                </tr>
            </thead>
            {{-- <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                    </tr>
                @endforeach
            </tbody> --}}
        </table>
    </div>
@endsection