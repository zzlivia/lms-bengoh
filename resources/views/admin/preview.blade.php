@extends('layouts.admin_layout') {{-- preview MCQ  --}}

@section('content')
<div class="container">
    <div class="mb-3">
        <a href="{{ url()->previous() }}" class="btn btn-secondary">← {{ __('messages.admin.back') }}</a>
    </div>
    <h3>{{ __('messages.admin.view') }} {{ __('messages.admin.type_mcq') }}</h3>
    @foreach($questions as $q)
        <div class="card mb-3 p-3">
            <h5>
                {{ __('messages.courses.question') }} {{ $loop->iteration }}.
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
                <div class="form-check">
                    <input type="radio" class="form-check-input" disabled 
                        {{ $q->correct_answer == ($index + 1) ? 'checked' : '' }}>
                    <label class="form-check-label">
                        {{ $option }}
                        @if($q->correct_answer == ($index + 1))
                            <span class="badge bg-success ms-2">
                                {{ __('messages.courses.correct_answer') }}
                            </span>
                        @endif
                    </label>
                </div>
            @endforeach
        </div>
    @endforeach
</div>
@endsection