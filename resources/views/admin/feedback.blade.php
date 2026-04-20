@extends('layouts.admin_layout')

@section('content')
    <div class="container">
    <h4>{{ __('messages.courses.feedback.title') }}</h4>
        <div class="mb-3"> {{-- add filter function --}}
            <select id="courseFilter" class="form-control">
                <option value="">All Courses</option>
                @foreach($feedbacks->pluck('course.courseName')->unique() as $courseName)
                    <option value="{{ $courseName }}">{{ $courseName }}</option>
                @endforeach
            </select>
        </div>
        <table class="table table-bordered" id="feedbackTable"> {{-- add ID to the table--}}
            <thead>
                <tr>
                    <th>{{ __('messages.courses.cert.instructor') }} ({{ __('messages.courses.settings.name') }})</th>
                    <th>{{ __('messages.courses.courses_breadcrumb') }}</th>
                    <th>{{ __('messages.courses.feedback.overall_rating') }}</th>
                    <th>{{ __('messages.admin.system_clarity') ?? 'Clarity' }}</th>
                    <th>{{ __('messages.courses.feedback.q2_importance') }}</th>
                    <th>{{ __('messages.courses.feedback.q4_enjoy') }}</th>
                    <th>{{ __('messages.courses.feedback.q5_improve') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($feedbacks as $feedback)
                <tr>
                    <td>{{ $feedback->user->userName ?? 'N/A' }}</td>
                    <td>{{ $feedback->course->courseName ?? 'N/A' }}</td>
                    <td>
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $feedback->rating)
                                <i class="fas fa-star text-warning"></i>
                            @else
                                <i class="far fa-star text-secondary"></i>
                            @endif
                        @endfor
                    </td>
                    <td>{{ $feedback->clarity }}</td>
                    <td>{{ $feedback->understanding }}</td>
                    <td>{{ $feedback->enjoyed }}</td>
                    <td>{{ $feedback->suggestions }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="text-center mt-4">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-light px-4">{{ __('messages.nav.home') }}</a>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
    $(document).ready(function() {
        if ($('#feedbackTable').length) {
            let table = $('#feedbackTable').DataTable({
                // Add localization for DataTable itself if needed
                "language": {
                    "search": "{{ __('messages.admin.search_placeholder') }}",
                    "zeroRecords": "{{ __('messages.admin.no_data') }}"
                }
            });
            $('#courseFilter').on('change', function() {
                table.column(1).search(this.value).draw();
            });
        }
    });
    </script>
@endpush