@extends('layouts.app')

@section('title', 'Listado de Colecciones')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Listado de Colecciones</h2>
        <a href="/collections/create"  class="btn btn-primary mb-3">Agregar Coleccion</a>
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
                @foreach($collections as $collection)
                    <tr>
                        {{-- <td>{{ $collection->id }}</td> --}}
                        <td>{{ $collection->id }}</td>
                        <td>{{ $collection->name }}</td>
                        <td>

                            <a href="/collections/{{$collection -> id}}/edit" class="btn btn-warning mb-3 me-5">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                        <td>
                            <x-delete-confirmation 
                                :actionUrl="'/collections/' . $collection->id" 
                                :itemName="$collection->name" 
                                :itemId="$collection->id" 
                            />

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{$collections->links()}}
@endsection
