@extends('layouts.admin_layout')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Community Stories</h2>
        <a href="{{ route('admin.stories.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Add New Story
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table class="table table-hover align-middle" id="userTable">
                <thead class="table-light">
                    <tr>
                        <th>Image</th>
                        <th>Community Name</th>
                        <th>Title</th>
                        <th>Date Published</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stories as $story)
                        <tr>
                            <td>
                                @if($story->community_image)
                                    <img src="{{ asset('storage/' . $story->community_image) }}" 
                                        alt="Story Image" class="rounded" width="50" height="50" style="object-fit: cover;">
                                @else
                                    <div class="bg-secondary text-white rounded d-flex align-items-center justify-content-center" 
                                        style="width: 50px; height: 50px; font-size: 10px;">No Image</div>
                                @endif
                            </td>
                            <td>{{ $story->community_name }}</td>
                            <td>{{ $story->title }}</td>
                            <td>{{ $story->created_at->format('d M Y') }}</td>
                            <td class="text-end">
                                <div class="btn-group">
                                    <a href="{{ route('admin.stories.edit', $story->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.stories.destroy', $story->id) }}" method="POST" 
                                        onsubmit="return confirm('Are you sure you want to delete this story?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection