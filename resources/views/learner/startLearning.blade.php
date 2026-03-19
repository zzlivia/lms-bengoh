@extends('layouts.open_layout')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/startLearning.css') }}">
@endsection

@section('content')
    <div class="container-fluid mt-3">
        <div class="row">
            @include('partials.course-sidebar')
            <div class="col-md-9 px-md-4">
                <div class="learning-content-card p-4 shadow-sm bg-white rounded">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb small">
                            <li class="breadcrumb-item"><a href="#">Courses</a></li> {{-- {{ route('courses.index') }} --}}
                            <li class="breadcrumb-item active">{{ $course->courseTitle }}</li>
                        </ol>
                    </nav>

                    <h3 class="fw-bold mb-4">{{ $course->courseTitle }}</h3>
                    {{-- content loading --}}
                    @if($section)
                        <div class="section-header mb-3">
                            <h5 class="text-primary fw-bold">{{ $section->section_title }}</h5>
                        </div>

                        {{-- video section if any --}}
                        @if($section->section_type == 'video')
                            <div class="video-container mb-4">
                                {{-- replace later with video --}}
                                <div class="ratio ratio-16x9 bg-dark d-flex align-items-center justify-content-center rounded">
                                    <span class="text-white"><i class="fa fa-play-circle fa-3x"></i></span>
                                </div>
                            </div>
                        @endif

                        {{-- section --}}
                        @if($section->section_type == 'text')
                            <div class="text-content mb-4 lead-custom">
                                {!! nl2br(e($section->section_content)) !!}
                            </div>
                        @endif

                        {{-- section --}}
                        @if($section->section_type == 'pdf')
                            <div class="pdf-container mb-4">
                                {{-- path to point to public/learning-materials/ --}}
                                <iframe src="{{ asset('learning-materials/' . $section->section_file) }}#toolbar=0" 
                                        width="100%" 
                                        height="600px" 
                                        class="rounded border">
                                </iframe>
                            </div>
                        @endif
                    @else
                        <div class="alert alert-info">
                            Please select a lecture from the sidebar to begin.
                        </div>
                    @endif

                    <div class="d-flex justify-content-between mt-5 pt-3 border-top">
                        <button class="btn btn-outline-secondary btn-nav px-4">
                            <i class="fa fa-chevron-left me-2"></i> Previous
                        </button>
                        <button class="btn btn-primary btn-nav px-4">
                            Next <i class="fa fa-chevron-right ms-2"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection