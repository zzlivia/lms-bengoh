@extends('layouts.admin_layout')

@section('content')

<h4 class="fw-bold mb-4">{{ __('messages.admin.progress') }}</h4>
<div class="row g-4">
    <div class="col-md-6">
        <div class="card-box">
        <h6>{{ __('messages.courses.course_completion') }} {{ __('messages.admin.progress') }}</h6>
            <div class="d-flex justify-content-around text-center mt-3">
                <div>
                    <div class="progress-circle gray" style="--value: {{ $notStartedPercent ?? 0 }}">
                        <span>{{ $notStartedPercent ?? 0 }}%</span>
                    </div>
                    <small>{{ __('messages.admin.not_available') }}</small>
                </div>
                <div>
                    <div class="progress-circle red" style="--value: {{ $inProgressPercent ?? 0 }}">
                        <span>{{ $inProgressPercent ?? 0 }}%</span>
                    </div>
                    <small>{{ __('messages.courses.incomplete') }}</small>
                </div>
                <div>
                    <div class="progress-circle red" style="--value: {{ $completedPercent ?? 0 }}">
                        <span>{{ $completedPercent ?? 0 }}%</span>
                    </div>
                    <small>{{ __('messages.courses.completed') }}</small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card-box">
        <h6>{{ __('messages.admin.course_assessments') }} {{ __('messages.admin.progress') }}</h6>
            <div class="d-flex justify-content-around text-center mt-3">
                <div>
                    <div class="progress-circle gray" style="--value: {{ $assessmentNotStarted ?? 0 }}">
                        <span>{{ $assessmentNotStarted ?? 0 }}%</span>
                    </div>
                    <small>{{ __('messages.admin.not_available') }}</small>
                </div>
                <div>
                    <div class="progress-circle red" style="--value: {{ $assessmentPending ?? 0 }}">
                        <span>{{ $assessmentPending ?? 0 }}%</span>
                    </div>
                    <small>{{ __('messages.courses.incomplete') }}</small>
                </div>
                <div>
                    <div class="progress-circle red" style="--value: {{ $assessmentCompleted ?? 0 }}">
                        <span>{{ $assessmentCompleted ?? 0 }}%</span>
                    </div>
                    <small>{{ __('messages.courses.completed') }}</small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card-box">
        <h6>{{ __('messages.admin.type_mcq') }} {{ __('messages.admin.progress') }}</h6>
            <div class="d-flex justify-content-around text-center mt-3">
                <div>
                    <div class="progress-circle blue" style="--value: {{ $mcqNotAttempted ?? 0 }}">
                        <span>{{ $mcqNotAttempted ?? 0 }}%</span>
                    </div>
                    <small>{{ __('messages.admin.not_available') }}</small>
                </div>

                <div>
                    <div class="progress-circle red" style="--value: {{ $mcqAssigned ?? 0 }}">
                        <span>{{ $mcqAssigned ?? 0 }}%</span>
                    </div>
                    <small>{{ __('messages.courses.incomplete') }}</small>
                </div>
                <div>
                    <div class="progress-circle red" style="--value: {{ $mcqAttempted ?? 0 }}">
                        <span>{{ $mcqAttempted ?? 0 }}%</span>
                    </div>
                    <small>{{ __('messages.courses.completed') }}</small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card-box">
            <h6>{{ __('messages.courses.total_grade') }} ({{ __('messages.admin.type_mcq') }})</h6>
            <div class="progress mt-4" style="height:12px;">
                <div class="progress-bar bg-danger"
                    style="width: {{ $averageScore ?? 0 }}%">
                </div>
            </div>
            <div class="d-flex justify-content-between mt-2">
                <span>{{ __('messages.courses.passing_grade') }}: 80%</span>
                <span>{{ __('messages.courses.current_grade') }}: {{ $averageScore ?? 0 }}%</span>
            </div>
        </div>  
    </div>
</div>
@endsection