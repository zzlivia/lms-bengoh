@extends('layouts.admin_layout')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">MCQ (Quiz) Results</h4>
        <a href="{{ route('admin.course.module') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Back to Management
        </a>
    </div>

    <div class="card-box">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Learner</th>
                    <th>Course</th>
                    <th>Score</th>
                    <th>Status</th>
                    <th>Date Attempted</th>
                </tr>
            </thead>
            <tbody>
                @forelse($results as $index => $result)
                <tr>
                    <td>{{ $results->firstItem() + $index }}</td>
                    <td>{{ $result->user->userName ?? 'Unknown User' }}</td>
                    <td>{{ $result->course->courseName ?? 'N/A' }}</td>
                    <td><strong class="text-primary">{{ $result->score }}%</strong></td>
                    <td>
                        <a href="{{ route('admin.reports.mcq.details', $result->id) }}" class="text-primary fw-bold">
                            {{ $result->user->userName ?? 'Unknown User' }}
                        </a>
                    </td>
                    <td>{{ $result->created_at->format('d M Y, h:i A') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">No MCQ results recorded yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">
            {{ $results->links() }}
        </div>
    </div>
</div>
@endsection