<div class="settings-sidebar p-3">

    <h6 class="fw-bold mb-3">Settings</h6>

    {{-- PROFILE (REGISTERED USERS ONLY) --}}
    @auth
    <a href="{{ route('settings.profile') }}" 
       class="settings-link d-flex justify-content-between align-items-center 
       {{ request()->routeIs('settings.profile') ? 'active' : '' }}">
        <span>Profile</span>
        <span>›</span>
    </a>
    @endauth

    {{-- NOTIFICATIONS --}}
    <a href="{{ route('settings.notifications') }}" 
       class="settings-link d-flex justify-content-between align-items-center 
       {{ request()->routeIs('settings.notifications') ? 'active' : '' }}">
        <span>Notifications</span>
        <span>›</span>
    </a>

    {{-- PREFERENCES --}}
    <a href="{{ route('settings.preferences') }}" 
       class="settings-link d-flex justify-content-between align-items-center 
       {{ request()->routeIs('settings.preferences') ? 'active' : '' }}">
        <span>Preferences</span>
        <span>›</span>
    </a>

</div>