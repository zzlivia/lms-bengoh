@extends('layouts.open_layout')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/view_allCourse.css') }}">
@endsection

@section('content')
    <div class="mt-4">
        {{-- a form for all filters and search --}}
        <form action="{{ route('courses.allCourses') }}" method="GET" id="filterForm">
            <div class="course-hero mb-5">
                <p class="mb-1 fw-bold">Bengoh Academy</p>
                <h1 class="fw-bold">{{ __('messages.courses.title') }}</h1>
                <div class="search-bar">
                    <i class="fa fa-search search-icon"></i>
                    <input type="text"
                        name="search"
                        class="form-control"
                        placeholder="{{ __('messages.courses.search_placeholder') }}"
                        value="{{ request('search') }}">
                </div>
            </div>

            <div class="row">
                {{-- sidebar --}}
                <div class="col-md-3 filter-section">
                    <div class="sort-box mb-4">
                        <label class="fw-bold mb-2">{{ __('messages.courses.filter') }}</label>
                        <select name="sort" class="form-select" onchange="this.form.submit()"> {{-- remove  --}}
                            <option value="">{{ __('messages.courses.best_match') }}</option>
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>{{ __('messages.courses.latest_added') }}</option>
                            <option value="short" {{ request('sort') == 'short' ? 'selected' : '' }}>{{ __('messages.courses.short_learn') }}</option>
                            <option value="updated" {{ request('sort') == 'updated' ? 'selected' : '' }}>{{ __('messages.courses.recent_update') }}</option>
                        </select>
                    </div>

                    <p class="small text-muted mb-3">{{ __('messages.courses.refine_search') }}</p>
                    {{-- course category--}}
                    <div class="filter-group mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <label class="fw-bold">{{ __('messages.courses.subjects') }}</label>
                            <i class="fa fa-chevron-down small"></i>
                        </div>
                        <select name="category" class="form-select" onchange="this.form.submit()"> {{-- remove  --}}
                            <option value="">{{ __('messages.courses.all_category') }}</option>
                            @foreach($categories as $category)
                            <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                {{ $category }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- course level --}}
                    <div class="mb-3">
                        <label class="fw-bold">{{ __('messages.courses.level') }}</label>
                        <select name="level" class="form-select" onchange="this.form.submit()">  {{-- remove onchange="this.form.submit()" --}}
                            <option value="">{{ __('messages.courses.all_levels') }}</option>
                            @foreach($levels as $level)
                            <option value="{{ $level }}" {{ request('level') == $level ? 'selected' : '' }}>
                                {{ $level }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- course duration --}}
                    <div class="mb-3">
                        <label class="fw-bold">{{ __('messages.courses.duration') }}</label>
                        <select name="duration" class="form-select" onchange="this.form.submit()">  {{-- remove onchange="this.form.submit()" --}}
                            <option value="">{{ __('messages.courses.any_duration') }}</option>
                            @foreach($durations as $duration)
                            <option value="{{ $duration }}" {{ request('duration') == $duration ? 'selected' : '' }}>
                                {{ $duration }} {{ __('messages.courses.weeks') }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- available course list --}}
                <div class="col-md-9">
                    <div class="d-flex justify-content-end align-items-center mb-4">
                        <span class="me-2">{{ __('messages.courses.showing') }}</span>
                            {{-- choose number courses to be displayed per page --}}
                            <select name="per_page" class="form-select form-select-sm w-auto" onchange="this.form.submit()"> {{-- remove onchange="this.form.submit()" --}}
                                <option value="3" {{ request('per_page') == 3 ? 'selected' : '' }}>3</option>
                                <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
                                <option value="8" {{ request('per_page') == 8 ? 'selected' : '' }}>8</option>
                                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                            </select>
                        <span class="ms-2">{{ __('messages.courses.per_page') }}</span>
                    </div>            
                    
                    @forelse($courses as $course)
                    <div class="course-row shadow-sm mb-4">
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                {{-- check through config/filesystems.php, r2 --}}
                                <img src="{{ Storage::disk('r2')->url($course->courseImg) }}" alt="{{ $course->getTranslation('courseName') }}" class="img-fluid rounded">
                            </div>
                            <div class="col-md-8 position-relative">  
                                {{-- audio icon --}}
                                <i class="fa fa-volume-up position-absolute top-0 end-0 mt-2 me-2" style="cursor:pointer"
                                    onclick="readCourseName('{{ $course->getTranslation('courseName') }}')"></i>
                                <h5 class="course-title">{{ $course->getTranslation('courseName') }}</h5>
                                <div class="meta-text mb-2">
                                    <span class="me-3">
                                        {{ $course->courseDuration }} {{ __('messages.courses.weeks') }}
                                    </span>
                                    <span>
                                        {{ $course->courseLevel }}
                                    </span>
                                </div>
                                <p class="small text-muted">
                                    {{ Str::limit($course->getTranslation('courseDesc') ?? 'Course description here.', 180) }}
                                </p>
                                <div class="d-flex justify-content-end gap-2 mt-3">
                                    <a href="{{ route('learn', $course->courseID) }}" 
                                    class="btn btn-outline-dark btn-sm px-4">
                                        {{ __('messages.courses.start_learning') }}
                                    </a>
                                    <a href="{{ route('courses.showCourse', $course->courseID) }}" 
                                    class="btn btn-outline-secondary btn-sm">
                                        {{ __('messages.courses.view_course') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-5">
                        <p>{{ __('messages.courses.no_match_course') }}</p>
                    </div>
                    @endforelse

                    {{-- pagination process --}}
                    <div class="d-flex justify-content-center mt-4">
                        {{ $courses->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        function readCourseName(courseName) {
            //stop any current speech first (optional but recommended)
            window.speechSynthesis.cancel();
            const speech = new SpeechSynthesisUtterance(courseName);
            //optional settings
            speech.lang = 'en-US';   // change if needed
            speech.rate = 1;        // speed (0.5 - 2)
            speech.pitch = 1;       // voice pitch

            window.speechSynthesis.speak(speech);
        }
    </script>
@endsection