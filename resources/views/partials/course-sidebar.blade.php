@section('styles')
    <link rel="stylesheet" href="{{ asset('css/course-sidebar.css') }}">
@endsection

<div class="col-md-3 sidebar p-3">
    <h6 class="fw-bold mb-3">Course Modules</h6>
    @foreach($course->modules as $module)
    <div class="mb-3">
        <div class="text-uppercase small text-muted fw-bold">MODULE {{ $loop->iteration }}</div>
        {{-- retrieve modules --}}
        <a href="{{ route('learn', ['id' => $course->getKey()]) }}">
            {{ $module->moduleName }}
        </a>
        {{-- retrieve lectures --}}
        @foreach($module->lectures as $lecture)
            <div class="ms-2 mb-1">○ {{ $lecture->lectName }}</div>
            {{-- display sections --}}
            @foreach($lecture->sections as $section)
                <div class="ms-4 small text-muted">
                    • {{ $section->section_title }}
                </div>
            @endforeach
        @endforeach
        {{-- display mcqs --}}
        @if($module->mcqs && $module->mcqs->count() > 0)
            <div class="ms-2 mt-1">
                <a href="{{ route('mcq.module', $module->moduleID) }}" class="text-decoration-none">
                    ○ MCQs {{ $loop->iteration }}
                </a>
            </div>
        @endif
    </div>
    @endforeach
    {{-- others --}}
    <a class="sidebar-link d-block mb-2" href="{{ route('course.feedback', $course->courseID) }}">Course Feedback</a>
    <a class="sidebar-link d-block mb-2" href="{{ route('course.assessment', $course->courseID) }}">Course Assessment</a>
    <a class="sidebar-link d-block mb-2" href="{{ route('course.progress', $course->courseID) }}">Progress</a>
    <a class="sidebar-link d-block" href="{{ route('leaderboards') }}">Leaderboards</a>
</div>