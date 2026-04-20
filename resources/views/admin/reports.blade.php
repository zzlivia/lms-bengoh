@extends('layouts.admin_layout')

@section('content')

<h4 class="fw-bold mb-4">Report Overview</h4>
    {{-- user and enrolment --}}
    <div class="card-box mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="fw-bold mb-0">{{ __('messages.admin.user_mgmt') }} & {{ __('messages.admin.students_enrolled') }}</h6>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <p>{{ __('messages.admin.total_users') }}</p>
                <p>{{ __('messages.admin.new_users') }}</p>
                <p>{{ __('messages.admin.active_users') }}</p>
                <p>{{ __('messages.admin.hidden') }} ({{ __('messages.admin.not_available') }})</p>
                <p>{{ __('messages.admin_settings.guest_access') }}</p>
            </div>
            <div class="col-md-6 text-end">
                <p>: {{ $totalUsers }}</p>
                <p>: {{ $newUsers }}</p>
                <p>: {{ $activeUsers }}</p>
                <p>: {{ $inactiveUsers }}</p>
                <p>: {{ $guestUsers }}</p>
            </div>
        </div>
        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#userReportModal">{{ __('messages.admin.view') }} {{ __('messages.admin.advanced') }}</button>
    </div>
    {{-- course and module --}}
    <div class="card-box mb-4">
        <h6 class="fw-bold mb-3">{{ __('messages.admin.course_mgmt') }} {{ __('messages.admin.progress') }}</h6>
        <table class="table">
            <thead>
                <tr>
                    <th>{{ __('messages.admin.course_name') }}</th>
                    <th>{{ __('messages.admin.module_name') }}</th>
                    <th>{{ __('messages.admin.students_enrolled') }}</th>
                    <th>{{ __('messages.courses.completed') }}</th>
                    <th>{{ __('messages.admin.progress') }}</th>
                </tr>
            </thead>
            <tbody>
            @if($courseModules->count() > 0)
                @foreach($courseModules as $row)
                <tr>
                    <td>{{ $row->courseName }}</td>
                    <td>{{ $row->moduleName }}</td>
                    <td>{{ $row->enrolled }}</td>
                    <td>{{ $row->completed }}</td>
                    <td>{{ $row->in_progress }}</td>
                </tr>
                @endforeach
            @else
            <tr>
                <td colspan="5" class="text-center text-muted">{{ __('messages.admin.no_data') }}</td>
            </tr>
            @endif
            </tbody>
        </table>
        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#courseReportModal">{{ __('messages.admin.view') }} {{ __('messages.admin.advanced') }}</button>
    </div>
    {{-- assessment and mcq --}}
    <div class="card-box mb-4">
        <h6 class="fw-bold mb-3">Assessment & MCQ</h6>
        <table class="table">
            <thead>
                <tr>
                    <th>{{ __('messages.admin.total_courses') }}</th>
                    <th>{{ __('messages.admin.module_name') }}</th>
                    <th>{{ __('messages.admin.students_enrolled') }}</th>
                    <th>{{ __('messages.courses.completed') }}</th>
                    <th>{{ __('messages.admin.progress') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="5" class="text-center text-muted">{{ __('messages.admin.no_data') }}</td>
                </tr>
            </tbody>
        </table>
        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#assessmentReportModal">{{ __('messages.admin.view') }} {{ __('messages.admin.advanced') }}</button>
    </div>


{{-- bottom buttons --}}
<div class="text-center mt-4">
    <button class="btn btn-outline-dark me-2" data-bs-toggle="modal" data-bs-target="#generateReportModal">{{ __('messages.admin.reports') }}</button>
   <a href="{{ route('admin.downloadReport') }}" class="btn btn-outline-dark">{{ __('messages.admin.reports') }} (PDF)</a>
</div>

{{-- bootstrap modal pop up --}}
    {{-- user and enrolment --}}
    <div class="modal fade" id="userReportModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('messages.admin.user_mgmt') }} & {{ __('messages.admin.students_enrolled') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tr>
                            <th>{{ __('messages.admin.total_users') }}</th>
                            <td>{{ $totalUsers }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('messages.admin.new_users') }}</th>
                            <td>{{ $newUsers }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('messages.admin.active_users') }}</th>
                            <td>{{ $activeUsers }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('messages.admin.not_available') }}</th>
                            <td>{{ $inactiveUsers }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('messages.admin_settings.guest_access') }}</th>
                            <td>{{ $guestUsers }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- course and module --}}
    <div class="modal fade" id="courseReportModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('messages.admin.course_mgmt') }} {{ __('messages.admin.progress') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>{{ __('messages.admin.course_name') }}</th>
                                <th>{{ __('messages.admin.module_name') }}</th>
                                <th>{{ __('messages.admin.students_enrolled') }}</th>
                                <th>{{ __('messages.courses.completed') }}</th>
                                <th>{{ __('messages.admin.progress') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($courseModules as $row)
                            <tr>
                                <td>{{ $row->courseName }}</td>
                                <td>{{ $row->moduleName }}</td>
                                <td>{{ $row->enrolled }}</td>
                                <td>{{ $row->completed }}</td>
                                <td>{{ $row->in_progress }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- assessment and mcq --}}
    <div class="modal fade" id="assessmentReportModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('messages.admin.course_assessments') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted">{{ __('messages.admin.no_data') }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- report modal --}}
    <div class="modal fade" id="generateReportModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('messages.admin.summary') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <h6>{{ __('messages.admin.user_mgmt') }} {{ __('messages.admin.summary') }}</h6>
                        <ul>
                            <li>{{ __('messages.admin.total_users') }}: {{ $totalUsers }}</li>
                            <li>{{ __('messages.admin.new_users') }}: {{ $newUsers }}</li>
                            <li>{{ __('messages.admin.active_users') }}: {{ $activeUsers }}</li>
                            <li>{{ __('messages.admin.not_available') }}: {{ $inactiveUsers }}</li>
                        </ul>
                    <h6 class="mt-3">Courses</h6>
                    <table class="table">
                    <tr>
                        <th>{{ __('messages.admin.course_name') }}</th>
                        <th>{{ __('messages.admin.module_name') }}</th>
                        <th>{{ __('messages.courses.completed') }}</th>
                    </tr>
                    @foreach($courseModules as $row)
                    <tr>
                        <td>{{ $row->courseName }}</td>
                        <td>{{ $row->moduleName }}</td>
                        <td>{{ $row->completed }}</td>
                    </tr>
                    @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection