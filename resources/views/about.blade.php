@extends('layouts.open_layout')

@section('content')

<div class="container mt-5">

    <!-- Page Title -->
    <div class="text-center mb-5">
        <h1 class="fw-bold">About Bengoh Academy</h1>
        <p class="text-muted">Empowering learners everywhere</p>
    </div>

    <!-- Mission -->
    <div class="mb-5">
        <h3>Our Mission</h3>
        <p>
            Bengoh Academy aims to provide accessible, high-quality education for everyone.
            We believe learning should be flexible, practical, and available to all,
            regardless of location or background.
        </p>
    </div>

    <!-- What We Offer -->
    <div class="mb-5">
        <h3>What We Offer</h3>
        <ul class="list-unstyled">
            <li class="mb-2">
                <i class="fas fa-book text-primary me-2"></i>
                Structured online courses
            </li>
            <li class="mb-2">
                <i class="fas fa-video text-danger me-2"></i>
                Video-based learning
            </li>
            <li class="mb-2">
                <i class="fas fa-users text-success me-2"></i>
                Community discussions
            </li>
            <li class="mb-2">
                <i class="fas fa-chart-line text-warning me-2"></i>
                Progress tracking
            </li>
            <li class="mb-2">
                <i class="fas fa-globe text-info me-2"></i>
                Learn anytime, anywhere
            </li>
        </ul>
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