@extends('layouts.admin_layout')

@section('content')

<h4 class="fw-bold mb-4">{{ __('messages.admin.review') }} {{ __('messages.admin.announcements') }}</h4>
    <div class="card-box">
        <h5 class="fw-bold">
            {{ $announcement->announcementTitle }}
        </h5>
        <p class="mt-3">
            {{ $announcement->announcementDetails }}
        </p>
        
        <div class="d-flex justify-content-between align-items-center mt-3">
            <small class="text-muted">{{ __('messages.admin.posted') }}: {{ \Carbon\Carbon::parse($announcement->created_at)->format('d M Y') }}</small>
            <span class="badge bg-{{ $announcement->status === 'Available' ? 'success' : 'warning' }}">
                {{ $announcement->status }}
            </span>
        </div>
    </div>
    
    <div class="mt-4 d-flex gap-2">
        {{-- back button --}}
        <a href="{{ route('admin.announcements') }}" class="btn btn-light">{{ __('messages.admin.back') }}</a>
        
        {{-- toggle visibility form --}}
        <form action="{{ route('admin.announcements.toggleStatus', $announcement->announcementID) }}" method="POST">
            @csrf
            @if($announcement->status === 'Available')
                <button type="submit" class="btn btn-warning text-white">
                    <i class="fas fa-eye-slash me-1"></i> Make Private (Pending)
                </button>
            @else
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-eye me-1"></i> {{ __('messages.admin.available') }}
                </button>
            @endif
        </form>

        {{-- delete button --}}
        <button class="btn btn-danger">{{ __('messages.admin.delete') }}</button>
    </div>
@endsection