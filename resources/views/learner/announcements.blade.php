@extends('layouts.open_layout')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0">
                    <i class="fas fa-bullhorn text-primary me-2"></i>{{ __('messages.admin.announcements') }}
                </h4>
                <a href="{{ route('homepage') }}" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-2 px-3 py-2 rounded-3 shadow-sm">
                    <i class="fas fa-arrow-left"></i> {{ __('messages.admin.back') }}
                </a>
            </div>

            @forelse($announcements as $announcement)
                <div class="card mb-3 shadow-sm border-0 rounded-3 bg-white">
                    <div class="card-body p-4">
                        <h5 class="fw-bold text-dark mb-2">
                            {{ $announcement->announcementTitle }}
                        </h5>
                        <p class="text-secondary mb-3" style="white-space: pre-line;">
                            {{ $announcement->announcementDetails }}
                        </p>
                        <div class="border-top pt-2 mt-2 d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="fas fa-calendar-alt me-1"></i> 
                                {{ \Carbon\Carbon::parse($announcement->created_at)->format('d M Y') }}
                            </small>
                            <span class="badge bg-primary rounded-pill">New</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="card text-center p-5 shadow-sm border-0 bg-light">
                    <div class="card-body">
                        <i class="fas fa-bullhorn text-muted display-4 mb-3 d-block"></i>
                        <p class="text-muted mb-0">No new announcements are available at this moment.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection