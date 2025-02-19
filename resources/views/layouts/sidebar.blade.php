<link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Lee Unach</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    {{-- <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li> --}}

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Nav Item - Gestor de Libros -->
    <li class="nav-item" >
        <a href="/users/index" class="nav-link">
            <i class="fas fa-fw fa-book"></i>
            <span>Usuarios</span>
        </a>
    </li>
    <li class="nav-item">
        <a href="/books/index" class="nav-link">
            <i class="fas fa-fw fa-book"></i>
            <span>Libros</span>
        </a>
    </li>
    <li class="nav-item">
        <a href="/categories/index" class="nav-link">
            <i class="fas fa-fw fa-book"></i>
            <span>Categorias</span>
        </a>
    </li>
    <li class="nav-item">
        <a href="/authors/index" class="nav-link">
            <i class="fas fa-fw fa-book"></i>
            <span>Autores</span>
        </a>
    </li>
    <li class="nav-item">
        <a href="/collections/index" class="nav-link">
            <i class="fas fa-fw fa-book"></i>
            <span>Colecciones</span>
        </a>
    </li>
    {{-- </li> --}}

    <!-- Nav Item - Gestor de Autores -->
    {{-- <li class="nav-item {{ request()->routeIs('authors.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('authors.index') }}">
            <i class="fas fa-fw fa-user"></i>
            <span>Autores</span>
        </a>
    </li> --}}
    <!-- Más enlaces aquí -->
</ul>