@extends('layouts.admin_layout')

@section('content')
    <h4 class="fw-bold mb-4">{{ __('messages.admin.summary') }}</h4>
    
    {{-- Summary Cards --}}
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
                <h6>{{ __('messages.admin.active_users') }}</h6>
                <h2>{{ $activeUsers }}</h2>
                <small>{{ __('messages.admin.active_week') }}</small>
            </div>
        </div>
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Bulk Delete Form Wraps the Actions and the Table --}}
    <form id="bulkDeleteForm" method="POST" action="{{ route('admin.user.bulkDelete') }}" onsubmit="return confirm('Are you sure you want to delete the selected users?');">
        @csrf
        @method('DELETE')

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="w-50">
                {{-- This input works with DataTables automatically if you use the built-in search --}}
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
                        <th><input type="checkbox" id="selectAll"></th>
                        <th>{{ __('messages.admin_settings.name') }}</th>
                        <th>{{ __('messages.admin_settings.email') }}</th>
                        <th>{{ __('messages.admin.engagement') }}</th>
                        <th>{{ __('messages.admin.rank') }}</th>
                        <th>{{ __('messages.admin.completed_courses_col') }}</th>
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
                        <td>{{ $user->completedCourses }}</td>
                        <td>
                            {{-- Triggers the JS function below --}}
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

    {{-- Hidden form for individual delete requests --}}
    <form id="singleDeleteForm" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>

    <div class="text-center mt-5">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">{{ __('messages.nav.home') }}</a>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            var table = $('#userTable').DataTable({
                "dom": 'lrtip' // Hides the default search box so we can use our custom one
            });

            // Connect custom search input to DataTable
            $('#customSearch').on('keyup', function() {
                table.search(this.value).draw();
            });

            // Select All logic
            $('#selectAll').on('click', function() {
                $('.user-checkbox').prop('checked', this.checked);
            });
        });

        // Individual delete function
        function confirmSingleDelete(userId) {
            if (confirm('Are you sure you want to delete this user?')) {
                var form = $('#singleDeleteForm');
                // Dynamically set the action URL using the route name
                var url = "{{ route('admin.user.delete', ':id') }}";
                url = url.replace(':id', userId);
                
                form.attr('action', url);
                form.submit();
            }
        }
    </script>
    @endpush

    @push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize DataTable with Bootstrap 5 styling compatibility
            var table = $('#userTable').DataTable({
                "dom": 'lrtip', // Keeps your custom search setup
                "pagingType": "full_numbers", // Optional: provides more navigation options
                "language": {
                    "paginate": {
                        "previous": "«",
                        "next": "»"
                    }
                }
            });

            // Connect custom search input
            $('#customSearch').on('keyup', function() {
                table.search(this.value).draw();
            });

            // Select All logic
            $('#selectAll').on('click', function() {
                $('.user-checkbox').prop('checked', this.checked);
            });
        });

        function confirmSingleDelete(userId) {
            if (confirm('Are you sure you want to delete this user?')) {
                var form = $('#singleDeleteForm');
                var url = "{{ route('admin.user.delete', ':id') }}";
                url = url.replace(':id', userId);
                form.attr('action', url);
                form.submit();
            }
        }
    </script>
    @endpush
@endsection