@extends('layouts.admin_layout')

@section('content')
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">{{ __('messages.admin.add_module') }}</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.module.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="moduleID" class="form-label">{{ __('messages.admin.course_code') }} ({{ __('messages.courses.module') }} ID)</label>
                    <input type="text" name="moduleID" id="moduleID" class="form-control @error('moduleID') is-invalid @enderror" placeholder="e.g. MOD-101" value="{{ old('moduleID') }}">
                    @error('moduleID') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="moduleName" class="form-label">{{ __('messages.admin.module_name') }}</label>
                    <input type="text" name="moduleName" id="moduleName" class="form-control @error('moduleName') is-invalid @enderror" placeholder="Enter module title" value="{{ old('moduleName') }}">
                    @error('moduleName') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4">
                    <label for="courseID" class="form-label">{{ __('messages.admin.select_course') }}</label>
                    <select name="courseID" id="courseID" class="form-select @error('courseID') is-invalid @enderror">
                        <option value="" selected disabled>{{ __('messages.admin.choose_course') }}</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->courseName }}</option>
                        @endforeach
                    </select>
                    @error('courseID') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.course.module') }}" class="btn btn-secondary">{{ __('messages.courses.cancel') }}</a>
                    <button type="submit" class="btn btn-success">{{ __('messages.admin.save_module') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection