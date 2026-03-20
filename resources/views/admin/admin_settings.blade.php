@extends('layouts.admin')

@section('content')

    <div class="container-fluid">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
        <form action="{{ route('admin.settings.save') }}" method="POST">
        @csrf
            <div class="row">
                <!-- left side -->
                <div class="col-md-6">
                    <h6 class="fw-bold mb-3">General System Settings</h6>
                    <div class="mb-3 d-flex align-items-center">
                        <label class="me-3">Default Language:</label>
                        <select class="form-select w-auto" name="default_language">
                            <option value="Default"
                                {{ ($settings->default_language ?? '') == 'Default' ? 'selected' : '' }}>
                                Default
                            </option>
                            <option value="English"
                                {{ ($settings->default_language ?? '') == 'English' ? 'selected' : '' }}>
                                English
                            </option>
                            <option value="Malay"
                                {{ ($settings->default_language ?? '') == 'Malay' ? 'selected' : '' }}>
                                Malay
                            </option>
                        </select>
                    </div>
                    <div class="mb-4 d-flex align-items-center">
                    <label class="me-3">Notifications:</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input"
                            type="checkbox"
                            name="notifications"
                            value="1"
                            {{ ($settings->notifications ?? 0) ? 'checked' : '' }}>
                        </div>
                    </div>
                    <h6 class="fw-bold mb-3">User & Access Settings</h6>
                    <div class="mb-3">
                        <label class="me-3">User Registration:</label>
                        <select class="form-select w-auto" name="user_registration">
                            <option value="1"
                                {{ ($settings->user_registration ?? 1) == 1 ? 'selected' : '' }}>
                                Enable
                            </option>
                            <option value="0"
                                {{ ($settings->user_registration ?? 1) == 0 ? 'selected' : '' }}>
                                Disable
                            </option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="me-3">Guest Access:</label>
                        <select class="form-select w-auto" name="guest_access">
                            <option value="1"
                                {{ ($settings->guest_access ?? 0) == 1 ? 'selected' : '' }}>
                                Enable
                            </option>
                            <option value="0"
                                {{ ($settings->guest_access ?? 0) == 0 ? 'selected' : '' }}>
                                Disable
                            </option>
                        </select>
                    </div>
                    <h6 class="fw-bold mb-3">Accessibility</h6>
                    <div class="mb-3">
                        <label class="me-3">Enable Text-to-Speech:</label>
                            <select class="form-select w-auto" name="text_to_speech">
                                <option value="1"
                                    {{ ($settings->text_to_speech ?? 0) == 1 ? 'selected' : '' }}>
                                    Enable
                                </option>
                                <option value="0"
                                    {{ ($settings->text_to_speech ?? 0) == 0 ? 'selected' : '' }}>
                                    Disable
                                </option>
                            </select>
                    </div>
                    <div class="mb-3 d-flex align-items-center">
                        <label class="me-3">Font Size:</label>
                            <select class="form-select w-auto" name="font_size">
                                <option value="Default"
                                    {{ ($settings->font_size ?? '') == 'Default' ? 'selected' : '' }}>
                                    Default
                                </option>
                                <option value="Small"
                                    {{ ($settings->font_size ?? '') == 'Small' ? 'selected' : '' }}>
                                    Small
                                </option>
                                <option value="Medium"
                                    {{ ($settings->font_size ?? '') == 'Medium' ? 'selected' : '' }}>
                                    Medium
                                </option>
                                <option value="Large"
                                    {{ ($settings->font_size ?? '') == 'Large' ? 'selected' : '' }}>
                                    Large
                                </option>
                            </select>
                    </div>
                </div> <!-- left side ends -->
                <!-- right side -->
                <div class="col-md-6">
                    <h6 class="fw-bold mb-3">Announcement Settings</h6>
                    <div class="mb-4 d-flex align-items-center">
                        <label class="me-3">Announcements:</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="announcements" value="1" {{ ($settings->announcements ?? 1) ? 'checked' : '' }}>
                        </div>
                    </div>
                    <h6 class="fw-bold mb-3">Report Settings</h6>
                    <div class="mb-4">
                        <label class="me-3">Export format:</label>
                        <select class="form-select w-auto" name="export_format">
                            <option value="PDF"
                                {{ ($settings->export_format ?? '') == 'PDF' ? 'selected' : '' }}>
                                PDF
                            </option>
                            <option value="Excel"
                                {{ ($settings->export_format ?? '') == 'Excel' ? 'selected' : '' }}>
                                Excel
                            </option>
                        </select>
                    </div>
                    <h6 class="fw-bold mb-3">Content Upload & Media Settings</h6>
                    <div class="mb-3">
                        <label class="me-3">Allowed File Types:</label>
                        <input type="text" class="form-control w-50" name="allowed_file_types" value="{{ $settings->allowed_file_types ?? '' }}" placeholder="Example: PDF, MP4">
                    </div>
                    <div class="mb-3 d-flex align-items-center">
                        <label class="me-3">Maximum file size:</label> class="form-control w-50" name="max_file_size" value="{{ $settings->max_file_size ?? '' }}" placeholder="Example: 10MB">
                    </div>
                    <div class="mb-3 d-flex align-items-center">
                        <label class="me-3">Video resolution limit:</label>
                        <input type="text" class="form-control w-50" name="video_resolution_limit" value="{{ $settings->video_resolution_limit ?? '' }}" placeholder="Example: 1080p">
                    </div>
                </div><!-- right side ends -->
            </div>
            <!-- save button section -->
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-outline-dark btn-sm"> Save Changes </button>
            </div>
        </form>
    </div>
@endsection