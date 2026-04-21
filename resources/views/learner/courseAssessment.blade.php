@extends('layouts.open_layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/course-sidebar.css') }}">
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        @include('partials.course-sidebar', ['course' => $course])
        <!-- Main Content -->
        <div class="col-md-9 p-4">
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            @if(session('info'))
                <div class="alert alert-info">
                    {{ session('info') }}
                </div>
            @endif
            <div class="text-center mb-4">
                <button class="btn btn-light shadow-sm px-4">{{ __('messages.courses.learn_history') }}</button>
            </div>
            <h6 class="text-center mb-4">
                {{ __('messages.courses.assessment_title', ['id' => $assessment->courseAssID,, 'name' => $assessment->getTranslation('courseAssTitle')]) }}
            </h6>
            @auth
            <div class="card p-4 shadow-sm">
                <p>
                    <b>{{ __('messages.courses.assessment_purpose_label') }}</b><br>
                    {{ $assessment->getTranslation('courseAssDesc') }}
                </p>
                <hr>
                <form id="assessmentForm" method="POST" action="{{ route('final.assessment.submit', $course->courseID) }}">
                    @csrf
                    <input type="hidden" name="courseAssID" value="{{ $assessment->courseAssID }}">
                    <input type="hidden" name="courseID" value="{{ $course->courseID }}">
                    <input type="hidden" name="score" value="80">
                    @foreach($questions as $index => $q)
                        <p><b>{{ __('messages.courses.question') }} {{ $index+1 }}</b><br>
                        {{ $q->getTranslation('courseAssQs') }}</p>
                        @if($q->courseAssType == 'MCQ')
                            @foreach($q->options as $opt)
                                <input type="radio"
                                    name="answers[{{ $q->assQsID }}]"
                                    value="{{ $opt->id }}">
                                {{ $opt->getTranslation('optionText') }} <br>
                            @endforeach
                        @else
                            <textarea name="answers[{{ $q->assQsID }}]" class="form-control mb-3"></textarea>
                        @endif
                    @endforeach
                    <!-- button that trigger modal -->
                    <button type="button" class="btn btn-success"
                        data-bs-toggle="modal"
                        data-bs-target="#confirmSubmitModal">
                        {{ __('messages.courses.submit') }}
                    </button>
                    <!-- modal inside form -->
                    <div class="modal fade" id="confirmSubmitModal" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">{{ __('messages.courses.confirm_submission') }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    {{ __('messages.courses.confirm_prompt') }}<br>
                                    {{ __('messages.courses.check_answers_prompt') }}
                                    <div id="warningText" class="text-danger mt-2"></div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('messages.courses.cancel') }}</button>
                                    <!-- submit -->
                                    <button type="button" class="btn btn-success" id="confirmSubmitBtn">{{ __('messages.courses.yes_submit') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            @endauth

            @guest
            <div class="card p-5 shadow-sm text-center">
                <div style="font-size:40px;">🔒</div>
                <p class="mt-3">{{ __('messages.courses.login_required') }}</p>
                <a href="{{ route('login') }}" class="btn btn-primary mt-2">{{ __('messages.courses.login') }}</a>
                <a href="{{ route('register') }}" class="btn btn-outline-secondary mt-2">{{ __('messages.courses.register') }}</a>
            </div>
            @endguest
        </div>
    </div>
</div>

    <!-- SCRIPT -->
    <script>
        document.getElementById('confirmSubmitBtn').addEventListener('click', function () {
            document.getElementById('assessmentForm').submit();
        });
    </script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const triggerBtn = document.querySelector('[data-bs-target="#confirmSubmitModal"]');
        const warningLabel = "{{ __('messages.courses.unanswered_warning') }}";
        triggerBtn.addEventListener('click', function () {
            let unanswered = 0;
            document.querySelectorAll('textarea').forEach(el => {
                if (el.value.trim() === '') unanswered++;
            });
            let grouped = {};
            document.querySelectorAll('input[type=radio]').forEach(el => {
                if (!grouped[el.name]) grouped[el.name] = false;
                if (el.checked) grouped[el.name] = true;
            });
            for (let key in grouped) {
                if (!grouped[key]) unanswered++;
            }
            let warning = document.getElementById('warningText');
            if (unanswered > 0) {
                warning.innerHTML = `⚠️ You have ${unanswered} unanswered question(s).`;
            } else {
                warning.innerHTML = '';
            }
        });

        //force submit form
        document.getElementById('confirmSubmitBtn').addEventListener('click', function () {
            document.getElementById('assessmentForm').submit();
        });

    });
    </script>

@endsection