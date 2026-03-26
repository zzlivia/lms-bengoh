@extends('layouts.admin_layout')

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    <div class="container">
        <h3>Add Questions: {{ $assessment->courseAssTitle }}</h3>
        @if($assessment->questions->count() > 0)
            <div class="mb-4">
                <h5>Existing Questions</h5>
                @foreach($assessment->questions as $q)
                    <div class="card p-3 mb-3">
                        <b>{{ $q->courseAssQs }}</b><br>
                        @if($q->courseAssType == 'MCQ')
                            @foreach($q->options as $index => $opt)
                                {{ chr(65 + $index) }}. {{ $opt->optionText }} <br>
                            @endforeach
                        @endif
                        <div class="mt-2">
                            <!-- edit question button -->
                            <a href="{{ route('admin.assessment.editQuestions', $assessment->courseAssID) }}" 
                            class="btn btn-primary btn-sm">
                                Edit
                            </a>

                            <!-- delete question button -->
                            <form action="{{ route('admin.assessment.deleteQuestion', $q->assQsID) }}" 
                                method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Delete this question?')">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
                <hr>
            </div>
        @endif
        <form method="POST" action="{{ route('admin.assessment.addQs.storeQs') }}">
            @csrf
            <input type="hidden" name="courseAssID" value="{{ $assessment->courseAssID }}">
            <div id="questions-container">
                <!-- question block -->
                <div class="question-block border p-3 mb-3">
                    <!-- question text -->
                    <label>Question</label>
                    <input type="text" name="questions[0][text]" class="form-control mb-2" required>

                    <!-- type of question -->
                    <label>Question Type</label>
                    <select name="questions[0][type]" class="form-control mb-2" onchange="toggleOptions(this)">
                        <option value="MCQ">MCQ</option>
                        <option value="SHORT_ANSWER">Short Answer</option>
                        <option value="LONG_ANSWER">Long Answer</option>
                    </select>

                    <!-- options of MCQS -->
                    <div class="mcq-options">
                        <label>Options (A–D)</label>
                        <input type="text" name="questions[0][options][]" class="form-control mb-1" placeholder="Option A">
                        <input type="text" name="questions[0][options][]" class="form-control mb-1" placeholder="Option B">
                        <input type="text" name="questions[0][options][]" class="form-control mb-1" placeholder="Option C">
                        <input type="text" name="questions[0][options][]" class="form-control mb-1" placeholder="Option D">

                        <label>Correct Answer</label>
                        <select name="questions[0][correct]" class="form-control">
                            <option value="0">A</option>
                            <option value="1">B</option>
                            <option value="2">C</option>
                            <option value="3">D</option>
                        </select>
                    </div>
                </div>
            </div>
            <!-- buttons -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <!-- left -->
                <div>
                    <button type="button" onclick="addQuestion()" class="btn btn-secondary">+ Add Question</button>
                    <button type="submit" class="btn btn-success">Save Questions</button>
                </div>

                <!-- right -->
                <div>
                    <a href="{{ route('admin.course.module.create', ['tab' => 'assessment']) }}" class="btn btn-outline-primary">Back</a>
                </div>
            </div>
        </form>
    </div>

    {{-- JS --}}
    <script>
    let index = 1;

    function addQuestion() {
        let container = document.getElementById('questions-container');

        let html = `
        <div class="question-block border p-3 mb-3">
            <label>Question</label>
            <input type="text" name="questions[${index}][text]" class="form-control mb-2" required>

            <label>Type</label>
            <select name="questions[${index}][type]" class="form-control mb-2" onchange="toggleOptions(this)">
                <option value="MCQ">MCQ</option>
                <option value="SHORT_ANSWER">Short Answer</option>
                <option value="LONG_ANSWER">Long Answer</option>
            </select>

            <div class="mcq-options">
                <input type="text" name="questions[${index}][options][]" class="form-control mb-1" placeholder="Option A">
                <input type="text" name="questions[${index}][options][]" class="form-control mb-1" placeholder="Option B">
                <input type="text" name="questions[${index}][options][]" class="form-control mb-1" placeholder="Option C">
                <input type="text" name="questions[${index}][options][]" class="form-control mb-1" placeholder="Option D">

                <select name="questions[${index}][correct]" class="form-control">
                    <option value="0">A</option>
                    <option value="1">B</option>
                    <option value="2">C</option>
                    <option value="3">D</option>
                </select>
            </div>
        </div>
        `;

        container.insertAdjacentHTML('beforeend', html);
        index++;
    }

    function toggleOptions(select) {
        let block = select.closest('.question-block');
        let options = block.querySelector('.mcq-options');

        if (select.value === 'MCQ') {
            options.style.display = 'block';
        } else {
            options.style.display = 'none';
        }
    }
    </script>

@endsection