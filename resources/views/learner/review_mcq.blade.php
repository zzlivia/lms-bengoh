@extends('layouts.open_layout')

@section('content')
    <div class="container-fluid mt-3">
        <div class="row">
            @include('partials.course-sidebar', ['course' => $course])
            
            <div class="col-md-9 px-md-4">
                <h4 class="mb-4">{{ __('messages.courses.review_answers') }}</h4>

                {{-- Display Score from Session or Database --}}
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
                            
                            //convert DB (1-4) to Index (0-3)
                            $correctIndex = (int)$question->correct_answer - 1; 

                            $isCorrect = ($key === $correctIndex);
                            $isSelected = ($userSelection !== null && (int)$userSelection === $key);

                        @endphp

                        @foreach($options as $key => $option)
                            @if($option)
                                @php
                                    $isCorrect = ($key === $correctIndex);
                                    // Robust check for selection
                                    $isSelected = ($userSelection !== null && (string)$userSelection === (string)$key);
                                @endphp

                                <div class="mt-2 p-2 rounded" style="border: 1px solid #eee; background-color: {{ $isCorrect ? '#d4edda' : ($isSelected ? '#f8d7da' : 'transparent') }}">
                                    <strong>{{ chr(65 + $key) }}.</strong> {{ $option }}
                                    
                                    @if($isCorrect)
                                        <i class="bi bi-check-circle-fill text-success"></i> <small class="text-success">(Correct Answer)</small>
                                    @endif

                                    @if($isSelected && !$isCorrect)
                                        <i class="bi bi-x-circle-fill text-danger"></i> <small class="text-danger">(Your Choice)</small>
                                    @endif
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endforeach

                {{-- Fixed Button Row (Moved outside the loop but inside the col-md-9) --}}
                <div class="mt-4 d-flex gap-3 mb-5">
                    <a href="{{ route('mcq.module', $module->moduleID) }}" class="btn btn-secondary px-4">
                        <i class="bi bi-arrow-left"></i> {{ __('messages.courses.back_to_mcq') }}
                    </a>
                    <a href="{{ route('course.feedback', ['id' => $module->courseID]) }}" class="btn btn-primary px-4">
                        {{ __('messages.courses.proceed_to_feedback') }} <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div> {{-- End col-md-9 --}}
        </div> {{-- End row --}}
    </div> {{-- End container --}}
@endsection