@extends('settings.settings')

@section('settings_content')
    <h6 class="mb-3">{{ __('messages.nav.settings') }} / {{ __('messages.courses.settings.notifications') }}</h6>
    <form method="POST" action="{{ route('settings.notifications.save') }}">
        @csrf
        <div class="settings-row">
            <strong>{{ __('messages.courses.settings.general_notif') }}</strong>
        </div>

        {{-- MCQs --}}
        <div class="settings-row d-flex justify-content-between align-items-center">
            <span>{{ __('messages.courses.settings.notify_mcq') }}</span>
            <input 
                type="checkbox" 
                name="notify_mcq"
                {{ session('notify_mcq', true) ? 'checked' : '' }}
            >
        </div>

        {{-- Overall Grades --}}
        <div class="settings-row d-flex justify-content-between align-items-center">
            <span>{{ __('messages.courses.settings.notify_grades') }}</span>
            <input 
                type="checkbox" 
                name="notify_grades"
                {{ session('notify_grades', true) ? 'checked' : '' }}
            >
        </div>

        {{-- button --}}
        <div class="mt-4 d-flex gap-2">
            <a href="{{ route('homepage') }}" class="btn btn-success">{{ __('messages.nav.home') }}</a>
            <button type="submit" class="btn btn-success">{{ __('messages.courses.settings.save_changes') }}</button>
        </div>

    </form>

@endsection