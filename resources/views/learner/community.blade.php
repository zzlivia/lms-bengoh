@extends('layouts.open_layout')

@section('content')
    <div class="container py-5">
        <h2 class="text-center mb-5 fw-bold">{{ __('messages.home.community_title') }}</h2>
        <div class="row g-4 justify-content-center">
            @forelse($stories as $story)
                <div class="col-lg-10 col-xl-8"> {{-- Makes the card wider but keeps it centered --}}
                    <div class="p-4 p-md-5 border rounded bg-light h-100 d-flex align-items-start shadow-sm">
                        {{-- image: increased size slightly for the wider layout --}}
                        <div class="flex-shrink-0">
                            @if($story->community_image)
                                <img src="{{ asset('storage/' . $story->community_image) }}" 
                                    class="me-4 rounded shadow-sm" width="120" height="120" style="object-fit: cover;">
                            @else
                                <div class="me-4 bg-secondary text-white rounded d-flex align-items-center justify-content-center" style="width: 120px; height: 120px;">
                                    <i class="fa-solid fa-user-tie fs-1"></i>
                                </div>
                            @endif
                        </div>
                        {{-- content --}}
                        <div class="flex-grow-1">
                            <h4 class="fw-bold mb-1">{{ $story->getTranslation('community_name') }}</h4>
                            <h6 class="text-primary mb-3">{{ $story->getTranslation('title') }}</h6>
                            <p class="mb-0 text-muted" style="line-height: 1.6; font-style: italic;">
                                "{{ $story->getTranslation('community_story') }}"
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