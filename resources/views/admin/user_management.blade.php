@extends('layouts.admin_layout')

@section('content')
    <h4 class="fw-bold mb-4">{{ __('messages.admin.summary') }}</h4>
    <div class="row mb-4 justify-content-center">
        <div class="col-md-4">
            <div class="card-box text-center">
                <h6>{{ __('messages.admin.total_users') }}</h6>
                <h2>{{ $totalUsers }}</h2>
                <small>{{ __('messages.admin.reg_users_desc') }}</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-box text-center">
                <h6>{{ __('messages.admin.new_users') }}</h6>
                <h2>{{ $newUsers }}</h2>
                <small>{{ __('messages.admin.joined_week') }}</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-box text-center">
                {{-- Fixed the typo: removed the trailing '<' --}}
                <h6>{{ __('messages.admin.active_users') }}</h6>
                <h2>{{ $activeUsers }}</h2>
                <small>{{ __('messages.admin.active_week') }}</small>
            </div>
        </div>
    </div>

    {{-- search actions --}}
    <form method="GET" action="{{ route('admin.user.management') }}" 
        class="d-flex justify-content-between align-items-center mb-3">
        <input type="text" name="search" class="form-control w-50" placeholder="Search User" value="{{ request('search') }}">
        <div>
            {{-- This button is just a label now. Real deletion happens in the table below. --}}
            <button type="button" class="btn btn-outline-danger" disabled>{{ __('messages.admin.remove_user') }}</button>
        </div>
    </form>

    <div class="card-box">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table id="userTable" class="table">
            <thead>
                <tr>
                    <th>{{ __('messages.admin_settings.name') }}</th>
                    <th>{{ __('messages.admin_settings.email') }}</th>
                    <th>{{ __('messages.admin.engagement') }}</th>
                    <th>{{ __('messages.admin.rank') }}</th>
                    <th>{{ __('messages.admin.completed_courses_col') }}</th>
                    <th>{{ __('messages.admin.action') }}</th>
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
                                {{ __('messages.admin.expert') }}
                            @elseif($user->completedCourses >= 5)
                                {{ __('messages.admin.intermediate') }}
                            @else
                                {{ __('messages.admin.beginner') }}
                            @endif
                        </td>
                        <td>{{ $user->completedCourses }}</td>
                        <td>
                            {{-- The $user variable is ONLY available inside this @foreach loop --}}
                            <form action="{{ route('admin.user.delete', $user->userID) }}" method="POST" 
                                  onsubmit="return confirm('Are you sure you want to delete this user?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">{{ __('messages.admin.delete') }}</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6" class="text-center">{{ __('messages.admin.no_users_found') }}</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>

    <div class="text-center mt-5">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">{{ __('messages.nav.home') }}</a>
    </div>
@endsection