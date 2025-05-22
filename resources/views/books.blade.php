<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Libros</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/lookbook.css') }}">
  </head>
  <body class="light-mode">
    @php
    $filtersActive = !session('filters_applied') && (
      request()->has('search') || request()->has('collections') || request()->has('categories')
    );
  @endphp


    {{-- @php
      $filtersActive = request()->has('search') || request()->has('collections') || request()->has('categories');
    @endphp --}}

    <nav class="navbar sticky-top px-3 py-2 custom-navbar">
      <div class="container-fluid d-flex justify-content-between align-items-center flex-wrap">
        <a class="navbar-brand me-3" href="{{ route('books') }}">
          <img src="{{ asset('img/logo.svg') }}" alt="Logo" class="logo-img">
        </a>

        <form class="d-flex ms-auto" method="GET" action="{{ route('books') }}">
          <input class="form-control form-control-sm me-2" style="width: 200px;" type="search" name="search" placeholder="Buscar por título" value="{{ request('search') }}">
          <button class="btn btn-outline-success btn-sm" type="submit">Buscar</button>
        </form>
      </div>
    </nav>

    <div class="container my-4">
      <nav class="navbar navbar-light bg-light px-4 mb-4 justify-content-end">
        <div class="d-flex gap-2">
          <button id="fitoggle" 
              class="btn btn-outline-primary w-100" 
              type="button"
              style="display: {{ $filtersActive ? 'none' : 'inline-block' }}; min-width: 140px; height: 42px">
              Filtrar<span id="filter-count" class="badge bg-primary ms-1" style="display: none;">0</span>
          </button>

          <button id="toggle-theme" class="btn btn-outline-dark" style="min-width: 140px; height: 42px; white-space: nowrap;">
            <i class="bi bi-moon-fill me-2"></i> Modo oscuro
          </button>
        </div>
      </nav>
    <div class="container">
      <div id="filter-form"
          class="py-4 filter-wrapper"
          style="display: {{ $filtersActive ? 'block' : 'none' }};">
        <form method="GET" action="{{ route('books') }}">
          <div class="row mb-4">
            <div class="col-md-6">
              <div class="card">
                <div class="card-header fw-bold">Colecciones</div>
                <div class="card-body">
                  @foreach ($collections as $collection)
                    <div class="form-check">
                      <input type="checkbox"
                            class="form-check-input collection-checkbox"
                            id="collection-{{ $collection->id }}"
                            name="collections[]"
                            value="{{ $collection->id }}"
                            {{ in_array($collection->id, request('collections', [])) ? 'checked' : '' }}>
                      <label class="form-check-label" for="collection-{{ $collection->id }}">
                        {{ $collection->name }}
                      </label>
                    </div>
                  @endforeach
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="card">
                <div class="card-header fw-bold">Categorías</div>
                <div class="card-body">
                  @foreach ($categories as $category)
                    <div class="form-check">
                      <input type="checkbox"
                            class="form-check-input category-checkbox"
                            id="category-{{ $category->id }}"
                            name="categories[]"
                            value="{{ $category->id }}"
                            {{ in_array($category->id, request('categories', [])) ? 'checked' : '' }}>
                      <label class="form-check-label" for="category-{{ $category->id }}">
                        {{ $category->name }}
                      </label>
                    </div>
                  @endforeach
                </div>
              </div>
            </div>
          </div>

        <div class="d-flex justify-content-end gap-2">
          <button id="filter-close" class="btn btn-outline-primary" type="button">Cerrar</button>
          <button id="apply-filters" class="btn btn-outline-primary" type="submit">Aplicar</button>
        </div>
      </form>
    </div>
  </div>
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
        @foreach ($books as $book)
          <div class="col">
            <div class="card h-100 shadow-sm hover-card">
              <img src="{{ asset('storage/' . $book->cover_photo) }}" class="card-img-top book-img" alt="Portada del libro">
              <div class="card-body d-flex flex-column">
                <h5 class="card-title text-truncate" title="{{ $book->tittle }}">{{ $book->tittle }}</h5>
                <div class="flex-grow-1 mb-3" style="min-height: 90px;">
                  <p class="card-text">{{ Str::limit($book->description, 100) }}</p>
                </div>
                <div class="container mt-auto">
                  <div class="row mb-4 gx-2">
                    <div class="col-12 mb-3">
                      <a href="{{ url('/lector-epub/' . basename($book->file)) }}" 
                        class="btn custom-button w-100">
                        <i class="bi bi-book me-1"></i> 
                        <span>Leer en linea</span> 
                      </a>
                    </div>
                    <div class="col-12">
                      <a href="{{ asset('storage/' . $book->file) }}" 
                        class="btn custom-button w-100"
                        download>
                        <i class="bi bi-cloud-arrow-down me-1"></i>
                        <span>Descargar Epub</span> 
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endforeach
        @if ($books->isEmpty())
          <div class="alert alert-warning text-center w-100 mt-4" role="alert">
            <i class="bi bi-exclamation-circle"></i> No se encontraron libros.
          </div>
        @endif

      </div>
      
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/lookbook.js') }}"></script>
  
  </body>
</html>


    