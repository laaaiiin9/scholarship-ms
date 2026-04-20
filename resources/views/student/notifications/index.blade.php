@extends('layouts.student')
@section('header_title', 'Inbox')
@section('title', 'My Notifications')

@section('content')
<div class="container-fluid p-0">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-transparent border-bottom-0 p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h5 class="fw-bold mb-0">Notifications</h5>
                            <p class="text-muted small mb-0">Stay updated with your scholarship status and announcements</p>
                        </div>
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3">
                            {{ count($notifications) }} Total
                        </span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($notifications as $n)
                            @php $isRead = in_array($n->id, $readIds); @endphp
                            <div class="list-group-item p-4 border-start-4 {{ $isRead ? 'border-transparent' : 'border-primary bg-primary bg-opacity-10' }}" 
                                 id="notification-{{ $n->id }}"
                                 style="transition: all 0.3s ease;">
                                <div class="d-flex align-items-start gap-4">
                                    <div class="flex-shrink-0">
                                        @php
                                            $icon = $n->type === 'ALERT' ? 'circle-alert' : ($n->type === 'ANNOUNCEMENT' ? 'megaphone' : 'bell');
                                            $color = $n->type === 'ALERT' ? 'danger' : ($n->type === 'ANNOUNCEMENT' ? 'primary' : 'info');
                                        @endphp
                                        <div class="avatar-circle md bg-{{ $color }}-subtle text-{{ $color }}">
                                            <i data-lucide="{{ $icon }}"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center justify-content-between mb-1">
                                            <h6 class="mb-0 fw-bold {{ $isRead ? 'text-body-secondary' : 'text-body' }}">
                                                {{ $n->title }}
                                                @if(!$isRead)
                                                    <span class="badge bg-primary ms-2 p-1 rounded-circle" style="width: 8px; height: 8px; display: inline-block;"> </span>
                                                @endif
                                            </h6>
                                            <small class="text-muted">{{ $n->created_at->diffForHumans() }}</small>
                                        </div>
                                        <p class="mb-0 text-muted {{ $isRead ? 'small' : '' }}">{{ $n->message }}</p>
                                        
                                        @if(!$isRead)
                                            <button class="btn btn-link p-0 mt-2 text-primary small text-decoration-none fw-bold" 
                                                    onclick="markAsRead({{ $n->id }})">
                                                Mark as read
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <div class="avatar-circle xl bg-body-tertiary text-muted mx-auto mb-3">
                                    <i data-lucide="bell-off" style="width: 48px; height: 48px;"></i>
                                </div>
                                <h6 class="text-muted">No notifications yet</h6>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
