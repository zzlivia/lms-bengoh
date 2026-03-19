@extends('layouts.open_layout')

@section('title', $course->courseName . ' - Bengoh Academy')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/viewCourse.css') }}">
@endpush

@section('content')
<div class="container mt-4">
    <div class="text-center mb-4">
        {{-- path to point to public/images/ --}}
         <img src="{{ asset('images/' . $course->courseImg) }}" alt="{{ $course->courseName }}" class="course-banner-img">
    </div>

    <div class="row mb-4">
        <div class="col-md-9">
            <h4>{{ $course->courseName }}</h4>
            <p class="text-muted"> {{ $course->courseDesc }} </p>
        </div>
        <div class="col-md-3 text-end">
            <small class="text-muted"> Author: {{ $course->courseAuthor }} </small>
        </div>
    </div>

    <div class="row">
        @foreach($course->modules as $index => $module)
        <div class="col-md-6 mb-4">
            <div class="card p-3 shadow-sm h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0">{{ $module->moduleName }}</h6>
                    <strong class="module-number">0{{ $index + 1 }}</strong>
                </div>

                <ul class="list-unstyled mb-0">
                    @foreach($module->lectures as $lecture)
                        <li class="d-flex justify-content-between align-items-center mb-2">
                            <span>{{ $lecture->lectName }}</span>
                            <span class="text-muted small">
                                @php
                                    $duration = null;
                                    foreach($lecture->materials as $material) {
                                        if ($material->video) {
                                            $duration = $material->video->videoLearningDuration;
                                            break; //stop loop once found
                                        }
                                    }
                                @endphp
                                @if($duration)
                                    ⏱ {{ $duration }} mins
                                @endif
                            </span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-between mt-4 mb-5">
        {{-- {{ route('course.feedback', $course->courseID) }} --}}
        <a href="#" class="btn btn-outline-secondary">View Course Feedback</a>
        {{-- {{ route('courses.learn', $course->courseID) }} --}}
        <a href="#" class="btn btn-outline-dark btn-action px-4">Enrol</a> 
    </div>
</div>
@endsection