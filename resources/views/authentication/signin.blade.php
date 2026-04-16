@extends('layouts.open_layout')

@section('title', 'Sign In - Bengoh Academy')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/signin.css') }}">
@endsection

@section('content')
    <div class="login-section">
        {{-- path to point to public/images/ of illustration--}}
        <img src="{{ asset('images/sign-in-authentication.png') }}" class="left-peeking-image d-none d-lg-block">

        <div class="container d-flex justify-content-center align-items-center min-vh-75">
            <div class="login-card shadow-sm">
                <h3 class="mb-4 fw-bold text-center">Sign In</h3>

                {{-- success messages --}}
                @if(session('success'))
                    <div class="alert alert-success small">{{ session('success') }}</div>
                @endif
                {{-- error messages --}}
                @if($errors->any())
                    <div class="alert alert-danger small">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" autocomplete="off"> {{--{{ route('login') }}--}}
                    @csrf
                    <!-- fake fields -->
                    <input type="text" name="fake_username" style="display:none">
                    <input type="password" name="fake_password" style="display:none">
                    <div class="mb-3"> {{-- email input --}}
                        <label class="form-label small fw-bold">Email Address</label>
                        <input type="email"
                            name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            placeholder="name@example.com"
                            value="" {{--remove {{ old('email') }}--}}
                            autocomplete="off"
                            required>
                    </div>
                    <div class="mb-2">{{--password input--}}
                        <label class="form-label small fw-bold">Password</label>
                        <div class="input-group">
                            <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="••••••••"
                                 autocomplete="off" required>
                            <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                                <i class="bi bi-eye"></i>
                            </span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4 small">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label" for="remember">Remember me</label>
                        </div>
                        <a href="{{ route('password.request') }}" class="text-decoration-none">Forgot Password?</a>
                    </div>
                    <button type="submit" class="btn btn-login w-100 py-2 fw-bold">SIGN IN</button>
                </form>

                <div class="mt-4 text-center small-link">
                    <p class="text-muted mb-1">OR</p>
                    <a href="{{ route('register') }}" class="text-decoration-none fw-bold">Register my account</a> {{--{{ route('register') }}--}}
                </div>
            </div>
        </div>
    </div>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        const icon = togglePassword.querySelector('i');

        togglePassword.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            // Toggle icon
            icon.classList.toggle('bi-eye');
            icon.classList.toggle('bi-eye-slash');
        });
    </script>
@endsection