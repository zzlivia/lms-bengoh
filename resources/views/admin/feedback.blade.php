@extends('layouts.admin')

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
<td>{{ $feedback->userID }}</td>
<td>{{ $feedback->courseID }}</td>
<td>{{ $feedback->feedback }}</td>
</tr>
@endforeach
</tbody>

</table>

</div>

@endsection