@extends('layouts.admin_layout')

@section('content')
    <div class="container">
    <h4>{{ __('messages.admin.edit') }} {{ __('messages.courses.settings.new_password') }}</h4>
    <table class="table table-bordered">
            <thead>
                <tr>
                    <th>{{ __('messages.courses.settings.name') }}</th>
                    <th>{{ __('messages.courses.settings.email') }}</th>
                    <th>{{ __('messages.admin.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($requests as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <button class="btn btn-success">{{ __('messages.admin.edit') }} {{ __('messages.courses.settings.new_password') }}</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection