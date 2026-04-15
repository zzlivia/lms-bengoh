@extends('layouts.open_layout')

@section('title', 'Change Password - Bengoh Academy')

@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/forgotPass.css') }}">
@endsection

@section('content')
    <div class="login-card shadow text-center p-4">

        <h3 class="mb-3 fw-bold title">Change Your Password</h3>
        <p class="text-muted small mb-4">
            Enter your new password below
        </p>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="alert alert-success small">{{ session('success') }}</div>
        @endif

        {{-- Errors --}}
        @if($errors->any())
            <div class="alert alert-danger small">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            {{-- New Password --}}
            <div class="mb-3 text-start input-group-custom position-relative">
                <label class="form-label small fw-semibold">New Password</label>
                
                <input type="password"
                    name="password"
                    id="password"
                    class="form-control modern-input pe-5"
                    placeholder="Enter new password"
                    required>

                <i class="bi bi-eye-slash toggle-password"
                    toggle="#password"></i>
            </div>

            {{-- Confirm Password --}}
            <div class="mb-3 text-start input-group-custom position-relative">
                <label class="form-label small fw-semibold">Confirm Password</label>
                
                <input type="password"
                    name="password_confirmation"
                    id="password_confirmation"
                    class="form-control modern-input pe-5"
                    placeholder="Confirm your password"
                    required>

                <i class="bi bi-eye-slash toggle-password"
                    toggle="#password_confirmation"></i>
            </div>

            <button type="submit" class="btn btn-modern w-100">
                Update Password
            </button>
        </form>

        {{-- Back --}}
        <div class="mt-4 small">
            <a href="{{ route('login') }}" class="back-link">← Back to Sign In</a>
        </div>
    </div>

    <script>
        document.querySelectorAll('.toggle-password').forEach(icon => {
            icon.addEventListener('click', function () {
                const input = document.querySelector(this.getAttribute('toggle'));

                if (input.type === "password") {
                    input.type = "text";
                    this.classList.remove("bi-eye-slash");
                    this.classList.add("bi-eye");
                } else {
                    input.type = "password";
                    this.classList.remove("bi-eye");
                    this.classList.add("bi-eye-slash");
                }
            });
        });
    </script>
@endsection