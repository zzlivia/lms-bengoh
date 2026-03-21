@extends('layouts.learner')

@section('content')

<div class="container-fluid">
    <div class="row">
        <!-- sidebar -->
        @include('partials.course-sidebar')
       <!-- main content -->
        <div class="col-md-9">

            <div class="text-center mb-4">
                <h5 class="fw-semibold">Course Feedback</h5>
                <p class="text-muted small">
                    Help us improve Bengoh Academy by sharing your learning experience.
                </p>
            </div>

            <form method="POST" action="{{ route('course.feedback.submit', $course->courseID) }}">
            @csrf

            <div class="card shadow-sm border-0 p-4">

                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        1. How clear was the course content?
                    </label>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="clarity" value="Excellent">
                        <label class="form-check-label">Excellent</label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="clarity" value="Good">
                        <label class="form-check-label">Good</label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="clarity" value="Average">
                        <label class="form-check-label">Average</label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="clarity" value="Poor">
                        <label class="form-check-label">Poor</label>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        2. Did the course help you understand the importance of the Bengoh Dam?
                    </label>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="understanding" value="Yes">
                        <label class="form-check-label">Yes</label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="understanding" value="Somewhat">
                        <label class="form-check-label">Somewhat</label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="understanding" value="Not really">
                        <label class="form-check-label">Not really</label>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        3. Which module did you find most interesting?
                    </label>

                    <select name="favorite_module" class="form-select">
                        <option value="">Select Module</option>
                        <option>Module 1 - Introduction</option>
                        <option>Module 2 - Historical Background</option>
                        <option>Module 3 - Impact</option>
                        <option>Module 4 - Preservation</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        4. What did you enjoy most about the course?
                    </label>

                    <textarea name="enjoyed" class="form-control" rows="3"></textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        5. Suggestions to improve this course?
                    </label>

                    <textarea name="suggestions" class="form-control" rows="3"></textarea>
                </div>

            </div>
            <div class="text-end mt-4">
                <button type="submit" class="btn btn-success px-4">
                    Submit
                </button>
            </div>
            </form>
        </div>
    </div>
</div>

@endsection