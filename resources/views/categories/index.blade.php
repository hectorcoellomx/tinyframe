@extends('layouts.app')

@section('title', 'Listado de Categorías')

@section('content')
    <div class="container"> 
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Listado de Categorías</h2>
            <a href="{{ route('categories.create') }}"  class="btn btn-primary mb-3">Agregar Categoría</a>
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
                @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>
                            <a href="{{ route('categories.edit',$category->id) }}" class="btn btn-warning mb-3">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                        </td>
                        <td>
                            <x-delete-confirmation 
                                :actionUrl="route('categories.destroy', $category->id)" 
                                :itemName="$category->name" 
                                :itemId="$category->id" 
                            />
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{$categories->links()}}
@endsection
