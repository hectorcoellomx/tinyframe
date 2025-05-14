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
    <nav class="navbar sticky-top navbar-dark bg-dark px-4">
      <div class="container-fluid d-flex justify-content-between align-items-center">
        <a class="navbar-brand" href="{{ route('books') }}">LeeUnach</a>
        <form class="d-flex ms-auto" method="GET" action="{{ route('books') }}">
          <input class="form-control form-control-sm me-2" style="width: 200px;" type="search" name="search" placeholder="Buscar por título" value="{{ request('search') }}">
          <button class="btn btn-outline-success btn-sm" type="submit">Buscar</button>
        </form>
      </div>
    </nav>

    <div class="container my-4">
            <nav class="navbar navbar-light bg-light px-4 mb-3 justify-content-end">
    <button id="toggle-theme" class="btn btn-outline-dark">
        <i class="bi bi-moon-fill"></i> Modo oscuro
    </button>
    </nav>

    <form method="GET" action="{{ route('books') }}">
      <div class="row mb-4">
        <div class="col-md-5">
          <div class="accordion">
            <div class="accordion-header" onclick="toggleAccordion(this)">
              <span>Colecciones</span>
            </div>
            <div class="accordion-body">
              <div class="genre-checkbox">
                <label>
                  <input type="checkbox" id="select-all-collections"> Todas las colecciones
                </label>
                @foreach ($collections as $collection)
                  <label>
                    <input type="checkbox" name="collections[]" value="{{ $collection->id }}"
                      {{ in_array($collection->id, request('collections', [])) ? 'checked' : '' }}>
                    {{ $collection->name }}
                  </label>
                @endforeach
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-5">
          <div class="accordion">
            <div class="accordion-header" onclick="toggleAccordion(this)">
              <span>Categorías</span>
            </div>
            <div class="accordion-body">
              <div class="genre-checkbox">
                <label>
                  <input type="checkbox" id="select-all-categories"> Todas las categorías
                </label>
                @foreach ($categories as $category)
                  <label>
                    <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                      {{ in_array($category->id, request('categories', [])) ? 'checked' : '' }}>
                    {{ $category->name }}
                  </label>
                @endforeach
              </div>
            </div>
          </div>
        </div>

        <div class="col d-flex align-items-end">
          <button class="btn btn-outline-primary w-100" type="submit">Filtrar</button>
        </div>
      </div>
    </form>

    
      {{-- <form method="GET" action="{{ route('books') }}">
        <div class="row mb-4">
          <div class="col">
            <div class="accordion">
              <div class="accordion-header" onclick="toggleAccordion(this)">
                <span>Colecciones</span>
                </div>
                <div class="accordion-body">
                <div class="genre-checkbox">
                @foreach ($collections as $collection)
                  <label>
                    <input type="checkbox" name="collections[]" value="{{ $collection->id }}"
                      {{ in_array($collection->id, request('collections', [])) ? 'checked' : '' }}>
                    {{ $collection->name }}
                  </label>
                @endforeach
              </div>
            </div>
          </div>
          <div class="col">
            <div class="accordion">
              <div class="accordion-header" onclick="toggleAccordion(this)">
                <span>Categorias</span>
              </div>
              <div class="accordion-body">
              <div class="genre-checkbox">
                @foreach ($categories as $category)
                  <label>
                    <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                      {{ in_array($category->id, request('categories', [])) ? 'checked' : '' }}>
                    {{ $category->name }}
                  </label>
                @endforeach
              </div>
            </div>
          </div>
          </div>
          
          <div class="col d-flex align-items-end">
            <button class="btn btn-outline-primary" type="submit">Filtrar</button>
          </div>
        </div>
      </form> --}}

      <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 g-4">
        @foreach ($books as $book)
          <div class="col">
            <div class="card h-100 shadow-sm hover-card">
              <img src="{{ asset('storage/' . $book->cover_photo) }}" class="card-img-top book-img" alt="Portada del libro">
              <div class="card-body d-flex flex-column">
                <h5 class="card-title text-truncate" title="{{ $book->tittle }}">{{ $book->tittle }}</h5>
                <p class="card-text flex-grow-1">{{ Str::limit($book->description, 100) }}</p>
                <a href="{{ url('/lector-epub/' . basename($book->file)) }}" class="btn btn-outline-secondary mt-auto">
                  <i class="bi bi-book"></i> Leer en línea
                </a>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/lookbook.js') }}"></script>
  
  </body>
</html>


    