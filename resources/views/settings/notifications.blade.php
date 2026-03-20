@extends('settings.settings')

@section('settings_content')

<h6 class="mb-3">Settings / Notifications</h6>

<div class="settings-row">
    General Notification
</div>

<div class="settings-row">
    Submitted MCQs
    <input type="checkbox" checked>
</div>

<div class="settings-row">
    Overall Grades
    <input type="checkbox" checked>
</div>

<div class="mt-4">
    <a href="/" class="btn btn-success">Home</a>
    <button class="btn btn-success">Save Changes</button>
</div>

@endsection