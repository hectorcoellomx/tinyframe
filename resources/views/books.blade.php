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
    <nav class="navbar sticky-top navbar-light bg-dark">
        <div class="d-flex justify-content-between">
          <a class="navbar-brand" href="#">Navbar</a>
          <form class="form-inline">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
          </form>
        </div>
    </nav>
    <div class="container my-4">
            <nav class="navbar navbar-light bg-light px-4 mb-3 justify-content-end">
    <button id="toggle-theme" class="btn btn-outline-dark">
        <i class="bi bi-moon-fill"></i> Modo oscuro
    </button>
    </nav>

    
      <div class="row-cols-2">
        <div class="col">
            <select class="card h-100 shadow-sm hover-card" name="tittle" id="tittle">
                @foreach ($collections as $collection)
                    <option value="">
                        {{ $collection->name }}
                    </option>
                    
                @endforeach
            </select>
        </div>

        <div class="col">
             <select class="card h-100 shadow-sm" name="tittle" id="tittle">
                @foreach ($categories as $category)
                    <option value="">
                        {{ $category->name }}
                    </option>
                    
                @endforeach
            </select>
        </div>
        

       

      </div>
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
    <script>
    const body = document.body;
    const toggleBtn = document.getElementById('toggle-theme');
    const currentTheme = localStorage.getItem('theme');

    if (currentTheme === 'dark') {
        body.classList.replace('light-mode', 'dark-mode');
        toggleBtn.innerHTML = '<i class="bi bi-sun-fill"></i> Modo claro';
        toggleBtn.classList.replace('btn-outline-dark', 'btn-outline-light');
    }

    toggleBtn.addEventListener('click', () => {
        if (body.classList.contains('light-mode')) {
        body.classList.replace('light-mode', 'dark-mode');
        toggleBtn.innerHTML = '<i class="bi bi-sun-fill"></i> Modo claro';
        toggleBtn.classList.replace('btn-outline-dark', 'btn-outline-light');
        localStorage.setItem('theme', 'dark');
        } else {
        body.classList.replace('dark-mode', 'light-mode');
        toggleBtn.innerHTML = '<i class="bi bi-moon-fill"></i> Modo oscuro';
        toggleBtn.classList.replace('btn-outline-light', 'btn-outline-dark');
        localStorage.setItem('theme', 'light');
        }
    });
    </script>

  
  </body>
</html>


    