@extends('layouts.admin')

@section('content')

<div class="container">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    <h4 class="mb-4">Edit Section</h4>
    <form action="{{ route('admin.section.update', $section->sectionID) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Section Title</label>
            <input type="text" name="section_title" class="form-control"
                   value="{{ $section->section_title }}" required>
        </div>
        <div class="mb-3">
            <label>Section Content</label>
            <textarea name="section_content" class="form-control" rows="5" required>{{ $section->section_content }}</textarea>
        </div>
        <div class="mb-3">
            <label>Section Type</label>
            <select name="section_type" class="form-control" required>
                <option value="text" {{ $section->section_type == 'text' ? 'selected' : '' }}>Text</option>
                <option value="video" {{ $section->section_type == 'video' ? 'selected' : '' }}>Video</option>
                <option value="pdf" {{ $section->section_type == 'pdf' ? 'selected' : '' }}>PDF</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
    </form>
    <hr>
    <h5 class="mt-4">Learning Materials</h5>
    <button type="button" class="btn btn-primary mb-3" onclick="addMaterial()">
        Add Learning Material
    </button>
    <form action="{{ route('admin.section.material.store', $section->sectionID) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div id="materials-container"></div>
        <button type="submit" class="btn btn-success">Save Materials</button>
    </form>
</div>

<script>
let count = document.querySelectorAll('#materials-container .card').length;
    function addMaterial() {
        let count = document.querySelectorAll('#materials-container .card').length;

        let html = `
            <div class="card mb-3 p-3">
                <h6>Material ${count + 1}</h6>

                <div class="mb-2">
                    <label>Type</label>
                    <select name="materials[${count}][type]" class="form-control" onchange="changeInput(this, ${count})">
                        <option value="text">Text</option>
                        <option value="video">Video</option>
                        <option value="pdf">PDF</option>
                    </select>
                </div>

                <div class="mb-2" id="input-${count}">
                    <label>Text Content</label>
                    <textarea name="materials[${count}][content]" class="form-control"></textarea>
                </div>

                <button type="button" class="btn btn-danger btn-sm" onclick="this.parentElement.remove()">Remove</button>
            </div>
        `;

        document.getElementById('materials-container').insertAdjacentHTML('beforeend', html);
    }
    function changeInput(select, id) {
        let container = document.getElementById('input-' + id);

        if (select.value === 'text') {
            container.innerHTML = `
                <label>Text Content</label>
                <textarea name="materials[${id}][content]" class="form-control"></textarea>
            `;
        }
        else if (select.value === 'video') {
            container.innerHTML = `
                <label>Video URL (YouTube)</label>
                <input type="text" name="materials[${id}][content]" class="form-control">
            `;
        }
        else if (select.value === 'pdf') {
            container.innerHTML = `
                <label>Upload PDF</label>
                <input type="file" name="materials[${id}][file]" class="form-control">
            `;
        }
    }
</script>

@endsection