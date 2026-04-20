@extends('layouts.open_layout')

@section('content')

<div class="container mt-5">

    <!-- Page Title -->
    <div class="text-center mb-5">
        <h1 class="fw-bold">About Bengoh Academy</h1>
        <p class="text-muted">Empowering learners everywhere</p>
    </div>

    <!-- Mission -->
    <div class="mb-5" data-aos="fade-up">
        <h3>Our Mission</h3>
        <p>
            Bengoh Academy aims to provide accessible, high-quality education for everyone.
            We believe learning should be flexible, practical, and available to all,
            regardless of location or background.
        </p>
    </div>

    <!-- What We Offer -->
    <div class="mb-5" data-aos="fade-right">
        <h3 class="mb-4">What We Offer</h3>

        <div class="row g-4">

            <div class="col-md-4">
                <div class="card h-100 shadow-sm offer-card">
                    <div class="card-body text-center">
                        <i class="fas fa-book fa-2x text-primary mb-3"></i>
                        <h5>Courses</h5>
                        <p>Structured online courses</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 shadow-sm offer-card">
                    <div class="card-body text-center">
                        <i class="fas fa-video fa-2x text-danger mb-3"></i>
                        <h5>Video Learning</h5>
                        <p>Engaging video content</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 shadow-sm offer-card">
                    <div class="card-body text-center">
                        <i class="fas fa-users fa-2x text-success mb-3"></i>
                        <h5>Community</h5>
                        <p>Discussion & collaboration</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 shadow-sm offer-card">
                    <div class="card-body text-center">
                        <i class="fas fa-chart-line fa-2x text-warning mb-3"></i>
                        <h5>Progress Tracking</h5>
                        <p>Monitor your learning journey</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 shadow-sm offer-card">
                    <div class="card-body text-center">
                        <i class="fas fa-globe fa-2x text-info mb-3"></i>
                        <h5>Anywhere Access</h5>
                        <p>Learn anytime, anywhere</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Learning System -->
    <div class="mb-5">
        <h3>Our Learning System</h3>
        <p>
            Our platform is designed with learners in mind:
        </p>
        <ul>
            <li><strong>Clarity:</strong> Simple and structured lessons</li>
            <li><strong>Engagement:</strong> Interactive learning experience</li>
            <li><strong>Practicality:</strong> Real-world applications</li>
            <li><strong>Flexibility:</strong> Learn at your own pace</li>
        </ul>
    </div>

    <!-- Vision -->
    <div class="mb-5">
        <h3>Our Vision</h3>
        <p>
            We envision a future where education is inclusive, digital, and empowering,
            helping individuals unlock their full potential.
        </p>
    </div>

    <!-- Call to Action -->
    <div class="text-center mt-5">
        <h4>Join Bengoh Academy today</h4>
        <p>Learn. Grow. Succeed.</p>
    </div>

</div>

@endsection