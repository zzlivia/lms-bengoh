@extends('layouts.admin_layout')

@section('content')
    <h4 class="fw-bold mb-4">{{ __('messages.admin.view') }} {{ __('messages.admin.announcements') }}</h4>
        <div class="card-box">
            <h5 class="fw-bold">{{ $announcement->announcementTitle }}</h5>
            <p class="mt-3">
                {{ $announcement->announcementDetails }}
            </p>
            <small class="text-muted">
                {{ __('messages.admin.posted') }}: {{ \Carbon\Carbon::parse($announcement->created_at)->format('d M Y') }}
            </small>
        </div>
        <div class="mt-4">
            <a href="{{ route('admin.announcements') }}" class="btn btn-light">← {{ __('messages.admin.back') }}</a>
        </div>
@endsection