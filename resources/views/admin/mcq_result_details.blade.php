@extends('layouts.admin_layout')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">MCQ Review: {{ $result->user->userName }}</h4>
        <a href="{{ route('admin.reports.mcq') }}" class="btn btn-secondary btn-sm">Back to List</a>
    </div>

    <div class="row">
        {{-- Summary Sidebar (Matches left side of image_a4073a.png) --}}
        <div class="col-md-4">
            <div class="card shadow-sm border-0 p-4">
                <h5 class="fw-bold mb-3">Attempt Summary</h5>
                <p class="mb-2"><strong>Course:</strong> {{ $result->course->courseName }}</p>
                <p class="mb-2"><strong>Score:</strong> <span class="badge bg-primary px-3">{{ $result->score }}%</span></p>
                <p class="mb-2"><strong>Status:</strong> 
                    <span class="badge {{ $result->status == 'pass' ? 'bg-success' : 'bg-danger' }}">
                        {{ strtoupper($result->status) }}
                    </span>
                </p>
                <p class="mb-0 text-muted"><strong>Date:</strong> {{ $result->created_at->format('d M Y, h:i A') }}</p>
            </div>
        </div>

        {{-- Question Breakdown (Matches right side of image_a4073a.png) --}}
        <div class="col-md-8">
            <div class="card shadow-sm border-0 p-4">
                <h5 class="fw-bold mb-4">Question Breakdown</h5>
                
                @foreach($details as $index => $item)
                    <div class="card p-3 mb-4 border shadow-sm">
                        <p class="fw-bold mb-3">{{ $index + 1 }}. {{ $item->question }}</p>
                        
                        @php
                            // Mapping the 4 potential options from your $item object
                            $options = [
                                0 => $item->answer1,
                                1 => $item->answer2,
                                2 => $item->answer3,
                                3 => $item->answer4,
                            ];
                            
                            // Determine indexes (Assuming correct_answer is 1-4 and learner_answer_index is 0-3)
                            $correctIndex = (int)$item->correct_answer - 1;
                            $learnerSelection = $item->learner_answer_index; 
                        @endphp

                        @foreach($options as $key => $option)
                            @if($option)
                                @php
                                    $isCorrect = ($key === $correctIndex);
                                    $isSelected = ($learnerSelection !== null && (string)$learnerSelection === (string)$key);
                                    
                                    // Set colors based on correctness or selection
                                    $bgColor = $isCorrect ? '#d4edda' : ($isSelected ? '#f8d7da' : 'white');
                                    $borderColor = $isCorrect ? '#c3e6cb' : ($isSelected ? '#f5c6cb' : '#dee2e6');
                                @endphp

                                <div class="mt-2 p-2 px-3 rounded border d-flex justify-content-between align-items-center" 
                                     style="background-color: {{ $bgColor }}; border-color: {{ $borderColor }} !important;">
                                    
                                    <span>
                                        <strong>{{ chr(65 + $key) }}.</strong> {{ $option }}
                                    </span>

                                    @if($isCorrect)
                                        <span class="badge bg-success text-white small">
                                            <i class="fas fa-check-circle"></i> Correct
                                        </span>
                                    @elseif($isSelected)
                                        <span class="badge bg-danger text-white small">
                                            <i class="fas fa-times-circle"></i> Learner's Choice
                                        </span>
                                    @endif
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection