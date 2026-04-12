@extends('layouts.admin_layout') {{-- preview MCQ  --}}

@section('content')
<div class="container">
    <div class="mb-3">
        <a href="{{ url()->previous() }}" class="btn btn-secondary">
            ← Back
        </a>
    </div>
    <h3>MCQ Preview</h3>

    @foreach($questions as $qID => $answers)
        <div class="card mb-3 p-3">
            <h5>
                {{ $loop->iteration }}. 
                {{-- if AI exist, shows the questions but if not generated, show manual questions instead --}}
                {{ $answers[0]->question ?? $answers[0]->moduleQs }} {{-- either manual question or AI generated question --}}
            </h5>

            @php
                $q = $answers[0];
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