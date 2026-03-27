@extends('layouts.open_layout')

@section('title', 'Forgot Password - Bengoh Academy')

@section('content')
    <div class="login-section">
        <div class="container d-flex justify-content-center align-items-center min-vh-75">
            <div class="login-card shadow-sm text-center">
                <h3 class="mb-4 fw-bold">Forgot your password?</h3>
                {{-- success --}}
                @if(session('success'))
                    <div class="alert alert-success small">{{ session('success') }}</div>
                @endif
                {{-- errors --}}
                @if($errors->any())
                    <div class="alert alert-danger small">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form method="POST" action="{{ route('password.sendTemp') }}">
                    @csrf
                    <div class="mb-3 text-start">
                        <label class="form-label small fw-bold">Email or Phone Number</label>
                        <input type="text"
                            name="login"
                            class="form-control"
                            placeholder="Enter your email or phone"
                            required>
                    </div>
                    <button type="submit" class="btn btn-login w-100">SUBMIT</button>
                </form>
                <div class="mt-3 small">
                    <a href="{{ route('login') }}">Back to Sign In</a>
                </div>
            </div>
        </div>
    </div>
@endsection