@extends('layouts.open_layout')

@section('styles')
    {{-- Reusing the same CSS from the learning page for consistency --}}
    <link rel="stylesheet" href="{{ asset('css/startLearning.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
@endsection

@section('content')
    <div class="container-fluid mt-3">
        <div class="row">
            {{-- Sidebar: Hidden on small screens, shown in a column on medium+ --}}
            <div class="col-md-3 d-none d-md-block" id="desktopSidebar">
                @include('partials.course-sidebar', ['course' => $course])
            </div>

            <div class="col-12 col-md-9 px-md-4">
                {{-- Mobile Menu Toggle & Breadcrumb --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <button class="btn btn-sm btn-outline-primary d-md-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebarReview">
                        <i class="bi bi-list"></i> {{ __('messages.courses.course_modules') }}
                    </button>
                    
                    <nav aria-label="breadcrumb" class="d-none d-sm-block">
                        <ol class="breadcrumb mb-0 small">
                            <li class="breadcrumb-item"><a href="{{ route('courses.allCourses') }}">{{ __('messages.courses.courses_breadcrumb') }}</a></li>
                            <li class="breadcrumb-item active text-truncate" style="max-width: 200px;">{{ $course->getTranslation('courseName') }}</li>
                        </ol>
                    </nav>
                </div>

                {{-- The main card wrapper (Matching first image) --}}
                <div class="learning-content-card p-4 shadow-sm bg-white rounded border-0">
                    
                    <h4 class="fw-bold mb-4">{{ __('messages.courses.review_answers') }}</h4>

                    {{-- Display Score --}}
                    @if(session('score') !== null)
                        <div class="alert alert-success shadow-sm border-0 bg-light-success">
                            <h5 class="fw-bold">Result: {{ session('score') }} / {{ session('total') }} Marks</h5>
                            <p class="mb-0 text-muted">Attempt: {{ session('attempts') }}/3</p>
                        </div>
                    @endif

                    <div class="step-content-wrapper mt-4">
                        @foreach($module->mcqs as $index => $question)
                            <div class="card p-3 mb-3 border shadow-sm">
                                <p class="fw-bold mb-2">{{ $index+1 }}. {{ $question->getTranslation('question') }}</p>
                                
                                @php
                                    $options = [
                                        0 => $question->getTranslation('answer1'),
                                        1 => $question->getTranslation('answer2'),
                                        2 => $question->getTranslation('answer3'),
                                        3 => $question->getTranslation('answer4'),
                                    ];
                                    $userSelection = session('last_submitted_answers')[$question->moduleQs_ID] ?? null;
                                    $correctIndex = (int)$question->correct_answer - 1; 
                                @endphp

                                @foreach($options as $key => $option)
                                    @if($option)
                                        @php
                                            $isCorrect = ($key === $correctIndex);
                                            $isSelected = ($userSelection !== null && (string)$userSelection === (string)$key);
                                        @endphp

                                        <div class="mt-2 p-3 rounded border" 
                                            style="background-color: {{ $isCorrect ? '#d4edda' : ($isSelected ? '#f8d7da' : 'white') }}; 
                                                   border-color: {{ $isCorrect ? '#c3e6cb' : ($isSelected ? '#f5c6cb' : '#dee2e6') }} !important;">
                                            
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span>
                                                    <strong>{{ chr(65 + $key) }}.</strong> {{ $option }}
                                                </span>

                                                @if($isCorrect)
                                                    <span class="badge bg-success text-white p-2">
                                                        <i class="bi bi-check-circle-fill"></i> Correct Answer
                                                    </span>
                                                @elseif($isSelected)
                                                    <span class="badge bg-danger text-white p-2">
                                                        <i class="bi bi-x-circle-fill"></i> Your Choice
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endforeach
                    </div>

                    {{-- Navigation Buttons (Matching first image style) --}}
                    <div class="d-flex justify-content-between align-items-center mt-5 pt-4 border-top">
                        <a href="{{ route('mcq.module', $module->moduleID) }}" class="btn btn-outline-secondary px-4">
                            <i class="bi bi-chevron-left"></i> {{ __('messages.courses.back_to_mcq') }}
                        </a>

                        @if($nextSectionID)
                            <a href="{{ route('learn', ['id' => $course->courseID, 'sectionId' => $nextSectionID]) }}" class="btn btn-primary px-4 shadow">
                                {{ __('messages.courses.continue_to_next_module') }} <i class="bi bi-chevron-right ms-2"></i>
                            </a>
                        @else
                            <a href="{{ route('course.feedback', $course->courseID) }}" class="btn btn-success text-white px-4 shadow">
                                {{ __('messages.courses.proceed_to_feedback') }} <i class="bi bi-check-all ms-2"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div> 
        </div> 
    </div>

    {{-- Mobile Offcanvas Sidebar --}}
    <div class="offcanvas offcanvas-start d-md-none" tabindex="-1" id="mobileSidebarReview" aria-labelledby="mobileSidebarLabel">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title fw-bold" id="mobileSidebarLabel">Course Modules</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-0">
            @include('partials.course-sidebar', ['course' => $course])
        </div>
    </div>
@endsection