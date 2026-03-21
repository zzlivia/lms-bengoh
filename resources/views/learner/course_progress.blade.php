@extends('layouts.learner')

<link rel="stylesheet" href="{{ asset('css/course_progress.css') }}">

@section('content')

<div class="container mt-4">

<!-- Progress Title -->
<div class="text-center mb-4">
    <div class="progress-title">
        Progress
    </div>
</div>

<div class="row">

    <!-- SIDEBAR -->
    @include('partials.course-sidebar')

    <!-- MAIN CONTENT -->
    <div class="col-md-9">

        <div class="row">

            <!-- LEFT SIDE -->
            <div class="col-md-8">

                <h5 class="fw-bold">Your Progress</h5>

                <p class="fw-bold mb-1">Course Completion</p>
                <p class="text-muted">
                    This represents how much of the course content you have completed.
                </p>

            </div>

            <!-- RIGHT SIDE PROGRESS CIRCLE -->
            <div class="col-md-4 text-center">

                <div class="progress-circle">
                    <span>{{ $totalProgress ?? 0 }}%</span>
                    <small class="d-block text-muted">completed</small>
                </div>

            </div>

        </div>

        <hr>

        <!-- GRADES TABLE -->
        <h5 class="fw-bold mb-3">Your Grades</h5>

        <div class="card shadow-sm">
            <div class="card-body p-0">

                <table class="table mb-0 text-center">

                    <thead class="table-light">
                        <tr>
                            <th>Task</th>
                            <th>Passing Grade</th>
                            <th>Current Grade</th>
                        </tr>
                    </thead>

                    <tbody>

                        <tr>
                            <td>MCQ 1</td>
                            <td>80%</td>
                            <td>{{ $grades['mcq1'] ?? '0%' }}</td>
                        </tr>

                        <tr>
                            <td>MCQ 2</td>
                            <td>80%</td>
                            <td>{{ $grades['mcq2'] ?? '0%' }}</td>
                        </tr>

                        <tr>
                            <td>MCQ 3</td>
                            <td>80%</td>
                            <td>{{ $grades['mcq3'] ?? '0%' }}</td>
                        </tr>

                        <tr>
                            <td>MCQ 4</td>
                            <td>80%</td>
                            <td>{{ $grades['mcq4'] ?? '0%' }}</td>
                        </tr>

                        <tr>
                            <td>Course Assessment</td>
                            <td>80%</td>
                            <td>{{ $grades['assessment'] ?? '0%' }}</td>
                        </tr>

                        <tr class="fw-bold">
                            <td>Total Grade</td>
                            <td></td>
                            <td>{{ $totalProgress ?? 0 }}%</td>
                        </tr>

                    </tbody>

                </table>

            </div>
        </div>

    </div>

</div>

</div>

@endsection