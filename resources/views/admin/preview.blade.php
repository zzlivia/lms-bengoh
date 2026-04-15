@extends('layouts.admin_layout') {{-- preview MCQ  --}}

@section('content')
<div class="container">
    <div class="mb-3">
        <a href="{{ url()->previous() }}" class="btn btn-secondary">
            ← Back
        </a>
    </div>
    <h3>MCQ Preview</h3>
    @foreach($questions as $q)
        <div class="card mb-3 p-3">
            <h5>
                {{ $loop->iteration }}.
                {{ $q->question ?? $q->moduleQs }}
            </h5>

            @php
                $options = [
                    $q->answer1,
                    $q->answer2,
                    $q->answer3,
                    $q->answer4
                ];
            @endphp

            @foreach($options as $index => $option)
                <div>
                    <input type="radio" disabled 
                        {{ $q->correct_answer == $index ? 'checked' : '' }}>
                    {{ $option }}
                </div>
            @endforeach
        </div>
    @endforeach
</div>
@endsection