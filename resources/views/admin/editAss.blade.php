@extends('layouts.admin_layout')

@section('content')
    <div class="container">

        <h3 class="mb-4">Edit Assessment</h3>

        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('admin.assessment.updateAss', $assessment->courseAssID) }}">
            @csrf
            @method('PUT')

            <!-- select course -->
            <div class="mb-3">
                <label class="form-label">Select Course</label>
                <select name="courseID" class="form-control" required>
                    @foreach($courses as $course)
                        <option value="{{ $course->courseID }}"
                            {{ $assessment->courseID == $course->courseID ? 'selected' : '' }}>
                            {{ $course->courseName }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- title -->
            <div class="mb-3">
                <label class="form-label">Assessment Title</label>
                <input type="text" name="title" class="form-control"
                    value="{{ $assessment->courseAssTitle }}" required>
            </div>

            <!-- description -->
            <div class="mb-3">
                <label class="form-label">Assessment Description</label>
                <textarea name="desc" class="form-control" rows="4">{{ $assessment->courseAssDesc }}</textarea>
            </div>

            <!-- buttons -->
            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.assessment.manageCourseAss') }}" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-success">Update Assessment</button>
            </div>
        </form>
    </div>
@endsection