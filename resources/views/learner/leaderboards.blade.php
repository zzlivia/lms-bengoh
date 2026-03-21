@extends('layouts.learner')

<link rel="stylesheet" href="{{ asset('css/leaderboards.css') }}">

@section('content')

<div class="container mt-4">

<div class="text-center mb-4">
    <div class="progress-title">Leaderboards</div>
</div>

<div class="card leaderboard-card p-4">

<h5 class="text-center mb-4">
Current Top Learners of Bengoh Academy
</h5>

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

@foreach($learners as $index => $learner)

<tr>

<td>{{ $index + 1 }}</td>

<td>{{ $learner->name }}</td>

<td>{{ $learner->completed_courses }}/4</td>

<td>

@if($learner->completed_courses >= 4)
🏆
@elseif($learner->completed_courses == 3)
⭐
@elseif($learner->completed_courses == 2)
🥈
@else
🎓
@endif

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

</div>

@endsection