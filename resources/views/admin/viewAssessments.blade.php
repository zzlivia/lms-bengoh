@extends('layouts.admin_layout')

@section('content')
    <div class="container">
        <h3 class="mb-4">Course Assessments</h3>
        {{-- success message --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- filter --}}
        <form method="GET" class="mb-3">
            <div class="row">
                <div class="col-md-4">
                    <select name="courseID" class="form-control">
                        <option value="">-- Filter by Course --</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->courseID }}">
                                {{ $course->courseName }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <button class="btn btn-primary">Filter</button>
                </div>
            </div>
        </form>

        {{-- table --}}
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Course</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th width="200">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($assessments as $index => $ass)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $ass->course->courseName ?? 'N/A' }}</td>
                    <td>{{ $ass->courseAssTitle }}</td>
                    <td>{{ $ass->courseAssDesc }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <!-- add question route -->
                            <a href="{{ route('admin.assessment.addQs', $ass->courseAssID) }}" class="btn btn-success btn-sm me-1">
                                <i class="bi bi-plus-circle me-1"></i> Add Questions
                            </a>
                            <!-- edit assessment -->
                            <a href="{{ route('admin.assessment.editAss', $ass->courseAssID) }}" 
                            class="btn btn-warning btn-sm">
                                Edit
                            </a>
                            <!-- delete assessment -->
                            <form action="{{ route('admin.assessment.deleteCourseAss', $ass->courseAssID) }}" 
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Delete this assessment?')">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">No assessments found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mb-3">
        <button onclick="history.back()" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Back</button>
    </div>
@endsection