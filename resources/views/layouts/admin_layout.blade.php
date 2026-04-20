<!DOCTYPE html>
<html>
<head>
    <title>Bengoh Academy - Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#0d6efd">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>

<body>
    <div class="d-flex">
        
        <div class="sidebar d-flex flex-column p-3">
            <a class="navbar-brand fw-bold d-flex align-items-center mb-4"
               href="{{ route('admin.dashboard') }}">
                <img src="{{ asset('images/bengohdam-logo.png') }}" width="30" class="me-2">
                Bengoh Academy
            </a>

            <div class="flex-grow-1">
                <a href="{{ route('admin.dashboard') }}"
                   class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">{{ __('messages.admin.dashboard') }}</a>

                <a href="{{ route('admin.user.management') }}"
                   class="{{ request()->routeIs('admin.user.management') ? 'active' : '' }}">{{ __('messages.admin.user_mgmt') }}</a>

                <a href="{{ route('admin.course.module') }}"
                   class="{{ request()->routeIs('admin.course.module') ? 'active' : '' }}">{{ __('messages.admin.course_mgmt') }}</a>

                <a href="{{ route('admin.progress') }}"
                   class="{{ request()->routeIs('admin.progress') ? 'active' : '' }}">{{ __('messages.admin.progress') }}</a>

                <a href="{{ route('admin.announcements') }}"
                   class="{{ request()->routeIs('admin.announcements') ? 'active' : '' }}">{{ __('messages.admin.announcements') }}</a>

                <a href="{{ route('admin.reports') }}"
                   class="{{ request()->routeIs('admin.reports') ? 'active' : '' }}">{{ __('messages.admin.reports') }}</a>
            </div>

            <div>
                <a href="{{ route('admin.settings') }}"
                   class="{{ request()->routeIs('admin.settings') ? 'active' : '' }}">{{ __('messages.nav.settings') }}</a>

                <a href="{{ route('admin.help') }}">{{ __('messages.admin.help') }}</a>

                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="sidebar-logout">{{ __('messages.nav.logout') }}</button>
                </form>
            </div>
        </div>

        <div class="main-content flex-grow-1 d-flex flex-column">
            <div class="topbar d-flex align-items-center p-3 px-4">
                <div class="d-flex align-items-center ms-auto gap-4">
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle"
                        href="#"
                        role="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">
                            {{ __('messages.nav.language') }}
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('lang.switch', 'en') }}">English</a></li>
                            <li><a class="dropdown-item" href="{{ route('lang.switch', 'ms') }}">Bahasa Melayu</a></li>
                        </ul>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="bi bi-person-circle fs-4 me-2"></i>
                        <div class="lh-sm">
                            <div class="fw-bold">
                                @if(auth()->check())
                                    {{ auth()->user()->name }}
                                @else
                                    Guest
                                @endif
                            </div>
                            <small class="text-muted">{{ __('messages.admin.admin_role') }}</small>
                        </div>
                    </div>
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link position-relative" href="#"
                               id="notificationDropdown"
                               role="button"
                               data-bs-toggle="dropdown">
                                <i class="bi bi-bell fs-5"></i>
                                @if($totalNotifications > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ $totalNotifications }}
                                    </span>
                                @endif
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow">
                                <li><h6 class="dropdown-header">{{ __('messages.admin.alerts') }}</h6></li>
                                <li>
                                    <a class="dropdown-item d-flex justify-content-between"
                                       href="{{ route('admin.password.requests') }}">
                                        {{ __('messages.admin.reset_req') }}
                                        <span class="badge bg-primary">{{ $forgotRequests }}</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex justify-content-between"
                                       href="{{ route('admin.feedback') }}">
                                        {{ __('messages.admin.pending_feedback') }}
                                        <span class="badge bg-primary">{{ $pendingFeedbackCount ?? 0 }}</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex justify-content-between"
                                       href="{{ route('admin.announcements') }}">
                                        {{ __('messages.admin.announcement_review') }}
                                        <span class="badge bg-primary">{{ $announcementReview }}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="p-4">
                @yield('content')
            </div>
        </div>
    </div>

    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/service-worker.js')
            .then(() => console.log("Service Worker Registered"));
        }
    </script>
    <script>
        $(document).ready(function() {

            if ($('#userTable').length) {

                if ($.fn.DataTable.isDataTable('#userTable')) {
                    $('#userTable').DataTable().destroy();
                }

                $('#userTable').DataTable();
            }

        });
    </script>

    {{-- the rich editor 
    <script src="https://cdn.tiny.cloud/1/v6ov6w4ysrw63gdffs61dqb69kgf7co61rpfrrc77u59ae9u/tinymce/6/tinymce.min.js"></script>--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.7.0/tinymce.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>