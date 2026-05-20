{{-- template for learner interface--}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <title>Bengoh Academy</title> {{-- page title --}}
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> {{-- responsive design --}}
        {{-- add manifest link --}}
        <link rel="manifest" href="/manifest.json">
        <meta name="theme-color" content="#0d6efd">
        <link rel="apple-touch-icon" href="/images/icon-192.png">
        {{-- bootstrap and font --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/course-sidebar.css') }}">
        <link rel="stylesheet" href="{{ asset('css/homepage.css') }}"> {{-- custom CSS --}}
        <link rel="stylesheet" href="{{ asset('css/settings.css') }}">
        <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
        @yield('styles')
    </head>

    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-white px-4 border-bottom"> {{-- top navigation bar --}}
            <a class="navbar-brand fw-bold d-flex align-items-center" href="/"> {{-- logo --}}
                <img src="{{ asset('images/bengohdam-logo.png') }}" width="30" class="me-2"> Bengoh Academy
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target=".navbar-collapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end">
                <ul class="navbar-nav"> {{-- navigation menu --}}
                    <li class="nav-item mx-2">
                        <a class="nav-link {{ request()->routeIs('homepage') ? 'active' : '' }}" href="{{ route('homepage') }}">
                            {{ __('messages.nav.home') }} {{-- highlights the page --}}
                        </a>
                    </li>

                    <li class="nav-item mx-2">
                        <a class="nav-link {{ request()->routeIs('courses.*') ? 'active' : '' }}" href="{{ route('courses.allCourses') }}">
                            {{ __('messages.nav.courses') }}
                        </a>
                    </li>

                    <li class="nav-item mx-2">
                        <a class="nav-link" href="{{ route('community.stories') }}">{{ __('messages.nav.community') }}</a>
                    </li>

                    <li class="nav-item mx-2">
                        <a class="nav-link" href="{{ route('about') }}">{{ __('messages.nav.about') }}</a>
                    </li>
                    {{-- language switches --}}
                    <li class="nav-item dropdown mx-2">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">{{ __('messages.nav.language') }}</a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="{{ route('lang.switch', 'en') }}">English</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('lang.switch', 'ms') }}">Bahasa Melayu</a>
                            </li>
                        </ul>
                    </li>

                    {{-- notification --}}
                    <li class="nav-item mx-2 position-relative" x-data="{ open: false }">
                        {{-- trigger icon bell --}}
                        <div @click="open = !open" style="cursor:pointer;" class="nav-link position-relative d-inline-block">
                            <i class="bi bi-bell fs-5"></i>
                            @if(isset($activeAnnouncementsCount) && $activeAnnouncementsCount > 0)
                                <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle">
                                    <span class="visually-hidden">New alerts</span>
                                </span>
                            @endif
                        </div>

                        {{-- notification dropdown --}}
                        <div x-show="open" x-transition x-cloak @click.outside="open = false" class="dropdown-menu dropdown-menu-end position-absolute p-0 shadow border-0 mt-2" style="min-width: 320px; right: 0; max-height: 400px; overflow-y: auto; z-index: 1050;">
                            <div class="px-3 py-2 bg-light border-bottom rounded-top d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-dark small">Recent Updates</span>
                                @if($activeAnnouncementsCount > 0)
                                    <span class="badge bg-danger rounded-pill small" style="font-size: 0.75rem;">{{ $activeAnnouncementsCount }} New</span>
                                @endif
                            </div>
                            @if(isset($recentAnnouncements) && $recentAnnouncements->count() > 0)
                                @foreach($recentAnnouncements as $alert)
                                    <a class="dropdown-item px-3 py-2 border-bottom d-flex align-items-start gap-2 bg-white text-wrap" 
                                    href="{{ route('learner.announcements.index') }}" 
                                    style="white-space: normal;">
                                        <div class="bg-primary bg-opacity-10 p-2 rounded-circle text-primary mt-1">
                                            <i class="bi bi-megaphone-fill" style="font-size: 0.9rem;"></i>
                                        </div>
                                        <div class="w-100">
                                            <span class="d-block small fw-bold text-dark text-truncate" style="max-width: 220px;">
                                                {{ $alert->announcementTitle }}
                                            </span>
                                            <span class="text-muted d-block text-truncate small" style="font-size: 0.8rem; max-width: 220px;">
                                                {{ $alert->announcementDetails }}
                                            </span>
                                            <span class="text-muted extra-small d-block mt-1 text-end" style="font-size: 0.7rem;">
                                                {{ \Carbon\Carbon::parse($alert->created_at)->diffForHumans() }}
                                            </span>
                                        </div>
                                    </a>
                                @endforeach
                                
                                {{-- view all action page link layout --}}
                                <div class="text-center bg-light rounded-bottom">
                                    <a href="{{ route('learner.announcements.index') }}" class="d-block w-100 text-decoration-none small fw-bold text-primary py-2 hover-bg-dark">
                                        See All Announcements <i class="bi bi-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            @else
                                <div class="py-4 text-center text-muted rounded-bottom">
                                    <i class="bi bi-bell-slash display-6 d-block mb-2 text-secondary"></i>
                                    <span class="small">No new notifications available</span>
                                </div>
                            @endif
                        </div>
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
                                <a class="dropdown-item" href="{{ route('settings.index') }}"> {{-- {{ route('settings.index') }} --}}
                                    {{ __('messages.nav.settings') }}
                                </a>
                            </li>

                            <li>
                                <form method="POST" action="{{ route('logout') }}"> {{-- AuthController --}}
                                    @csrf
                                    <button class="dropdown-item">{{ __('messages.nav.logout') }}</button> {{-- allow user to log out --}}
                                </form>
                            </li>
                        </ul>
                    </div>

                    @else
                        <a class="nav-link text-primary fw-bold px-1" href="{{ route('register') }}">{{ __('messages.nav.register') }}</a> {{-- AuthenticationController --}}
                            <span class="text-muted">|</span>
                        <a class="nav-link text-primary fw-bold px-1" href="{{ route('login') }}">{{ __('messages.nav.login') }}</a> {{-- AuthenticationController --}}
                    @endauth
                    </li>
                </ul>
            </div>
        </nav>

        {{-- to main content --}}
        <main class="container mt-4">
            @yield('content')
        </main>
        {{-- bottom navigation bar --}}
        <footer>
            <div class="container d-flex justify-content-start gap-4 small fw-bold">
                <a href="#">Terms</a>
                <a href="#">Privacy</a>
                <a href="#">Contact</a>
            </div>
        </footer>

        {{-- alpine load --}}
        <script src="//unpkg.com/alpinejs" defer></script>

        {{-- JS for dropdowns --}}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

        {{-- add service worker --}}
        <script>
            if ('serviceWorker' in navigator) {
                navigator.serviceWorker.register('/service-worker.js')
                .then(() => console.log("Service Worker Registered"))
                .catch(err => console.error("SW failed:", err));
            }   
        </script>

        <script src="{{ asset('js/language.js') }}"></script>

        @yield('scripts')

        @stack('scripts')

        <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
        <script>
            AOS.init();
        </script>
    </body>
</html>