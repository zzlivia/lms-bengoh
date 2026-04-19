@extends('layouts.open_layout')

@section('content')
    <div class="container-fluid mt-4">
        <div class="text-center mb-4">
            <div class="settings-title">{{ __('messages.nav.settings') }}</div>
        </div>
        <div class="row">
            <div class="col-md-3">
            <div class="settings-sidebar p-3">
                <div>
                    <h6 class="fw-bold mb-3">{{ __('messages.nav.settings') }}</h6>
                    @auth
                    <a href="{{ route('settings.profile') }}" 
                    class="settings-link {{ request()->routeIs('settings.profile') ? 'active' : '' }}">
                        {{ __('messages.settings.profile') }}
                        <span>›</span>
                    </a>
                    @endauth

                    <a href="{{ route('settings.notifications') }}" 
                    class="settings-link {{ request()->routeIs('settings.notifications') ? 'active' : '' }}">
                        {{ __('messages.settings.notifications') }}
                        <span>›</span>
                    </a>

                    <a href="{{ route('settings.preferences') }}" 
                    class="settings-link {{ request()->routeIs('settings.preferences') ? 'active' : '' }}">
                        {{ __('messages.settings.preferences') }}
                        <span>›</span>
                    </a>
                </div>
                @auth
                <form method="POST" action="{{ route('logout') }}" class="mt-3 text-end">
                    @csrf
                    <button class="btn btn-link text-dark fw-semibold">{{ __('messages.nav.logout') }}</button>
                </form>
                @endauth
            </div>
            </div>
            <div class="col-md-9">
                <div class="settings-content p-4">
                    @yield('settings_content')
                </div>
            </div>
        </div>
    </div>
@endsection