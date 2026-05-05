@extends('layouts.admin_layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold"><i class="fas fa-file-invoice me-2"></i>Assessment Performance Report</h4>
    <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left me-1"></i> Back
    </a>
</div>

<div class="card-box">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Learner</th>
                    <th>Course & Module</th>
                    <th>Score</th>
                    <th>Attempts</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Date Submitted</th>
                </tr>
            </thead>
            <tbody>
                @foreach($results as $result)
                <tr>
                    <td>{{ $result->id }}</td>
                    <td>
                        <span class="fw-bold">{{ $result->user->userName ?? 'User #'.$result->userID }}</span>
                    </td>
                    <td>
                        <small class="d-block text-muted">{{ $result->course->courseName ?? 'N/A' }}</small>
                        <span class="badge bg-light text-dark border">Mod: {{ $result->moduleID }}</span>
                    </td>
                    <td>
                        <h6 class="mb-0 {{ $result->score >= 80 ? 'text-success' : 'text-dark' }}">
                            {{ $result->score }}%
                        </h6>
                    </td>
                    <td>{{ $result->attempts }}</td>
                    <td><span class="text-uppercase small fw-bold">{{ $result->type }}</span></td>
                    <td>
                        @if($result->status == 'pass')
                            <span class="badge bg-success-soft text-success">
                                <i class="fas fa-check-circle me-1"></i> PASS
                            </span>
                        @else
                            <span class="badge bg-danger-soft text-danger">
                                <i class="fas fa-times-circle me-1"></i> FAIL
                            </span>
                        @endif
                    </td>
                    <td><small>{{ $result->created_at->format('Y-m-d H:i') }}</small></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection