@extends('layouts.admin')

@section('content')
<div class="container">
    <h3>Edit Course</h3>
    <form method="POST" action="{{ route('admin.course.update',$course->courseID) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
        <div class="mb-3">
            <label>Course Code</label>
            <input type="text" name="courseCode" class="form-control" value="{{ $course->courseCode }}">
        </div>

        <div class="mb-3">
            <label>Course Name</label>
            <input type="text" name="courseName" class="form-control" value="{{ $course->courseName }}">
        </div>

        <div class="mb-3">
            <label>Author</label>
            <input type="text" name="courseAuthor" class="form-control" value="{{ $course->courseAuthor }}">
        </div>

        <div class="mb-3">
            <label>Course Description</label>
            <textarea name="courseDesc" class="form-control">{{ $course->courseDesc }}</textarea>
        </div>

        <div class="mb-3">
            <label>Course Category</label>
            <input type="text" name="courseCategory" class="form-control" value="{{ $course->courseCategory }}">
        </div>

        <div class="mb-3">
            <label>Course Level</label>
            <input type="text" name="courseLevel" class="form-control" value="{{ $course->courseLevel }}">
        </div>

        <div class="mb-3">
            <label>Course Duration</label>
            <input type="number" name="courseDuration" class="form-control" value="{{ $course->courseDuration }}">
        </div>

        <div class="mb-3">
            <label>Available</label>
            <select name="isAvailable" class="form-control">
                <option value="1" {{ $course->isAvailable ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ !$course->isAvailable ? 'selected' : '' }}>No</option>
            </select>
        </div>
        
        <div class="mb-3">
            <label>Course Image</label>
            <input type="file" name="courseImg" class="form-control">
            
            @if($course->courseImg)
                <div class="mt-2">
                    <img src="{{ asset($course->courseImg) }}" width="120">
                </div>
            @endif
        </div>
        <button class="btn btn-success">Update Course</button>
        <a href="{{ route('admin.course.module') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection