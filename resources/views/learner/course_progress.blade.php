@extends('layouts.open_layout')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/course_progress.css') }}">
    {{-- Using the same stylesheet as startLearning for visual consistency --}}
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
                    <button class="btn btn-sm btn-outline-primary d-md-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
                        <i class="bi bi-list"></i> {{ __('messages.courses.course_modules') }}
                    </button>
                    
                    <nav aria-label="breadcrumb" class="d-none d-sm-block">
                        <ol class="breadcrumb mb-0 small">
                            <li class="breadcrumb-item"><a href="{{ route('courses.allCourses') }}">{{ __('messages.courses.courses_breadcrumb') }}</a></li>
                            <li class="breadcrumb-item active text-truncate" style="max-width: 200px;">{{ $course->getTranslation('courseName') }}</li>
                            <li class="breadcrumb-item active">{{ __('messages.courses.view_progress') }}</li>
                        </ol>
                    </nav>
                </div>

                {{-- Main White Card Content --}}
                <div class="learning-content-card p-4 shadow-sm bg-white rounded border-0">
                    
                    @if(session('assessment_completed'))
                        <div class="alert alert-success text-center shadow-sm mb-4">
                            {{ __('messages.courses.congrats_msg') }}<br>
                            {{ __('messages.courses.action_prompt') }}
                            <br><br>
                            <a href="{{ route('courses.index') }}" class="btn btn-primary btn-sm">
                                {{ __('messages.courses.choose_another') }}
                            </a>
                            <a href="{{ route('course.progress', $course->courseID) }}" class="btn btn-success btn-sm">
                                {{ __('messages.courses.view_progress') }}
                            </a>
                        </div>
                    @endif

                    {{-- Performance Header Section --}}
                    <div class="row align-items-center mb-4">
                        <div class="col-md-8">
                            <h4 class="fw-bold mb-2">{{ __('messages.courses.your_progress') }}</h4>
                            <p class="fw-bold mb-1">{{ __('messages.courses.course_completion') }}</p>
                            <p class="text-muted small">
                                {{ __('messages.courses.completion_desc') }}
                            </p>
                        </div>
                        {{-- Progress circle --}}
                        <div class="col-md-4 text-center">
                            <div class="progress-circle mx-auto"
                                style="background: conic-gradient(#4caf50 {{ $totalProgress }}%, #e0e0e0 {{ $totalProgress }}%);">
                                <span>{{ $totalProgress ?? 0 }}%</span>
                                <small class="d-block text-muted">{{ __('messages.courses.completed_small') }}</small>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    {{-- Completion Certificate Alert --}}
                    @if($isCompletedAll)
                        <div class="alert alert-success text-center shadow-sm border-0 mb-4" style="background-color: #e8f5e9;">
                            <h4 class="fw-bold">🎉 {{ __('messages.courses.congrats_title') }}</h4>
                            <p class="mb-1">{{ __('messages.courses.success_msg') }}</p>
                            <p class="mb-0">{{ __('messages.courses.name_label') }}: <strong>{{ auth()->user()->userName }}</strong></p>
                            <a href="{{ route('course.certificate', $course->courseID) }}" class="btn btn-success mt-3 shadow-sm">
                                <i class="bi bi-patch-check"></i> {{ __('messages.courses.download_cert') }}
                            </a>
                        </div>
                    @endif

                    {{-- Grades Section --}}
                    <div class="grades-section">
                        <h5 class="fw-bold mb-3"><i class="bi bi-trophy me-2 text-primary"></i>{{ __('messages.courses.your_grades') }}</h5>
                        <div class="table-responsive rounded border">
                            <table class="table mb-0 text-center align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-start ps-4">{{ __('messages.courses.task') }}</th>
                                        <th>{{ __('messages.courses.passing_grade') }}</th>
                                        <th>{{ __('messages.courses.current_grade') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($grades as $grade)
                                        <tr>
                                            <td class="text-start ps-4">{{ $grade['name'] }}</td>
                                            <td class="text-muted">80%</td>
                                            <td class="fw-bold {{ $grade['score'] >= 80 ? 'text-success' : 'text-danger' }}">
                                                {{ $grade['score'] }}%
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr class="table-light fw-bold">
                                        <td class="text-start ps-4">{{ __('messages.courses.total_grade') }}</td>
                                        <td></td>
                                        <td class="text-primary fs-5">{{ $totalProgress ?? 0 }}%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> {{-- End learning-content-card --}}
            </div> {{-- End col-md-9 --}}
        </div> {{-- End row --}}
    </div> {{-- End container-fluid --}}

    {{-- Mobile Offcanvas Sidebar --}}
    <div class="offcanvas offcanvas-start d-md-none" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title fw-bold" id="mobileSidebarLabel">Course Modules</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-0">
            @include('partials.course-sidebar', ['course' => $course])
        </div>
    </div>
@endsection