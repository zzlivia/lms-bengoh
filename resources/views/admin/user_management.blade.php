@extends('layouts.admin_layout')

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
        <input type="text" name="search" class="form-control w-50" placeholder="Search User">
        <div>
            <button type="button" class="btn btn-danger">Remove User</button>
        </div>
    </form>

    {{-- display list of user --}}
    <div class="card-box">
        {{-- display alert message --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <table id="userTable" class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email Address</th>
                    <th>Engagement</th>
                    <th>Rank</th>
                    <th>Completed Courses</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @if($users->count() > 0)
                @foreach($users as $user)
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
                        <td>
                            <form action="{{ route('admin.user.delete', $user->userID) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6" class="text-center">No users found</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>

    <div class="text-center mt-5">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Home</a>
    </div>
@endsection