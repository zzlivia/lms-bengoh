@extends('layouts.admin_layout')

@section('content')
    <div class="container">
    <h4>Course Feedback</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Course</th>
                    <th>Feedback</th>
                </tr>
            </thead>
            <tbody>
                @foreach($feedbacks as $feedback)
                <tr>
                    <td>{{ $feedback->user->name ?? 'N/A' }}</td>
                    <td>{{ $feedback->course->title ?? 'N/A' }}</td>
                    <td>{{ $feedback->rating }}</td>
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