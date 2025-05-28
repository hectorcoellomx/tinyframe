@extends('layouts.app')

@section('title', 'Editar libro')

@section('content')
    <div class="container">
        <h2>Editar Libro</h2>
        <form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="title">Título:</label>
                <input type="text" name="title" id="title" class="form-control" value="{{$book->title}}" required>
            </div>
            <div class="form-group">
                <label for="cover_photo">Portada:</label>
                <input type="file" name="cover_photo" id="cover_photo" class="form-control" value="{{$book->cover_photo}}">
            </div>
            <div class="form-group">
                <label for="description">Descripción:</label>
                <textarea name="description" id="description" class="form-control"  required>{{$book->description}}</textarea>
            </div>
            <div class="form-group">
                <label for="file">Archivo EPUB</label>
                <input type="file" name="file" id="file" class="form-control" accept="application/epub+zip">
            </div>
            <div class="form-group">
                <label for="year">Año:</label>
                <input type="number" name="year" id="year" class="form-control" value="{{$book->year}}" required>
            </div>
            <div class="form-group">
                <label for="keywords">Palabras clave:</label>
                <input type="text" name="keywords" id="keywords" class="form-control" value="{{$book->keywords}}" required>
            </div>
            <!-- Colecciones -->
            <div class="mb-3">
                <label class="form-label">Colecciones:</label>
                <div>
                    @foreach($collections as $collection)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="collection_ids[]" id="collection_{{ $collection->id }}" value="{{ $collection->id }}"
                                {{ in_array($collection->id, $selectedCollections) ? 'checked' : '' }}>
                            <label class="form-check-label" for="collection_{{ $collection->id }}">
                                {{ $collection->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
                <small class="text-muted">Selecciona una o más colecciones.</small>
            </div>

            <!-- Autores -->
            <div class="mb-3">
                <label class="form-label">Autores:</label>
                <div>
                    @foreach($authors as $author)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="author_ids[]" id="author_{{ $author->id }}" value="{{ $author->id }}"
                                {{ in_array($author->id, $selectedAuthors) ? 'checked' : '' }}>
                            <label class="form-check-label" for="author_{{ $author->id }}">
                                {{ $author->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
                <small class="text-muted">Selecciona uno o más autores.</small>
            </div>

            <!-- Categorías -->
            <div class="mb-3">
                <label class="form-label">Categorías:</label>
                <div>
                    @foreach($categories as $category)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="category_ids[]" id="category_{{ $category->id }}" value="{{ $category->id }}"
                                {{ in_array($category->id, $selectedCategories) ? 'checked' : '' }}>
                            <label class="form-check-label" for="category_{{ $category->id }}">
                                {{ $category->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
                <small class="text-muted">Selecciona una o más categorías.</small>
            </div>


            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
@endsection