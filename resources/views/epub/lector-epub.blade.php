{{-- @extends('layouts.app')

@section('title', 'Lector EPUB')

@section('content')
<div class="container">
    <h2 class="text-center my-4">Lector de Libros EPUB</h2>
    <div id="viewer" style="height: 600px; border: 1px solid #ccc;"></div>
</div>

<script src="https://unpkg.com/epubjs/dist/epub.min.js"></script>
<script>
    const book = ePub("{{ url('storage/files/' . $archivo) }}");
    const rendition = book.renderTo("viewer", {
        width: "100%",
        height: 600,
    });
    rendition.display();
</script>
@endsection --}}

@extends('layouts.app')

@section('title', 'Lector EPUB - ' . basename($archivo))

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Lector de EPUB</h2>
        <a href="{{ url()->previous() }}" class="btn btn-outline-primary">
            <i class="bi bi-arrow-left"></i> Volver al libro
        </a>
    </div>
    
    <div id="epub-viewer" style="width: 100%; height: 80vh; border: 1px solid #ddd;"></div>
    
    <div class="mt-3 text-center">
        <button id="prev-page" class="btn btn-primary mx-2">
            <i class="bi bi-chevron-left"></i> Anterior
        </button>
        <span id="page-info" class="mx-3"></span>
        <button id="next-page" class="btn btn-primary mx-2">
            Siguiente <i class="bi bi-chevron-right"></i>
        </button>
    </div>
    
    <!-- Loader -->
    <div id="epub-loader" class="text-center mt-3">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Cargando libro...</span>
        </div>
        <p class="mt-2">Cargando libro, por favor espere...</p>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/epubjs@0.3.93/dist/epub.min.js"></script>
<script>
    // Pasar variables PHP a JavaScript
    window.epubConfig = {
        bookPath: "/storage/files/{{ $archivo }}",
        enableDebug: {{ config('app.debug') ? 'true' : 'false' }}
    };
</script>
<script src="{{ asset('js/epub-reader.js') }}"></script>
@endsection


