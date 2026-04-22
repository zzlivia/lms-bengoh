@extends('layouts.admin_layout')

@section('content')
<div class="container mt-4">
    <h3>Edit Lecture</h3>
    <hr>

    <form action="{{ route('admin.lecture.update', $lecture->lectID) }}" method="POST">
        @csrf
        @method('PUT') {{-- Crucial for update routes --}}

        <div class="mb-3">
            <label for="moduleID" class="form-label">Select Module</label>
            <select name="moduleID" class="form-control" required>
                @foreach($modules as $module)
                    <option value="{{ $module->moduleID }}" {{ $lecture->moduleID == $module->moduleID ? 'selected' : '' }}>
                        {{ $module->moduleName }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="lectName" class="form-label">Lecture Name</label>
            <input type="text" name="lectName" class="form-control" value="{{ $lecture->lectName }}" required>
        </div>

        <div class="mb-3">
            <label for="lect_duration" class="form-label">Duration (Minutes)</label>
            <input type="number" name="lect_duration" class="form-control" value="{{ $lecture->lect_duration }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Lecture</button>
        <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection