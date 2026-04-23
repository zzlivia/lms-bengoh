@extends('layouts.open_layout')

@section('content')
    <div class="container-fluid mt-3">
        <div class="row">
            {{-- add sidebar of course --}}
            @include('partials.course-sidebar', ['course' => $course])
            {{-- main content --}}
            <div class="col-md-9 px-md-4">
                <h4 class="mb-4">{{ __('messages.courses.review_answers') }}</h4>
                {{-- display score --}}
                @if(session()->has('score'))
                    <div class="alert alert-info shadow-sm d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0">
                                <i class="bi bi-trophy-fill text-warning me-2"></i>
                                {{ __('messages.courses.score_label') }}: 
                                <strong>{{ session('score') }} / {{ session('total') }}</strong>
                            </h5>
                            <small>{{ __('messages.courses.attempt_label') }}: {{ session('attempts') }}</small>
                        </div>
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
                            $correct = $question->correct_answer;
                            $labels = [1 => 'A', 2 => 'B', 3 => 'C', 4 => 'D'];
                        @endphp

                        @foreach($options as $key => $option)
                            @if($option)
                                @php
                                    $userSelection = $selectedAnswers[$question->moduleQs_ID] ?? null;
                                    $correctIndex = $question->correct_answer - 1; 
                                @endphp
                                <div class="mt-2" style="color: {{ ($key == $correctIndex) ? 'green' : (($key == $userSelection) ? 'red' : 'black') }}">
                                    <strong>{{ $labels[$key + 1] }}.</strong> {{ $option }}
                                    @if($key == $correctIndex)
                                        <i class="bi bi-check-circle-fill text-success"></i>
                                    @endif
                                    @if($key == $userSelection && $key != $correctIndex)
                                        <i class="bi bi-x-circle-fill text-danger"></i>
                                        <small class="text-danger">({{ __('messages.courses.your_answer') }})</small>
                                    @endif
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endforeach
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