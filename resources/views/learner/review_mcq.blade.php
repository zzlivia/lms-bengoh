@extends('layouts.open_layout')

@section('content')
    <div class="container-fluid mt-3">
        <div class="row">
            {{-- add sidebar of course --}}
            @include('partials.course-sidebar')
            {{-- main content --}}
            <div class="col-md-9 px-md-4">
                <h4 class="mb-4">Review Answers</h4>

                @foreach($module->mcqs as $index => $question)
                    <div class="card p-3 mb-3 shadow-sm">
                        <strong>{{ $index+1 }}. {{ $question->moduleQs }}</strong>

                        @foreach($question->answers as $answer)
                            <div class="mt-2">
                                <span style="color: {{ $answer->ansCorrect ? 'green' : 'black' }}">
                                    {{ $answer->ansID_text }}

                                    @if($answer->ansCorrect)
                                        ✅ (Correct Answer)
                                    @endif
                                </span>
                            </div>
                        @endforeach
                    </div>
                @endforeach
                {{--buttons after loop--}}
                <div class="mt-4 d-flex gap-2">
                    {{-- back to mcq --}}
                    <a href="{{ route('mcq.module', $module->moduleID) }}" class="btn btn-secondary">
                        Back to MCQ
                    </a>

                    {{-- proceed to feedback --}}
                    <a href="{{ route('course.feedback', $module->courseID) }}" class="btn btn-primary">
                        Proceed to Feedback
                    </a>
                </div>

            </div>
        </div>
    </div>
@endsection