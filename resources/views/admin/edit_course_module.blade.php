@extends('layouts.admin_layout')

@section('content')
<div class="container">
    <h3>{{ __('messages.admin.edit') }} {{ __('messages.admin.course_details') }}</h3>
    <form method="POST" action="{{ route('admin.course.update',$course->courseID) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
        <div class="mb-3">
            <label>{{ __('messages.admin.course_code') }}</label>
            <input type="text" name="courseCode" class="form-control" value="{{ $course->courseCode }}">
        </div>

        <div class="mb-3">
            <label>{{ __('messages.admin.course_name') }}</label>
            <input type="text" name="courseName" class="form-control" value="{{ $course->courseName }}">
        </div>

        <div class="mb-3">
            <label>{{ __('messages.admin.author') }}</label>
            <input type="text" name="courseAuthor" class="form-control" value="{{ $course->courseAuthor }}">
        </div>

        <div class="mb-3">
            <label>{{ __('messages.admin.desc') }}</label>
            <textarea name="courseDesc" class="form-control">{{ $course->courseDesc }}</textarea>
        </div>

        <div class="mb-3">
            <label>{{ __('messages.admin.category') }}</label>
            <input type="text" name="courseCategory" class="form-control" value="{{ $course->courseCategory }}">
        </div>

        <div class="mb-3">
            <label>{{ __('messages.admin.level') }}</label>
            <input type="text" name="courseLevel" class="form-control" value="{{ $course->courseLevel }}">
        </div>

        <div class="mb-3">
            <label>{{ __('messages.admin.duration') }}</label>
            <input type="number" name="courseDuration" class="form-control" value="{{ $course->courseDuration }}">
        </div>

        <div class="mb-3">
            <label>{{ __('messages.admin.available') }}</label>
            <select name="isAvailable" class="form-control">
                <option value="1" {{ $course->isAvailable ? 'selected' : '' }}>{{ __('messages.courses.feedback.yes') }}</option>
                <option value="0" {{ !$course->isAvailable ? 'selected' : '' }}>{{ __('messages.courses.feedback.not_really') }}</option>
            </select>
        </div>
        
        <div class="mb-3">
            <label>{{ __('messages.admin.thumbnail') }}</label>
            <input type="file" name="courseImg" class="form-control">
            
            @if($course->courseImg)
                <div class="mt-2">
                    <img src="{{ asset($course->courseImg) }}" width="120">
                </div>
            @endif
        </div>
        <button class="btn btn-success">{{ __('messages.admin.save_course') }}</button>
        <a href="{{ route('admin.course.module') }}" class="btn btn-secondary">{{ __('messages.admin.back') }}</a>
    </form>
</div>
@endsection