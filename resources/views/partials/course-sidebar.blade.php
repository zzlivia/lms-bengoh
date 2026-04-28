@section('styles')
    <link rel="stylesheet" href="{{ asset('css/course-sidebar.css') }}">
@endsection

<div class="course-sidebar-wrapper p-3" id="courseSidebar">
    @php 
        // Fetch completed lectures for the authenticated user
        $completedLectures = DB::table('lectureprogress')
            ->where('userID', auth()->id())
            ->pluck('lectID')
            ->toArray();
    @endphp

    <h6 class="fw-bold mb-3">{{ __('messages.courses.course_modules') }}</h6>

    @foreach($course->modules as $module)
    <div class="mb-3">
        {{-- Module Header --}}
        <div class="text-uppercase small text-muted fw-bold mb-1">
            {{ __('messages.courses.module') }} {{ $loop->iteration }}
        </div>

        @php
            $moduleLectureIds = $module->lectures->pluck('lectID')->toArray();
            $isModuleCompleted = count(array_diff($moduleLectureIds, $completedLectures)) === 0;
        @endphp

        {{-- Module Title (Visual Indicator) --}}
        <div class="mb-2 {{ $isModuleCompleted ? 'text-success fw-bold' : '' }}">
            <i class="fa {{ $isModuleCompleted ? 'fa-check-circle' : 'fa-circle-o' }} me-1"></i>
            {{ $module->getTranslation('moduleName') }}
        </div>

        {{-- Lectures and Sections --}}
        @foreach($module->lectures as $lecture)
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

        {{-- MCQ Step --}}
        @if($module->mcqs->count() > 0)
            <div class="ms-4 mt-1">
                <a href="{{ route('mcq.module', $module->moduleID) }}" 
                   class="sidebar-section d-block small {{ Request::is('*/mcq/'.$module->moduleID) ? 'active-section fw-bold' : 'text-muted' }}">
                    <i class="fa fa-question-circle me-1"></i> {{ __('messages.courses.mcqs') }} {{ $loop->iteration }}
                </a>
            </div>
        @endif
    </div>
    @endforeach

    <hr>

    {{-- Footer Links --}}
    <div class="mt-3">
        <a class="sidebar-link d-block small mb-2 text-decoration-none text-dark" href="{{ route('course.feedback', $course->courseID) }}">
            <i class="bi bi-chat-left-text me-2"></i> {{ __('messages.courses.view_feedback') }}
        </a>
        <a class="sidebar-link d-block small mb-2 text-decoration-none text-dark" href="{{ route('course.assessment', $course->courseID) }}">
            <i class="bi bi-journal-check me-2"></i> {{ __('messages.courses.course_assessment') }}
        </a>
        <a class="sidebar-link d-block small mb-2 text-decoration-none text-dark" href="{{ route('course.progress', $course->courseID) }}">
            <i class="bi bi-bar-chart me-2"></i> {{ __('messages.courses.my_progress') }}
        </a>
        <a class="sidebar-link d-block small text-decoration-none text-dark" href="{{ route('course.leaderboard', $course->courseID) }}">
            <i class="bi bi-trophy me-2"></i> {{ __('messages.courses.leaderboards') }}
        </a>
    </div>
</div>