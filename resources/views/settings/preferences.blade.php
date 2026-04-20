@extends('settings.settings')

@section('settings_content')
    <h6 class="mb-3">{{ __('messages.nav.settings') }} / {{ __('messages.courses.settings.preferences') }}</h6>

    <form method="POST" action="{{ route('settings.preferences.save') }}">
        @csrf
        <div class="settings-row d-flex justify-content-between align-items-center">
            <span>{{ __('messages.courses.settings.listening_mode') }}</span>
            <input 
                type="checkbox" 
                name="listening_mode"
                {{ session('listening_mode') ? 'checked' : '' }}
            >
        </div>
        <div class="settings-row d-flex justify-content-between align-items-center">
            <span>{{ __('messages.courses.settings.sound_effects') }}</span>
            <input 
                type="checkbox" 
                name="sound_effects"
                {{ session('sound_effects') ? 'checked' : '' }}
            >
        </div>
        <div class="mt-4 d-flex gap-2">
            <a href="{{ route('homepage') }}" class="btn btn-success">{{ __('messages.nav.home') }}</a>
            <button type="submit" class="btn btn-success">{{ __('messages.courses.settings.save_changes') }}</button>
        </div>

    </form>
@endsection