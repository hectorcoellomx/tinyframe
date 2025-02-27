@extends('layouts.app')

@section('title', 'Listado de Colecciones')

@section('content')
    <div class="container">
        <h2>Listado de Colecciones</h2>
        <a href="/collections/create"  class="btn btn-primary mb-3">Agregar Coleccion</a>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($collections as $collection)
                    <tr>
                        {{-- <td>{{ $collection->id }}</td> --}}
                        <td>{{ $collection->id }}</td>
                        <td>{{ $collection->name }}</td>
                        <td>
                            <a href="/collections/{{$collection -> id}}" class="btn btn-warning mb-3">Editar</a>
                        </td>
                        <td>
                            <a class="btn btn-danger mb-3">Eliminar</a>
                        </td>
                        {{-- <td>
                            <a href="{{ route('books.edit', $book->id) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('books.destroy', $book->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </td> --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
