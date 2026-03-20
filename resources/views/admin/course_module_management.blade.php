@extends('layouts.admin')

@section('content')

<h4 class="fw-bold mb-4">Course/Module Management</h4>
{{-- Summary Cards --}}
<div class="row mb-4">
    @php
        $stats = [
            [
                'label' => 'Total Courses',
                'value' => $totalCourses,
                /*'link' => route('#')*/
            ],
            [
                'label' => 'Total Modules',
                'value' => $totalModules,
                /*'link' => route('#')*/
            ],
            [
                'label' => 'Feedback Received',
                'value' => $totalFeedback,
                /*'link' => route('#')*/
            ],
            [
                'label' => 'Assessments Passed',
                'value' => $totalAssessmentsPassed,
                /*'link' => route('#')*/
            ],
        ];
    @endphp

    @foreach($stats as $stat)
    <div class="col-md-3">
        <div class="card-box text-center">
            <h6>{{ $stat['label'] }}</h6>
            <h2>{{ $stat['value'] }}</h2>
            <small>Engaged in this week</small>
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
        <input type="text" class="form-control border-start-0 ps-0" placeholder="Search Course/Modules">
    </div>
    
    <div class="dropdown">
        <button class="btn btn-primary dropdown-toggle" type="button" id="addDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-plus me-1"></i> Add New
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="addDropdown">
            {{-- passing query parameter --}}
            <li>
                <a class="dropdown-item" href="{{ route('admin.course.module.create') }}?tab=course">
                    <i class="fas fa-book-open me-2"></i> Add Course
                </a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <a class="dropdown-item py-2" href="{{ route('admin.course.module.create', ['tab' => 'module']) }}">
                    <i class="fas fa-layer-group me-2 text-success"></i> Add Module
                </a>
            </li>
            <li class="nav-item">
                <a class="dropdown-item py-2" href="{{ route('admin.course.module.create', ['tab' => 'lecture']) }}">
                    <i class="fas fa-chalkboard-teacher me-2 text-info"></i> Add Lecture
                </a>
            </li>
            <li class="nav-item">
                <a class="dropdown-item py-2" href="{{ route('admin.course.module.create', ['tab' => 'section']) }}">
                    <i class="fas fa-chalkboard-teacher me-2 text-info"></i> Add Section
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
                <th>Course Code</th>
                <th>Course Name</th>
                <th>Author</th>
                <th>No of Modules</th>
                <th>Availability</th>
                <th>Action</th>
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
                    {{ $course->isAvailable ? 'Available' : 'Hidden' }}
                </span>
            </td>
            <td>
                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewCourseModal{{ $course->courseID }}"> View </button>
                <a href="{{ route('admin.course.edit', $course->courseID) }}" class="btn btn-sm btn-warning"> Edit </a>
                
                <form action="{{ route('admin.course.delete', $course->courseID) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"> Delete </button>
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
                    <div class="card p-3">
                        <h4>{{ $course->courseName }}</h4>
                        <p><strong>Course Code:</strong> {{ $course->courseCode }}</p>
                        <p><strong>Author:</strong> {{ $course->courseAuthor }}</p>
                        <p><strong>Category:</strong> {{ $course->courseCategory }}</p>
                        <p><strong>Level:</strong> {{ $course->courseLevel }}</p>
                        <p><strong>Duration:</strong> {{ $course->courseDuration }} hours</p>
                        <p><strong>Description:</strong> {{ $course->courseDesc }}</p>
                        
                        @if($course->courseImg)
                            <img src="{{ asset('storage/'.$course->courseImg) }}" class="img-fluid rounded" style="width:250px; height:200px; object-fit:cover;">
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach

      
    {{--<div class="text-center mt-3">
        <button class="btn btn-dark">Save Changes</button>
    </div>--}}
</div>
@endsection