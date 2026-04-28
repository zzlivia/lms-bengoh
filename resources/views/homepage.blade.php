@extends('layouts.open_layout')

@section('content')
    {{-- intro image --}}
    <div class="mb-4">
        <img src="{{ asset('images/homepage.png') }}" class="hero-img shadow-sm"> {{--  --}}
    </div>

    {{-- feature boxes --}}
    <div class="row mb-5 g-3">
        <div class="col-md-4">
            <div class="feature-box d-flex align-items-center align-items-md-center flex-row flex-md-column text-start text-md-center">
                <div class="feature-icon-wrapper me-3 me-md-0 mb-0 mb-md-2">
                    <i class="fa-solid fa-handshake fs-3"></i>
                </div>
                <div>
                    <h6 class="mb-1">{{ __('messages.home.feature_1_title') }}</h6>
                    <p class="small mb-0">{{ __('messages.home.feature_1_desc') }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="feature-box d-flex align-items-center align-items-md-center flex-row flex-md-column text-start text-md-center">
                <div class="feature-icon-wrapper me-3 me-md-0 mb-0 mb-md-2">
                    <i class="fa-solid fa-graduation-cap fs-3"></i>
                </div>
                <div>
                    <h6 class="mb-1">{{ __('messages.home.feature_2_title') }}</h6>
                    <p class="small mb-0">{{ __('messages.home.feature_2_desc') }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="feature-box d-flex align-items-center align-items-md-center flex-row flex-md-column text-start text-md-center">
                <div class="feature-icon-wrapper me-3 me-md-0 mb-0 mb-md-2">
                    <i class="fa-solid fa-gear fs-3"></i>
                </div>
                <div>
                    <h6 class="mb-1">{{ __('messages.home.feature_3_title') }}</h6>
                    <p class="small mb-0">{{ __('messages.home.feature_3_desc') }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- featured courses - fetch top 4 courses from database --}}
    <h5 class="mb-3 fw-bold">{{ __('messages.nav.featured_courses') }}</h5>

    {{-- featured courses --}}
    <div class="row">
        @forelse(\App\Models\Course::where('isAvailable', 1)->take(4)->get() as $course)
            <div class="col-md-3 mb-3">
                <div class="course-card">
                   <img src="{{ Storage::disk('r2')->url($course->courseImg) }}" alt="{{ $course->courseName }}" class="img-fluid">
                    <h6 class="mt-2 fw-bold">{{ $course->getTranslation('courseName') }}</h6>
                </div>
            </div>

        @empty
            <div class="col-12 text-center">
                <p class="text-muted">{{ __('messages.home.no_courses') }}</p>
            </div>
        @endforelse
    </div>

    {{-- button --}}
    <div class="text-center mb-5">
        <a href="{{ route('courses.allCourses') }}" class="btn btn-primary btn-lg">{{ __('messages.home.view_all_courses') }}</a>
    </div>

    {{-- community stories section --}}
    <h5 class="text-center mb-4 fw-bold">{{ __('messages.home.community_title') }}</h5>
    <div class="row mb-3 justify-content-center">
        @forelse($stories->take(2) as $story)
            <div class="col-md-6 mb-3"> {{-- Changed to col-6 for better desktop width --}}
                <div class="story-card p-3">
                    {{-- Header with Image and Name --}}
                    <div class="d-flex align-items-center mb-2">
                        @if($story->community_image)
                            <img src="{{ Storage::disk('r2')->url($story->community_image) }}" 
                                class="rounded-circle me-3 shadow-sm" 
                                width="50" 
                                height="50" 
                                style="object-fit: cover;"
                                alt="{{ $story->getTranslation('community_name') }}">
                        @else
                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                <i class="fa-solid fa-user text-secondary"></i>
                            </div>
                        @endif
                        <div>
                            <h6 class="fw-bold mb-0">{{ $story->getTranslation('community_name') }}</h6>
                            <small class="text-muted">Community Story</small>
                        </div>
                    </div>

                    {{-- The Story Excerpt --}}
                    <div class="story-content">
                        <p class="story-text mb-0">
                            "{{ $story->getTranslation('community_story') }}"
                        </p>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center"><p class="text-muted">{{ __('messages.home.no_stories') }}</p></div>
        @endforelse
    </div>

    {{-- link to community stories section --}}
    <div class="text-center mb-5">
        <a href="{{ route('community.stories') }}" class="text-primary small text-decoration-underline">
            {{ __('messages.home.read_more') }}
        </a>
    </div>

    {{-- histories of the Bengoh Dam --}}
    <h5 class="mb-3 fw-bold">{{ __('messages.home.history_title') }}</h5>
    <div class="row g-3">
        <div class="col-md-4">
            <div class="history-card p-3 h-100">
                <h6 class="small fw-bold">{{ __('messages.home.history_1_title') }}</h6>
                <p class="small text-muted mb-0">{{ __('messages.home.history_1_desc') }}</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="history-card p-3 h-100">
                <h6 class="small fw-bold">{{ __('messages.home.history_2_title') }}</h6>
                <p class="small text-muted mb-0">{{ __('messages.home.history_2_desc') }}</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="history-card p-3 h-100">
                <h6 class="small fw-bold">{{ __('messages.home.history_3_title') }}</h6>
                <p class="small text-muted mb-0">{{ __('messages.home.history_3_desc') }}</p>
            </div>
        </div>
    </div>
@endsection