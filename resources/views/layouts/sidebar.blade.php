<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vista</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- SB Admin 2 CSS -->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>
<body>
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
        <!-- Sidebar - Brand -->
        <a href="/users" class="sidebar-brand d-flex align-items-center justify-content-center">
            <div class="sidebar-brand-icon">
                <img src="{{ asset('img/logo.svg') }}" class="img-fluid" alt="LeeUNACH">
                {{-- <i class="fas fa-laugh-wink"></i> --}}
            </div>
            {{-- <div class="sidebar-brand-text mx-3">

            </div> --}}
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Nav Item - Gestor de Libros -->
        <li class="nav-item">
            <a href="{{ route('users.index') }}" class="nav-link">
                <i class="bi bi-people"></i>
                <span>Usuarios</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('books.index') }}" class="nav-link">
                <i class="bi bi-book"></i>
                <span>Libros</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('categories.index') }}" class="nav-link">
                <i class="bi bi-bookmark-star"></i>
                <span>Categorías</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('authors.index') }}" class="nav-link">
                <i class="bi bi-person-square"></i>
                <span>Autores</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('collections.index') }}" class="nav-link">
                <i class="bi bi-collection"></i>
                <span>Colecciones</span>
            </a>
        </li>
    </ul>
</body>
</html>