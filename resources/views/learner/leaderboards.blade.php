@extends('layouts.open_layout')

<link rel="stylesheet" href="{{ asset('css/leaderboards.css') }}">

@section('content')
<div class="container mt-4">

    @if(isset($course))
        <div class="row">
            @include('partials.course-sidebar', ['course' => $course])

            <div class="col-md-9">
    @else
        <div class="d-flex justify-content-center">
            <div style="width: 100%; max-width: 900px;">
    @endif

                <div class="text-center mb-4">
                    <div class="progress-title">Leaderboards</div>
                </div>

                <div class="card leaderboard-card p-4">
                    <h5 class="text-center mb-4">Current Top Learners of Bengoh Academy</h5>

                    <table class="table text-center">
                        <thead>
                            <tr>
                                <th>Rank</th>
                                <th>Name</th>
                                <th>Completed Courses</th>
                                <th>Badge Earned</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $rank = 1; @endphp

                            @foreach($learners as $index => $learner)
                                @if($index > 0 && $learner->completed_courses < $learners[$index - 1]->completed_courses)
                                    @php $rank = $index + 1; @endphp
                                @endif

                                <tr class="{{ $index == 0 ? 'table-warning' : '' }}">
                                    <td class="fw-bold">{{ $rank }}</td>
                                    <td>{{ $learner->name }}</td>
                                    <td>{{ $learner->completed_courses }}/{{ $totalCourses ?? 4 }}</td>
                                    <td>
                                        @if($learner->completed_courses >= 4)
                                            <i class="bi bi-trophy-fill text-warning"></i>
                                        @elseif($learner->completed_courses == 3)
                                            <i class="bi bi-star-fill text-warning"></i>
                                        @elseif($learner->completed_courses == 2)
                                            <i class="bi bi-award-fill text-secondary"></i>
                                        @else
                                            <i class="bi bi-mortarboard-fill text-primary"></i>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

    @if(isset($course))
            </div>
        </div>
    @else
            </div>
        </div>
    @endif

</div>
@endsection