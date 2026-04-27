@extends('layouts.open_layout')

@section('content')
    <div class="container-fluid mt-3">
        <div class="row">
            @include('partials.course-sidebar', ['course' => $course])
            
            <div class="col-md-9 px-md-4">
                <h4 class="mb-4">{{ __('messages.courses.review_answers') }}</h4>

                {{-- Display Score --}}
                @if(session('score') !== null)
                    <div class="alert alert-success shadow-sm">
                        <h5>Result: {{ session('score') }} / {{ session('total') }} Marks</h5>
                        <p class="mb-0">Attempt: {{ session('attempts') }}/3</p>
                    </div>
                @endif

                @foreach($module->mcqs as $index => $question)
                    <div class="card p-3 mb-3 shadow-sm">
                        <strong>{{ $index+1 }}. {{ $question->getTranslation('question') }}</strong>
                        
                        @php
                            $options = [
                                0 => $question->getTranslation('answer1'),
                                1 => $question->getTranslation('answer2'),
                                2 => $question->getTranslation('answer3'),
                                3 => $question->getTranslation('answer4'),
                            ];
                            $userSelection = session('last_submitted_answers')[$question->moduleQs_ID] ?? null;
                            $correctIndex = (int)$question->correct_answer - 1; 
                        @endphp
                        @foreach($options as $key => $option)
                            @if($option)
                                @php
                                    $isCorrect = ($key === $correctIndex);
                                    $isSelected = ($userSelection !== null && (string)$userSelection === (string)$key);
                                @endphp

                                <div class="mt-2 p-3 rounded border" 
                                    style="background-color: {{ $isCorrect ? '#d4edda' : ($isSelected ? '#f8d7da' : 'white') }}; 
                                            border-color: {{ $isCorrect ? '#c3e6cb' : ($isSelected ? '#f5c6cb' : '#dee2e6') }} !important;">
                                    
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span>
                                            <strong>{{ chr(65 + $key) }}.</strong> {{ $option }}
                                        </span>

                                        @if($isCorrect)
                                            <span class="badge bg-success text-white p-2">
                                                <i class="bi bi-check-circle-fill"></i> Correct Answer
                                            </span>
                                        @elseif($isSelected)
                                            <span class="badge bg-danger text-white p-2">
                                                <i class="bi bi-x-circle-fill"></i> Your Choice
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endforeach
                {{-- bottom --}}
                <div class="d-flex justify-content-between mt-4">
                    {{-- Always allow them to go back to the MCQ if they want to try again (if attempts remain) --}}
                    <a href="{{ route('mcq.module', $module->moduleID) }}" class="btn btn-outline-secondary">
                        ← {{ __('messages.courses.back_to_mcq') }}
                    </a>

                    @if($nextSectionID)
                        {{-- 1 if there are more modules to learn --}}
                        <a href="{{ route('learn', ['id' => $course->courseID, 'sectionId' => $nextSectionID]) }}" class="btn btn-primary">
                            {{ __('messages.courses.continue_to_next_module') }} →
                        </a>
                    @else
                        {{-- 2 for final module of the course --}}
                        <a href="{{ route('course.feedback', $course->courseID) }}" class="btn btn-success">
                            {{ __('messages.courses.proceed_to_feedback') }} →
                        </a>
                    @endif
                </div>
            </div> 
        </div> 
    </div>
@endsection