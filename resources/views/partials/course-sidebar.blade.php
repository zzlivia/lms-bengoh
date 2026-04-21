@section('styles')
    <link rel="stylesheet" href="{{ asset('css/course-sidebar.css') }}">
@endsection

<div class="col-md-3 sidebar p-3">
    @php //check completion at lecture level
        $completedLectures = DB::table('lectureprogress')
            ->where('userID', auth()->id())
            ->pluck('lectID')
            ->toArray();
    @endphp
    <h6 class="fw-bold mb-3">{{ __('messages.courses.course_modules') }}</h6>
    @foreach($course->modules as $module)
    <div class="mb-3">
        <div class="text-uppercase small text-muted fw-bold">{{ __('messages.courses.module') }} {{ $loop->iteration }}</div>
        {{-- retrieve modules --}}
        @php
            $moduleLectureIds = $module->lectures->pluck('lectID')->toArray();
            $isModuleCompleted = count(array_diff($moduleLectureIds, $completedLectures)) === 0;
        @endphp

        <a href="{{ route('learn', ['id' => $course->getKey()]) }}"class="{{ $isModuleCompleted ? 'text-success fw-bold' : '' }}">
            @if($isModuleCompleted)
                <i class="fa fa-circle text-success me-1"></i>
            @else
                <i class="fa fa-circle text-muted me-1"></i>
            @endif
            {{ $module->getTranslation('moduleName') }}
        </a>
        {{-- retrieve lectures --}}
        @foreach($module->lectures as $lecture)
            <div class="ms-2 mb-1">
                <div class="ms-2 mb-1">
                    @if(in_array($lecture->lectID, $completedLectures))
                        <i class="fa fa-circle text-success me-1"></i>
                    @else
                        <i class="fa fa-circle text-muted me-1"></i>
                    @endif
                    {{ $lecture->getTranslation('lectName') }}
                </div>
            </div>
            {{-- display sections --}}
            @foreach($lecture->sections as $section)
                <a href="{{ route('learn', ['id' => $course->courseID, 'sectionId' => $section->sectionID]) }}"
                class="ms-4 small d-block sidebar-section 
                {{ isset($current) && $current->sectionID == $section->sectionID ? 'active-section' : '' }}">
                    • {{ $section->getTranslation('section_title') }}
                </a>
            @endforeach
        @endforeach
        {{-- display mcqs --}}
        @if($module->mcqs && $module->mcqs->count() > 0)
            <div class="ms-2 mt-1">
                <a href="{{ route('mcq.module', $module->moduleID) }}" class="text-decoration-none">
                    ○ {{ __('messages.courses.mcqs') }} {{ $loop->iteration }}
                </a>
            </div>
        @endif
    </div>
    @endforeach
    {{-- others --}}
    <a class="sidebar-link d-block mb-2" href="{{ route('course.feedback', $course->courseID) }}">{{ __('messages.courses.view_feedback') }}</a>
    <a class="sidebar-link d-block mb-2" href="{{ route('course.assessment', $course->courseID) }}">{{ __('messages.courses.course_assessment') }}</a>
    <a class="sidebar-link d-block mb-2" href="{{ route('course.progress', $course->courseID) }}">{{ __('messages.courses.my_progress') }}</a>
    <a class="sidebar-link d-block" href="{{ route('course.leaderboard', $course->courseID) }}">{{ __('messages.courses.leaderboards') }}</a>
</div>