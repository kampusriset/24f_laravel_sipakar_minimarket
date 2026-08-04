<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SMARTMINI AI')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    @stack('styles')
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
    <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
        <i class="bi bi-robot"></i> SMARTMINI AI
    </a>
    <div class="collapse navbar-collapse justify-content-end">
        @auth
            <ul class="navbar-nav align-items-lg-center">
                <li class="nav-item me-3 text-light small">
                    <i class="bi bi-person-circle"></i>
                    {{ auth()->user()->name }}
                    <span class="badge bg-secondary text-uppercase">{{ auth()->user()->role }}</span>
                </li>
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="btn btn-sm btn-outline-light" type="submit">
                            <i class="bi bi-box-arrow-right"></i> Keluar
                        </button>
                    </form>
                </li>
            </ul>
        @endauth
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        @auth
        <div class="col-lg-2 bg-white border-end min-vh-100 py-3">
            @include('layouts.sidebar')
        </div>
        <div class="col-lg-10 py-4">
        @else
        <div class="col-12 py-4">
        @endauth

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
