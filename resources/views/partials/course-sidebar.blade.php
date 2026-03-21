{{-- sidebar of course, module, progress, assessment, mcqs, and leaderboards --}}
<div class="col-md-3 sidebar p-3">
    <h6 class="fw-bold mb-3">Course Modules</h6>
    @foreach($course->modules as $module)
    <div class="mb-3">
        <div class="text-uppercase small text-muted fw-bold"> MODULE {{ $loop->iteration }} </div>
        <a href="{{ route('courses.startLearn', ['id' => $course->courseID, 'module' => $module->moduleID]) }}" 
            class="fw-semibold mb-2 d-block text-decoration-none">
            {{ $module->moduleName }}
        </a>
        {{-- Lectures --}}
        @foreach($module->lectures as $lecture)
            <div class="ms-2 mb-1">
                ○ {{ $lecture->lectName }}
            </div>
            {{-- show sections --}}
            @foreach($lecture->sections as $section)
                <div class="ms-4 small text-muted">
                    • {{ $section->section_title }}
                </div>
            @endforeach
        @endforeach
    </div>
    @endforeach
    <a class="sidebar-link d-block mb-2" href="{{ route('course.feedback', $course->courseID) }}">Course Feedback</a>
    <a class="sidebar-link d-block mb-2" href="{{ route('course.assessment', $course->courseID) }}">Course Assessment</a>
    <a class="sidebar-link d-block mb-2" href="{{ route('course.progress', $course->courseID) }}">Progress</a>
    <a class="sidebar-link d-block" href="{{ route('leaderboards') }}">Leaderboards</a>
</div>