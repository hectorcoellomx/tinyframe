@extends('layouts.app')

@section('title', 'Redireccionando al lector EPUB...')

@section('content')
<script>
    // Redirección directa al lector de Bibi con el archivo
    window.location.href = "{{ asset('bibi/index.html') }}?book={{ url('storage/files/' . $archivo) }}";
</script>

<noscript>
    <p>Este lector requiere JavaScript para funcionar. Por favor, actívalo.</p>
    <a href="{{ asset('bibi/index.html') }}?book={{ url('storage/files/' . $archivo) }}">Ir al lector manualmente</a>
</noscript>
@endsection



