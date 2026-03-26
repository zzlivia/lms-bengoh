@extends('layouts.open_layout')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/course-sidebar.css') }}">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            @include('partials.course-sidebar')
            <!-- Main Content -->
            <div class="col-md-9 p-4">
                <div class="text-center mb-4">
                    <button class="btn btn-light shadow-sm px-4">
                        Learn Local History of The Dam
                    </button>
                </div>

                <h6 class="text-center mb-4">
                    Course Assessment of Module 1: Introduction to the Dam
                </h6>


                {{-- if user is logged in --}}
                @auth
                    <div class="card p-4 shadow-sm">
                        <p>
                            <b>Assessment Purpose</b><br>
                            This assessment is designed to help learners reflect on what they have learned,
                            share their personal memories or opinions, and demonstrate understanding of the
                            dam's history and importance.
                        </p>
                        <p>
                            <b>Assessment Format</b>
                            <ol>
                                <li>Short Multiple-Choice Questions</li>
                                <li>Simple Short-Answer Questions</li>
                                <li>Reflection & Sharing Activity</li>
                            </ol>
                            Learners may complete the assessment at their own pace.
                        </p>
                        <hr>
                        <form method="POST" action="{{ route('assessment.submit') }}">
                            @csrf

                            <input type="hidden" name="courseAssID" value="{{ $assessment->courseAssID }}">

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

                            <button class="btn btn-success">Submit</button>
                        </form>
                    </div>
                @endauth
                {{-- If user NOT logged in --}}
                @guest
                    <div class="card p-5 shadow-sm text-center">
                        <div style="font-size:40px;">🔒</div>
                        <p class="mt-3">
                            This assessment requires you to register or sign in.
                        </p>
                        <a href="{{ route('login') }}" class="btn btn-primary mt-2">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-outline-secondary mt-2">
                            Register
                        </a>
                    </div>
                @endguest
            </div>
        </div>
    </div>
@endsection