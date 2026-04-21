@extends('layouts.admin_layout')

@section('content')
<div class="container">
    <h3>{{ $assessment->courseAssTitle }}</h3>

    @foreach($assessment->questions as $q)
        <div class="card p-3 mb-3">
            <b>{{ $q->courseAssQs }}</b><br>

            @if($q->courseAssType == 'MCQ')
                @foreach($q->options as $index => $opt)
                    {{ chr(65 + $index) }}. {{ $opt->optionText }} <br>
                @endforeach

                <small class="text-success">
                    {{ __('messages.admin.correct_answer_label') }}:
                    {{ chr(65 + $q->options->search(fn($o) => $o->is_correct)) }}
                </small>
            @endif
        </div>
    @endforeach
</div>
@endsection