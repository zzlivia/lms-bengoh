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
                        {{ __('messages.progress.congrats_msg') }}<br>
                        {{ __('messages.progress.action_prompt') }}
                        <br><br>
                        <a href="{{ route('courses.index') }}" class="btn btn-primary">
                            {{ __('messages.progress.choose_another') }}
                        </a>
                        <a href="{{ route('course.progress', $course->courseID) }}" class="btn btn-success">
                            {{ __('messages.progress.view_progress') }}
                        </a>
                    </div>
                @endif
                <div class="row">
                    <!-- left side -->
                    <div class="col-md-8">
                        <h5 class="fw-bold">{{ __('messages.progress.your_progress') }}</h5>
                        <p class="fw-bold mb-1">{{ __('messages.progress.course_completion') }}</p>
                        <p class="text-muted">
                            {{ __('messages.progress.completion_desc') }}
                        </p>
                    </div>
                    <!-- right side - progress circle -->
                    <div class="col-md-4 text-center">
                        <div class="progress-circle"
                            style="background: conic-gradient(#4caf50 {{ $totalProgress }}%, #e0e0e0 {{ $totalProgress }}%);">
                            <span>{{ $totalProgress ?? 0 }}%</span>
                            <small class="d-block text-muted">{{ __('messages.progress.completed_small') }}</small>
                        </div>
                    </div>
                </div>
                <hr>
                @if($isCompletedAll)
                    <div class="alert alert-success text-center shadow-sm">
                        <h4 class="fw-bold">🎉 {{ __('messages.progress.congrats_title') }}</h4>
                        <p class="mb-1">{{ __('messages.progress.success_msg') }}</p>
                        <p class="mb-0">{{ __('messages.progress.name_label') }}:<strong>{{ auth()->user()->userName }}</strong></p>
                        <a href="{{ route('course.certificate', $course->courseID) }}" class="btn btn-success mt-3">🎓 {{ __('messages.progress.download_cert') }}</a>
                    </div>
                @endif
                <!-- grades -->
                <h5 class="fw-bold mb-3">{{ __('messages.progress.your_grades') }}</h5>
                <div class="card shadow-sm">
                    <div class="card-body p-0">
                        <table class="table mb-0 text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>{{ __('messages.progress.task') }}</th>
                                    <th>{{ __('messages.progress.passing_grade') }}</th>
                                    <th>{{ __('messages.progress.current_grade') }}</th>
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
                                    <td>{{ __('messages.progress.total_grade') }}</td>
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