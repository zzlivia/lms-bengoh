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
                                @if(app()->environment('local'))
                                    <a href="{{ route('courses.allCourses') }}">Courses</a>
                                @else
                                    <a href="{{ route('courses.allCourses') }}">Courses</a>
                                @endif
                            </li>
                            <li class="breadcrumb-item active">
                                {{ $course->courseName }}
                            </li>
                        </ol>
                    </nav>

                    <h3 class="fw-bold mb-4">{{ $course->courseTitle }}</h3>
                    {{-- ================= CONTENT ================= --}}
                    @if($current) {{-- current selected lecture --}}
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="text-primary fw-bold">{{ $current->section_title }}</h5>
                            <div id="timer" class="fw-bold text-danger"></div>
                        </div>
                        @if($current->section_type == 'video' && $current->section_file)
                            <div class="video-container mb-4">
                                <div class="ratio ratio-16x9">
                                    <video controls class="w-100 h-100 rounded">
                                        <source src="{{ asset('storage/' . $current->section_file) }}" type="video/mp4">Your browser does not support the video tag.
                                    </video>
                                </div>
                            </div>
                        @endif
                        @if($current->section_type == 'text') {{-- text lecture content --}}
                            <div class="text-content mb-4 lead-custom">
                                {!! nl2br(e($current->section_content)) !!}
                            </div>
                        @endif
                        @if($current->section_type == 'pdf') {{-- PDF frame --}}
                            <div class="pdf-container mb-4">
                                <iframe src="{{ asset('storage/' . $current->section_file) }}#toolbar=0" width="100%" height="600px" class="rounded border"></iframe>
                            </div>
                        @endif
                    {{-- ================= MCQ ================= --}}
                    @elseif($module && $module->mcqs->count())
                        <h5 class="fw-bold mb-3">Module Quiz: {{ $module->moduleName }}</h5>
                        <form id="quizForm" method="POST" action="{{ route('module.questions.submit', $module->moduleID) }}">
                            @csrf
                            @foreach($module->mcqs as $question)
                                <div class="mb-4">
                                    <strong>{{ $question->moduleQs }}</strong>
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
                            <button class="btn btn-primary">Submit Quiz</button>
                        </form>
                    {{-- ================= EMPTY ================= --}}
                    @else
                        <div class="alert alert-info">
                            Please select a module or lecture from the sidebar.
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
                                <a href="{{ route('learn', ['id' => $course->courseID, 'sectionId' => $prev->sectionID]) }}" class="btn btn-outline-secondary">← Previous</a>
                            @endif
                        </div>
                        <div>
                            @if(!$isLast)
                                <a href="{{ route('learn', ['id' => $course->courseID, 'sectionId' => $next->sectionID]) }}" class="btn btn-primary">Next →</a>
                            @else
                                <a href="{{ route('mcq.module', $module->moduleID ?? 1) }}" class="btn btn-success text-white">Go to MCQ →</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ================= SCRIPTS ================= --}}
    
    {{-- pass all section IDs --}}
    <script>
        const courseId = {{ $course->courseID }};
        const allSections = @json($sections->pluck('sectionID'));
    </script>

    <script>
    document.getElementById('quizForm')?.addEventListener('submit', function(e) {
        const questions = document.querySelectorAll('[name^="answers["]');
        const answered = new Set();

        questions.forEach(input => {
            if (input.checked) {
                answered.add(input.name);
            }
        });

        const totalQuestions = new Set(Array.from(questions).map(q => q.name)).size;
        const answeredCount = answered.size;

        if (answeredCount < totalQuestions) {
            e.preventDefault();
            const remaining = totalQuestions - answeredCount;

            if (confirm(`You forgot ${remaining} question(s). Submit anyway?`)) {
                e.target.submit();
            }
        }
    });
    </script>

    {{-- pop up alert modal --}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const modal = document.getElementById('accessModal');
            const closeBtn = document.getElementById('closeModal');

            if (modal) {
                modal.style.display = 'flex';

                // auto close after 5s
                setTimeout(() => {
                    modal.style.display = 'none';
                }, 5000);

                // close button
                closeBtn?.addEventListener('click', () => {
                    modal.style.display = 'none';
                });

                // click outside
                modal.addEventListener('click', (e) => {
                    if (e.target === modal) {
                        modal.style.display = 'none';
                    }
                });
            }
        });
    </script>

    <script>
        @if($current && $current->lecture && $current->lecture->lect_duration)

            const lectureId = {{ $current->lectID }};
            const storageKey = "lecture_timer_" + lectureId;
            let duration;
            //check if timer already exists
            const savedStartTime = localStorage.getItem(storageKey);
            const totalDuration = {{ $current->lecture->lect_duration }} * 60;

            let startTime;

            if (savedStartTime) {
                startTime = parseInt(savedStartTime);
            } else {
                startTime = Date.now();
                localStorage.setItem(storageKey, startTime);
            }

            const timerDisplay = document.getElementById('timer');

            const countdown = setInterval(() => { //countdown function
                const now = Date.now();
                const elapsed = Math.floor((now - startTime) / 1000);
                const remaining = totalDuration - elapsed;

                if (remaining <= 0) {
                    clearInterval(countdown);
                    timerDisplay.textContent = "Completed ✅";
                    localStorage.removeItem(storageKey);

                    // send to backend
                    fetch(`/lecture/complete/{{ $current->lectID }}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });
                    return;
                }

                let minutes = Math.floor(remaining / 60);
                let seconds = remaining % 60;
                seconds = seconds < 10 ? '0' + seconds : seconds;

                timerDisplay.textContent = `Time Left: ${minutes}:${seconds}`;
            }, 1000);
        @endif
    </script>

    <script>
        const sectionKey = "last_section_{{ auth()->id() }}_{{ $course->courseID }}";
        @if($current)
            // save current section
            localStorage.setItem(sectionKey, "{{ $current->sectionID }}");
        @endif
        // resume automatically once user returns
        const savedSection = localStorage.getItem(sectionKey);
        const urlParams = new URLSearchParams(window.location.search);
        const currentSectionId = urlParams.get('sectionId');
        if (!currentSectionId && savedSection) {
            window.location.href = `?sectionId=${savedSection}`;
        }
    </script>

    {{-- preload --}}
    @push('scripts')
    <script>
    document.addEventListener("DOMContentLoaded", function () {

        if (!navigator.onLine) return;

        const CACHE_NAME = "laravel-dynamic-v2";

        // build all lesson URLs dynamically
        const lessonUrls = allSections.map(sectionId =>
            `/courses/${courseId}/startLearn?sectionId=${sectionId}`
        );

        caches.open(CACHE_NAME).then(cache => {

            lessonUrls.forEach(url => {

                // avoid duplicate caching
                cache.match(url).then(existing => {
                    if (existing) return;

                    fetch(url)
                        .then(res => {
                            if (res.ok) {
                                cache.put(url, res.clone());
                                console.log("Cached:", url);
                            }
                        })
                        .catch(() => {});
                });

            });

        });

    });
    </script>
    @endpush
@endsection