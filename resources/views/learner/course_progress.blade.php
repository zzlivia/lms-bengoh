@extends('layouts.open_layout')

<link rel="stylesheet" href="{{ asset('css/course_progress.css') }}">

@section('content')
    <div class="container mt-4">
        <!-- Progress Title 
        <div class="text-center mb-4">
            <div class="progress-title">Progress</div>
        </div>-->
        <div class="row">
            <!-- sidebar -->
            @include('partials.course-sidebar', ['course' => $course])
            <!-- main content-->
            <div class="col-md-9">
                @if(session('assessment_completed'))
                    <div class="alert alert-success text-center">
                        🎉 Congratulations! You have completed the course.<br>
                        Would you like to:
                        <br><br>

                        <a href="{{ route('courses.index') }}" class="btn btn-primary">
                            Choose Another Course
                        </a>

                        <a href="{{ route('course.progress', $course->courseID) }}" class="btn btn-success">
                            View Your Progress
                        </a>
                    </div>
                @endif
                <div class="row">
                    <!-- left side -->
                    <div class="col-md-8">
                        <h5 class="fw-bold">Your Progress</h5>
                        <p class="fw-bold mb-1">Course Completion</p>
                        <p class="text-muted">
                            This represents how much of the course content you have completed.
                        </p>
                    </div>
                    <!-- right side - progress circle -->
                    <div class="col-md-4 text-center">
                        <div class="progress-circle"
                            style="background: conic-gradient(#4caf50 {{ $totalProgress }}%, #e0e0e0 {{ $totalProgress }}%);">
                            <span>{{ $totalProgress ?? 0 }}%</span>
                            <small class="d-block text-muted">completed</small>
                        </div>
                    </div>
                </div>
                <hr>
                @if($isCompletedAll)
                    <div class="alert alert-success text-center shadow-sm">
                        <h4 class="fw-bold">🎉 Congratulations!</h4>
                        <p class="mb-1">You have successfully completed this course.</p>
                        <p class="mb-0">Name: <strong>{{ auth()->user()->userName }}</strong></p>
                    </div>
                @endif
                <!-- grades -->
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
                                @foreach($grades as $grade)
                                    <tr>
                                        <td>{{ $grade['name'] }}</td>
                                        <td>80%</td>
                                        <td>{{ $grade['score'] }}</td>
                                    </tr>
                                @endforeach

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