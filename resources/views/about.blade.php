@extends('layouts.open_layout')

@section('content')
    <div class="container mt-5">
        <div class="mb-4">
            <a href="{{ url('/') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left me-2"></i> {{ __('messages.nav.home') }}
            </a>
        </div>
        <!-- title -->
        <div class="text-center mb-5">
            <h1 class="fw-bold">{{ __('messages.about.title') }}</h1>
            <p class="text-muted">{{ __('messages.about.subtitle') }}</p>
        </div>
        <!-- mission -->
        <div class="mb-5" data-aos="fade-up">
            <h3>{{ __('messages.about.mission_title') }}</h3>
            <p>{{ __('messages.about.mission_desc') }}</p>
        </div>
        <!-- offer -->
        <div class="mb-5" data-aos="fade-right">
            <h3 class="mb-4">{{ __('messages.about.offer_title') }}</h3>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm offer-card">
                        <div class="card-body text-center">
                            <i class="fas fa-book fa-2x text-primary mb-3"></i>
                            <h5>{{ __('messages.about.offer_courses') }}</h5>
                            <p>{{ __('messages.about.offer_courses_desc') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm offer-card">
                        <div class="card-body text-center">
                            <i class="fas fa-video fa-2x text-danger mb-3"></i>
                            <h5>{{ __('messages.about.offer_video') }}</h5>
                            <p>{{ __('messages.about.offer_video_desc') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm offer-card">
                        <div class="card-body text-center">
                            <i class="fas fa-users fa-2x text-success mb-3"></i>
                            <h5>{{ __('messages.about.offer_community') }}</h5>
                            <p>{{ __('messages.about.offer_comm_desc') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm offer-card">
                        <div class="card-body text-center">
                            <i class="fas fa-chart-line fa-2x text-warning mb-3"></i>
                            <h5>{{ __('messages.about.offer_tracking') }}</h5>
                            <p>{{ __('messages.about.offer_track_desc') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm offer-card">
                        <div class="card-body text-center">
                            <i class="fas fa-globe fa-2x text-info mb-3"></i>
                            <h5>{{ __('messages.about.offer_access') }}</h5>
                            <p>{{ __('messages.about.offer_access_desc') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- desc system -->
        <div class="mb-5">
            <h3>{{ __('messages.about.system_title') }}</h3>
            <p>{{ __('messages.about.system_intro') }}</p>
            <ul>
                <li><strong>{{ __('messages.about.system_clarity') }}</strong> {{ __('messages.about.clarity_d') }}</li>
                <li><strong>{{ __('messages.about.system_engage') }}</strong> {{ __('messages.about.engage_d') }}</li>
                <li><strong>{{ __('messages.about.system_practical') }}</strong> {{ __('messages.about.system_practical_d') }}</li>
                <li><strong>{{ __('messages.about.system_flex') }}</strong> {{ __('messages.about.system_flex_d') }}</li>
            </ul>
        </div>
        <!-- vision -->
        <div class="mb-5">
            <h3>{{ __('messages.about.vision_title') }}</h3>
            <p>{{ __('messages.about.vision_desc') }}</p>
        </div>
        <!-- call to action -->
        <div class="text-center mt-5">
            <h4>{{ __('messages.about.cta_title') }}</h4>
            <p>{{ __('messages.about.cta_tagline') }}</p>
        </div>

    </div>
@endsection