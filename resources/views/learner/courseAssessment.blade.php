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
                <button class="btn btn-light shadow-sm px-4">
                    Learn Local History of The Dam
                </button>
            </div>

            <h6 class="text-center mb-4">
                Course Assessment of Module 1: Introduction to the Dam
            </h6>

            @auth
            <div class="card p-4 shadow-sm">

                <p>
                    <b>Assessment Purpose</b><br>
                    This assessment is designed to help learners reflect on what they have learned.
                </p>

                <hr>

                <!-- ✅ FORM START -->
                <form id="assessmentForm" method="POST" action="{{ route('assessment.submit') }}">
                    @csrf

                    <input type="hidden" name="courseAssID" value="{{ $assessment->courseAssID }}">
                    <input type="hidden" name="courseID" value="{{ $course->courseID }}">

                    @foreach($questions as $index => $q)
                        <p><b>Question {{ $index+1 }}</b><br>
                        {{ $q->courseAssQs }}</p>

                        @if($q->courseAssType == 'MCQ')
                            @foreach($q->options as $opt)
                                <input type="radio"
                                    name="answers[{{ $q->assQsID }}]"
                                    value="{{ $opt->id }}">
                                {{ $opt->optionText }} <br>
                            @endforeach
                        @else
                            <textarea name="answers[{{ $q->assQsID }}]" class="form-control mb-3"></textarea>
                        @endif
                    @endforeach

                    <!-- ✅ BUTTON triggers modal -->
                    <button type="button" class="btn btn-success"
                        data-bs-toggle="modal"
                        data-bs-target="#confirmSubmitModal">
                        Submit
                    </button>

                    <!-- ✅ MODAL INSIDE FORM -->
                    <div class="modal fade" id="confirmSubmitModal" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title">Confirm Submission</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    Are you sure you want to submit?<br>
                                    Please double check your answers.

                                    <div id="warningText" class="text-danger mt-2"></div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        Cancel
                                    </button>

                                    <!-- ✅ REAL SUBMIT -->
                                    <button type="button" class="btn btn-success" id="confirmSubmitBtn">
                                        Yes, Submit
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>

                </form>
                <!-- ✅ FORM END -->

            </div>
            @endauth

            @guest
            <div class="card p-5 shadow-sm text-center">
                <div style="font-size:40px;">🔒</div>
                <p class="mt-3">This assessment requires login.</p>
                <a href="{{ route('login') }}" class="btn btn-primary mt-2">Login</a>
                <a href="{{ route('register') }}" class="btn btn-outline-secondary mt-2">Register</a>
            </div>
            @endguest

        </div>
    </div>
</div>

    <!-- ✅ SCRIPT -->
    <script>
    document.addEventListener('DOMContentLoaded', function () {

        const triggerBtn = document.querySelector('[data-bs-target="#confirmSubmitModal"]');

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

        // ✅ FORCE FORM SUBMIT
        document.getElementById('confirmSubmitBtn').addEventListener('click', function () {
            document.getElementById('assessmentForm').submit();
        });

    });
    </script>

@endsection