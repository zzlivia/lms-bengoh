@extends('layouts.admin')

@section('content')

<h4 class="fw-bold mb-4">Add Announcement</h4>
    <form method="POST" action="{{ route('admin.announcements.store') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="announcementTitle" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Details</label>
            <textarea name="announcementDetails" class="form-control" rows="4" required></textarea>
        </div>
        <div class="d-flex justify-content-between mt-4">
            <button type="button" onclick="history.back()" class="btn btn-light">
                ← Back
            </button>
            <button type="submit" class="btn btn-primary">
                Save Announcement
            </button>
        </div>
    </form>
@endsection