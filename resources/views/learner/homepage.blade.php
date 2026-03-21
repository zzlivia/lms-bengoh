@extends('layouts.learner')

@section('content')

{{-- intro image --}}
<div class="mb-4">
    <img src="{{ asset('images/homepage.png') }}" class="hero-img shadow-sm">
</div>

{{-- feature boxes --}}
<div class="row text-center mb-5 g-3">
    <div class="col-md-4">
        <div class="feature-box">
            <i class="fa-solid fa-handshake fs-3 mb-2"></i>
            <h6>Built for Bengoh</h6> 
            <small>Courses designed to foster community-owned enterprises</small>
        </div>
    </div>

    <div class="col-md-4">
        <div class="feature-box">
            <i class="fa-solid fa-graduation-cap fs-3 mb-2"></i>
            <h6>Eco-centric Learning</h6>
            <small>Training in eco-tourism</small>
        </div>
    </div>

    <div class="col-md-4">
        <div class="feature-box">
            <i class="fa-solid fa-gear fs-3 mb-2"></i>
            <h6>Ready Skills</h6>
            <small>Get hands-on skills</small>
        </div>
    </div>
</div>

{{-- featured courses - fetch top 4 courses from database --}}
<h5 class="mb-3 fw-bold">Featured Courses</h5>

<div class="row">
@foreach(\App\Models\Course::where('isAvailable', 1)->take(4)->get() as $course)

<div class="col-md-3 mb-3">
    <div class="course-card">
        <img src="{{ asset('storage/' . $course->courseImg) }}" alt="{{ $course->courseName }}">
        <h6 class="mt-2 fw-bold">{{ $course->courseName }}</h6>
    </div>
</div>

@endforeach
</div>

{{-- button --}}
<div class="text-center mb-5">
    <a href="{{ route('courses.index') }}" class="btn btn-outline-secondary btn-sm">
        View All Courses
    </a>
</div>

{{-- community stories section --}}
<h5 class="text-center mb-4 fw-bold">Community Story</h5>
<div class="row mb-3 justify-content-center">
    <div class="col-md-5 mb-3">
        <div class="story-card d-flex align-items-center">
            <i class="fa-solid fa-user-tie profile-icon me-3"></i>
            <div>
                <h6 class="fw-bold mb-1">Atta Anak Peter</h6>
                <p class="small mb-0">"Thanks to Bengoh Academy, I launched a homestay."</p>
            </div>
        </div>
    </div>
    <div class="col-md-5 mb-3">
        <div class="story-card d-flex align-items-center">
            <i class="fa-solid fa-user-tie profile-icon me-3"></i>
            <div>
                <h6 class="fw-bold mb-1">Oscar Anak Isah</h6>
                <p class="small mb-0">"Thanks to Bengoh Academy, I learned a lot on customer service and communication skills."</p>
            </div>
        </div>
    </div>
</div>
{{-- link to community stories section --}}
<div class="text-center mb-5">
    <a href="{{ route('community.stories') }}" class="text-primary small text-decoration-underline">Read More Community Stories</a>
</div>

{{-- histories of the Bengoh Dam --}}
<h5 class="mb-3 fw-bold">The Bengoh Dam Histories</h5>
<div class="row g-3">
    <div class="col-md-4">
        <div class="history-card">
            <h6 class="small fw-bold">Function & Usage</h6>
            <div style="height:150px;"></div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="history-card">
            <h6 class="small fw-bold">Impact on the Community</h6>
            <div style="height:150px;"></div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="history-card">
            <h6 class="small fw-bold">Nature Tourism Attraction</h6>
            <div style="height:150px;"></div>
        </div>
    </div>
</div>

@endsection