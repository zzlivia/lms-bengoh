@extends('layouts.admin_layout') {{-- preview MCQ  --}}

@section('content')
<div class="container">
    <h3>MCQ Preview</h3>

    @foreach($questions as $qID => $answers)
        <div class="card mb-3 p-3">
            <h5>
                {{ $loop->iteration }}. 
                {{ $answers[0]->moduleQs }}
            </h5>

            @foreach($answers as $ans)
                <div>
                    <input type="radio" disabled 
                        {{ $ans->ansCorrect ? 'checked' : '' }}>
                    {{ $ans->ansID_text }}
                </div>
            @endforeach
        </div>
    @endforeach
</div>
@endsection