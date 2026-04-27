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
    <form id="bulkDeleteForm" method="POST" action="{{ route('admin.user.bulkDelete') }}" onsubmit="return confirm('Are you sure you want to delete the selected users?');">
        @csrf
        @method('DELETE')
        <div class="d-flex justify-content-between align-items-center mb-3">
            {{-- search --}}
            <div class="w-50">
                <input type="text" id="customSearch" class="form-control" placeholder="Search User...">
            </div>
            <div>
                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-trash"></i> {{ __('messages.admin.remove_user') }}
                </button>
            </div>
        </div>
        <div class="card-box">
            <table id="userTable" class="table">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="selectAll"></th> {{-- Select All Checkbox --}}
                        <th>{{ __('messages.admin_settings.name') }}</th>
                        <th>{{ __('messages.admin_settings.email') }}</th>
                        <th>{{ __('messages.admin.engagement') }}</th>
                        <th>{{ __('messages.admin.rank') }}</th>
                        <th>{{ __('messages.admin.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td><input type="checkbox" name="user_ids[]" value="{{ $user->userID }}" class="user-checkbox"></td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->engagement }}</td>
                        <td>
                            @if($user->completedCourses >= 10) {{ __('messages.admin.expert') }}
                            @elseif($user->completedCourses >= 5) {{ __('messages.admin.intermediate') }}
                            @else {{ __('messages.admin.beginner') }}
                            @endif
                        </td>
                        <td>
                            {{-- individual delete button if you want --}}
                            <button type="button" class="btn btn-danger btn-sm" onclick="confirmSingleDelete('{{ $user->userID }}')">
                                {{ __('messages.admin.delete') }}
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </form>

    {{-- hidden form for individual delete --}}
    <form id="singleDeleteForm" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
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

    @push('scripts')
    <script>
        //select all
        document.getElementById('selectAll').onclick = function() {
            var checkboxes = document.getElementsByClassName('user-checkbox');
            for (var checkbox of checkboxes) {
                checkbox.checked = this.checked;
            }
        }

        //individual delete
        function confirmSingleDelete(userId) {
            if (confirm('Are you sure you want to delete this user?')) {
                var form = document.getElementById('singleDeleteForm');
                form.action = '/admin/user/' + userId; // Match your route
                form.submit();
            }
        }
    </script>
    @endpush
@endsection