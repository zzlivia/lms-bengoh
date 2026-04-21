@extends('layouts.admin_layout')

@section('content')
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <h4 class="mb-4">{{ __('messages.admin.edit') }} {{ __('messages.admin.lecture') }}</h4>
        
        <form action="{{ route('admin.sections.update', $section->sectionID) }}" method="POST" id="main-edit-form">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label>{{ __('messages.admin.section_title') }}</label>
                <input type="text" name="section_title" class="form-control" value="{{ $sectionTranslation->title ?? $section->section_title }}" required>
            </div>

            <div class="mb-3">
                <label>{{ __('messages.admin.section_content') }}</label>
                <textarea name="section_content" id="tiny_editor_unique" class="form-control" rows="5">{{ $sectionTranslation->content ?? $section->section_content }}</textarea>
            </div>

            <div class="mb-3">
                <label>{{ __('messages.admin.section_type') }}</label>
                <select name="section_type" class="form-control" required>
                    <option value="text" {{ $section->section_type == 'text' ? 'selected' : '' }}>{{ __('messages.admin.text') }}</option>
                    <option value="video" {{ $section->section_type == 'video' ? 'selected' : '' }}>{{ __('messages.admin.video') }}</option>
                    <option value="pdf" {{ $section->section_type == 'pdf' ? 'selected' : '' }}>{{ __('messages.admin.pdf') }}</option>
                </select>
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-success">{{ __('messages.admin.edit') }}</button>
                <a href="{{ route('admin.course.module.create', ['tab' => 'section']) }}" class="btn btn-secondary">{{ __('messages.courses.cancel') }}</a>
            </div>
        </form>

        <hr class="my-5">

        <h5 class="mt-4">{{ __('messages.admin.add_new') }} {{ __('messages.admin.content') }}</h5>
        
        <form action="{{ route('admin.section.material.store', $section->sectionID) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div id="materials-container"></div>
            
            <div class="d-flex justify-content-between mt-3">
                <button type="button" class="btn btn-primary" onclick="addMaterial()">{{ __('messages.admin.add_new') }} {{ __('messages.admin.content') }}</button>
                <button type="submit" class="btn btn-success">{{ __('messages.courses.settings.save_changes') }}</button>
            </div>
        </form>
    </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js"></script>

<script>
    /**
     * 2. Global JavaScript Functions
     * These must stay outside the DOMContentLoaded listener so the HTML buttons can see them.
     */
    function addMaterial() {
        const container = document.getElementById('materials-container');
        const count = container.querySelectorAll('.card').length;
        
        const html = `
            <div class="card mb-3 p-3 shadow-sm border-light">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="mb-0">{{ __('messages.admin.content') }} ${count + 1}</h6>
                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="this.closest('.card').remove()">
                        <i class="bi bi-trash"></i> {{ __('messages.admin.remove') }}
                    </button>
                </div>
                <div class="mb-2">
                    <label class="form-label">Type</label>
                    <select name="materials[${count}][type]" class="form-select" onchange="changeInput(this, ${count})">
                        <option value="text">{{ __('messages.admin.text') }}</option>
                        <option value="video">{{ __('messages.admin.video') }}</option>
                        <option value="pdf">{{ __('messages.admin.pdf') }}</option>
                    </select>
                </div>
                <div id="input-${count}" class="mb-2">
                    <label class="form-label">{{ __('messages.admin.text') }}</label>
                    <textarea name="materials[${count}][content]" class="form-control" rows="3"></textarea>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
    }

    function changeInput(select, id) {
        const container = document.getElementById('input-' + id);
        const val = select.value;

        if (val === 'text') {
            container.innerHTML = `<label class="form-label">{{ __('messages.admin.text') }}</label><textarea name="materials[${id}][content]" class="form-control" rows="3"></textarea>`;
        } else if (val === 'video') {
            container.innerHTML = `<label class="form-label">{{ __('messages.admin.video') }} URL</label><input type="text" name="materials[${id}][content]" class="form-control">`;
        } else if (val === 'pdf') {
            container.innerHTML = `<label class="form-label">Muat Naik PDF</label><input type="file" name="materials[${id}][file]" class="form-control">`;
        }
    }

    /**
     * 3. TinyMCE Initialization
     */
    document.addEventListener("DOMContentLoaded", function() {
        tinymce.init({
            selector: '#section_content',
            height: 400,
            license_key: 'gpl', // Required for version 6+ free use
            menubar: true,
            plugins: 'lists link image table code wordcount',
            toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | bullist numlist | link image | code',
            promotion: false,
            branding: false,
            setup: function (editor) {
                editor.on('change', function () {
                    editor.save(); // Pushes TinyMCE content back to the original textarea
                });
            }
        });
    });
</script>
@endsection