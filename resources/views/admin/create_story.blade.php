@extends('layouts.admin_layout')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <a href="{{ route('admin.stories.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Back to Stories
        </a>
        <h2 class="mt-2">Add New Community Story</h2>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('admin.stories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="community_name" class="form-label fw-bold">Community Name</label>
                        <input type="text" name="community_name" id="community_name" 
                               class="form-control @error('community_name') is-invalid @enderror" 
                               value="{{ old('community_name') }}" placeholder="e.g. Kampung Bengoh">
                        @error('community_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="title" class="form-label fw-bold">Story Title</label>
                        <input type="text" name="title" id="title" 
                               class="form-control @error('title') is-invalid @enderror" 
                               value="{{ old('title') }}" placeholder="e.g. Life after the Dam">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="community_image" class="form-label fw-bold">Story Image</label>
                    <input type="file" name="community_image" id="community_image" 
                           class="form-control @error('community_image') is-invalid @enderror">
                    <small class="text-muted">Allowed formats: JPG, PNG, JPEG (Max 2MB)</small>
                    @error('community_image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="community_story" class="form-label fw-bold">The Story Content</label>
                    <textarea name="community_story" id="community_story" rows="6" 
                              class="form-control @error('community_story') is-invalid @enderror">{{ old('community_story') }}</textarea>
                    @error('community_story')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-check-lg"></i> Save Story
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection