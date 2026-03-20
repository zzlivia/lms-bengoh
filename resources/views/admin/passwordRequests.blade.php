@extends('layouts.admin')

@section('content')

<div class="container">
<h4>Password Reset Requests</h4>

<table class="table table-bordered">
<thead>
<tr>
<th>Name</th>
<th>Email</th>
<th>Action</th>
</tr>
</thead>

<tbody>
@foreach($requests as $user)
<tr>
<td>{{ $user->name }}</td>
<td>{{ $user->email }}</td>
<td>
<button class="btn btn-success">Reset Password</button>
</td>
</tr>
@endforeach
</tbody>

</table>
</div>

@endsection