<h5>
Multiple Choice Questions of Module {{ $module->moduleID }} :
{{ $module->moduleName }}
</h5>

<form method="POST" action="{{ route('module.submit', $module->moduleID) }}">
@csrf

@foreach($module->mcqs as $index => $question)

<div class="mb-4">

    <strong>{{ $index+1 }}. {{ $question->moduleQs }}</strong>

    @foreach($question->answers as $answer)

        <div class="form-check">
            <input class="form-check-input"
                   type="radio"
                   name="question_{{ $question->moduleQs_ID }}"
                   value="{{ $answer->ansID }}">

            <label class="form-check-label">
                {{ $answer->ansID_text }}
            </label>
        </div>

    @endforeach

</div>

@endforeach

<button class="btn btn-dark">NEXT</button>

</form>