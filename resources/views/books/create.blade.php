@extends('layouts.app')

@section('title', 'Crear Libro')

@section('content')
    <div class="container">
        <h2>Crear Libro</h2>
        <form action="/books" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="title">Título:</label>
                <input type="text" name="title" id="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="cover_photo">Portada:</label>
                <input type="file" name="cover_photo" id="cover_photo" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="description">Descripción:</label>
                <textarea name="description" id="description" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label for="file">Archivo (PDF o EPUB)</label>
                <input type="file" name="file" id="file" class="form-control" accept="application/epub+zip" required>
            </div>
            <div class="form-group">
                <label for="year">Año:</label>
                <input type="number" name="year" id="year" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="keywords">Palabras clave:</label>
                <input type="text" name="keywords" id="keywords" class="form-control" required>
            </div>  
            <!-- Autores -->
            <div class="mb-3">
                <label class="form-label">Autores:</label>
                <div>
                    @foreach($authors as $author)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="author_ids[]" id="author_{{ $author->id }}" value="{{ $author->id }}">
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
                            <input class="form-check-input" type="checkbox" name="category_ids[]" id="category_{{ $category->id }}" value="{{ $category->id }}">
                            <label class="form-check-label" for="category_{{ $category->id }}">
                                {{ $category->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
                <small class="text-muted">Selecciona una o más categorías.</small>
            </div>

            <!-- Colecciones -->
            <div class="mb-3">
                <label class="form-label">Colecciones:</label>
                <div>
                    @foreach($collections as $collection)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="collection_ids[]" id="collection_{{ $collection->id }}" value="{{ $collection->id }}">
                            <label class="form-check-label" for="collection_{{ $collection->id }}">
                                {{ $collection->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
                <small class="text-muted">Selecciona una o más colecciones.</small>
            </div>
            
            {{-- <div class="mb-3">
                <label class="form-label">Colecciones:</label>
                <div>
                    @foreach($collections as $collection)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="collections_ids[]" id="collection_{{ $collection->id }}" value="{{ $collection->id }}">
                            <label class="form-check-label" for="collection_{{ $collection->id }}">
                                {{ $collection->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
                <small class="text-muted">Selecciona una o más colecciones.</small>
            </div>
            <div class="mb-3">
                <label class="form-label">Autores:</label>
                <div>
                    @foreach($authors as $author)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="authors_ids[]" id="author_{{ $author->id }}" value="{{ $author->id }}">
                            <label class="form-check-label" for="author_{{ $author->id }}">
                                {{ $author->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
                <small class="text-muted">Selecciona una o más colecciones.</small>
            </div> --}}
            {{-- <select name="author_ids[]" multiple required>
                @foreach($authors as $author)
                    <option value="{{ $author->id }}">{{ $author->name }}</option>
                @endforeach
            </select> --}}
            {{-- <div>
                <label for="collections">Colecciones:</label>
                <select name="collections" id="collections" multiple>
                    @foreach($collections as $collection)
                        <option value="{{ $collection->id }}">{{ $collection->name }}</option>
                    @endforeach
                </select>
            </div> --}}

            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
@endsection