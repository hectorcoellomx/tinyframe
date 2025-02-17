@extends('layouts.app')

@section('title', 'Listado de Usuarios')

@section('content')
    <div class="container">
        <h2>Listado de Usuarios</h2>
        <a class="btn btn-primary mb-3">Agregar Usuario</a>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Ubicación</th>
                    <th>Hobby</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                {{-- @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->location }}</td>
                        <td>{{ $user->hobby }}</td>
                        <td>
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach --}}
            </tbody>
        </table>
    </div>
@endsection