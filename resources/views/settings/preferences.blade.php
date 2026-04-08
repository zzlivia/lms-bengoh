@extends('settings.settings')

@section('settings_content')
    <h6 class="mb-3">Settings / Preferences</h6>

    <form method="POST" action="{{ route('settings.preferences.save') }}">
        @csrf

        {{-- LISTENING MODE --}}
        <div class="settings-row d-flex justify-content-between align-items-center">
            <span>Listening Mode</span>
            <input 
                type="checkbox" 
                name="listening_mode"
                {{ session('listening_mode') ? 'checked' : '' }}
            >
        </div>

        {{-- SOUND EFFECTS --}}
        <div class="settings-row d-flex justify-content-between align-items-center">
            <span>Sound Effects</span>
            <input 
                type="checkbox" 
                name="sound_effects"
                {{ session('sound_effects') ? 'checked' : '' }}
            >
        </div>

        {{-- BUTTONS --}}
        <div class="mt-4 d-flex gap-2">
            <a href="{{ route('homepage') }}" class="btn btn-success">Home</a>
            <button type="submit" class="btn btn-success">Save Changes</button>
        </div>

    </form>
@endsection