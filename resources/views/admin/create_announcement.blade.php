@extends('layouts.admin_layout')

@section('content')

<h4 class="fw-bold mb-4">{{ __('messages.admin.add_new') }} {{ __('messages.admin.announcements') }}</h4>
    <form method="POST" action="{{ route('admin.announcements.store') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">{{ __('messages.admin.section_title') }}</label>
            <input type="text" name="announcementTitle" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">{{ __('messages.admin.desc') }}</label>
            <textarea name="announcementDetails" class="form-control" rows="4" required></textarea>
        </div>
        <div class="d-flex justify-content-between mt-4">
            <button type="button" onclick="history.back()" class="btn btn-light">
                ← {{ __('messages.admin.back') }}
            </button>
            <button type="submit" class="btn btn-primary">
                {{ __('messages.admin.save_course') }} {{ __('messages.admin.announcements') }}
            </button>
        </div>
    </form>
@endsection