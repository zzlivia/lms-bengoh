@extends('layouts.learner')

@section('content')

<div class="container-fluid mt-4">

<!-- SETTINGS TITLE -->
<div class="text-center mb-4">
    <div class="settings-title">
        Settings
    </div>
</div>

<div class="row">

    <!-- LEFT SIDEBAR -->
    <div class="col-md-3">

        <div class="settings-sidebar p-3">

            <h6 class="fw-bold mb-3">Settings</h6>

            {{-- PROFILE (REGISTERED USERS ONLY) --}}
            @auth
            <a href="{{ route('settings.profile') }}" class="settings-link">
                Profile
                <span class="float-end">›</span>
            </a>
            @endauth

            {{-- NOTIFICATIONS --}}
            <a href="{{ route('settings.notifications') }}" class="settings-link">
                Notifications
                <span class="float-end">›</span>
            </a>

            {{-- PREFERENCES --}}
            <a href="{{ route('settings.preferences') }}" class="settings-link">
                Preferences
                <span class="float-end">›</span>
            </a>

        </div>

    </div>


    <!-- RIGHT CONTENT AREA -->
    <div class="col-md-9">

        <div class="settings-content p-4">

            {{-- CONTENT FROM CHILD PAGES --}}
            @yield('settings_content')

        </div>

    </div>

</div>

</div>

@endsection