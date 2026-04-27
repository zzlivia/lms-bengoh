@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <a href="{{ route('admin.stories.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Back to Stories
        </a>
        <h2 class="mt-2">Edit Community Story</h2>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('admin.stories.update', $story->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="community_name" class="form-label fw-bold">Community Name</label>
                        <input type="text" name="community_name" id="community_name" 
                               class="form-control @error('community_name') is-invalid @enderror" 
                               value="{{ old('community_name', $story->community_name) }}">
                        @error('community_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="title" class="form-label fw-bold">Story Title</label>
                        <input type="text" name="title" id="title" 
                               class="form-control @error('title') is-invalid @enderror" 
                               value="{{ old('title', $story->title) }}">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="community_image" class="form-label fw-bold">Story Image</label>
                    
                    @if($story->community_image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $story->community_image) }}" width="150" class="img-thumbnail rounded">
                            <p class="small text-muted">Current Image</p>
                        </div>
                    @endif

                    <input type="file" name="community_image" id="community_image" 
                           class="form-control @error('community_image') is-invalid @enderror">
                    <small class="text-muted">Leave blank to keep the current image.</small>
                    @error('community_image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="community_story" class="form-label fw-bold">The Story Content</label>
                    <textarea name="community_story" id="community_story" rows="6" 
                              class="form-control @error('community_story') is-invalid @enderror">{{ old('community_story', $story->community_story) }}</textarea>
                    @error('community_story')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-save"></i> Update Story
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection