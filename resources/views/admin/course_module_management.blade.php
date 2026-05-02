@extends('layouts.admin_layout')
@section('content')

<h4 class="fw-bold mb-4">Course/Module Management</h4>
    {{-- Summary Cards --}}
    <div class="row mb-4">
        @php
            $stats = [
                ['label' => __('messages.admin.total_courses'), 'value' => $totalCourses],
                ['label' => __('messages.admin.total_modules'), 'value' => $totalModules],
                ['label' => __('messages.admin.feedback_received'), 'value' => $totalFeedback],
                ['label' => __('messages.admin.assessments_passed'), 'value' => $totalAssessmentsPassed],
            ];
        @endphp
        @foreach($stats as $stat)
        <div class="col-md-3">
            <div class="card-box text-center">
                <h6>{{ $stat['label'] }}</h6>
                <h2>{{ $stat['value'] }}</h2>
                <small>{{ __('messages.admin.engaged_week') }}</small>
            </div>
        </div>
        @endforeach
    </div>

    {{-- search and add course or module --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="input-group w-50">
            <span class="input-group-text bg-white border-end-0">
                <i class="fas fa-search text-muted"></i>
            </span>
            <input type="text" class="form-control border-start-0 ps-0" placeholder="{{ __('messages.admin.search_placeholder') }}">
        </div>
        <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle" type="button" id="addDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-plus me-1"></i> {{ __('messages.admin.add_new') }}
            </button>

            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="addDropdown">
                {{-- Add Course --}}
                <li>
                    <a class="dropdown-item" href="{{ route('admin.course.module.create') }}?tab=course">
                        <i class="fas fa-book-open me-2"></i> {{ __('messages.admin.add_course') }}
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                {{-- Add Module --}}
                    <a class="dropdown-item py-2" href="{{ route('admin.course.module.create', ['tab' => 'module']) }}">
                        <i class="fas fa-layer-group me-2 text-success"></i> {{ __('messages.admin.add_module') }}
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                {{-- Add Lecture --}}
                <li>
                    <a class="dropdown-item py-2" href="{{ route('admin.course.module.create', ['tab' => 'lecture']) }}">
                        <i class="fas fa-chalkboard-teacher me-2 text-info"></i> {{ __('messages.admin.add_lecture') }}
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                {{-- Add Section --}}
                <li>
                    <a class="dropdown-item py-2" href="{{ route('admin.course.module.create', ['tab' => 'section']) }}">
                        <i class="fas fa-file-alt me-2 text-warning"></i> {{ __('messages.admin.add_section') }}
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                {{-- Add MCQs --}}
                <li>
                    <a class="dropdown-item py-2" href="{{ route('admin.course.module.create', ['tab' => 'mcq']) }}">
                        <i class="fas fa-question-circle me-2 text-danger"></i> {{ __('messages.admin.add_mcq') }}
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                {{-- Add Course Assessment --}}
                <li>
                    <a class="dropdown-item py-2" href="{{ route('admin.course.module.create', ['tab' => 'assessment']) }}">
                        <i class="fas fa-question-circle me-2 text-danger"></i> {{ __('messages.admin.add_assessment') }}
                    </a>
                </li>
            </ul>
        </div>
    </div>
    {{-- display box of courses with author, availability, and modules --}}
    <div class="card-box">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>{{ __('messages.admin.course_code') }}</th>
                    <th>{{ __('messages.admin.course_name') }}</th>
                    <th>{{ __('messages.admin.author') }}</th>
                    <th>{{ __('messages.admin.existing_modules') }}</th>
                    <th>{{ __('messages.courses.status') ?? 'Availability' }}</th>
                    <th>{{ __('messages.admin.action') }}</th>
                </tr>
            </thead>
            <tbody>
            @foreach($courses as $index => $course)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $course->courseCode }}</td>
                <td>{{ $course->courseName }}</td>
                <td>{{ $course->courseAuthor }}</td>
                <td>{{ $course->modules->count() }}</td>
                <td>
                    <span class="badge {{ $course->isAvailable ? 'bg-success' : 'bg-danger' }}">
                        {{ $course->isAvailable ? __('messages.admin.available') : __('messages.admin.hidden') }}
                    </span>
                </td>
                <td>
                    <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewCourseModal{{ $course->courseID }}"> {{ __('messages.admin.view') }} </button>
                    
                    <!-- New Results Button -->
                    <a href="{{ route('admin.reports.course', $course->courseID) }}" class="btn btn-sm btn-success">
                        <i class="fas fa-chart-bar"></i> {{ __('Results') }}
                    </a>

                    <a href="{{ route('admin.course.edit', $course->courseID) }}" class="btn btn-sm btn-warning"> {{ __('messages.admin.edit') }} </a>
                    
                    <form action="{{ route('admin.course.delete', $course->courseID) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"> {{ __('messages.admin.delete') }} </button>
                    </form>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        {{-- when user click on View Action, it display pop up modal tab --}}
        @foreach($courses as $course)
        <div class="modal fade" id="viewCourseModal{{ $course->courseID }}" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Course Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card p-3 border-0">
                            <h4 class="fw-bold text-primary">{{ $course->courseName }}</h4>
                            <p><strong>{{ __('messages.admin.course_code') }}:</strong> {{ $course->courseCode }}</p>
                            <p><strong>{{ __('messages.admin.author') }}:</strong> {{ $course->courseAuthor }}</p>
                            <p><strong>{{ __('messages.admin.category') }}:</strong> {{ $course->courseCategory }}</p>
                            <p><strong>{{ __('messages.admin.level') }}:</strong> {{ $course->courseLevel }}</p>
                            <p><strong>{{ __('messages.admin.duration') }}:</strong> {{ $course->courseDuration }} {{ __('messages.admin.hours') }}</p>
                            <p><strong>{{ __('messages.admin.desc') }}:</strong> {{ $course->courseDesc }}</p>
                            @if($course->courseImg)
                                <img src="{{ asset('storage/'.$course->courseImg) }}" class="img-fluid rounded mt-2" style="width:250px; height:200px; object-fit:cover;">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    {{-- results section --}}
    <div class="row mt-5">
        <div class="col-12">
            <div class="card-box">
                <h5 class="fw-bold mb-3"><i class="fas fa-user-graduates me-2"></i>Learner Performance Reports</h5>
                <p class="text-muted small">Access detailed breakdowns of how learners are performing in assessments and quizzes.</p>
                <hr>
                <div class="d-flex gap-3">
                    {{-- Button for MCQ Results --}}
                    <a href="{{ route('admin.reports.mcq') }}" class="btn btn-outline-primary">
                        <i class="fas fa-list-ol me-1"></i> View MCQ Results
                    </a>

                    {{-- Button for Assessment Results --}}
                    <a href="{{ route('admin.reports.assessments') }}" class="btn btn-outline-danger">
                        <i class="fas fa-file-invoice me-1"></i> View Assessment Results
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection