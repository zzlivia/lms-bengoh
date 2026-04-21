@extends('layouts.admin_layout')

@section('content')
    <div class="container">
        <h3 class="mb-4">{{ __('messages.admin.course_assessments') }}</h3>
        {{-- success message --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- filter --}}
        <form method="GET" class="mb-3">
            <div class="row">
                <div class="col-md-4">
                    <select name="courseID" class="form-control">
                        <option value="">-- {{ __('messages.admin.choose_course') }} --</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->courseID }}">
                                {{ $course->courseName }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <button class="btn btn-primary">{{ __('messages.courses.filter') }}</button>
                </div>
            </div>
        </form>

        {{-- table --}}
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>{{ __('messages.admin.course_name') }}</th>
                    <th>{{ __('messages.courses.assessment_title_label') ?? __('messages.admin.assessment_title_label') }}</th>
                    <th>{{ __('messages.admin.desc') }}</th>
                    <th width="200">{{ __('messages.admin.action') }}</th>
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
                                <i class="bi bi-plus-circle me-1"></i> {{ __('messages.admin.add_questions') }}
                            </a>
                            <!-- edit assessment -->
                            <a href="{{ route('admin.assessment.editAss', $ass->courseAssID) }}" 
                            class="btn btn-warning btn-sm">
                                {{ __('messages.admin.edit') }}
                            </a>
                            <!-- delete assessment -->
                            <form action="{{ route('admin.assessment.deleteCourseAss', $ass->courseAssID) }}" 
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Delete this assessment?')">
                                    {{ __('messages.admin.delete') }}
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center"{{ __('messages.admin.no_data') }}</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mb-3">
        <button onclick="history.back()" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> {{ __('messages.admin.back') }}</button>
    </div>
@endsection