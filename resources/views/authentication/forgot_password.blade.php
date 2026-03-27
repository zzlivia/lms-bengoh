@extends('layouts.open_layout')

@section('title', 'Forgot Password - Bengoh Academy')

@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/forgotPass.css') }}">
@endsection

@section('content')
    <div class="login-card shadow text-center p-4">
        <h3 class="mb-3 fw-bold title">Forgot your password?</h3>
        <p class="text-muted small mb-4">
            Enter your email or phone and we’ll send you a reset link
        </p>

        @if(session('success'))
            <div class="alert alert-success small">{{ session('success') }}</div>
        @endif

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

            <div class="mb-3 text-start input-group-custom">
                <label class="form-label small fw-semibold">Email or Phone Number</label>
                <input type="text"
                    name="login"
                    class="form-control modern-input"
                    placeholder="Enter your email or phone"
                    required>
            </div>

            <button type="submit" class="btn btn-modern w-100">
                Send Reset Link
            </button>
        </form>

        <div class="mt-4 small">
            <a href="{{ route('login') }}" class="back-link">← Back to Sign In</a>
        </div>
        
        {{-- Image --}}
        <div class="forgot-image-wrapper text-center">
            <img src="{{ asset('images/forgotten-authentication.png') }}"
                class="img-fluid forgot-image">
        </div>
    </div>
@endsection