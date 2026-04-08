@extends('settings.settings')

@section('settings_content')
    @auth

    <h6 class="mb-3">Settings / Profile</h6>

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('settings.profile.update') }}">
        @csrf

        {{-- NAME --}}
        <div class="settings-row">
            <label class="form-label">Name</label>
            <input 
                type="text" 
                name="name" 
                class="form-control"
                value="{{ old('name', $user->name) }}"
                required
            >
        </div>

        {{-- EMAIL --}}
        <div class="settings-row">
            <label class="form-label">Email</label>
            <input 
                type="email" 
                name="email" 
                class="form-control"
                value="{{ old('email', $user->email) }}"
                required
            >
        </div>

        {{-- NEW PASSWORD --}}
        <div class="settings-row">
            <label class="form-label">New Password</label>
            <input 
                type="password" 
                name="new_password" 
                class="form-control"
                placeholder="Leave blank if no change"
            >
        </div>

        {{-- BUTTONS --}}
        <div class="mt-4 d-flex gap-2">
            <a href="{{ route('homepage') }}" class="btn btn-success">Home</a>
            <button type="submit" class="btn btn-success">Save Changes</button>
        </div>

    </form>

    @endauth


    @guest
    <div class="text-center">
        <p class="text-muted">Please log in to view and update your profile.</p>
        <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
    </div>
    @endguest

@endsection