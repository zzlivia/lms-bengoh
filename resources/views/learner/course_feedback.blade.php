@extends('layouts.open_layout')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/courseFeedback.css') }}">
    {{-- We include startLearning.css to reuse the clean 'learning-content-card' style --}}
    <link rel="stylesheet" href="{{ asset('css/startLearning.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
@endsection

@section('content')
    <div class="container-fluid mt-3">
        <div class="row">
            {{-- Desktop Sidebar: Matches Progress page --}}
            <div class="col-md-3 d-none d-md-block" id="desktopSidebar">
                @include('partials.course-sidebar', ['course' => $course])
            </div>

            {{-- Main Content Column --}}
            <div class="col-12 col-md-9 px-md-4">
                {{-- Mobile Menu Toggle & Breadcrumb: Consistent across all learning pages --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <button class="btn btn-sm btn-outline-primary d-md-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
                        <i class="bi bi-list"></i> {{ __('messages.courses.course_modules') }}
                    </button>
                    
                    <nav aria-label="breadcrumb" class="d-none d-sm-block">
                        <ol class="breadcrumb mb-0 small">
                            <li class="breadcrumb-item"><a href="{{ route('courses.allCourses') }}">{{ __('messages.courses.courses_breadcrumb') }}</a></li>
                            <li class="breadcrumb-item active text-truncate" style="max-width: 200px;">{{ $course->getTranslation('courseName') }}</li>
                            <li class="breadcrumb-item active">{{ __('messages.courses.feedback.title') }}</li>
                        </ol>
                    </nav>
                </div>

                {{-- Main Learning Card: Replaces the standard card for consistency --}}
                <div class="learning-content-card p-4 shadow-sm bg-white rounded border-0">
                    <div class="mb-4">
                        <h4 class="fw-bold mb-1">{{ __('messages.courses.feedback.title') }}</h4>
                        <p class="text-muted small">{{ __('messages.courses.feedback.subtitle') }}</p>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger mb-4 rounded-3">
                            <ul class="mb-0 small">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('course.feedback.submit', $course->courseID) }}" method="POST">
                        @csrf
                        
                        {{-- Overall Rating Section --}}
                        <div class="mb-5 text-center p-4 bg-light rounded-4 border">
                            <label class="form-label fw-bold d-block mb-3 fs-5">{{ __('messages.courses.feedback.overall_rating') }}</label>
                            <div class="star-rating fs-1">
                                @for($i = 5; $i >= 1; $i--)
                                    <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}" required>
                                    <label for="star{{ $i }}"><i class="fas fa-star"></i></label>
                                @endfor
                            </div>
                        </div>

                        {{-- Question 1: Clarity (Star Grid) --}}
                        <div class="mb-5">
                            <h6 class="fw-bold mb-3">1. {{ __('messages.courses.feedback.q1_clarity') }}</h6>
                            <div class="clarity-rating d-flex justify-content-between flex-wrap gap-2">
                                @php $clarityOptions = ['Poor', 'Average', 'Good', 'Excellent']; @endphp
                                @foreach($clarityOptions as $key => $opt)
                                    <input type="radio" name="clarity" id="clarity{{$key+1}}" value="{{$opt}}" required>
                                    <label for="clarity{{$key+1}}" class="{{strtolower($opt)}} flex-fill text-center p-3 border rounded-3 pointer shadow-sm transition">
                                        <div class="stars mb-1">
                                            @for($s=0; $s<=$key; $s++) <i class="fas fa-star text-warning"></i> @endfor
                                        </div>
                                        <span class="fw-bold small">{{ __('messages.courses.feedback.' . strtolower($opt)) }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Question 2: Importance (Button Group) --}}
                        <div class="mb-5">
                            <h6 class="fw-bold mb-3">2. {{ __('messages.courses.feedback.q2_importance') }}</h6>
                            <div class="d-flex flex-column flex-sm-row gap-3">
                                @foreach(['Yes', 'Somewhat', 'Not really'] as $ans)
                                    <div class="flex-fill">
                                        <input class="btn-check" type="radio" name="understanding" id="und{{$loop->index}}" value="{{$ans}}" required>
                                        <label class="btn btn-outline-success w-100 py-2 rounded-3 fw-semibold" for="und{{$loop->index}}">
                                            {{ __('messages.courses.feedback.' . Str::snake(strtolower($ans))) }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Question 3: Favorite Module (Dropdown) --}}
                        <div class="mb-4">
                            <h6 class="fw-bold mb-2">3. {{ __('messages.courses.feedback.q3_module') }}</h6>
                            <select name="favorite_module" class="form-select rounded-3 p-2 shadow-sm">
                                <option value="">{{ __('messages.courses.feedback.select_module') }}</option>
                                @foreach($course->modules as $module)
                                    <option value="{{ $module->moduleID }}">
                                        {{ __('messages.courses.module') }} {{ $loop->iteration }}: {{ $module->getTranslation('moduleName') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Question 4: Enjoyed (Textarea) --}}
                        <div class="mb-4">
                            <h6 class="fw-bold mb-2">4. {{ __('messages.courses.feedback.q4_enjoy') }}</h6>
                            <textarea name="enjoyed" class="form-control rounded-3 shadow-sm" rows="3" placeholder="What did you like most?"></textarea>
                        </div>

                        {{-- Question 5: Suggestions (Textarea) --}}
                        <div class="mb-4">
                            <h6 class="fw-bold mb-2">5. {{ __('messages.courses.feedback.q5_improve') }}</h6>
                            <textarea name="suggestions" class="form-control rounded-3 shadow-sm" rows="3" placeholder="How can we improve?"></textarea>
                        </div>

                        {{-- Submit Button: Styled to match 'Download Certificate' button --}}
                        <div class="text-center mt-5">
                            <button type="submit" class="btn btn-success px-5 py-3 fw-bold shadow rounded-pill w-100 w-sm-auto">
                                <i class="bi bi-send-check me-2"></i> {{ __('messages.courses.feedback.feedback_submit') }}
                            </button>
                        </div>
                    </form>
                </div>
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