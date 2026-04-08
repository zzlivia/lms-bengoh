@extends('settings.settings')

@section('settings_content')
    <h6 class="mb-3">Settings / Notifications</h6>

    <form method="POST" action="{{ route('settings.notifications.save') }}">
        @csrf

        {{-- GENERAL (LABEL ONLY) --}}
        <div class="settings-row">
            <strong>General Notification</strong>
        </div>

        {{-- SUBMITTED MCQs --}}
        <div class="settings-row d-flex justify-content-between align-items-center">
            <span>Submitted MCQs</span>
            <input 
                type="checkbox" 
                name="notify_mcq"
                {{ session('notify_mcq', true) ? 'checked' : '' }}
            >
        </div>

        {{-- OVERALL GRADES --}}
        <div class="settings-row d-flex justify-content-between align-items-center">
            <span>Overall Grades</span>
            <input 
                type="checkbox" 
                name="notify_grades"
                {{ session('notify_grades', true) ? 'checked' : '' }}
            >
        </div>

        {{-- BUTTONS --}}
        <div class="mt-4 d-flex gap-2">
            <a href="{{ route('homepage') }}" class="btn btn-success">Home</a>
            <button type="submit" class="btn btn-success">Save Changes</button>
        </div>

    </form>

@endsection