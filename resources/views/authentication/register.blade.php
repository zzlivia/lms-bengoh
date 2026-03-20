@extends('layouts.open_layout')

@section('title', 'Register - Bengoh Academy')

@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<div class="register-wrapper">
    <div class="registration-container text-center px-3">
        <h3 class="mb-4 fw-bold">Register</h3>
        {{-- validatuon --}}
        @if($errors->any())
            <div class="alert alert-danger text-start">
                <ul class="mb-0 small">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('register.submit') }}" autocomplete="off"> {{--{{ route('register') }}--}}
            @csrf
            {{-- name --}}
            <input type="text" name="name" class="form-control mb-3" placeholder="Enter your full name" value="{{ old('name') }}" required>
            {{-- email --}}
            <input type="email" name="email" class="form-control mb-3" placeholder="Enter your email" value="{{ old('email') }}" required>
            {{-- password first enter --}}
            <div class="password-container mb-3"> 
                <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required autocomplete="new-password">
                <i class="bi bi-eye-slash toggle-password" id="togglePassword"></i>
            </div>
            {{-- password re-enter --}}
            <div class="password-container mb-3">
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Re-enter your password" required autocomplete="new-password">
                <i class="bi bi-eye-slash toggle-password" id="toggleConfirmPassword"></i>
            </div>
            {{-- checkbox if the user is an admin --}}
            <div class="mb-3 d-flex justify-content-center">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="isAdminCheck" name="is_admin" value="1">
                    <label class="form-check-label" for="isAdminCheck">Are you an admin?</label>
                </div>
            </div>
            {{-- dropdown role --}}
            <div id="admin-role-section" class="mb-4" style="{{ old('is_admin') ? 'display:block' : 'display:none' }}">
                <label class="form-label d-block text-start px-2 small fw-bold">Select Admin Role:</label>
                <select name="role" class="form-select">
                    <option value="admin">Admin</option>
                </select>
            </div>
            {{-- button --}}
            <button type="submit" class="btn btn-register w-100 shadow-sm">REGISTER</button>
            
            <div class="mt-4">
                <p class="text-muted small">Already have an account? 
                    <a href="{{ route('login') }}" class="signin-link">Sign in here</a> {{----}}
                </p>
            </div>
        </form>
    </div>
    {{-- path to point to public/images/ --}}
    <img src="{{ asset('images/registration-authentication.png') }}" alt="Registration Illustration" class="right-peeking-image">
</div>
@endsection

@push('scripts')
    <script>
        // logic- admin
        const adminCheckbox = document.getElementById('isAdminCheck');
        const roleSection = document.getElementById('admin-role-section');
        adminCheckbox.addEventListener('change', function() {
            roleSection.style.display = this.checked ? 'block' : 'none';
        });
        // logic - password visible
        function setupPasswordToggle(toggleId, inputId) {
            const toggle = document.getElementById(toggleId);
            const input = document.getElementById(inputId);
            if(toggle && input) {
                toggle.addEventListener('click', function() {
                    const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                    input.setAttribute('type', type);
                    this.classList.toggle('bi-eye');
                    this.classList.toggle('bi-eye-slash');
                });
            }
        }
        setupPasswordToggle('togglePassword', 'password');
        setupPasswordToggle('toggleConfirmPassword', 'password_confirmation');
    </script>
@endpush