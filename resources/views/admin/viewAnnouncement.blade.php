@extends('layouts.admin')

@section('content')

<h4 class="fw-bold mb-4">View Announcement</h4>
    <div class="card-box">
        <h5 class="fw-bold">
            {{ $announcement->announcementTitle }}
        </h5>
        <p class="mt-3">
            {{ $announcement->announcementDetails }}
        </p>
        <small class="text-muted">
            Posted: {{ \Carbon\Carbon::parse($announcement->created_at)->format('d M Y') }}
        </small>
    </div>

    <div class="mt-4">
        <a href="{{ route('admin.announcements') }}" class="btn btn-light">
            ← Back
        </a>
    </div>

@endsection