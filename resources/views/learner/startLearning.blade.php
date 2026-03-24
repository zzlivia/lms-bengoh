@extends('layouts.open_layout')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/startLearning.css') }}">
@endsection

@section('content')
    <div class="container-fluid mt-3">
        <div class="row">
            @include('partials.course-sidebar')

            <div class="col-md-9 px-md-4">
                <div class="learning-content-card p-4 shadow-sm bg-white rounded">

                    {{-- Breadcrumb --}}
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb small">
                            <li class="breadcrumb-item">
                                @if(app()->environment('local'))
                                    <a href="/index.php/courses">Courses</a>
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
                    @if($current)

                        <div class="section-header mb-3">
                            <h5 class="text-primary fw-bold">{{ $current->section_title }}</h5>
                        </div>

                        {{-- VIDEO --}}
                        @if($current->section_type == 'video')
                            <div class="video-container mb-4">
                                <div class="ratio ratio-16x9 bg-dark d-flex align-items-center justify-content-center rounded">
                                    <span class="text-white">
                                        <i class="fa fa-play-circle fa-3x"></i>
                                    </span>
                                </div>
                            </div>
                        @endif

                        {{-- TEXT --}}
                        @if($current->section_type == 'text')
                            <div class="text-content mb-4 lead-custom">
                                {!! nl2br(e($current->section_content)) !!}
                            </div>
                        @endif

                        {{-- PDF --}}
                        @if($current->section_type == 'pdf')
                            <div class="pdf-container mb-4">
                                <iframe src="{{ asset('learning-materials/' . $current->section_file) }}#toolbar=0"
                                        width="100%"
                                        height="600px"
                                        class="rounded border">
                                </iframe>
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

                    <div class="d-flex justify-content-between align-items-center mt-5 pt-3 border-top">

                        {{-- PREVIOUS --}}
                        @if($prev)
                            <a href="{{ route('learn', ['id' => $course->courseID, 'sectionID' => $prev->sectionID]) }}"
                            class="btn btn-outline-secondary px-4">
                                <i class="fa fa-chevron-left me-2"></i> Previous
                            </a>
                        @else
                            <button class="btn btn-outline-secondary px-4" disabled>
                                <i class="fa fa-chevron-left me-2"></i> Previous
                            </button>
                        @endif


                        {{-- ===== MARK LECTURE COMPLETE ===== 
                        @if($current)
                            @php
                                $completed = \App\Models\LectureProgress::where('userID', Auth::id())
                                    ->where('lectID', $current->lectID)
                                    ->exists();
                            @endphp

                            <div>
                                @if(!$completed)
                                    <form action="{{ route('lecture.complete', $current->lectID) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success">
                                            Mark Lecture as Completed
                                        </button>
                                    </form>
                                @else
                                    <button class="btn btn-success" disabled>
                                        ✅ Completed
                                    </button>
                                @endif
                            </div>
                        @endif--}}


                        {{-- NEXT --}}
                        @if(!$isLast)
                            {{-- <a href="{{ route('learn', ['id' => $course->courseID, 'sectionID' => $next->sectionID]) }}"
                            class="btn btn-primary px-4">
                                Next <i class="fa fa-chevron-right ms-2"></i>
                            </a>--}}
                            <a href="{{ route('learn', ['id' => $course->courseID, 'sectionID' => $next->sectionID]) }}"
                            class="btn btn-primary px-4">
                                Next <i class="fa fa-chevron-right ms-2"></i>
                            </a>
                        @else
                            <a href="{{ route('mcq.module', $module->moduleID ?? 1) }}"
                            class="btn btn-success px-4">
                                Go to MCQ <i class="fa fa-arrow-right ms-2"></i>
                            </a>
                        @endif

                    </div>

                </div>
            </div>
        </div>
    </div>


    {{-- ================= SCRIPT ================= --}}
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

@endsection