@extends('layouts.admin')

@section('content')

<h4 class="fw-bold mb-4">Announcements</h4>
    <div class="card-box mb-4 d-flex justify-content-between align-items-center">
        <div class="d-flex w-50">
            <input type="text" class="form-control me-2" placeholder="Filter the announcements">
            <button class="btn btn-outline-secondary">
                Filter
            </button>
        </div>
        <div>
            <a href="{{ route('admin.announcements.create') }}" class="btn btn-primary">
                + Add Announcement
            </a>
        </div>
    </div>

    {{-- list of announcement --}}
    @forelse($announcements as $announcement)
    <div class="card-box mb-3">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h6 class="fw-bold">
                    {{ $announcement->announcementTitle }}
                </h6>
                <p class="mb-1 text-muted">
                    {{ $announcement->announcementDetails }}
                </p>
                <small class="text-muted">
                    Posted: {{ \Carbon\Carbon::parse($announcement->created_at)->format('d M Y') }}
                </small>
            </div>
            <div>
                <a href="{{ route('admin.announcements.view', $announcement->announcementID) }}" class="btn btn-sm btn-light">
                    View
                </a>
                <a href="{{ route('admin.announcements.review', $announcement->announcementID) }}" class="btn btn-sm btn-warning">
                    Review
                </a>
                <a href="{{ route('admin.announcements.edit', $announcement->announcementID) }}" class="btn btn-sm btn-light">
                    Edit
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="card-box text-center">
        <p class="text-muted mb-0">No announcements available yet.</p>
    </div>
    @endforelse
    <div class="text-center mt-4">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-light px-4">
            HOME
        </a>
    </div>
@endsection