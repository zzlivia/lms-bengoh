@extends('layouts.admin')

@section('content')

<h4 class="fw-bold mb-4">Edit Announcement</h4>
    <form method="POST" action="{{ route('announcements.update', $announcement->announcementID) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input 
                type="text" 
                name="announcementTitle" 
                class="form-control"
                value="{{ $announcement->announcementTitle }}"
                required
            >
        </div>
        <div class="mb-3">
            <label class="form-label">Details</label>
            <textarea 
                name="announcementDetails" 
                class="form-control"
                rows="4"
                required
            >{{ $announcement->announcementDetails }}</textarea>
        </div>
        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('admin.announcements') }}" class="btn btn-light">
                Back
            </a>
            <button type="submit" class="btn btn-primary">
                Update Announcement
            </button>
        </div>
    </form>

@endsection