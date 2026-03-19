<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Bengoh Academy')</title> {{--dynamic title support --}}
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0d6efd">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/homepage.css') }}">
    @yield('styles')
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white px-4 border-bottom">
        <a class="navbar-brand fw-bold d-flex align-items-center" href="/">
            {{-- path to point to public/images/ --}}
            <img src="{{ asset('images/bengohdam-logo.png') }}" width="30" class="me-2"> Bengoh Academy
        </a>
        {{-- navbar-toggler for mobile --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        {{-- top navbar --}}
        <div class="collapse navbar-collapse justify-content-end" id="mainNav">
            <ul class="navbar-nav">
                <li class="nav-item mx-2"><a class="nav-link" href="/homepage">Home</a></li>
                <li class="nav-item mx-2"><a class="nav-link active" href="#">Courses</a></li> {{--{{ route('courses.index') }}--}}
                <li class="nav-item mx-2"><a class="nav-link" href="#">Community Stories</a></li>
                <li class="nav-item mx-2"><a class="nav-link" href="#">About the Dam</a></li>
                {{-- dropdown languages --}}
                <li class="nav-item dropdown mx-2">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Language</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">English</a></li>
                        <li><a class="dropdown-item" href="#">Bahasa Melayu</a></li>
                        <li><a class="dropdown-item" href="#">Iban</a></li>
                    </ul>
                </li>
                {{-- register and sign in--}}
                <li class="nav-item mx-2 d-flex align-items-center">
                @auth
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            Hi, {{ auth()->user()->userName }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#">Settings</a></li>
                            <li>
                                <form method="POST" action="#"> {{--{{ route('logout') }}--}}
                                    @csrf
                                    <button class="dropdown-item">Sign Out</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a class="nav-link text-primary fw-bold px-1" href="#">Register</a> {{--{{ route('register') }}--}}
                    <span class="text-muted">|</span>
                    <a class="nav-link text-primary fw-bold px-1" href="#">Sign In</a> {{--{{ route('login') }}--}}
                @endauth
                </li>
            </ul>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="mt-5 py-4 border-top">
        <div class="container d-flex justify-content-start gap-4 small fw-bold">
            <a href="#" class="text-decoration-none text-muted">Terms</a>
            <a href="#" class="text-decoration-none text-muted">Privacy</a>
            <a href="#" class="text-decoration-none text-muted">Contact</a>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/service-worker.js')
        .then(function() { console.log("Service Worker Registered"); });
    }
    </script>
    @stack('scripts')
</body>
</html>