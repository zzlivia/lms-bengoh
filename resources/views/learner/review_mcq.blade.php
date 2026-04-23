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
                        <span class="badge {{ session('score') == session('total') ? 'bg-success' : 'bg-primary' }} p-2">
                            {{ session('score') == session('total') ? 'Perfect!' : 'Keep Learning' }}
                        </span>
                    </div>
                @endif
                @foreach($module->mcqs as $index => $question)
                    <div class="card p-3 mb-3 shadow-sm">
                        <strong>{{ $index+1 }}. {{ $question->getTranslation('question') }}</strong>
                        @php
                            $options = [
                                1 => $question->getTranslation('answer1'),
                                2 => $question->getTranslation('answer2'),
                                3 => $question->getTranslation('answer3'),
                                4 => $question->getTranslation('answer4'),
                            ];
                            $correct = $question->correct_answer;
                            $labels = [1 => 'A', 2 => 'B', 3 => 'C', 4 => 'D'];
                        @endphp

                        @foreach($options as $key => $option)
                            @if($option)
                                @php
                                    $labels = [1 => 'A', 2 => 'B', 3 => 'C', 4 => 'D'];
                                @endphp

                                <div class="mt-2">
                                    <span style="color: {{ $key == $correct ? 'green' : 'black' }}">
                                        <strong>{{ $labels[$key] }}.</strong> {{ $option }}
                                        @if($key == $correct)
                                            <i class="bi bi-check-circle-fill text-success"></i>
                                            <small class="text-success fw-bold">({{ __('messages.courses.correct_answer') }})</small>
                                        @endif
                                    </span>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endforeach
                {{--buttons after loop--}}
                <div class="mt-4 d-flex gap-2">
                    {{-- back to mcq --}}
                    <a href="{{ route('mcq.module', $module->moduleID) }}" class="btn btn-secondary">
                        {{ __('messages.courses.back_to_mcq') }}
                    </a>
                    {{-- proceed to feedback --}}
                    <a href="{{ route('course.feedback', ['id' => $module->courseID]) }}" class="btn btn-primary">
                        {{ __('messages.courses.proceed_to_feedback') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection