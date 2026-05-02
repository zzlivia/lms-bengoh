@extends('layouts.admin_layout')

@section('content')
<div class="card-box">
    <div class="d-flex justify-content-between mb-4">
        <h4>Attempt Details: {{ $result->user->userName }}</h4>
        <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">Back</a>
    </div>

    <div class="mb-4">
        <p><strong>Course:</strong> {{ $result->course->courseName }}</p>
        <p><strong>Final Score:</strong> <span class="badge bg-info">{{ $result->score }}%</span></p>
    </div>

    <hr>

    <h5 class="mb-3">Question Breakdown</h5>
    @foreach($details as $index => $item)
        <div class="p-3 mb-3 border rounded {{ $item->is_correct ? 'border-success bg-light' : 'border-danger' }}">
            <p class="fw-bold">Q{{ $index + 1 }}: {{ $item->question }}</p>
            <div class="ps-3">
                <p class="{{ $item->is_correct ? 'text-success' : 'text-danger' }}">
                    <strong>Learner's Choice:</strong> {{ $item->selected_answer }}
                </p>
                @if(!$item->is_correct)
                    <p class="text-success">
                        <strong>Correct Answer:</strong> {{ $item->correct_answer }}
                    </p>
                @endif
            </div>
        </div>
    @endforeach
</div>
@endsection