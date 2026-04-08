@extends('layouts.open_layout')

@section('content')

<div class="container-fluid mt-4">

    <!-- TITLE -->
    <div class="text-center mb-4">
        <div class="settings-title">Settings</div>
    </div>

    <div class="row">

        <!-- SIDEBAR -->
        <div class="col-md-3">
            <div class="settings-sidebar p-3">

                <h6 class="fw-bold mb-3">Settings</h6>

                @auth
                <a href="{{ route('settings.profile') }}" 
                   class="settings-link {{ request()->routeIs('settings.profile') ? 'active' : '' }}">
                    Profile
                    <span>›</span>
                </a>
                @endauth

                <a href="{{ route('settings.notifications') }}" 
                   class="settings-link {{ request()->routeIs('settings.notifications') ? 'active' : '' }}">
                    Notifications
                    <span>›</span>
                </a>

                <a href="{{ route('settings.preferences') }}" 
                   class="settings-link {{ request()->routeIs('settings.preferences') ? 'active' : '' }}">
                    Preferences
                    <span>›</span>
                </a>

            </div>
        </div>

        <!-- CONTENT -->
        <div class="col-md-9">
            <div class="settings-content p-4">
                @yield('settings_content')
            </div>
        </div>

    </div>

</div>

@endsection