@extends('layouts.admin_layout')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4">{{ __('messages.admin.edit') }} {{ __('messages.admin.type_mcq') }}</h2>
        <form action="{{ route('admin.mcq.update', $mcq->group_id) }}" method="POST">
            @csrf
            @method('PUT')
            <!-- question -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label"><strong>{{ __('messages.admin.question_num') }}</strong></label>
                        <textarea name="question" class="form-control" rows="3" required>{{ $mcq->question }}</textarea>
                    </div>
                    <!-- answers -->
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
                            <!-- radio for correct answer -->
                            <input type="radio" 
                                name="correct_answer" 
                                value="{{ $key }}"
                                {{ $mcq->correct_answer == $key ? 'checked' : '' }}
                                class="form-check-input me-2">
                            <!-- answer input -->
                            <input type="text" 
                                name="answer{{ $key }}" 
                                value="{{ $answer }}" 
                                class="form-control" 
                                required>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <a href="{{ url()->previous() }}" class="btn btn-secondary">← {{ __('messages.admin.back') }}</a>
                <button type="submit" class="btn btn-success">{{ __('messages.courses.settings.save_changes') }}</button>
            </div>
        </form>
    </div>
@endsection