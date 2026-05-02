@extends('layouts.admin_layout')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Results: {{ $course->courseName }}</h4>
        <a href="{{ route('admin.course.module') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>

    <div class="card-box">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Learner Name</th>
                    <th>Result Type</th>
                    <th>Score</th>
                    <th>Status</th>
                    <th>Date Attempted</th>
                </tr>
            </thead>
            <tbody>
                @forelse($results as $result)
                <tr>
                    <td>{{ $result->user->userName ?? 'Unknown User' }}</td>
                    <td>{{ strtoupper($result->type) }}</td>
                    <td>{{ $result->score }}%</td>
                    <td>
                        <span class="badge {{ $result->status == 'passed' ? 'bg-success' : 'bg-danger' }}">
                            {{ strtoupper($result->status) }}
                        </span>
                    </td>
                    <td>{{ $result->created_at->format('d M Y, h:i A') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">No results found for this course yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection