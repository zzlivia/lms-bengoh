@extends('layouts.admin')

@section('content')

<h4 class="fw-bold mb-4">Progress</h4>
<div class="row g-4">
    <div class="col-md-6">
        <div class="card-box">
        <h6>Course Completion Progress</h6>
            <div class="d-flex justify-content-around text-center mt-3">
                <div>
                    <div class="progress-circle gray" style="--value: {{ $notStartedPercent ?? 0 }}">
                        <span>{{ $notStartedPercent ?? 0 }}%</span>
                    </div>
                    <small>Not Started</small>
                </div>
                <div>
                    <div class="progress-circle red" style="--value: {{ $inProgressPercent ?? 0 }}">
                        <span>{{ $inProgressPercent ?? 0 }}%</span>
                    </div>
                    <small>In Progress</small>
                </div>
                <div>
                    <div class="progress-circle red" style="--value: {{ $completedPercent ?? 0 }}">
                        <span>{{ $completedPercent ?? 0 }}%</span>
                    </div>
                    <small>Completed</small>
                </div>

            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card-box">
        <h6>Assessment Completion Progress</h6>
            <div class="d-flex justify-content-around text-center mt-3">
                <div>
                    <div class="progress-circle gray" style="--value: {{ $assessmentNotStarted ?? 0 }}">
                        <span>{{ $assessmentNotStarted ?? 0 }}%</span>
                    </div>
                    <small>Not Started</small>
                </div>
                <div>
                    <div class="progress-circle red" style="--value: {{ $assessmentPending ?? 0 }}">
                        <span>{{ $assessmentPending ?? 0 }}%</span>
                    </div>
                    <small>Pending</small>
                </div>
                <div>
                    <div class="progress-circle red" style="--value: {{ $assessmentCompleted ?? 0 }}">
                        <span>{{ $assessmentCompleted ?? 0 }}%</span>
                    </div>
                    <small>Completed</small>
                </div>

            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card-box">
        <h6>MCQs Attempt Progress</h6>
            <div class="d-flex justify-content-around text-center mt-3">
                <div>
                    <div class="progress-circle blue" style="--value: {{ $mcqNotAttempted ?? 0 }}">
                        <span>{{ $mcqNotAttempted ?? 0 }}%</span>
                    </div>
                    <small>Not Attempted</small>
                </div>

                <div>
                    <div class="progress-circle red" style="--value: {{ $mcqAssigned ?? 0 }}">
                        <span>{{ $mcqAssigned ?? 0 }}%</span>
                    </div>
                    <small>Assigned</small>
                </div>
                <div>
                    <div class="progress-circle red" style="--value: {{ $mcqAttempted ?? 0 }}">
                        <span>{{ $mcqAttempted ?? 0 }}%</span>
                    </div>
                    <small>Attempted</small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card-box">
            <h6>Average MCQ Score</h6>
            <div class="progress mt-4" style="height:12px;">
                <div class="progress-bar bg-danger"
                    style="width: {{ $averageScore ?? 0 }}%">
                </div>
            </div>
            <div class="d-flex justify-content-between mt-2">
                <span>80%</span>
                <span>{{ $averageScore ?? 0 }}%</span>
            </div>
        </div>  
    </div>
</div>
@endsection