@extends('layouts.open_layout')

@section('styles')
    {{-- Use startLearning.css if it contains the "learning-content-card" styles from your previous code --}}
    <link rel="stylesheet" href="{{ asset('css/startLearning.css') }}">
    <link rel="stylesheet" href="{{ asset('css/course-sidebar.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
@endsection

@section('content')
    <div class="container-fluid mt-3">
        <div class="row">
            <!-- Sidebar: Hidden on mobile, visible on medium+ -->
            <div class="col-md-3 d-none d-md-block" id="desktopSidebar">
                @include('partials.course-sidebar', ['course' => $course])
            </div>

            <!-- Main Content -->
            <div class="col-12 col-md-9 px-md-4">
                {{-- Mobile Sidebar Toggle (Visible only on small screens) --}}
                <div class="d-md-none mb-3">
                    <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
                        <i class="bi bi-list"></i> {{ __('messages.courses.course_modules') }}
                    </button>
                </div>

                <div class="learning-content-card p-4 shadow-sm bg-white rounded border-0">
                    {{-- Header Section --}}
                    <div class="mb-4 border-bottom pb-2 d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2">
                        <div>
                            <h3 class="fw-bold h4 mb-0">{{ $course->getTranslation('courseName') }}</h3>
                            <p class="text-muted small mb-0">{{ __('messages.courses.assessment_title', ['id' => $assessment->courseAssID, 'name' => $assessment->getTranslation('courseAssTitle')]) }}</p>
                        </div>
                        <div class="badge bg-light text-danger border p-2 h-fit">
                            Time Left: <span id="timer">10:00</span>
                        </div>
                    </div>

                    @auth
                        <div class="assessment-purpose mb-4">
                            <p class="mb-1"><b>{{ __('messages.courses.assessment_purpose_label') }}</b></p>
                            <p class="text-secondary small">{{ $assessment->getTranslation('courseAssDesc') }}</p>
                        </div>

                        <form id="assessmentForm" method="POST" action="{{ route('final.assessment.submit', $course->courseID) }}">
                            @csrf
                            <input type="hidden" name="courseAssID" value="{{ $assessment->courseAssID }}">
                            <input type="hidden" name="courseID" value="{{ $course->courseID }}">

                            @foreach($questions as $index => $q)
                                <div class="question-block mb-4">
                                    <p class="fw-bold mb-2">{{ $index+1 }}. {{ $q->getTranslation('courseAssQs') }}</p>
                                    
                                    @if($q->courseAssType == 'MCQ')
                                        <div class="options-group ps-2">
                                            @foreach($q->options as $opt)
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" name="answers[{{ $q->assQsID }}]" value="{{ $opt->id }}" id="opt{{ $opt->id }}">
                                                    <label class="form-check-label pointer ps-1" for="opt{{ $opt->id }}">
                                                        {{ $opt->getTranslation('optionText') }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <textarea name="answers[{{ $q->assQsID }}]" class="form-control mb-3" rows="3" placeholder="Type your answer here..."></textarea>
                                    @endif
                                </div>
                            @endforeach

                            <div class="mt-4 pt-3 border-top">
                                <button type="button" class="btn btn-success px-5 shadow-sm" data-bs-toggle="modal" data-bs-target="#confirmSubmitModal">
                                    {{ __('messages.courses.submit') }}
                                </button>
                            </div>

                            {{-- Modal code remains the same as your previous version --}}
                            <div class="modal fade" id="confirmSubmitModal" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">{{ __('messages.courses.confirm_submission') }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            {{ __('messages.courses.confirm_prompt') }}<br>
                                            {{ __('messages.courses.check_answers_prompt') }}
                                            <div id="warningText" class="text-danger mt-2 fw-bold"></div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('messages.courses.cancel') }}</button>
                                            <button type="button" class="btn btn-success" id="confirmSubmitBtn">{{ __('messages.courses.yes_submit') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @endauth

                    @guest
                        <div class="text-center p-5">
                            <div class="display-4 mb-3">🔒</div>
                            <p>{{ __('messages.courses.login_required') }}</p>
                            <div class="d-grid gap-2 col-mx-auto">
                                <a href="{{ route('login') }}" class="btn btn-primary">{{ __('messages.courses.login') }}</a>
                            </div>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </div>

    {{-- Offcanvas Mobile Sidebar --}}
    <div class="offcanvas offcanvas-start d-md-none" tabindex="-1" id="mobileSidebar">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title fw-bold">Course Modules</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body p-0">
            @include('partials.course-sidebar', ['course' => $course])
        </div>
    </div>

    <!-- SCRIPT -->
    <script>
        document.getElementById('confirmSubmitBtn').addEventListener('click', function () {
            document.getElementById('assessmentForm').submit();
        });
    </script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const triggerBtn = document.querySelector('[data-bs-target="#confirmSubmitModal"]');
        const warningLabel = "{{ __('messages.courses.unanswered_warning') }}";
        triggerBtn.addEventListener('click', function () {
            let unanswered = 0;
            document.querySelectorAll('textarea').forEach(el => {
                if (el.value.trim() === '') unanswered++;
            });
            let grouped = {};
            document.querySelectorAll('input[type=radio]').forEach(el => {
                if (!grouped[el.name]) grouped[el.name] = false;
                if (el.checked) grouped[el.name] = true;
            });
            for (let key in grouped) {
                if (!grouped[key]) unanswered++;
            }
            let warning = document.getElementById('warningText');
            if (unanswered > 0) {
                warning.innerHTML = `⚠️ You have ${unanswered} unanswered question(s).`;
            } else {
                warning.innerHTML = '';
            }
        });

        //force submit form
        document.getElementById('confirmSubmitBtn').addEventListener('click', function () {
            document.getElementById('assessmentForm').submit();
        });

    });
    </script>

    <script>
        let timeLeft = 600; // 10 minutes

        const timerEl = document.getElementById('timer');

        const countdown = setInterval(() => {
            let minutes = Math.floor(timeLeft / 60);
            let seconds = timeLeft % 60;

            seconds = seconds < 10 ? '0' + seconds : seconds;
            timerEl.textContent = minutes + ':' + seconds;

            if (timeLeft <= 0) {
                clearInterval(countdown);
                document.getElementById('assessmentForm').submit();
            }

            timeLeft--;
        }, 1000);
    </script>

@endsection