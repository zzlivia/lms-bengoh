@extends('settings.settings')

@section('settings_content')
    <h6 class="mb-3">{{ __('messages.nav.settings') }} / {{ __('messages.settings.notifications') }}</h6>
    <form method="POST" action="{{ route('settings.notifications.save') }}">
        @csrf
        <div class="settings-row">
            <strong>{{ __('messages.settings.general_notif') }}</strong>
        </div>

        {{-- MCQs --}}
        <div class="settings-row d-flex justify-content-between align-items-center">
            <span>{{ __('messages.settings.notify_mcq') }}</span>
            <input 
                type="checkbox" 
                name="notify_mcq"
                {{ session('notify_mcq', true) ? 'checked' : '' }}
            >
        </div>

        {{-- Overall Grades --}}
        <div class="settings-row d-flex justify-content-between align-items-center">
            <span>{{ __('messages.settings.notify_grades') }}</span>
            <input 
                type="checkbox" 
                name="notify_grades"
                {{ session('notify_grades', true) ? 'checked' : '' }}
            >
        </div>

        {{-- button --}}
        <div class="mt-4 d-flex gap-2">
            <a href="{{ route('homepage') }}" class="btn btn-success">{{ __('messages.nav.home') }}</a>
            <button type="submit" class="btn btn-success">{{ __('messages.settings.save_changes') }}</button>
        </div>

    </form>

@endsection