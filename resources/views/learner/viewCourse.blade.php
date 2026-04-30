@extends('layouts.open_layout')

@section('title', $course->getTranslation('courseName') . ' - Bengoh Academy')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/viewCourse.css') }}">
    <style>
        .feedback-scroll { max-height: 400px; overflow-y: auto; }
        .star-rating { color: #ffc107; }
    </style>
@endsection

@section('content')
    {{-- alert message --}}
    @if(session('error'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="container mt-4">
        {{-- back to previous page --}}
        <div class="mb-3">
            <a href="{{ url()->previous() == url()->current() ? route('courses.allCourses') : url()->previous() }}" class="btn btn-outline-secondary btn-sm">
                <i class="fa fa-arrow-left me-1"></i> {{ __('Back to Courses') }}
            </a>
        </div>

        <div class="text-center mb-4 course-banner-container">
             <img src="{{ Storage::disk('r2')->url($course->courseImg) }}" alt="{{ $course->getTranslation('courseName') }}" class="course-banner-img rounded shadow-sm">
        </div>

        <div class="row mb-4 align-items-end">
            <div class="col-md-9">
                <h2 class="fw-bold">{{ $course->getTranslation('courseName') }}</h2>
                <p class="text-muted lead">{{ $course->getTranslation('courseDesc') }}</p>
            </div>
            <div class="col-md-3 text-md-end">
                <p class="mb-0 text-secondary"><i class="fa fa-user-edit me-1"></i> {{ $course->courseAuthor }}</p>
            </div>
        </div>

        <hr class="my-5">

        <div class="row">
            @foreach($course->modules as $index => $module)
            <div class="col-md-6 mb-4">
                <div class="card h-100 border-0 shadow-sm module-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title mb-0 fw-bold">{{ $module->getTranslation('moduleName') }}</h5>
                            <span class="badge bg-light text-dark border">M{{ __('messages.courses.module') }} {{ $index + 1 }}</span>
                        </div>

                        <ul class="list-group list-group-flush">
                            @foreach($module->lectures as $lecture)
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0 bg-transparent">
                                    <span><i class="fa-regular fa-circle-play me-2 text-primary"></i>{{ $lecture->getTranslation('lectName') }}</span>
                                    <span class="text-muted small">
                                        {{ $lecture->lect_duration }} {{ __('messages.courses.mins') }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-5 p-4 bg-white rounded shadow-sm">
            <h4 class="fw-bold mb-4">
                <i class="fa fa-comments me-2 text-primary"></i>{{ __('Learner Reviews') }}
            </h4>
            
            <div class="feedback-list" style="max-height: 500px; overflow-y: auto;">
                @forelse($feedbacks as $f)
                    <div class="card mb-3 border-0 border-bottom">
                        <div class="card-body px-0">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="fw-bold mb-0">{{ $f->userName }}</h6>
                                <div class="text-warning">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fa{{ $i <= $f->rating ? 's' : 'r' }} fa-star small"></i>
                                    @endfor
                                </div>
                            </div>
                            
                            <p class="mb-1 text-dark">"{{ $f->enjoyed }}"</p>
                            
                            @if($f->suggestions)
                                <p class="small text-muted mb-0">
                                    <strong>Suggestions:</strong> {{ $f->suggestions }}
                                </p>
                            @endif
                            
                            <div class="mt-2">
                                <span class="badge bg-light text-secondary border fw-normal">
                                    {{ __('Clarity') }}: {{ $f->clarity }}
                                </span>
                                <span class="badge bg-light text-secondary border fw-normal">
                                    {{ __('Module') }}: {{ $f->favorite_module }}
                                </span>
                            </div>
                            <small class="text-muted d-block mt-2">{{ \Carbon\Carbon::parse($f->created_at)->diffForHumans() }}</small>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4">
                        <p class="text-muted">{{ __('No reviews yet. Be the first to share your experience!') }}</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-5 mb-5 p-4 bg-light rounded shadow-sm">
            {{-- Review Link --}}
            <a href="{{ route('course.feedback', $course->courseID) }}" class="btn btn-outline-primary">
                <i class="fa fa-pen-to-square me-1"></i> {{ __('messages.courses.view_feedback') }}
            </a>
            
            {{-- Conditional Enrolment Logic --}}
            @if($hasModules)
                <a href="{{ route('learn', $course->courseID) }}" class="btn btn-primary btn-lg px-5 shadow">
                    {{ __('messages.courses.enrol_now') }}
                </a>
            @else
                <button type="button" class="btn btn-secondary btn-lg px-5" disabled>
                    <i class="fa fa-info-circle me-1"></i> {{ __('Enrollment Unavailable') }}
                </button>
            @endif
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/viewCourse.js') }}"></script>
@endsection