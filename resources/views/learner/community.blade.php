@extends('layouts.open_layout')

@section('content')
    <div class="container py-5">
        <h2 class="text-center mb-5 fw-bold">{{ __('messages.home.community_title') }}</h2>
        <div class="row g-4">
            @forelse($stories as $story)
                <div class="col-md-6">
                    <div class="p-4 border rounded bg-light h-100 d-flex">
                        {{-- Image --}}
                        @if($story->community_image)
                            <img src="{{ asset('storage/' . $story->community_image) }}" 
                                class="me-3 rounded" width="80" height="80" style="object-fit: cover;">
                        @else
                            <i class="fa-solid fa-user-tie fs-1 me-3"></i>
                        @endif
                        {{-- Content --}}
                        <div>
                            <h5 class="fw-bold mb-1">{{ $story->community_name }}</h5>
                            <h6 class="text-muted">{{ $story->title }}</h6>
                            <p class="mb-0 small">
                                "{{ $story->community_story }}"
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p class="text-muted">{{ __('messages.home.no_stories') }}</p>
                </div>
            @endforelse
        </div>
        <div class="text-center mt-4">
            <button onclick="window.location.href='/'" class="btn btn-secondary">← {{ __('messages.courses.go_back') }}</button>
        </div>
    </div>
@endsection