@extends('layouts.admin') {{-- adjust if different --}}

@section('content')
<div class="container mt-4">

    <h2 class="mb-4">Edit MCQ</h2>

    <form action="{{ route('admin.mcq.update', $mcq->group_id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Question -->
        <div class="card mb-4">
            <div class="card-body">

                <div class="mb-3">
                    <label class="form-label"><strong>Question</strong></label>
                    <textarea name="question" class="form-control" rows="3" required>{{ $mcq->question }}</textarea>
                </div>

                <!-- Answers -->
                @php
                    $answers = [
                        1 => $mcq->answer1,
                        2 => $mcq->answer2,
                        3 => $mcq->answer3,
                        4 => $mcq->answer4,
                    ];
                @endphp

                @foreach($answers as $key => $answer)
                    <div class="mb-2 d-flex align-items-center">
                        
                        <!-- Radio for correct answer -->
                        <input type="radio" 
                               name="correct_answer" 
                               value="{{ $key }}"
                               {{ $mcq->correct_answer == $key ? 'checked' : '' }}
                               class="form-check-input me-2">

                        <!-- Answer input -->
                        <input type="text" 
                               name="answer{{ $key }}" 
                               value="{{ $answer }}" 
                               class="form-control" 
                               required>
                    </div>
                @endforeach

            </div>
        </div>

        <!-- Buttons -->
        <div class="d-flex justify-content-between">
            <a href="{{ url()->previous() }}" class="btn btn-secondary">← Back</a>

            <button type="submit" class="btn btn-success">
                Save Changes
            </button>
        </div>

    </form>

</div>
@endsection