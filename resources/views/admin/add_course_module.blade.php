@extends('layouts.admin_layout')

@section('content')
    <div class="container">
        <!-- successful alert notifications -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <h3 class="mb-4">{{ __('messages.admin.create_title') }}</h3>
        <!-- tabs  -->
        <ul class="nav nav-tabs mb-4" id="managementTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active"
                        id="course-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#course-form"
                        type="button"
                        role="tab">
                    {{ __('messages.admin.add_course') }}
                </button>
            </li>

            <li class="nav-item" role="presentation">
                <button class="nav-link"
                        id="module-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#module-form"
                        type="button"
                        role="tab">
                    {{ __('messages.admin.add_module') }}
                </button>
            </li>

            <li class="nav-item" role="presentation">
                <button class="nav-link"
                        id="lecture-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#lecture-form"
                        type="button"
                        role="tab">
                    {{ __('messages.admin.add_lecture') }}
                </button>
            </li>

            <li class="nav-item" role="presentation">
                <button class="nav-link"
                        id="section-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#section-form"
                        type="button"
                        role="tab">
                   {{ __('messages.admin.add_section') }}
                </button>
            </li>

            <li class="nav-item" role="presentation">
                <button class="nav-link"
                        id="mcq-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#mcq-form"
                        type="button"
                        role="tab">
                    {{ __('messages.admin.add_mcq') }}
                </button>
            </li>

            <li class="nav-item" role="presentation">
                <button class="nav-link"
                        id="assessment-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#assessment-form"
                        type="button"
                        role="tab">
                    {{ __('messages.admin.add_assessment') }}
                </button>
            </li>
        </ul>
        <hr class="my-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5>{{ __('messages.admin.course_assessments') }}</h5>
            <a href="{{ route('admin.assessment.manageCourseAss') }}" class="btn btn-outline-primary">{{ __('messages.admin.view_all_assessments') }}</a>
        </div>
        <div class="tab-content">
            <!-- course form -->
            <div class="tab-pane fade show active" id="course-form">
                <form method="POST" action="{{ route('admin.course.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('messages.admin.view_all_assessments') }}</label>
                            <input type="text" class="form-control" name="courseCode" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('messages.admin.course_name') }}</label>
                            <input type="text" class="form-control" name="courseName" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('messages.admin.author') }}</label>
                            <input type="text" class="form-control" name="courseAuthor" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('messages.courses.category') }}</label>
                            <input type="text" class="form-control" name="courseCategory" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">{{ __('messages.courses.level') }}</label>
                            <select class="form-control" name="courseLevel" required>
                                <option value="Beginner">{{ __('messages.admin.beginner') }}</option>
                                <option value="Intermediate">{{ __('messages.admin.intermediate') }}</option>
                                <option value="Advanced">{{ __('messages.admin.advanced') }}</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">{{ __('messages.courses.duration') }} ({{ __('messages.courses.weeks') }})</label>
                            <input type="number" class="form-control" name="courseDuration" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">{{ __('messages.admin.thumbnail') }}</label>
                            <input type="file" class="form-control" name="courseImg" accept="image/*">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.admin.desc') }}</label>
                        <textarea class="form-control" name="courseDesc" rows="4" required></textarea>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" name="isAvailable" value="1" id="isAvailable" checked>
                        <label class="form-check-label">{{ __('messages.admin.available_immediately') }}</label>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-success">{{ __('messages.admin.save_course') }}</button>
                    </div>
                </form>
            </div>
            <!-- module form tab -->
            <div class="tab-pane fade" id="module-form">
                <form method="POST" action="{{ route('admin.module.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.admin.select_course') }}</label>
                        <select class="form-control" name="courseID" required>
                            <option value="">-- {{ __('messages.admin.choose_course') }} --</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->courseID }}">
                                    {{ $course->courseName }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.admin.module_name') }}</label>
                        <input type="text" class="form-control" name="moduleName" required>
                    </div>
                    <button type="submit" class="btn btn-primary">{{ __('messages.admin.save_module') }}</button>
                </form>
                <!-- display existing module below the form -->    
                <hr class="my-4">
                <h5 class="mb-3">{{ __('messages.admin.existing_modules') }}</h5>
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>{{ __('messages.nav.courses') }}</th>
                            <th>{{ __('messages.admin.module_name') }}</th>
                            <th width="150">{{ __('messages.admin.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($modules as $index => $module)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $module->course->courseName ?? 'N/A' }}</td>
                            <td>{{ $module->moduleName }}</td>
                            <td>
                                <a href="{{ route('admin.module.edit',$module->moduleID) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('admin.module.delete',$module->moduleID) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('{{ __('messages.admin.confirm_delete_module') }}')"> {{ __('messages.admin.delete') }} </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center"> {{ __('messages.admin.no_modules') }} </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- lecture tabs -->
            <div class="tab-pane fade" id="lecture-form">
                <form method="POST" action="{{ route('admin.lecture.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('messages.admin.select_module') }}</label>
                            <select class="form-control" name="moduleID" required>
                                <option value="">-- {{ __('messages.admin.choose_module') }} --</option>
                                @foreach($modules as $module)
                                    <option value="{{ $module->moduleID }}">
                                        {{ $module->course->courseName }} - {{ $module->moduleName }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label">{{ __('messages.admin.lecture_name') }}</label>
                            <input type="text" class="form-control" name="lectName" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">{{ __('messages.admin.duration_mins') }}</label>
                            <input type="number" class="form-control" name="lect_duration" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-info text-white"> {{ __('messages.admin.save_lecture') }} </button>
                </form>
                <!-- display existing lecture below the form -->
                <hr class="my-4">
                <h5 class="mb-3">{{ __('messages.admin.existing_lectures') }}</h5>
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>{{ __('messages.courses.module') }}</th>
                            <th>{{ __('messages.admin.lecture_name') }}</th>
                            <th>{{ __('messages.courses.duration') }}</th>
                            <th width="150">{{ __('messages.admin.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lectures as $index => $lecture)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $lecture->module->moduleName ?? 'N/A' }}</td>
                            <td>{{ $lecture->lectName }}</td>
                            <td>{{ $lecture->lect_duration }} {{ __('messages.courses.mins') }}</td>
                            <td>
                                <a href="{{ route('admin.lecture.edit',$lecture->lectID) }}" class="btn btn-warning btn-sm"> Edit </a>
                                <form action="{{ route('admin.lecture.delete',$lecture->lectID) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('{{ __('messages.admin.confirm_delete_lecture') }}')">{{ __('messages.admin.delete') }}</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center"> {{ __('messages.admin.no_lectures') }} </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{-- lecture section tabs--}}
            <div class="tab-pane fade" id="section-form">
                <form method="POST" action="{{ route('admin.sections.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.admin.select_lecture') }}</label>
                        <select class="form-control" name="lectID" required>
                            <option value="">-- {{ __('messages.admin.choose_lecture') }} --</option>
                            @foreach($lectures as $lecture)
                            <option value="{{ $lecture->lectID }}">
                            {{ $lecture->module->moduleName }} - {{ $lecture->lectName }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.admin.section_title') }}</label>
                        <input type="text" class="form-control" name="section_title" required>
                    </div>
                    <div class="mb-3">
                        <label>{{ __('messages.admin.section_type') }}</label>
                        <select name="section_type" id="editType" class="form-control">
                            <option value="text">{{ __('messages.admin.text') }}</option>
                            <option value="video">{{ __('messages.admin.video') }}</option>
                            <option value="pdf">PDF</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.admin.section_content') }}</label>
                        <textarea id="section_content" class="form-control" name="section_content" rows="5"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.admin.upload_file') }} ({{ __('messages.admin.optional') }})</label>
                        <input type="file" class="form-control" name="section_file">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.admin.display_order') }}</label>
                        <input type="number" class="form-control" name="section_order">
                    </div>
                    <button type="submit" class="btn btn-success"> {{ __('messages.admin.save_section') }} </button>
                </form>
                <!-- allow admin to edit section later -->
                <hr class="my-4">
                <h5>{{ __('messages.admin.existing_sections') }}</h5>
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>{{ __('messages.admin.lecture') }}</th>
                                <th>{{ __('messages.admin.section_title') }}</th>
                                <th>{{ __('messages.admin.action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($sections as $index => $section)
                        <tr>
                            <td>{{ $index+1 }}</td>
                            <td>{{ $section->lecture->lectName }}</td>
                            <td>{{ $section->section_title }}</td>
                            <td>
                                <button class="btn btn-info btn-sm viewSectionBtn" data-title="{{ $section->section_title }}" data-content="{{ $section->section_content }}"> {{ __('messages.admin.view') }} </button>
                                <button 
                                    class="btn btn-warning btn-sm editSectionBtn"
                                    data-id="{{ $section->sectionID }}"
                                    data-title="{{ $section->section_title }}"
                                    data-content="{{ $section->section_content }}"
                                    data-type="{{ $section->section_type }}">
                                    {{ __('messages.admin.edit') }}
                                </button>
                                <form action="{{ route('admin.section.delete',$section->sectionID) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">{{ __('messages.admin.delete') }}</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="modal fade" id="viewSectionModal" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="viewTitle">Section Title</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div id="viewContent">
                                        Section content will appear here...
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            {{-- MCQ tab --}}
            <div class="tab-pane fade" id="mcq-form">
                <form method="POST" action="{{ route('admin.mcq.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label>{{ __('messages.admin.select_module') }}</label>
                        <select name="moduleID" class="form-control" required>
                            @foreach($modules as $module)
                                <option value="{{ $module->moduleID }}">
                                    {{ $module->moduleName }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    {{-- container of questions --}}
                    <div id="questions-container">
                        {{-- main question display first --}}
                        <div class="question-block border p-3 mb-3 rounded">
                            <label>{{ __('messages.courses.question') }}</label>
                            <input type="text" name="questions[0][text]" class="form-control mb-2" required>

                            {{-- list of answers --}}
                            @for($i = 0; $i < 4; $i++)
                                <input type="text" name="questions[0][answers][]" class="form-control mb-2" placeholder="Answer {{ $i+1 }}" required>
                            @endfor
                            <label>{{ __('messages.courses.correct_answer') }}</label>
                            <select name="questions[0][correct]" class="form-control">
                                <option value="0">{{ __('messages.admin.answer') }} 1</option>
                                <option value="1">{{ __('messages.admin.answer') }} 2</option>
                                <option value="2">{{ __('messages.admin.answer') }} 3</option>
                                <option value="3">{{ __('messages.admin.answer') }} 4</option>
                            </select>
                        </div>
                    </div>
                    {{-- buttons --}}
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <!-- left -->
                        <button type="button" class="btn btn-secondary" onclick="addQuestion()">+ {{ __('messages.admin.add_question_btn') }}</button>
                        <!-- AI generate MCQS button -->
                        <button type="button" class="btn btn-primary ms-2" onclick="generateAIQuestions()">
                            ? {{ __('messages.admin.generate_ai_mcq') }}
                        </button>
                        <!-- right -->
                        <button class="btn btn-success">{{ __('messages.admin.submit_all') }}</button>
                    </div>
                </form>
                {{-- list of mcq --}}
                <hr class="my-4">
                <h5 class="mb-3">MCQ Overview</h5>
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Module</th>
                            <th>Total Questions</th>
                            <th>Status</th>
                            <th width="250">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($module->mcqs as $mcq)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $module->moduleName }}</td>
                        <td>{{ $mcq->question }}</td>
                        <td>
                            <span class="badge bg-success">Available</span>
                        </td>
                        <td>
                            <a href="{{ route('admin.mcq.preview', $mcq->group_id) }}" 
                            class="btn btn-secondary btn-sm">Preview</a>
                            <a href="{{ route('admin.mcq.edit', $mcq->group_id) }}" 
                            class="btn btn-warning btn-sm">Edit</a>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {{-- Course Assessment Tab --}}
            <div class="tab-pane fade" id="assessment-form">
                <form method="POST" action="{{ route('admin.assessment.saveAss') }}">
                    @csrf
                    <!-- select course -->
                    <div class="mb-3">
                        <label class="form-label">Select Course</label>
                        <select name="courseID" class="form-control" required>
                            <option value="">-- Choose Course --</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->courseID }}">
                                    {{ $course->courseName }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- state title -->
                    <div class="mb-3">
                        <label class="form-label">Assessment Title</label>
                        <input 
                            type="text" 
                            name="title" 
                            class="form-control @error('title') is-invalid @enderror"
                            value="{{ old('title') }}"
                            placeholder="Enter assessment title (e.g. Final Exam)"
                            required
                        >

                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- fill description -->
                    <div class="mb-3">
                        <label class="form-label">Assessment Description</label>
                        <textarea 
                            name="desc" 
                            class="form-control @error('desc') is-invalid @enderror"
                            rows="4"
                            placeholder="Enter description (optional)"
                        >{{ old('desc') }}</textarea>

                        @error('desc')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- submit the form -->
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Create Assessment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap FIRST -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JS file -->
    <script>
    document.addEventListener("DOMContentLoaded", function () {

        const urlParams = new URLSearchParams(window.location.search);
        const tabTarget = urlParams.get('tab');

        const tabMap = {
            'course': '#course-tab',
            'module': '#module-tab',
            'lecture': '#lecture-tab',
            'section': '#section-tab',
            'mcq': '#mcq-tab',
            'assessment': '#assessment-tab'
        };

        if (tabTarget && tabMap[tabTarget]) {
            let triggerEl = document.querySelector(tabMap[tabTarget]);
            if (triggerEl) {
                new bootstrap.Tab(triggerEl).show();
            }
        }

    });
    </script>

    <script src="{{ asset('js/admin-course-module.js') }}"></script>

    <script>
        function generateAIQuestions() {
            let moduleSelect = document.querySelector('#mcq-form select[name="moduleID"]');
            let moduleID = moduleSelect ? moduleSelect.value : '';

            if (!moduleID) {
                alert("Please select a module first!");
                return;
            }

            //ask admin for number of questions
            let num = prompt("Enter number of questions to generate:");

            if (!num || isNaN(num) || num <= 0) {
                alert("Please enter a valid number!");
                return;
            }

            fetch(`/admin/generate-ai-mcq/${moduleID}`, {
                method: "POST", 
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    count: parseInt(num)
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert("AI Questions Generated & Saved!");
                    location.reload();
                } else {
                    alert(data.error || "Failed to generate questions");
                }
            })
            .catch(err => {
                console.error(err);
                alert("Something went wrong!");
            });
        }
    </script>

    @push('scripts')
        <script>
        document.addEventListener("DOMContentLoaded", function () {
            tinymce.init({
                selector: '#section_content',
                height: 400,
                menubar: true,
                plugins: [
                    'advlist autolink lists link image charmap preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table help wordcount'
                ],
                toolbar: 'undo redo | formatselect | bold italic underline | \
                        alignleft aligncenter alignright alignjustify | \
                        bullist numlist outdent indent | link image media | code preview'
            });
        });
        </script>
    @endpush

    <script> //initialize TineMCE
        tinymce.init({
            selector: '#section_content',
            height: 400,
            menubar: true,
            plugins: ['advlist autolink lists link image charmap preview anchor','searchreplace visualblocks code fullscreen','insertdatetime media table help wordcount'],
            toolbar: 'undo redo | formatselect | bold italic underline | \
                    alignleft aligncenter alignright alignjustify | \
                    bullist numlist outdent indent | link image media | code preview',

            /* support image upload */
            images_upload_url: '/upload-image',
            automatic_uploads: true,
            file_picker_types: 'image',
            images_upload_handler: function (blobInfo, success, failure) {
                let formData = new FormData();
                formData.append('file', blobInfo.blob());

                fetch('/upload-image', {method: 'POST', body: formData,headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(result => {
                    success(result.location);
                })
                .catch(() => {
                    failure('Upload failed');
                });
            }
        });
    </script>
    @stack('scripts')
@endsection
