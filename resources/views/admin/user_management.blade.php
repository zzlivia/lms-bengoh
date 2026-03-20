@extends('layouts.admin')

@section('content')

<h4 class="fw-bold mb-4">Summary</h4>
<div class="row mb-4 justify-content-center">
    <div class="col-md-4">
        <div class="card-box text-center">
            <h6>Total Users</h6>
            <h2>{{ $totalUsers }}</h2>
            <small>Registered users</small>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-box text-center">
            <h6>New Users</h6>
            <h2>{{ $newUsers }}</h2>
            <small>Joined this week</small>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-box text-center">
            <h6>Active Users</h6>
            <h2>{{ $activeUsers }}</h2>
            <small>Active this week</small>
        </div>
    </div>
</div>


{{-- search, add, remove actions --}}
<form method="GET" action="{{ route('admin.user.management') }}" 
      class="d-flex justify-content-between align-items-center mb-3">
    <input type="text" name="search" class="form-control w-50"
           placeholder="Search User">
    <div>
        <button class="btn btn-primary">Search</button>
        <button type="button" class="btn btn-danger">Remove User</button>
    </div>
</form>


{{-- User Table --}}
<div class="card-box">
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email Address</th>
                <th>Engagement</th>
                <th>Rank</th>
                <th>Completed Courses</th>
            </tr>
        </thead>
        <tbody>
        @forelse($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->engagement }}</td>
                <td>
                    @if($user->completedCourses >= 10)
                        Expert
                    @elseif($user->completedCourses >= 5)
                        Intermediate
                    @else
                        Beginner
                    @endif
                </td>
                <td>{{ $user->completedCourses }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center">No users found</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>


<div class="text-center mt-5">
    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
        Home
    </a>
</div>

@endsection