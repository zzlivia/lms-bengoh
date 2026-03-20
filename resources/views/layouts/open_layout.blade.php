{{-- template for learner interface--}}
<!DOCTYPE html>
<html lang="en"> {{-- language of the webpage Eng --}}
<head>
    <meta charset="UTF-8">
    <title>Bengoh Academy</title> {{-- page title --}}
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> {{-- responsive design --}}
    {{-- add manifest link --}}
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#0d6efd">
    {{-- bootstrap and font --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/learner.css') }}"> {{-- custom CSS --}}
    @yield('styles')
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white px-4 border-bottom"> {{-- top navigation bar --}}
        <a class="navbar-brand fw-bold d-flex align-items-center" href="/"> {{-- logo --}}
            <img src="{{ asset('images/bengohdam-logo.png') }}" width="30" class="me-2"> Bengoh Academy
        </a>
        <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav"> {{-- navigation menu --}}
                <li class="nav-item mx-2">
                    <a class="nav-link active" href="{{ route('learner.homepage') }}">Home</a>
                </li>

                <li class="nav-item mx-2">
                    <a class="nav-link active" href="{{ route('courses.index') }}">Courses</a>
                </li>

                <li class="nav-item mx-2">
                    <a class="nav-link" href="{{ route('community.stories') }}">Community Stories</a>
                </li>

                <li class="nav-item mx-2">
                    <a class="nav-link" href="#">About the Dam</a>
                </li>
                {{-- language switches --}}
                <li class="nav-item dropdown mx-2">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Language</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">English</a></li>
                        <li><a class="dropdown-item" href="#">Bahasa Melayu</a></li>
                        <li><a class="dropdown-item" href="#">Iban</a></li>
                    </ul>
                </li>
                {{-- authentication --}}
                <li class="nav-item mx-2 d-flex align-items-center">
                @auth
                <div class="dropdown">
                    {{-- if a user logged in, it shows the name of the user --}}
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        Hi, {{ auth()->user()->userName }}
                    </a>
                    {{-- when user click on their own name --}}
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('settings.index') }}"> {{-- redirect user to settings page --}}
                                Settings
                            </a>
                        </li>

                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item">Sign Out</button> {{-- allow user to log out --}}
                            </form>
                        </li>
                    </ul>
                </div>

                @else
                <a class="nav-link text-primary fw-bold px-1" href="{{ route('register') }}">Register</a>
                <span class="text-muted">|</span>
                <a class="nav-link text-primary fw-bold px-1" href="{{ route('login') }}">Sign In</a>
                @endauth
                </li>
            </ul>
        </div>
    </nav>

    {{-- to main content --}}
    <div class="container mt-4">
        @yield('content')
    </div>
    {{-- bottom navigation bar --}}
    <footer>
        <div class="container d-flex justify-content-start gap-4 small fw-bold">
            <a href="#">Terms</a>
            <a href="#">Privacy</a>
            <a href="#">Contact</a>
        </div>
    </footer>
    {{-- JS for dropdowns --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    {{-- add service worker --}}
    <script>
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/service-worker.js')
        .then(function() {
            console.log("Service Worker Registered");
        });
    }
</body>
</html>