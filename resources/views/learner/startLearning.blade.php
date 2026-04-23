@extends('layouts.open_layout')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/startLearning.css') }}">
@endsection

@section('content')
    <div class="container-fluid mt-3">
        <div class="row">
            @include('partials.course-sidebar', ['course' => $course, 'current' => $current])
            <div class="col-md-9 px-md-4">
                <div class="learning-content-card p-4 shadow-sm bg-white rounded">
                    @if(session()->has('error'))
                        <div id="accessModal" class="custom-modal">
                            <div class="custom-modal-content">
                                <span id="closeModal" style="cursor:pointer; float:right;">&times;</span>
                                <p>{{ session('error') }}</p>
                            </div>
                        </div>
                    @endif
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb small">
                            <li class="breadcrumb-item">
                                <a href="{{ route('courses.allCourses') }}">{{ __('messages.courses.courses_breadcrumb') }}</a>
                            </li>
                            <li class="breadcrumb-item active">{{ $course->getTranslation('courseName') }}</li>
                        </ol>
                    </nav>

                    <h3 class="fw-bold mb-4">{{ $course->courseTitle }}</h3>
                    {{-- ================= CONTENT ================= --}}
                    @if($current) {{-- current selected lecture --}}
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="text-primary fw-bold">
                                {{ $current->getTranslation('section_title') }}
                            </h5>
                            <div id="timer" class="fw-bold text-danger"></div>
                        </div>
                        @if($current->section_type == 'video' && $current->section_file)
                            <div class="video-container mb-4">
                                <div class="ratio ratio-16x9">
                                    <video id="lessonVideo" controls class="w-100 h-100 rounded">
                                        <source src="{{ asset('storage/' . $current->section_file) }}" type="video/mp4">{{ __('messages.courses.video_not_supported') }}
                                    </video>
                                </div>
                            </div>
                        @endif
                        @if($current->section_type == 'text') {{-- text lecture content --}}
                            <div class="text-content mb-4 lead-custom">
                                {!! $current->getTranslation('section_content') !!}
                            </div>
                        @endif
                        @if($current->section_type == 'pdf') {{-- PDF frame --}}
                            <div class="pdf-container mb-4">
                                <iframe 
                                    id="lessonPdf"
                                    src="{{ url('/pdf/' . basename($current->section_file)) }}#toolbar=0"
                                    width="100%"
                                    height="600px"
                                    class="rounded border">
                                </iframe>
                            </div>
                        @endif
                    {{-- ================= MCQ ================= --}}
                    @elseif($module && $module->mcqs->count())
                        <h5 class="fw-bold mb-3">{{ __('messages.courses.module_quiz') }}: {{ $module->moduleName }}</h5>
                        <form id="quizForm" method="POST" action="{{ route('module.questions.submit', $module->moduleID) }}">
                            @csrf
                            @foreach($module->mcqs as $question)
                                <div class="mb-4">
                                    <strong>{{ $question->getTranslation('question') }}</strong>
                                    @foreach($question->answers as $answer)
                                        <div class="form-check">
                                            <input class="form-check-input"
                                                type="radio"
                                                name="answers[{{ $question->moduleQs_ID }}]"
                                                value="{{ $answer->ansID }}">
                                            <label class="form-check-label">
                                                {{ $answer->ansID_text }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                            <button class="btn btn-primary">{{ __('messages.courses.submit_quiz') }}</button>
                        </form>
                    {{-- ================= EMPTY ================= --}}
                    @else
                        <div class="alert alert-info">
                            {{ __('messages.courses.select_prompt') }}
                        </div>
                    @endif
                    {{-- ================= NAVIGATION ================= --}}
                    @php
                        $prev = $sections[$currentIndex - 1] ?? null;
                        $next = $sections[$currentIndex + 1] ?? null;
                        $isLast = $currentIndex == count($sections) - 1;
                    @endphp
                    <div class="d-flex justify-content-between mt-5 pt-3 border-top">
                        <div>
                            @if($prev)
                                <a href="{{ route('learn', ['id' => $course->courseID, 'sectionId' => $prev->sectionID]) }}" class="btn btn-outline-secondary">← {{ __('messages.courses.previous') }}</a>
                            @endif
                        </div>
                        <div>
                            @if(!empty($current->section_file))
                                <button onclick="downloadLesson('{{ asset('storage/' . $current->section_file) }}', this)" 
                                        class="btn btn-warning">
                                    <i class="bi bi-download"></i>
                                </button>
                            @endif
                        </div>
                        <div>
                            @if(!$isLast)
                                <a href="{{ route('learn', ['id' => $course->courseID, 'sectionId' => $next->sectionID]) }}" class="btn btn-primary">{{ __('messages.courses.next') }} →</a>
                            @else
                                <a href="{{ route('mcq.module', $module->moduleID ?? 1) }}" class="btn btn-success text-white">{{ __('messages.courses.go_to_mcq') }} →</a>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ================= SCRIPTS ================= --}}

    <script>
        // global Variables & Localized strings
        const courseId = {{ $course->courseID }};
        const allSections = @json($sections->pluck('sectionID'));
        const confirmMsg = "{{ __('messages.courses.quiz_confirm') }}";
        const timeLeftLabel = "{{ __('messages.courses.time_left') }}";
        const completedLabel = "{{ __('messages.courses.completed') }}";
        window.lectID = {{ $current->lectID ?? 0 }};
        // consolidated Quiz Form Logic
        document.getElementById('quizForm')?.addEventListener('submit', function(e) {
            const questions = document.querySelectorAll('[name^="answers["]');
            const answered = new Set();
            // track which questions have been answered
            questions.forEach(input => { 
                if (input.checked) answered.add(input.name); 
            });
            // calculate totals
            const totalQuestions = new Set(Array.from(questions).map(q => q.name)).size;
            const remainingQuestions = totalQuestions - answered.size;
            // if questions are missing, show confirmation
            if (answered.size < totalQuestions) {
                e.preventDefault();
                // use translation string if available, otherwise fallback to English
                let msg = confirmMsg.includes(':count') 
                    ? confirmMsg.replace(':count', remainingQuestions) 
                    : `You forgot ${remainingQuestions} question(s). Submit anyway?`;
                if (confirm(msg)) {
                    this.submit(); // submit the form programmatically if user says OK
                }
            }
        });

        // lecture Timer & Auto-Complete Logic
        @if($current && $current->lecture && $current->lecture->lect_duration)
            (function() {
                const lectureId = {{ $current->lectID }};
                const storageKey = "lecture_timer_" + lectureId;
                const timerDisplay = document.getElementById('timer');
                const totalDuration = {{ $current->lecture->lect_duration }} * 60; // Convert mins to secs
                let savedStartTime = localStorage.getItem(storageKey);
                let startTime = savedStartTime ? parseInt(savedStartTime) : Date.now();
                if (!savedStartTime) localStorage.setItem(storageKey, startTime);
                const countdown = setInterval(() => {
                    const now = Date.now();
                    const elapsed = Math.floor((now - startTime) / 1000);
                    const remainingTime = totalDuration - elapsed;
                    if (remainingTime <= 0) {
                        clearInterval(countdown);
                        timerDisplay.textContent = completedLabel + " ✅";
                        localStorage.removeItem(storageKey);
                        //notify Backend of completion
                        fetch(`/lecture/complete/{{ $current->lectID }}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        });
                    } else {
                        let mins = Math.floor(remainingTime / 60);
                        let secs = remainingTime % 60;
                        secs = secs < 10 ? '0' + secs : secs;
                        timerDisplay.textContent = `${timeLeftLabel}: ${mins}:${secs}`;
                    }
                }, 1000);
            })();
        @endif

        // remember Last Section Logic
        (function() {
            const sectionKey = "last_section_{{ auth()->id() }}_{{ $course->courseID }}";
            @if($current)
                localStorage.setItem(sectionKey, "{{ $current->sectionID }}");
            @endif
            const urlParams = new URLSearchParams(window.location.search);
            if (!urlParams.get('sectionId')) {
                const savedSection = localStorage.getItem(sectionKey);
                if (savedSection) {
                    window.location.href = `?sectionId=${savedSection}`;
                }
            }
        })();

        // access Modal Logic
        document.addEventListener("DOMContentLoaded", function () {
            const modal = document.getElementById('accessModal');
            const closeBtn = document.getElementById('closeModal');
            if (modal) {
                modal.style.display = 'flex';
                setTimeout(() => { modal.style.display = 'none'; }, 5000);
                closeBtn?.addEventListener('click', () => { modal.style.display = 'none'; });
                window.addEventListener('click', (e) => { if (e.target === modal) modal.style.display = 'none'; });
            }
        });
    </script>

    <script src="{{ asset('js/app.js') }}"></script>
@endsection