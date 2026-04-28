@extends('layouts.open_layout')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/startLearning.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
@endsection

@section('content')
    <div class="container-fluid mt-3">
        <div class="row">
            {{-- Sidebar: Hidden on small screens, shown in a column on medium+ --}}
           <div class="col-md-3 d-none d-md-block" id="desktopSidebar">
                @include('partials.course-sidebar', ['course' => $course, 'current' => $current])
            </div>

            <div class="col-12 col-md-9 px-md-4">
                {{-- Mobile Menu Toggle & Breadcrumb --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <button class="btn btn-sm btn-outline-primary d-md-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
                        <i class="bi bi-list"></i> {{ __('messages.courses.course_modules') }}
                    </button>
                    
                    <nav aria-label="breadcrumb" class="d-none d-sm-block">
                        <ol class="breadcrumb mb-0 small">
                            <li class="breadcrumb-item"><a href="{{ route('courses.allCourses') }}">{{ __('messages.courses.courses_breadcrumb') }}</a></li>
                            <li class="breadcrumb-item active text-truncate" style="max-width: 200px;">{{ $course->getTranslation('courseName') }}</li>
                        </ol>
                    </nav>
                </div>

                <div class="learning-content-card p-4 shadow-sm bg-white rounded border-0">
                    @if(session()->has('error'))
                        <div id="accessModal" class="custom-modal">
                            <div class="custom-modal-content">
                                <span id="closeModal" style="cursor:pointer; float:right;">&times;</span>
                                <p>{{ session('error') }}</p>
                            </div>
                        </div>
                    @endif

                    {{-- Title and Progress Indicator --}}
                    <div class="mb-4">
                        <h3 class="fw-bold h4 mb-1">{{ $course->courseTitle }}</h3>
                        <div class="text-muted small">
                            @if($current)
                                {{ __('messages.courses.module') }} {{ $current->module->moduleID ?? '' }} • Step {{ $currentIndex + 1 }} of {{ $sections->count() }}
                            @endif
                        </div>
                    </div>

                    {{-- ================= CONTENT AREA ================= --}}
                    <div class="step-content-wrapper">
                        @if($current)
                            <div class="d-flex justify-content-between align-items-start mb-3 border-bottom pb-2">
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ $current->getTranslation('section_title') }}
                                </h5>
                                <div id="timer" class="badge bg-light text-danger border p-2"></div>
                            </div>

                            {{-- Video Player --}}
                            @if($current->section_type == 'video' && $current->section_file)
                                <div class="video-container mb-4 shadow-sm rounded overflow-hidden">
                                    <div class="ratio ratio-16x9">
                                        <video id="lessonVideo" controls class="w-100">
                                            <source src="{{ asset('storage/' . $current->section_file) }}" type="video/mp4">
                                            {{ __('messages.courses.video_not_supported') }}
                                        </video>
                                    </div>
                                </div>
                            @endif

                            {{-- Text Content --}}
                            @if($current->section_type == 'text')
                                <div class="text-content mb-4 lead-custom p-2">
                                    {!! $current->getTranslation('section_content') !!}
                                </div>
                            @endif

                            {{-- PDF Viewer --}}
                            @if($current->section_type == 'pdf')
                                <div class="pdf-container mb-4 rounded border overflow-hidden">
                                    <iframe id="lessonPdf" src="{{ url('/pdf/' . basename($current->section_file)) }}#toolbar=0" width="100%" height="600px"></iframe>
                                </div>
                            @endif

                        {{-- MCQ Step --}}
                        @elseif($module && $module->mcqs->count())
                            <div class="quiz-container p-3 bg-light rounded border">
                                <h5 class="fw-bold mb-4 text-dark"><i class="bi bi-pencil-square me-2"></i>{{ __('messages.courses.module_quiz') }}: {{ $module->moduleName }}</h5>
                                <form id="quizForm" method="POST" action="{{ route('module.questions.submit', $module->moduleID) }}">
                                    @csrf
                                    @foreach($module->mcqs as $question)
                                        <div class="card mb-3 border-0 shadow-sm">
                                            <div class="card-body">
                                                <p class="fw-bold mb-2">{{ $loop->iteration }}. {{ $question->getTranslation('question') }}</p>
                                                @foreach($question->answers as $answer)
                                                    <div class="form-check custom-radio-group mb-2">
                                                        <input class="form-check-input" type="radio" name="answers[{{ $question->moduleQs_ID }}]" value="{{ $answer->ansID }}" id="ans{{ $answer->ansID }}">
                                                        <label class="form-check-label w-100 p-2 border rounded pointer" for="ans{{ $answer->ansID }}">
                                                            {{ $answer->ansID_text }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                    <button class="btn btn-primary w-100 mt-3 py-2 fw-bold shadow">{{ __('messages.courses.submit_quiz') }}</button>
                                </form>
                            </div>
                        @endif
                    </div>

                    {{-- ================= STEP NAVIGATION ================= --}}
                    @php
                        $prev = $sections[$currentIndex - 1] ?? null;
                        $next = $sections[$currentIndex + 1] ?? null;
                        $isEndOfModule = !$next || ($next->moduleID != $current->moduleID);
                    @endphp

                    <div class="d-flex justify-content-between align-items-center mt-auto pt-4 border-top">
                        {{-- Prev Button --}}
                        <div>
                            @if($prev)
                                <a href="{{ route('learn', ['id' => $course->courseID, 'sectionId' => $prev->sectionID]) }}" class="btn btn-outline-secondary px-4">
                                    <i class="bi bi-chevron-left"></i> <span class="d-none d-sm-inline">{{ __('messages.courses.previous') }}</span>
                                </a>
                            @endif
                        </div>

                        {{-- Actions: Download --}}
                        <div>
                            @if($current && !empty($current->section_file))
                                <button onclick="downloadLesson('{{ asset('storage/' . $current->section_file) }}', this)" class="btn btn-warning shadow-sm">
                                    <i class="bi bi-download"></i>
                                </button>
                            @endif
                        </div>

                        {{-- Next / MCQ Button --}}
                        <div>
                            @if(!$isEndOfModule)
                                <a href="{{ route('learn', ['id' => $course->courseID, 'sectionId' => $next->sectionID]) }}" class="btn btn-primary px-md-5 px-3 shadow">
                                    {{ __('messages.courses.next') }} <i class="bi bi-chevron-right ms-2"></i>
                                </a>
                            @else
                                <a href="{{ route('mcq.module', $current->moduleID) }}" class="btn btn-success text-white px-md-5 px-3 shadow">
                                    {{ __('messages.courses.go_to_mcq') }} <i class="bi bi-check-all ms-2"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-start d-md-none" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title fw-bold" id="mobileSidebarLabel">Course Modules</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-0">
            {{-- We reuse your existing partial here --}}
            @include('partials.course-sidebar', ['course' => $course, 'current' => $current])
        </div>
    </div>

    {{-- ================= SCRIPTS ================= --}}
    <script>
        // 1. GLOBAL CONFIGURATION
        const CONFIG = {
            courseId: {{ $course->courseID ?? 0 }},
            allSections: @json($sections->pluck('sectionID') ?? []),
            labels: {
                confirmMsg: "{{ __('messages.courses.quiz_confirm') }}",
                timeLeft: "{{ __('messages.courses.time_left') }}",
                completed: "{{ __('messages.courses.completed') }}"
            },
            userId: {{ auth()->id() ?? 0 }},
            csrfToken: '{{ csrf_token() }}'
        };

        // 2. MOBILE SIDEBAR TOGGLE
        function toggleMobileMenu() {
            const sidebar = document.getElementById('mobileSidebar');
            const overlay = document.getElementById('mobileMenuOverlay');
            if (!sidebar || !overlay) return;

            const isHidden = sidebar.style.transform === 'translateX(-100%)' || sidebar.style.transform === '';
            sidebar.style.transform = isHidden ? 'translateX(0%)' : 'translateX(-100%)';
            overlay.classList.toggle('d-none', !isHidden);
        }

        // 3. QUIZ SUBMISSION LOGIC
        document.getElementById('quizForm')?.addEventListener('submit', function(e) {
            const questions = document.querySelectorAll('[name^="answers["]');
            const uniqueNames = new Set(Array.from(questions).map(q => q.name));
            const answeredCount = new Set(Array.from(questions).filter(q => q.checked).map(q => q.name)).size;
            
            const remaining = uniqueNames.size - answeredCount;

            if (remaining > 0) {
                let msg = CONFIG.labels.confirmMsg.replace(':count', remaining);
                if (!confirm(msg)) {
                    e.preventDefault();
                }
            }
        });

        // 4. LECTURE TIMER & AUTO-COMPLETE
        @if($current && $current->lecture && $current->lecture->lect_duration)
        (function() {
            const lectID = {{ $current->lectID }};
            const storageKey = `lecture_timer_${lectID}`;
            const timerDisplay = document.getElementById('timer');
            const totalSeconds = {{ $current->lecture->lect_duration }} * 60;
            
            let startTime = localStorage.getItem(storageKey) || Date.now();
            if (!localStorage.getItem(storageKey)) localStorage.setItem(storageKey, startTime);

            const updateTimer = () => {
                const elapsed = Math.floor((Date.now() - startTime) / 1000);
                const remaining = totalSeconds - elapsed;

                if (remaining <= 0) {
                    clearInterval(timerInterval);
                    timerDisplay.innerHTML = `${CONFIG.labels.completed} <i class="bi bi-check-circle-fill text-success"></i>`;
                    localStorage.removeItem(storageKey);
                    
                    // Mark as complete in DB
                    fetch(`/lecture/complete/${lectID}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': CONFIG.csrfToken
                        }
                    }).catch(err => console.error("Completion failed:", err));
                } else {
                    const mins = Math.floor(remaining / 60);
                    const secs = String(remaining % 60).padStart(2, '0');
                    timerDisplay.textContent = `${CONFIG.labels.timeLeft}: ${mins}:${secs}`;
                }
            };

            const timerInterval = setInterval(updateTimer, 1000);
            updateTimer(); // Run immediately
        })();
        @endif

        // 5. RESUME PROGRESS LOGIC
        (function() {
            const sectionKey = `last_section_${CONFIG.userId}_${CONFIG.courseId}`;
            @if($current)
                localStorage.setItem(sectionKey, "{{ $current->sectionID }}");
            @endif

            const urlParams = new URLSearchParams(window.location.search);
            if (!urlParams.get('sectionId')) {
                const savedSection = localStorage.getItem(sectionKey);
                if (savedSection) window.location.href = `?sectionId=${savedSection}`;
            }
        })();

        // 6. MODAL UTILITY
        document.addEventListener("DOMContentLoaded", function () {
            const modal = document.getElementById('accessModal');
            if (modal) {
                modal.style.display = 'flex';
                setTimeout(() => { modal.style.display = 'none'; }, 5000);
                
                document.getElementById('closeModal')?.addEventListener('click', () => modal.style.display = 'none');
                window.addEventListener('click', (e) => { if (e.target === modal) modal.style.display = 'none'; });
            }
        });
    </script>

    @push('scripts')
    <script>
        // 7. OFFLINE PRE-FETCHING (Service Worker Lite)
        if (navigator.onLine) {
            const CACHE_NAME = "bengoh-academy-cache-v2";
            const lessonUrls = CONFIG.allSections.map(sid => `/courses/${CONFIG.courseId}/startLearn?sectionId=${sid}`);

            caches.open(CACHE_NAME).then(cache => {
                lessonUrls.forEach(url => {
                    cache.match(url).then(exists => {
                        if (!exists) fetch(url).then(res => { if (res.ok) cache.put(url, res.clone()); });
                    });
                });
            });
        }
    </script>
    @endpush
@endsection