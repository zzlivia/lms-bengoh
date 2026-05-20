@extends('layouts.open_layout')

@section('content')
    <div class="container-fluid mt-3">
        <div class="row">
            {{-- Desktop Sidebar Column: Matches Feedback structure --}}
            <div class="col-md-3 d-none d-md-block" id="desktopSidebar">
                @include('partials.course-sidebar', ['course' => $course])
            </div>

            {{-- Main Content Column --}}
            <div class="col-12 col-md-9 px-md-4">
                {{-- Mobile Menu Toggle & Breadcrumb Layout --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <button class="btn btn-sm btn-outline-primary d-md-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
                        <i class="fas fa-bars"></i> {{ __('messages.courses.course_modules') }}
                    </button>
                    
                    <nav aria-label="breadcrumb" class="d-none d-sm-block">
                        <ol class="breadcrumb mb-0 small">
                            <li class="breadcrumb-item"><a href="{{ route('courses.allCourses') }}">{{ __('messages.courses.courses_breadcrumb') }}</a></li>
                            <li class="breadcrumb-item active text-truncate" style="max-width: 200px;">{{ $course->getTranslation('courseName') }}</li>
                            <li class="breadcrumb-item active">{{ __('messages.courses.mcq_title', ['id' => $module->moduleID, 'name' => $module->getTranslation('moduleName')]) }}</li>
                        </ol>
                    </nav>
                </div>

                <h5 class="mb-4">
                    {{ __('messages.courses.mcq_title', ['id' => $module->moduleID, 'name' => $module->getTranslation('moduleName')]) }}
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
                                    {{ __('messages.courses.skip_continue') }}
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
                                    {{ __('messages.courses.not_answered') }}
                                </div>
                            @endif 

                            <div class="d-flex justify-content-between align-items-start">
                                <strong id="questionText{{ $index }}">
                                    {{ $index+1 }}. {{ $question->getTranslation('question') }}
                                </strong>

                                <button type="button" class="btn btn-sm btn-primary ms-2" onclick="speakQuestion({{ $index }})">
                                    <i class="fas fa-volume-up"></i> {{ __('messages.courses.listen') }}
                                </button>
                            </div>
                            
                            @php
                                $answers = [
                                    0 => $question->getTranslation('answer1'),
                                    1 => $question->getTranslation('answer2'),
                                    2 => $question->getTranslation('answer3'),
                                    3 => $question->getTranslation('answer4'),
                                ];
                            @endphp

                            @foreach($answers as $key => $answer)
                                @if($answer)
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="radio"
                                            name="answers[{{ $question->moduleQs_ID }}]"
                                            value="{{ $key }}"
                                            {{ old('answers.' . $question->moduleQs_ID) == (string)$key ? 'checked' : '' }}>
                                        <label class="form-check-label">
                                            {{ $answer }}
                                        </label>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endforeach

                    <button type="submit" class="btn btn-dark">{{ __('messages.courses.submit_answers') }}</button>
                </form>

                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                @if(session()->has('score'))
                    <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        const swalTitle = "{{ __('messages.courses.mcq_complete_title') }}";
                        const swalScore = "{{ __('messages.courses.score_label') }}";
                        const swalAttempt = "{{ __('messages.courses.attempt_label') }}";
                        const swalRedirect = "{{ __('messages.courses.redirect_label') }}";

                        let timerInterval;

                        Swal.fire({
                            title: swalTitle,
                            html: `
                                ${swalScore}: <b>{{ session('score') }} / {{ session('total') }}</b><br>
                                ${swalAttempt}: <b>{{ session('attempts') }}</b><br><br>
                                ${swalRedirect} <b><span id="countdown">10</span></b> ...
                            `,
                            icon: '{{ session('score') == session('total') ? "success" : "info" }}',
                            timer: 10000,
                            timerProgressBar: true,
                            showConfirmButton: true,
                            showCancelButton: true,
                            showCloseButton: true,
                            confirmButtonText: "{{ __('messages.courses.proceed_to_feedback') }}",
                            cancelButtonText: "{{ __('messages.courses.review_answers') }}",
                            didOpen: () => {
                                const countdownEl = document.getElementById('countdown');
                                let timeLeft = 10;
                                timerInterval = setInterval(() => {
                                    timeLeft--;
                                    if (countdownEl) countdownEl.textContent = timeLeft;
                                }, 1000);
                            },
                            willClose: () => { clearInterval(timerInterval); }
                        }).then((result) => {
                            if (result.isConfirmed) { 
                                window.location.href = "{{ route('course.feedback', ['id' => $module->courseID]) }}"; 
                            } 
                            else if (result.dismiss === Swal.DismissReason.cancel) { 
                                window.location.href = "{{ route('module.review', ['id' => $module->moduleID]) }}"; 
                            } 
                            else { 
                                window.location.href = "{{ route('course.assessment', ['id' => $module->courseID]) }}"; 
                            }
                        });
                    });
                    </script>
                @endif
            </div>
        </div>
    </div>

    {{-- Mobile Sidebar Drawer --}}
    <div class="offcanvas offcanvas-start d-md-none" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title fw-bold" id="mobileSidebarLabel">Course Modules</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-0">
            @include('partials.course-sidebar', ['course' => $course])
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const form = document.getElementById("quizForm");
            let allowSubmit = false;
            form.addEventListener("submit", function(e) {
                if (allowSubmit) return;
                
                let totalQuestions = {{ count($module->mcqs) }};
                let answered = document.querySelectorAll('input[type="radio"]:checked').length;
                let unanswered = totalQuestions - answered;
                
                if (answered < totalQuestions) {
                    e.preventDefault();
                    Swal.fire({
                        title: "{{ __('messages.courses.incomplete') }}",
                        html: "{{ __('messages.courses.skipped_msg', ['count' => '${unanswered}']) }}".replace('${unanswered}', unanswered),
                        icon: 'warning',
                        showCancelButton: true,
                        customClass: {
                            confirmButton: 'btn btn-primary btn-lg mx-2', 
                            cancelButton: 'btn btn-secondary btn-lg mx-2'
                        },
                        buttonsStyling: false, 
                    }).then((result) => {
                        if (result.isConfirmed) {
                            allowSubmit = true;
                            let input = document.createElement("input");
                            input.type = "hidden";
                            input.name = "force_submit";
                            input.value = "1";
                            form.appendChild(input);
                            form.submit();
                        }
                    });
                }
            });
        });
    </script>
@endsection