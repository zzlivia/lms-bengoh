@extends('layouts.admin_layout')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">MCQ Review: {{ $result->user->userName }}</h4>
        <a href="{{ route('admin.reports.mcq') }}" class="btn btn-secondary btn-sm">Back to List</a>
    </div>

    <div class="row">
        {{-- Summary Sidebar --}}
        <div class="col-md-4">
            <div class="card-box">
                <h5 class="mb-3">Attempt Summary</h5>
                <p><strong>Course:</strong> {{ $result->course->courseName }}</p>
                <p><strong>Score:</strong> <span class="badge bg-primary fs-6">{{ $result->score }}%</span></p>
                <p><strong>Status:</strong> 
                    <span class="badge {{ $result->status == 'pass' ? 'bg-success' : 'bg-danger' }}">
                        {{ strtoupper($result->status) }}
                    </span>
                </p>
                <p><strong>Date:</strong> {{ $result->created_at->format('d M Y, h:i A') }}</p>
            </div>
        </div>

        {{-- Question Breakdown --}}
        <div class="col-md-8">
            <div class="card-box">
                <h5 class="mb-4">Question Breakdown</h5>
                @foreach($details as $index => $item)
                    <div class="p-3 mb-4 border rounded {{ $item->is_correct ? 'border-success bg-light' : 'border-danger' }}" style="border-left: 5px solid !important;">
                        <p class="fw-bold mb-2">Q{{ $index + 1 }}: {{ $item->question }}</p>
                        
                        <div class="ms-3 small">
                            <p class="mb-1 {{ $item->is_correct ? 'text-success' : 'text-danger' }}">
                                <strong>Learner's Answer:</strong> {{ $item->learner_answer }}
                                @if($item->is_correct)
                                    <i class="fas fa-check-circle ms-1"></i>
                                @else
                                    <i class="fas fa-times-circle ms-1"></i>
                                @endif
                            </p>
                            
                            @if(!$item->is_correct)
                                <p class="text-success mb-0">
                                    <strong>Correct Answer:</strong> 
                                    @php
                                        $correctKey = 'answer' . $item->correct_answer;
                                        echo $item->$correctKey ?? 'Option ' . $item->correct_answer;
                                    @endphp
                                </p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection