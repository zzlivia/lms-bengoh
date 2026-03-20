<!DOCTYPE html>
<html>
<head>
    <title>Bengoh Academy - Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- add manifest link --}}
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#0d6efd">
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <!-- admin css -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>

<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 sidebar">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ route('admin.dashboard') }}"> {{-- logo --}}
                <img src="{{ asset('images/bengohdam-logo.png') }}" width="30" class="me-2"> Bengoh Academy
            </a>
            <div>
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
                <a href="{{ route('admin.user.management') }}" class="{{ request()->routeIs('admin.user.management') ? 'active' : '' }}">User Management</a>
                <a href="{{ route('admin.course.module') }}" class="{{ request()->routeIs('admin.course.module') ? 'active' : '' }}">Course/Module Management</a>
                <a href="{{ route('admin.progress') }}" class="{{ request()->routeIs('admin.progress') ? 'active' : '' }}">Progress</a>
                <a href="{{ route('admin.announcements') }}" class="{{ request()->routeIs('admin.announcements') ? 'active' : '' }}">Announcements</a>
                <a href="{{ route('admin.reports') }}" class="{{ request()->routeIs('admin.reports') ? 'active' : '' }}">Reports</a>
            </div>
            <div class="mt-auto">
                <a href="{{ route('admin.settings') }}"
                class="{{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                Settings
                </a>
                <a href="{{ route('admin.help') }}">Help & Support</a>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="sidebar-logout">Sign Out</button>
                </form>
            </div>
        </div>
        <div class="col-md-10 p-0">
            <div class="topbar d-flex align-items-center p-3 px-4">
                <div class="d-flex align-items-center ms-auto gap-4">
                    <!-- language -->
                    <div class="d-flex align-items-center text-muted" style="cursor:pointer;">
                        <small class="me-1">Languages</small>
                        <i class="bi bi-chevron-down"></i>
                    </div>
                    <!-- user -->
                    <div class="d-flex align-items-center">
                        <i class="bi bi-person-circle fs-4 me-2"></i>
                        <div class="lh-sm">
                            <div class="fw-bold">{{ auth()->user()->name }}</div>
                            <small class="text-muted">Administrator</small>
                        </div>
                    </div>
                    <!-- notification -->
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link position-relative" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-bell fs-5"></i>
                                @if($totalNotifications > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ $totalNotifications }}
                                        <span class="visually-hidden">unread notifications</span>
                                    </span>
                                @endif
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="notificationDropdown">
                                <li><h6 class="dropdown-header">Admin Alerts</h6></li>
                                
                                <li>
                                    <a class="dropdown-item d-flex justify-content-between align-items-center" href="{{ route('admin.password.requests') }}">
                                        Password Reset Requests
                                        <span class="badge bg-primary rounded-pill">{{ $forgotRequests }}</span>
                                    </a>
                                </li>

                                <li>
                                    <a class="dropdown-item d-flex justify-content-between align-items-center" href="{{ route('admin.feedback') }}">
                                        Pending Feedback
                                        <span class="badge bg-primary rounded-pill">{{ $feedbackCount }}</span>
                                    </a>
                                </li>

                                <li>
                                    <a class="dropdown-item d-flex justify-content-between align-items-center" href="{{ route('admin.announcements') }}">
                                        Announcements for Review
                                        <span class="badge bg-primary rounded-pill">{{ $announcementReview }}</span>
                                    </a>
                                </li>

                                @if($totalNotifications > 0)
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item text-center small text-muted" href="#">
                                            View All Alerts
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    </ul>
                    </div>
                </div>
            </div>
            <div class="p-4">
                @yield('content')
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')
{{-- add service worker --}}
<script>
if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/service-worker.js')
    .then(function() {
        console.log("Service Worker Registered");
    });
}
</script>
</body>
</html>