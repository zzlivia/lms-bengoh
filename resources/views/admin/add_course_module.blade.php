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

        <h3 class="mb-4">Create Course or Module</h3>
        <!-- tabs  -->
        <ul class="nav nav-tabs mb-4" id="managementTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active"
                        id="course-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#course-form"
                        type="button"
                        role="tab">
                    Add Course
                </button>
            </li>

            <li class="nav-item" role="presentation">
                <button class="nav-link"
                        id="module-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#module-form"
                        type="button"
                        role="tab">
                    Add Module
                </button>
            </li>

            <li class="nav-item" role="presentation">
                <button class="nav-link"
                        id="lecture-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#lecture-form"
                        type="button"
                        role="tab">
                    Add Lecture
                </button>
            </li>

            <li class="nav-item" role="presentation">
                <button class="nav-link"
                        id="section-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#section-form"
                        type="button"
                        role="tab">
                    Add Lecture Section
                </button>
            </li>

            <li class="nav-item" role="presentation">
                <button class="nav-link"
                        id="mcq-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#mcq-form"
                        type="button"
                        role="tab">
                    Add MCQ
                </button>
            </li>

            <li class="nav-item" role="presentation">
                <button class="nav-link"
                        id="assessment-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#assessment-form"
                        type="button"
                        role="tab">
                    Add Course Assessment
                </button>
            </li>
        </ul>
        <hr class="my-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5>Course Assessments</h5>
            <a href="{{ route('admin.assessment.manageCourseAss') }}" class="btn btn-outline-primary">View All Assessments</a>
        </div>
        <div class="tab-content">
            <!-- course form -->
            <div class="tab-pane fade show active" id="course-form">
                <form method="POST" action="{{ route('admin.course.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Course Code</label>
                            <input type="text" class="form-control" name="courseCode" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Course Name</label>
                            <input type="text" class="form-control" name="courseName" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Author</label>
                            <input type="text" class="form-control" name="courseAuthor" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Category</label>
                            <input type="text" class="form-control" name="courseCategory" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Level</label>
                            <select class="form-control" name="courseLevel" required>
                                <option value="Beginner">Beginner</option>
                                <option value="Intermediate">Intermediate</option>
                                <option value="Advanced">Advanced</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Duration (Weeks)</label>
                            <input type="number" class="form-control" name="courseDuration" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Course Thumbnail</label>
                            <input type="file" class="form-control" name="courseImg" accept="image/*">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="courseDesc" rows="4" required></textarea>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" name="isAvailable" value="1" id="isAvailable" checked>
                        <label class="form-check-label">Make this course available immediately</label>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-success">Save Course</button>
                    </div>
                </form>
            </div>
            <!-- module form tab -->
            <div class="tab-pane fade" id="module-form">
                <form method="POST" action="{{ route('admin.module.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Select Course</label>
                        <select class="form-control" name="courseID" required>
                            <option value="">-- Choose a Course --</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->courseID }}">
                                    {{ $course->courseName }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Module Name</label>
                        <input type="text" class="form-control" name="moduleName" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Module</button>
                </form>
                <!-- display existing module below the form -->    
                <hr class="my-4">
                <h5 class="mb-3">Existing Modules</h5>
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Course</th>
                            <th>Module Name</th>
                            <th width="150">Action</th>
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
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this module?')"> Delete </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center"> No modules added yet </td>
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
                            <label class="form-label">Select Module</label>
                            <select class="form-control" name="moduleID" required>
                                <option value="">-- Choose a Module --</option>
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
                            <label class="form-label">Lecture Name</label>
                            <input type="text" class="form-control" name="lectName" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Duration (Minutes)</label>
                            <input type="number" class="form-control" name="lect_duration" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-info text-white"> Save Lecture </button>
                </form>
                <!-- display existing lecture below the form -->
                <hr class="my-4">
                <h5 class="mb-3">Existing Lectures</h5>
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Module</th>
                            <th>Lecture Name</th>
                            <th>Duration</th>
                            <th width="150">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lectures as $index => $lecture)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $lecture->module->moduleName ?? 'N/A' }}</td>
                            <td>{{ $lecture->lectName }}</td>
                            <td>{{ $lecture->lect_duration }} min</td>
                            <td>
                                <a href="{{ route('admin.lecture.edit',$lecture->lectID) }}" class="btn btn-warning btn-sm"> Edit </a>
                                <form action="{{ route('admin.lecture.delete',$lecture->lectID) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this lecture?')"> Delete </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center"> No lectures added yet </td>
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
                        <label class="form-label">Select Lecture</label>
                        <select class="form-control" name="lectID" required>
                            <option value="">-- Choose Lecture --</option>
                            @foreach($lectures as $lecture)
                            <option value="{{ $lecture->lectID }}">
                            {{ $lecture->module->moduleName }} - {{ $lecture->lectName }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Section Title</label>
                        <input type="text" class="form-control" name="section_title" required>
                    </div>
                    <div class="mb-3">
                        <label>Section Type</label>
                        <select name="section_type" id="editType" class="form-control">
                            <option value="text">Text</option>
                            <option value="video">Video</option>
                            <option value="pdf">PDF</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Section Content</label>
                        <textarea id="section_content" class="form-control" name="section_content" rows="5"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Upload File (Optional)</label>
                        <input type="file" class="form-control" name="section_file">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Display Order</label>
                        <input type="number" class="form-control" name="section_order">
                    </div>
                    <button type="submit" class="btn btn-success"> Save Section </button>
                </form>
                <!-- allow admin to edit section later -->
                <hr class="my-4">
                <h5>Existing Sections</h5>
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Lecture</th>
                                <th>Section Title</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($sections as $index => $section)
                        <tr>
                            <td>{{ $index+1 }}</td>
                            <td>{{ $section->lecture->lectName }}</td>
                            <td>{{ $section->section_title }}</td>
                            <td>
                                <button class="btn btn-info btn-sm viewSectionBtn" data-title="{{ $section->section_title }}" data-content="{{ $section->section_content }}"> View </button>
                                <button 
                                    class="btn btn-warning btn-sm editSectionBtn"
                                    data-id="{{ $section->sectionID }}"
                                    data-title="{{ $section->section_title }}"
                                    data-content="{{ $section->section_content }}"
                                    data-type="{{ $section->section_type }}">
                                    Edit
                                </button>
                                <form action="{{ route('admin.section.delete',$section->sectionID) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Delete</button>
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
                        <label>Select Module</label>
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
                            <label>Question</label>
                            <input type="text" name="questions[0][text]" class="form-control mb-2" required>

                            {{-- list of answers --}}
                            @for($i = 0; $i < 4; $i++)
                                <input type="text" name="questions[0][answers][]" class="form-control mb-2" placeholder="Answer {{ $i+1 }}" required>
                            @endfor
                            <label>Correct Answer</label>
                            <select name="questions[0][correct]" class="form-control">
                                <option value="0">Answer 1</option>
                                <option value="1">Answer 2</option>
                                <option value="2">Answer 3</option>
                                <option value="3">Answer 4</option>
                            </select>
                        </div>
                    </div>
                    {{-- buttons --}}
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <!-- left -->
                        <button type="button" class="btn btn-secondary" onclick="addQuestion()">+ Add Question</button>
                        <!-- AI generate MCQS button -->
                        <button type="button" class="btn btn-primary ms-2" onclick="generateAIQuestions()">
                            ? Generate AI Questions
                        </button>
                        <!-- right -->
                        <button class="btn btn-success">Submit All</button>
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

    <script> //initialize TineMCE
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
    </script>
    @stack('scripts')
@endsection
