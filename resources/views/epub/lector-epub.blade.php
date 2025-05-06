@extends('layouts.app')

@section('title', 'Lector EPUB - ' . $archivo)

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Lector de EPUB</h2>
        <a href="{{ url()->previous() }}" class="btn btn-outline-primary">
            <i class="bi bi-arrow-left"></i> Volver al libro
        </a>
    </div>

    <iframe 
        src="{{ asset('bibi/index.html') }}?book={{ url('storage/files/' . $archivo) }}" 
        style="width: 100%; height: 85vh; border: 1px solid #ccc; border-radius: 6px;"
        allowfullscreen>
        {{-- src="/bibi/index.html?book=/storage/files/{{ $archivo }}"
        style="width: 100%; height: 85vh; border: 1px solid #ccc; border-radius: 6px;"
        allowfullscreen> --}}
    </iframe>

    {{-- <iframe 
        src="{{ asset('bibi/index.html') }}?book={{ asset('storage/files/' . $archivo) }}" 
        style="width: 100%; height: 85vh; border: 1px solid #ccc; border-radius: 6px;"
        allowfullscreen>
    </iframe> --}}
</div>
@endsection

@section('scripts')
{{-- <script src="https://unpkg.com/epubjs@0.3.93/dist/epub.min.js"></script>
<script>
    window.epubConfig = {
        bookPath: "/storage/files/{{ $archivo }}", // <- necesitas pasar '$archivo'
        enableDebug: {{ config('app.debug') ? 'true' : 'false' }}
    };
</script>
<script src="{{ asset('js/epub-reader.js') }}"></script> --}}
@endsection


