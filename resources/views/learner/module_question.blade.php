@extends('layouts.open_layout')

@section('content')
    <div class="container-fluid mt-3">
        <div class="row">
            {{-- include sidebar of courses --}}
            @include('partials.course-sidebar', ['course' => $course])
            {{-- main content --}}
            <div class="col-md-9 px-md-4">
                <h5 class="mb-4">
                    Multiple Choice Questions of Module {{ $module->moduleID }} : {{ $module->moduleName }}
                </h5>
                <form id="quizForm" method="POST" action="{{ route('module.submit', $module->moduleID) }}">
                    @csrf

                    @if(session('warning'))
                        <div class="alert alert-warning">
                            {{ session('warning') }}

                            <div class="mt-2">
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
                            $selected = old('answers.' . $question->moduleQs_ID);
                        @endphp

                        <div class="card mb-3 p-3 shadow-sm">
                            @if(!$selected && session('warning'))
                                <div class="text-danger mt-2">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    You did not answer this question
                                </div>
                            @endif 

                            <div class="d-flex justify-content-between align-items-start">
                                <strong id="questionText{{ $index }}">
                                    {{ $index+1 }}. {{ $question->moduleQs }}
                                </strong>

                                <button type="button" class="btn btn-sm btn-primary ms-2" onclick="speakQuestion({{ $index }})">
                                    <i class="fas fa-volume-up"></i> Listen
                                </button>
                            </div>

                            @foreach($question->answers as $answer)
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="radio"
                                        name="answers[{{ $question->moduleQs_ID }}]"
                                        value="{{ $answer->ansID }}"
                                        {{ old('answers.' . $question->moduleQs_ID) == $answer->ansID ? 'checked' : '' }}>

                                    <label class="form-check-label">
                                        {{ $answer->ansID_text }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    @endforeach

                    <button type="submit" class="btn btn-dark">Submit Answers</button>
                </form>

                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                @if(session()->has('score'))
                    <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        let feedbackUrl = "{{ session('goFeedback') }}";
                        let reviewUrl = "{{ session('reviewUrl') }}";
                        let assessmentUrl = "{{ route('course.assessment', ['id' => session('courseID')]) }}";
                        let timerInterval;
                        Swal.fire({
                            title: 'MCQS Completed 🎉',
                            html: `
                                You scored <b>{{ session('score') }} / {{ session('total') }}</b><br>
                                Attempt: <b>{{ session('attempts') }}</b><br><br>
                                Redirecting in <b><span id="countdown">10</span></b> seconds...
                            `,
                            icon: '{{ session('score') == session('total') ? "success" : "info" }}',
                            timer: 10000,
                            timerProgressBar: true,
                            showConfirmButton: true,
                            showCancelButton: true,
                            showCloseButton: true,
                            confirmButtonText: 'Proceed to Feedback',
                            cancelButtonText: 'Review Answers',
                            didOpen: () => {
                                const countdownEl = document.getElementById('countdown');
                                let timeLeft = 10;

                                timerInterval = setInterval(() => {
                                    timeLeft--;
                                    if (countdownEl) countdownEl.textContent = timeLeft;
                                }, 1000);
                            },
                            willClose: () => {
                                clearInterval(timerInterval);
                            }
                        }).then((result) => {

                            if (result.isConfirmed) {
                                window.location.href = feedbackUrl;
                            } 
                            else if (result.dismiss === Swal.DismissReason.cancel) {
                                window.location.href = reviewUrl;
                            } 
                            else {
                                // ⏱ Timer finished OR ❌ clicked
                                window.location.href = assessmentUrl;
                            }
                        });

                    });
                    </script>
                @endif
            </div>
        </div>
    </div>

    <script src="{{ asset('js/language.js') }}"></script>
    {{-- installed alert --}}

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const form = document.getElementById("quizForm");
            let allowSubmit = false;

            form.addEventListener("submit", function(e) {

                if (allowSubmit) {
                    return; //skip validation second time
                }

                let totalQuestions = {{ count($module->mcqs) }};
                let answered = document.querySelectorAll('input[type="radio"]:checked').length;
                let unanswered = totalQuestions - answered;

                if (answered < totalQuestions) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Incomplete!',
                        html: `You skipped <b>${unanswered}</b> question(s).<br>Do you want to continue?`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, continue',
                        cancelButtonText: 'Go back'
                    }).then((result) => {
                        if (result.isConfirmed) {

                            allowSubmit = true;
                            let input = document.createElement("input");
                            input.type = "hidden";
                            input.name = "force_submit";
                            input.value = "1";
                            form.appendChild(input);

                            form.requestSubmit(); // submit again WITHOUT triggering popup
                        }
                    });
                }
            });
        });
    </script>

    <script>
        //save answer
        function saveAnswer(moduleId, questionId, selectedOption) {
            let data = JSON.parse(localStorage.getItem("mcq_attempts")) || [];
            let moduleAttempt = data.find(m => m.module_id === moduleId);
            if (!moduleAttempt) {
                moduleAttempt = {module_id: moduleId, answers: [], status: "pending"};
                data.push(moduleAttempt);
            }
            const existing = moduleAttempt.answers.find(a => a.question_id === questionId);
            if (existing) {
                existing.selected = selectedOption;
            } else {
                moduleAttempt.answers.push({question_id: questionId, selected: selectedOption});
            }
            localStorage.setItem("mcq_attempts", JSON.stringify(data));
        }


        //load saved answers
        function loadSavedAnswers(moduleId) {
            let data = JSON.parse(localStorage.getItem("mcq_attempts")) || [];
            let moduleAttempt = data.find(m => m.module_id === moduleId);
            if (!moduleAttempt) return;
            moduleAttempt.answers.forEach(ans => {
                const input = document.querySelector(`input[name="q${ans.question_id}"][value="${ans.selected}"]`);
                if (input) input.checked = true;
            });
        }
    </script>
@endsection