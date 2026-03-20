@extends('layouts.admin')

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
            <li class="nav-item">
                <button class="nav-link active" id="course-tab" data-bs-toggle="tab" data-bs-target="#course-form" type="button">Add Course</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="module-tab" data-bs-toggle="tab" data-bs-target="#module-form" type="button">Add Module</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="lecture-tab" data-bs-toggle="tab" data-bs-target="#lecture-form" type="button">Add Lecture</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="section-tab" data-bs-toggle="tab" data-bs-target="#section-form" type="button">Add Lecture Section</button>
            </li>
        </ul>
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
                            <label class="form-label">Duration (Hours)</label>
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
            <div class="tab-pane fade" id="section-form">
                <form method="POST" action="{{ route('admin.section.store') }}" enctype="multipart/form-data">
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
                        <textarea class="form-control" name="section_content" rows="5"></textarea>
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
                <!-- live preview of the lecture section
                <hr class="my-4">
                <h5>Preview</h5>
                <div id="sectionPreview" class="border rounded p-3 bg-light">
                    <h6 id="previewTitle">Section Title</h6>
                    <div id="previewContent">
                        Section content will appear here...
                    </div>
                </div>-->
            </div>
        </div>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function() {

        const urlParams = new URLSearchParams(window.location.search);
        const tabTarget = urlParams.get('tab');

        if (tabTarget) {

            const tabMap = {
                'course': '#course-tab',
                'module': '#module-tab',
                'lecture': '#lecture-tab',
                'section': '#section-tab' // ← ADD THIS
            };

            const selector = tabMap[tabTarget];
            const tabButton = document.querySelector(selector);

            if (tabButton) {
                const tab = new bootstrap.Tab(tabButton);
                tab.show();
            }
        }

    });
    </script>
    <!-- JS for live -->
    <script>
    document.addEventListener("DOMContentLoaded", function(){
        const titleInput = document.querySelector('input[name="section_title"]');
        const contentInput = document.querySelector('textarea[name="section_content"]');
        const typeInput = document.querySelector('select[name="section_type"]');
        const previewTitle = document.getElementById("previewTitle");
        const previewContent = document.getElementById("previewContent");
        function updatePreview(){
            previewTitle.innerText = titleInput.value || "Section Title";
            if(typeInput.value === "text"){
                previewContent.innerText = contentInput.value || "Text content preview...";
            }
            if(typeInput.value === "image"){
                previewContent.innerHTML = "Image will appear after upload.";
            }
            if(typeInput.value === "video"){
                previewContent.innerHTML = "Video preview will appear here.";
            }
            if(typeInput.value === "pdf"){
                previewContent.innerHTML = "PDF preview will appear here.";
            }
        }
        titleInput.addEventListener("input", updatePreview);
        contentInput.addEventListener("input", updatePreview);
        typeInput.addEventListener("change", updatePreview);
    });
    </script>

    <!-- preview uploaded files -->
    <script>
    const fileInput = document.querySelector('input[name="section_file"]');
    fileInput.addEventListener("change", function(){
        const file = this.files[0];
        if(!file) return;
        const url = URL.createObjectURL(file);
        const previewContent = document.getElementById("previewContent");
        if(file.type.startsWith("image")){
            previewContent.innerHTML = `<img src="${url}" style="max-width:300px;">`;
        }
        if(file.type === "application/pdf"){
            previewContent.innerHTML = `<iframe src="${url}" width="100%" height="300"></iframe>`;
        }
    });
    </script>

    <!-- JS for view button -->
    <script>
    document.querySelectorAll('.viewSectionBtn').forEach(button => {
        button.addEventListener('click', function(){
            let title = this.getAttribute('data-title');
            let content = this.getAttribute('data-content');
            document.getElementById('previewTitle').innerText = title;
            document.getElementById('previewContent').innerHTML = content;
            document.getElementById('sectionPreview').scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
    </script>

    <script>
    document.querySelectorAll('.viewSectionBtn').forEach(button => {

        button.addEventListener('click', function(){

            let title = this.getAttribute('data-title');
            let content = this.getAttribute('data-content');

            // Set modal content
            document.getElementById('viewTitle').innerText = title;
            document.getElementById('viewContent').innerHTML = content;

            // Show modal
            let modal = new bootstrap.Modal(document.getElementById('viewSectionModal'));
            modal.show();

        });

    });
    </script>
    <script>
    document.querySelectorAll('.editSectionBtn').forEach(button => {
        button.addEventListener('click', function(){
            let id = this.getAttribute('data-id');
            let title = this.getAttribute('data-title');
            let content = this.getAttribute('data-content');
            let type = this.getAttribute('data-type');
            document.getElementById('editTitle').value = title;
            document.getElementById('editContent').value = content;
            document.getElementById('editType').value = type;
            document.getElementById('editSectionForm').action = 
                `/admin/section/update/${id}`;
            let modal = new bootstrap.Modal(document.getElementById('editSectionModal'));
            modal.show();
        });
    });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection
