@extends('layouts.admin_layout')

@section('content')
<div class="container">
    <h3><h3>{{ __('messages.admin.edit') }} {{ __('messages.admin.existing_questions') }}: {{ $assessment->courseAssTitle }}</h3></h3>
    <form method="POST" action="{{ route('admin.assessment.updateQuestions') }}">
        @csrf
        @foreach($assessment->questions as $qIndex => $q)
            <div class="card p-3 mb-3">
                <input type="hidden" name="questions[{{ $qIndex }}][id]" value="{{ $q->assQsID }}">
                <label>{{ __('messages.admin.question_num') }} {{ $qIndex + 1 }}</label>
                <input type="text" name="questions[{{ $qIndex }}][text]" value="{{ $q->courseAssQs }}" class="form-control mb-2">
                @if($q->courseAssType == 'MCQ')
                    @foreach($q->options as $oIndex => $opt)
                        <input type="text" 
                               name="questions[{{ $qIndex }}][options][{{ $oIndex }}]" 
                               value="{{ $opt->optionText }}" 
                               class="form-control mb-1">
                        <input type="radio" 
                               name="questions[{{ $qIndex }}][correct]" 
                               value="{{ $oIndex }}"
                               {{ $opt->is_correct ? 'checked' : '' }}>
                        Correct
                        <br>
                    @endforeach
                @endif
            </div>
        @endforeach
        <button class="btn btn-success">{{ __('messages.admin.save_questions') }}</button>
    </form>
</div>
@endsection