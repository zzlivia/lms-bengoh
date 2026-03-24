@extends('layouts.open_layout')

@section('content')
    <div class="container-fluid mt-3">
        <div class="row">
            {{-- include sidebar of courses --}}
            @include('partials.course-sidebar')
            {{-- main content --}}
            <div class="col-md-9 px-md-4">
                <h5 class="mb-4">
                    Multiple Choice Questions of Module {{ $module->moduleID }} : {{ $module->moduleName }}
                </h5>
                <form method="POST" action="{{ route('module.submit', $module->moduleID) }}">
                    @csrf
                    {{-- skip and continue button --}}
                    @if(session('warning'))
                        <div class="alert alert-warning">
                            {{ session('warning') }}

                            <div class="mt-2">
                                {{-- preserve previous answers --}}
                                @foreach(old('answers', []) as $qID => $ansID)
                                    <input type="hidden" name="answers[{{ $qID }}]" value="{{ $ansID }}">
                                @endforeach

                                <button type="submit" name="force_submit" value="1" class="btn btn-danger btn-sm">
                                    Skip & Continue
                                </button>
                            </div>
                        </div>
                    @endif
                    @foreach($module->mcqs as $index => $question)
                        @php
                            $selected = old('answers.' . $question->moduleQs_ID); //check if user have selected answer
                        @endphp
                        <div class="card mb-3 p-3 shadow-sm">
                            {{-- if the question is not being answer, it will trigger warning --}}
                            @if(!$selected && session('warning'))
                                <div class="text-danger mt-2"><i class="fas fa-exclamation-circle me-1"></i>You did not answer this question</div>
                            @endif 
                            <div class="d-flex justify-content-between align-items-start">
                                <strong id="questionText{{ $index }}">{{ $index+1 }}. {{ $question->moduleQs }}</strong>
                                <button type="button" class="btn btn-sm btn-primary ms-2" onclick="speakQuestion({{ $index }})">
                                    <i class="fas fa-volume-up"></i> Listen
                                </button>
                            </div>
                            @foreach($question->answers as $answer)
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="radio" name="answers[{{ $question->moduleQs_ID }}]" value="{{ $answer->ansID }}"
                                        {{ old('answers.' . $question->moduleQs_ID) == $answer->ansID ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ $answer->ansID_text }}</label>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                    <button class="btn btn-dark">Submit Answers</button>
                </form>
                @if(session('score'))
                    <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        Swal.fire({
                            title: 'Quiz Completed 🎉',
                            text: 'You scored {{ session('score') }} / {{ session('total') }}',
                            icon: '{{ session('score') == session('total') ? "success" : "info" }}',
                            showCancelButton: true,
                            confirmButtonText: 'Proceed to Feedback',
                            cancelButtonText: 'View Answers'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "{{ session('goFeedback') }}";
                            } else {
                                window.location.href = "{{ session('reviewUrl') }}";
                            }
                        });
                    });
                    </script>
                @endif
            </div>
        </div>
    </div>

    <script src="{{ asset('js/language.js') }}"></script>
    {{-- installed alert
    
    --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection