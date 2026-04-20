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
    <form action="{{ route('admin.sections.update', $section->sectionID) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>{{ __('messages.admin.section_title') }}</label>
            <input type="text" name="section_title" class="form-control" value="{{ optional($sectionTranslation)->section_title ?? $section->section_title }}" required>
        </div>
        <div class="mb-3">
            <label>{{ __('messages.admin.section_content') }}</label>
            <textarea name="section_content" class="form-control" rows="5" required> {{ optional($sectionTranslation)->section_content ?? $section->section_content }}</textarea>
        </div>
        <div class="mb-3">
            <label>{{ __('messages.admin.section_type') }}</label>
            <select name="section_type" class="form-control" required>
                <option value="text" {{ $section->section_type == 'text' ? 'selected' : '' }}>{{ __('messages.admin.text') }}</option>
                <option value="video" {{ $section->section_type == 'video' ? 'selected' : '' }}>{{ __('messages.admin.video') }}</option>
                <option value="pdf" {{ $section->section_type == 'pdf' ? 'selected' : '' }}>{{ __('messages.admin.pdf') }}</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">{{ __('messages.admin.edit') }}</button>
        <a href="{{ url()->previous() }}" class="btn btn-secondary">{{ __('messages.courses.cancel') }}</a>
    </form>
    <hr>
    <h5 class="mt-4">{{ __('messages.admin.add_new') }} {{ __('messages.admin.content') }}</h5>
    <button type="button" class="btn btn-primary mb-3" onclick="addMaterial()">{{ __('messages.admin.add_new') }} {{ __('messages.admin.content') }}</button>
    <form action="{{ route('admin.section.material.store', $section->sectionID) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div id="materials-container"></div>
        <button type="submit" class="btn btn-success">{{ __('messages.courses.settings.save_changes') }}</button>
    </form>
</div>

<script>
let count = document.querySelectorAll('#materials-container .card').length;
    function addMaterial() {
        let count = document.querySelectorAll('#materials-container .card').length;

        let html = `
            <div class="card mb-3 p-3">
                <h6>{{ __('messages.admin.content') }} ${count + 1}</h6>
                <div class="mb-2">
                    <label>Type</label>
                    <select name="materials[${count}][type]" class="form-control" onchange="changeInput(this, ${count})">
                        <option value="text">{{ __('messages.admin.text') }}</option>
                        <option value="video">{{ __('messages.admin.video') }}</option>
                        <option value="pdf">{{ __('messages.admin.pdf') }}</option>
                    </select>
                </div>

                <div class="mb-2" id="input-${count}">
                    <label>{{ __('messages.admin.text') }} {{ __('messages.admin.content') }}</label>
                    <textarea name="materials[${count}][content]" class="form-control"></textarea>
                </div>
                <button type="button" class="btn btn-danger btn-sm" onclick="this.parentElement.remove()">{{ __('messages.admin.remove') }}</button>
            </div>
        `;

        document.getElementById('materials-container').insertAdjacentHTML('beforeend', html);
    }
    function changeInput(select, id) {
        let container = document.getElementById('input-' + id);

        if (select.value === 'text') {
            container.innerHTML = `
                <label>{{ __('messages.admin.text') }} {{ __('messages.admin.content') }}</label>
                <textarea name="materials[${id}][content]" class="form-control"></textarea>
            `;
        }
        else if (select.value === 'video') {
            container.innerHTML = `
                <label>{{ __('messages.admin.video') }} URL (YouTube)</label>
                <input type="text" name="materials[${id}][content]" class="form-control">
            `;
        }
        else if (select.value === 'pdf') {
            container.innerHTML = `
                <label>{{ __('messages.admin.upload_file') }} ({{ __('messages.admin.pdf') }})</label>
                <input type="file" name="materials[${id}][file]" class="form-control">
            `;
        }
    }
</script>

@endsection