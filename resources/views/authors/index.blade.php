@extends('layouts.app')

@section('title', 'Listado de Autores')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Listado de Autores</h2>
            <a href="/authors/create" class="btn btn-primary mb-3">Agregar Autor</a>
        </div>
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
                    <th>Editar</th>
                    <th>Eliminar</th>
                    
                </tr>
            </thead>
            <tbody>
                @foreach($authors as $author)
                    <tr>
                        <td>{{ $author->id }}</td>
                        <td>{{ $author->name }}</td>
                        <td>
                            <a href="/authors/{{$author -> id}}/edit" class="btn btn-warning mb-3" >
                                <i class="bi bi-pencil-square"></i>
                            </a>
                        </td>
                        <td>
                            <x-delete-confirmation 
                                :actionUrl="'/authors/' . $author->id" 
                                :itemName="$author->name" 
                                :itemId="$author->id" 
                            />
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{$authors->links()}}
@endsection