@php use Illuminate\Support\Str; @endphp
@extends('layouts.app')



@section('title', $book->title)

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
<style>
    body {
        font-family: 'Roboto', sans-serif;
    }

    .book-container {
        max-width: 960px;
        margin: auto;
        padding: 2rem 1rem;
    }

    .book-cover {
        display: block;
        margin: auto;
        max-width: 300px;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .book-title {
        font-size: 2rem;
        font-weight: bold;
        margin-top: 2rem;
        text-align: center;
    }

    .book-author {
        font-size: 1rem;
        color: #555;
        text-align: center;
        margin-bottom: 2rem;
    }

    .book-description {
        text-align: justify;
        margin-top: 1rem;
        font-size: 1rem;
        color: #333;
    }

    .book-meta {
        margin-top: 2rem;
        font-size: 0.95rem;
    }

    .meta-label {
        font-weight: bold;
    }

    .download-section {
        margin-top: 3rem;
        text-align: center;
    }

    .btn-custom {
        background-color: #0056b3;
        color: white;
        padding: 0.75rem 2rem;
        font-size: 1rem;
        border-radius: 8px;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-custom:hover {
        background-color: #003f7f;
    }

    .btn-outline-secondary {
        padding: 0.75rem 2rem;
        font-size: 1rem;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
</style>

<div class="container book-container">
    <a href="/books" class="btn btn-outline-primary mb-4">
        <i class="bi bi-arrow-left"></i> Volver al listado
    </a>

    <div class="text-center">
        <img src="{{ asset('storage/' . $book->cover_photo) }}" alt="Portada del libro" class="img-fluid book-cover">
    </div>

    <div class="book-title">{{ $book->title }}</div>
    <div class="book-author">
        <i class="bi bi-person-circle"></i> {{ $book->author ?? 'Autor desconocido' }}
    </div>

    <div class="book-description">
        {{ $book->description }}
    </div>

    <div class="row book-meta mt-4">
        <div class="col-md-6">
            <p><span class="meta-label">Título en inglés:</span> {{ $book->title_en ?? 'N/A' }}</p>
            <p><span class="meta-label">Categorías:</span>            </p>
            <p><span class="meta-label">Idioma:</span> {{ $book->language ?? 'Español' }}</p>
        </div>
        <div class="col-md-6">
            <p><span class="meta-label">Formato:</span> {{ $book->format ?? 'Desconocido' }}</p>
            <p><span class="meta-label">Código:</span> {{ $book->code ?? 'N/A' }}</p>
        </div>
    </div>

    <div class="download-section">
        <p><span class="meta-label">Opciones:</span></p>
        <div class="d-flex justify-content-center flex-wrap gap-3">
            @if($book->file && Str::endsWith($book->file, '.epub'))
            <a href="{{ url('/lector-epub/' . basename($book->file)) }}" class="btn btn-outline-secondary">
                <i class="bi bi-book"></i> Leer en línea
            </a>
            @else
                <span class="text-muted">No disponible para lectura en línea</span>
            @endif

{{-- 
            <a href="#" class="btn btn-outline-secondary">
                <i class="bi bi-book"></i> Leer en línea
            </a> --}}
        </div>
    </div>
</div>
@endsection




