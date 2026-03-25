@extends('layouts.admin_layout')

@section('content')
    <div class="container">
    <h4>Course Feedback</h4>
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
                    <th>User</th>
                    <th>Course</th>
                    <th>Rating</th>
                    <th>Clarity</th>
                    <th>Understanding</th>
                    <th>Enjoyment</th>
                    <th>Suggestions</th>
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
    </div>
@endsection

@push('scripts')
    <script>
    $(document).ready(function() {
        let table = $('#feedbackTable').DataTable();

        //filter logics
        $('#courseFilter').on('change', function() {
            table.column(1).search(this.value).draw();
        });
    });
    </script>
@endpush