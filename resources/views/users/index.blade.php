@extends('layouts.app')

@section('title', 'Listado de Usuarios')

@section('content')
    <div class="container">
        <h2>Listado de Usuarios</h2>
        {{-- <a class="btn btn-primary mb-3">Agregar Usuario</a> --}}

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Tipo de cuenta</th>
                    <th>Ultimo acceso</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->type_text }}</td>
                        <td>{{ $user->last_access }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{$users->links()}}
@endsection