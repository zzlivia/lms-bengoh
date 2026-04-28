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
        <div class="text-uppercase small text-muted fw-bold">Module {{ $loop->iteration }}</div>
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
                {{-- lecture Name --}}
                <div class="ms-2 mb-1 text-muted small fw-bold">
                    {{ $lecture->getTranslation('lectName') }}
                </div>

                @foreach($lecture->sections as $section)
                    @php
                        $isCurrent = isset($current) && $current->sectionID == $section->sectionID;
                        $isCompleted = in_array($lecture->lectID, $completedLectures);
                    @endphp
                    <a href="{{ route('learn', ['id' => $course->courseID, 'sectionId' => $section->sectionID]) }}"
                    class="ms-4 small d-block sidebar-section {{ $isCurrent ? 'active-section fw-bold' : 'text-muted' }}">
                        <i class="fa {{ $isCompleted ? 'fa-check-circle text-success' : ($isCurrent ? 'fa-play-circle text-primary' : 'fa-circle-o') }} me-1"></i>
                        {{ $section->getTranslation('section_title') }}
                    </a>
                @endforeach
            @endforeach
        {{-- display mcqs --}}
        @if($module->mcqs->count() > 0)
            <div class="ms-4 mt-1">
                <a href="{{ route('mcq.module', $module->moduleID) }}" 
                class="small {{ Request::is('*/mcq/*') ? 'fw-bold text-primary' : 'text-muted' }}">
                    <i class="fa fa-question-circle me-1"></i> {{ __('messages.courses.mcqs') }}
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