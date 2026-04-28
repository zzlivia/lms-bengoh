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
            <a href="{{ url()->previous() == url()->current() ? route('courses.index') : url()->previous() }}" class="btn btn-outline-secondary btn-sm">
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

        {{-- NEW: Public Feedback Section --}}
        <div class="mt-5">
            <h4 class="fw-bold mb-4"><i class="fa fa-star me-2 text-warning"></i>{{ __('Learner Reviews') }}</h4>
            <div class="feedback-scroll pe-2">
                @forelse($feedbacks as $feedback)
                    <div class="card mb-3 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <span class="star-rating">
                                        @for($i=1; $i<=5; $i++)
                                            <i class="fa{{ $i <= $feedback->rating ? 's' : 'r' }} fa-star"></i>
                                        @endfor
                                    </span>
                                    <span class="ms-2 text-muted small">| {{ $feedback->created_at }}</span>
                                </div>
                                <span class="badge badge-outline-info text-info small">Fav: {{ $feedback->favorite_module }}</span>
                            </div>
                            <p class="mt-2 mb-1"><strong>"{{ $feedback->enjoyed }}"</strong></p>
                            @if($feedback->suggestions)
                                <p class="text-muted small mb-0"><em>Suggestion: {{ $feedback->suggestions }}</em></p>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-muted">No reviews yet. Be the first to provide feedback!</p>
                @endforelse
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-5 mb-5 p-4 bg-light rounded shadow-sm">
            {{-- Keep this link if you still want a separate page, or change it to "Give Feedback" --}}
            <a href="{{ route('course.feedback', $course->courseID) }}" class="btn btn-outline-primary"> 
                <i class="fa fa-pen-nib me-1"></i> {{ __('Write a Review') }}
            </a>
            <a href="{{ route('learn', $course->courseID) }}" class="btn btn-primary btn-lg px-5 shadow"> 
                {{ __('messages.courses.enrol_now') }}
            </a>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/viewCourse.js') }}"></script>
@endsection