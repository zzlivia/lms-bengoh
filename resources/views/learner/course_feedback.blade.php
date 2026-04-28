@extends('layouts.open_layout')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/courseFeedback.css') }}">
    <link rel="stylesheet" href="{{ asset('css/course-sidebar.css') }}"> {{-- Add this --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
@endsection

@section('content')
<div class="container-fluid mt-3">
    <div class="row">
        {{-- Desktop Sidebar --}}
        <div class="col-md-3 d-none d-md-block" id="desktopSidebar">
            @include('partials.course-sidebar', ['course' => $course])
        </div>

        {{-- Main Content --}}
        <div class="col-12 col-md-9 px-md-4">
            {{-- Mobile Toggle Button --}}
            <button class="btn btn-sm btn-outline-primary d-md-none mb-3 w-100" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
                <i class="bi bi-list"></i> {{ __('messages.courses.course_modules') }}
            </button>

            <div class="text-center mb-4">
                <h5 class="fw-semibold">{{ __('messages.courses.feedback.title') }}</h5>
                <p class="text-muted small">{{ __('messages.courses.feedback.subtitle') }}</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('course.feedback.submit', $course->courseID) }}" method="POST">
                @csrf
                <div class="card shadow-sm border-0 p-4 rounded-4">
                    {{-- Rating and questions remain as they are --}}
                    <div class="mb-4 text-center">
                        <label class="form-label fw-semibold d-block">{{ __('messages.courses.feedback.overall_rating') }}</label>
                        <div class="star-rating">
                            @for($i = 5; $i >= 1; $i--)
                                <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}" required>
                                <label for="star{{ $i }}"><i class="fas fa-star"></i></label>
                            @endfor
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">1. {{ __('messages.courses.feedback.q1_clarity') }}</label>
                        <div class="clarity-rating d-flex justify-content-between flex-wrap gap-2">
                            {{-- Kept your clarity radio inputs as is --}}
                            @php $clarityOptions = ['Poor', 'Average', 'Good', 'Excellent']; @endphp
                            @foreach($clarityOptions as $key => $opt)
                                <input type="radio" name="clarity" id="clarity{{$key+1}}" value="{{$opt}}" required>
                                <label for="clarity{{$key+1}}" class="{{strtolower($opt)}} flex-fill text-center p-2 border rounded pointer">
                                    <div class="stars mb-1">
                                        @for($s=0; $s<=$key; $s++) <i class="fas fa-star"></i> @endfor
                                    </div>
                                    <span class="small">{{ __('messages.courses.feedback.' . strtolower($opt)) }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">2. {{ __('messages.courses.feedback.q2_importance') }}</label>
                        <div class="d-flex gap-3">
                            @foreach(['Yes', 'Somewhat', 'Not really'] as $ans)
                                <div class="form-check border p-2 px-3 rounded flex-fill text-center">
                                    <input class="form-check-input" type="radio" name="understanding" id="und{{$loop->index}}" value="{{$ans}}" required>
                                    <label class="form-check-label w-100" for="und{{$loop->index}}">{{ __('messages.courses.feedback.' . Str::snake(strtolower($ans))) }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">3. {{ __('messages.courses.feedback.q3_module') }}</label>
                        <select name="favorite_module" class="form-select rounded-3">
                            <option value="">{{ __('messages.courses.feedback.select_module') }}</option>
                            @foreach($course->modules as $module)
                                <option value="{{ $module->moduleID }}">Module {{ $loop->iteration }} - {{ $module->moduleName }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">4. {{ __('messages.courses.feedback.q4_enjoy') }}</label>
                        <textarea name="enjoyed" class="form-control rounded-3" rows="3" placeholder="What did you like most?"></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">5. {{ __('messages.courses.feedback.q5_improve') }}</label>
                        <textarea name="suggestions" class="form-control rounded-3" rows="3" placeholder="How can we improve?"></textarea>
                    </div>
                </div>

                <div class="text-end mt-4 pb-5">
                    <button type="submit" class="btn btn-success px-5 py-2 fw-bold shadow-sm rounded-pill">
                        {{ __('messages.courses.feedback.feedback_submit') }} <i class="bi bi-send ms-2"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Mobile Sidebar Drawer --}}
<div class="offcanvas offcanvas-start d-md-none" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title fw-bold" id="mobileSidebarLabel">Course Modules</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-0">
        @include('partials.course-sidebar', ['course' => $course])
    </div>
</div>
@endsection