@extends('layouts.open_layout')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/view_allCourse.css') }}">
@endsection

@section('content')
    <div class="mt-4">
        {{-- a form for all filters and search --}}
        <form action="#" method="GET" id="filterForm">
            <div class="course-hero mb-5">
                <p class="mb-1 fw-bold">Bengoh Academy</p>
                <h1 class="fw-bold">Our Courses</h1>

                <div class="search-bar">
                    <i class="fa fa-search search-icon"></i>
                    <input type="text"
                        name="search"
                        class="form-control"
                        placeholder="Search Courses"
                        value="{{ request('search') }}">
                </div>
            </div>

            <div class="row">
                {{-- sidebar --}}
                <div class="col-md-3 filter-section">
                    <div class="sort-box mb-4">
                        <label class="fw-bold mb-2">Sort By</label>
                        <select name="sort" class="form-select" onchange="this.form.submit()"> {{-- remove  --}}
                            <option value="">Best Match</option>
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest Added</option>
                            <option value="short" {{ request('sort') == 'short' ? 'selected' : '' }}>Short Learning</option>
                            <option value="updated" {{ request('sort') == 'updated' ? 'selected' : '' }}>Recently Updated</option>
                        </select>
                    </div>

                    <p class="small text-muted mb-3">Refine your search:</p>
                    {{-- course category--}}
                    <div class="mb-3">
                        <label class="fw-bold">Subjects</label>
                        <select name="category" class="form-select" onchange="this.form.submit()"> {{-- remove  --}}
                            <option value="">All Subjects</option>
                            @foreach($categories as $category)
                            <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                {{ $category }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- course level --}}
                    <div class="mb-3">
                        <label class="fw-bold">Course Level</label>
                        <select name="level" class="form-select" onchange="this.form.submit()">  {{-- remove onchange="this.form.submit()" --}}
                            <option value="">All Levels</option>
                            @foreach($levels as $level)
                            <option value="{{ $level }}" {{ request('level') == $level ? 'selected' : '' }}>
                                {{ $level }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- course duration --}}
                    <div class="mb-3">
                        <label class="fw-bold">Course Duration</label>
                        <select name="duration" class="form-select" onchange="this.form.submit()">  {{-- remove onchange="this.form.submit()" --}}
                            <option value="">Any Duration</option>
                            @foreach($durations as $duration)
                            <option value="{{ $duration }}" {{ request('duration') == $duration ? 'selected' : '' }}>
                                {{ $duration }} Weeks
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- available course list --}}
                <div class="col-md-9">
                    <div class="d-flex justify-content-end align-items-center mb-4">
                        <span class="me-2">Showing</span>
                        {{-- choose number courses to be displayed per page --}}
                        <select name="per_page" class="form-select form-select-sm w-auto" onchange="this.form.submit()"> {{-- remove onchange="this.form.submit()" --}}
                            <option value="3" {{ request('per_page') == 3 ? 'selected' : '' }}>3</option>
                            <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
                            <option value="8" {{ request('per_page') == 8 ? 'selected' : '' }}>8</option>
                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                        </select>
                        <span class="ms-2">Courses Per Page</span>
                    </div>            
                    
                    @forelse($courses as $course)
                    <div class="course-row shadow-sm mb-4">
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                {{-- path to point to public/images/ --}}
                                <img src="{{ asset('images/' . $course->courseImg) }}" 
                                    alt="{{ $course->courseName }}" 
                                    class="img-fluid rounded">
                            </div>
                            <div class="col-md-8">
                                <h5 class="course-title">{{ $course->courseName }}</h5>
                                <div class="meta-text mb-2">
                                    <span class="me-3">{{ $course->duration ?? '2' }} Weeks</span>
                                    <span>{{ $course->level ?? 'Beginner' }}</span>
                                </div>
                                <p class="small text-muted">
                                    {{ Str::limit($course->courseDesc ?? 'Course description here.', 180) }}
                                </p>
                                <div class="d-flex justify-content-end gap-2 mt-3">
                                    <a href="#" class="btn btn-outline-dark btn-sm px-4"> Start Learning </a>
                                    <a href="#" class="btn btn-outline-secondary btn-sm"> View Course </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-5">
                        <p>No courses found matching your search.</p>
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
@endsection