@extends('layouts.open_layout')

@section('content')
    <div class="container-fluid mt-3">
        <div class="row">
            {{-- add sidebar of course --}}
            @include('partials.course-sidebar', ['course' => $course])
            {{-- main content --}}
            <div class="col-md-9 px-md-4">
                <h4 class="mb-4">{{ __('messages.courses.review_answers') }}</h4>

                {{-- Display Score and Marks --}}
                @if(session('score') !== null)
                    <div class="alert alert-success shadow-sm">
                        <h5>Result: {{ session('score') }} / {{ session('total') }} Marks</h5>
                        <p class="mb-0">Percentage: {{ (session('score') / session('total')) * 100 }}% | Attempt: {{ session('attempts') }}/3</p>
                    </div>
                @endif

                {{-- Red Error Alert if they tried to submit a 4th time --}}
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
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
                            // Get the user's specific choice from the session
                            $userSelection = session('last_submitted_answers')[$question->moduleQs_ID] ?? null;
                            $correctIndex = (int)$question->correct_answer - 1;
                        @endphp

                        @foreach($options as $key => $option)
                            @if($option)
                                @php
                                    $isCorrect = ($key === $correctIndex);
                                    $isSelected = ($userSelection !== null && (int)$userSelection === $key);
                                @endphp

                                <div class="mt-2 p-2 rounded" style="background-color: {{ $isCorrect ? '#d4edda' : ($isSelected ? '#f8d7da' : 'transparent') }}">
                                    <strong>{{ chr(65 + $key) }}.</strong> {{ $option }}
                                    
                                    @if($isCorrect)
                                        <i class="bi bi-check-circle-fill text-success"></i> (Correct Answer)
                                    @endif

                                    @if($isSelected && !$isCorrect)
                                        <i class="bi bi-x-circle-fill text-danger"></i> (Your Choice)
                                    @endif
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endforeach
            </div>
                {{--buttons after loop--}}
                <div class="mt-4 d-flex gap-3">
                    <a href="{{ route('mcq.module', $module->moduleID) }}" class="btn btn-secondary px-4">
                        {{ __('messages.courses.back_to_mcq') }}
                    </a>
                    <a href="{{ route('course.feedback', ['id' => $module->courseID]) }}" class="btn btn-primary px-4">
                        {{ __('messages.courses.proceed_to_feedback') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection