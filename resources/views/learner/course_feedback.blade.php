@extends('layouts.open_layout')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/courseFeedback.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <!-- sidebar -->
        @include('partials.course-sidebar', ['course' => $course])
       <!-- main content -->
        <div class="col-md-9">
            <div class="text-center mb-4">
                <h5 class="fw-semibold">{{ __('messages.feedback.title') }}</h5>
                <p class="text-muted small">{{ __('messages.feedback.subtitle') }}</p>
            </div>

            <form action="{{ route('course.feedback.submit', $course->courseID) }}" method="POST">
                @csrf
                <div class="card shadow-sm border-0 p-4">
                    <div class="mb-4">
                        <label class="form-label fw-semibold">{{ __('messages.feedback.overall_rating') }}</label>
                        <div class="star-rating">
                            @for($i = 5; $i >= 1; $i--)
                                <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}" required>
                                <label for="star{{ $i }}"><i class="fas fa-star"></i></label>
                            @endfor
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">1. {{ __('messages.feedback.q1_clarity') }}</label>
                        <div class="clarity-rating">
                            <!-- Poor -->
                            <input type="radio" name="clarity" id="clarity1" value="Poor" required>
                            <label for="clarity1" class="poor">
                                <div class="stars"><i class="fas fa-star"></i></div>
                                <span>{{ __('messages.feedback.poor') }}</span>
                            </label>

                            <!-- Average -->
                            <input type="radio" name="clarity" id="clarity2" value="Average">
                            <label for="clarity2" class="average">
                                <div class="stars"><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                                <span>{{ __('messages.feedback.average') }}</span>
                            </label>

                            <!-- Good -->
                            <input type="radio" name="clarity" id="clarity3" value="Good">
                            <label for="clarity3" class="good">
                                <div class="stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                                <span>{{ __('messages.feedback.good') }}</span>
                            </label>

                            <!-- Excellent -->
                            <input type="radio" name="clarity" id="clarity4" value="Excellent">
                            <label for="clarity4" class="excellent">
                                <div class="stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                                <span>{{ __('messages.feedback.excellent') }}</span>
                            </label>
                        </div>
                    </div>
                    {{-- second question --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">2. {{ __('messages.feedback.q2_importance') }}</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="understanding" value="Yes">
                            <label class="form-check-label">{{ __('messages.feedback.yes') }}</label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="understanding" value="Somewhat">
                            <label class="form-check-label">{{ __('messages.feedback.somewhat') }}</label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="understanding" value="Not really">
                            <label class="form-check-label">{{ __('messages.feedback.not_really') }}</label>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">3. {{ __('messages.feedback.q3_module') }}</label>
                        <select name="favorite_module" class="form-select">
                            <option value="">{{ __('messages.feedback.select_module') }}</option>
                            @foreach($course->modules as $module)
                                <option value="{{ $module->moduleID }}">{{ __('messages.courses.module') }} {{ $loop->iteration }} - {{ $module->moduleName }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">4. {{ __('messages.feedback.q4_enjoy') }}</label>
                        <textarea name="enjoyed" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">5. {{ __('messages.feedback.q5_improve') }}</label>
                        <textarea name="suggestions" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-success px-4">{{ __('messages.courses.submit') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection