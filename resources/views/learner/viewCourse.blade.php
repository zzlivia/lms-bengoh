@extends('layouts.open_layout')

@section('title', $course->courseName . ' - Bengoh Academy')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/viewCourse.css') }}">
@endsection

@section('content')
    {{-- alert message when a module has no content, it will redirect user back--}}
    @if(session('error'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    <div class="container mt-4">
        <div class="text-center mb-4">
            {{-- path to point to public/courses/ --}}
            <img src="{{ asset($course->courseImg) }}"alt="{{ $course->courseName }}"class="course-banner-img img-fluid rounded shadow-sm"> 
        </div>

        <div class="row mb-4 align-items-end">
            <div class="col-md-9">
                <h2 class="fw-bold">{{ $course->courseName }}</h2>
                <p class="text-muted lead">{{ $course->courseDesc }}</p>
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
                            <h5 class="card-title mb-0 fw-bold">{{ $module->moduleName }}</h5>
                            <span class="badge bg-light text-dark border">Module {{ $index + 1 }}</span>
                        </div>

                        <ul class="list-group list-group-flush">
                            @foreach($module->lectures as $lecture)
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0 bg-transparent">
                                    <span><i class="fa-regular fa-circle-play me-2 text-primary"></i>{{ $lecture->lectName }}</span>
                                    <span class="text-muted small">
                                        {{ $lecture->lect_duration }} mins
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-between align-items-center mt-5 mb-5 p-4 bg-light rounded">
            <a href="{{ route('course.feedback', $course->courseID) }}" class="btn btn-link text-decoration-none"> {{--{{ route('course.feedback', $course->courseID) }}--}}
                <i class="fa fa-comment-dots me-1"></i> View Course Feedback
            </a>
            <a href="{{ route('learn', $course->courseID) }}" class="btn btn-primary btn-lg px-5 shadow"> {{--{{ route('courses.learn', $course->courseID) }}--}}
                Enrol Now
            </a>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/viewCourse.js') }}"></script>
@endsection