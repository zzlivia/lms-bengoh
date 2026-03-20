@extends('settings.settings')

@section('settings_content')

<h6 class="mb-3">Settings / Preferences</h6>

<div class="settings-row">
    Listening Mode
    <input type="checkbox">
</div>

<div class="settings-row">
    Sound Effects
    <input type="checkbox">
</div>

<div class="mt-4">
    <a href="/" class="btn btn-success">Home</a>
    <button class="btn btn-success">Save Changes</button>
</div>

@endsection