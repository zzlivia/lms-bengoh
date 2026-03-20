@extends('layouts.admin')

@section('content')

<h4 class="fw-bold mb-4">Report Overview</h4>
    {{-- user and enrolment --}}
    <div class="card-box mb-4">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="fw-bold mb-0">User & Enrolment</h6>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <p>Total Registered Users</p>
                <p>New Users</p>
                <p>Active Users</p>
                <p>Inactive Users</p>
                <p>Unregistered (guess) access account</p>
            </div>
            <div class="col-md-6 text-end">
                <p>: {{ $totalUsers }}</p>
                <p>: {{ $newUsers }}</p>
                <p>: {{ $activeUsers }}</p>
                <p>: {{ $inactiveUsers }}</p>
                <p>: {{ $guestUsers }}</p>
            </div>
        </div>
        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#userReportModal">
            View more
        </button>
    </div>
    {{-- course and module --}}
    <div class="card-box mb-4">
        <h6 class="fw-bold mb-3">Course & Module Performance</h6>
        <table class="table">
            <thead>
                <tr>
                    <th>Course Name</th>
                    <th>Module Name</th>
                    <th>Enrolled</th>
                    <th>Completed</th>
                    <th>In Progress</th>
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
                <td colspan="5" class="text-center text-muted">
                    No data available
                </td>
            </tr>
            @endif
            </tbody>
        </table>
        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#courseReportModal">
            View more
        </button>
    </div>
    {{-- assessment and mcq --}}
    <div class="card-box mb-4">

        <h6 class="fw-bold mb-3">Assessment & MCQ</h6>

        <table class="table">
            <thead>
                <tr>
                    <th>Total Assessment Created</th>
                    <th>Module Name</th>
                    <th>Enrolled</th>
                    <th>Completed</th>
                    <th>In Progress</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td colspan="5" class="text-center text-muted">
                        No data available
                    </td>
                </tr>
            </tbody>
        </table>
        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#assessmentReportModal">
            View more
        </button>
    </div>


{{-- bottom buttons --}}
<div class="text-center mt-4">
    <button class="btn btn-outline-dark me-2" data-bs-toggle="modal" data-bs-target="#generateReportModal">
        Generate report
    </button>
   <a href="{{ route('admin.downloadReport') }}" class="btn btn-outline-dark">
        Download report
    </a>
</div>

{{-- bootstrap modal pop up --}}
    {{-- user and enrolment --}}
    <div class="modal fade" id="userReportModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">User & Enrolment Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tr>
                            <th>Total Users</th>
                            <td>{{ $totalUsers }}</td>
                        </tr>
                        <tr>
                            <th>New Users</th>
                            <td>{{ $newUsers }}</td>
                        </tr>
                        <tr>
                            <th>Active Users</th>
                            <td>{{ $activeUsers }}</td>
                        </tr>
                        <tr>
                            <th>Inactive Users</th>
                            <td>{{ $inactiveUsers }}</td>
                        </tr>
                        <tr>
                            <th>Guest Users</th>
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
                    <h5 class="modal-title">Course & Module Performance</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Course</th>
                                <th>Module</th>
                                <th>Enrolled</th>
                                <th>Completed</th>
                                <th>In Progress</th>
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
                    <h5 class="modal-title">Assessment & MCQ Report</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted">No data available</p>
                </div>
            </div>
        </div>
    </div>

    {{-- report modal --}}
    <div class="modal fade" id="generateReportModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Generated Report</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <h6>User Summary</h6>
                        <ul>
                            <li>Total Users: {{ $totalUsers }}</li>
                            <li>New Users: {{ $newUsers }}</li>
                            <li>Active Users: {{ $activeUsers }}</li>
                            <li>Inactive Users: {{ $inactiveUsers }}</li>
                        </ul>
                    <h6 class="mt-3">Courses</h6>
                    <table class="table">
                    <tr>
                        <th>Course</th>
                        <th>Module</th>
                        <th>Completed</th>
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