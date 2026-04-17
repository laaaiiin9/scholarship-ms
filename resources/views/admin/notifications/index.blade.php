@extends('layouts.admin')
@section('header_title', 'Communications')
@section('title', 'System Notifications')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 p-4 text-white" style="background: linear-gradient(135deg, #4f46e5 0%, #7e22ce 100%);">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-white bg-opacity-25 rounded-circle p-3">
                        <i data-lucide="bell" style="width: 32px; height: 32px;"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-1">Notification Center</h4>
                        <p class="mb-0 text-white-50">Manage system-wide announcements and individual scholar alerts.</p>
                    </div>
                </div>
                <button class="btn btn-white rounded-pill px-4 shadow-sm fw-bold" data-bs-toggle="modal" data-bs-target="#composeModal">
                    <i data-lucide="plus-circle" class="me-2" style="width: 18px;"></i> Compose Alert
                </button>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-transparent border-bottom-0 p-4 pb-0">
        <div class="row align-items-center justify-content-between g-3">
            <div class="col-md-6">
                <div class="position-relative">
                    <i data-lucide="search" class="position-absolute top-50 translate-middle-y ms-3 text-muted" style="width: 16px;"></i>
                    <input type="text" id="searchInput" class="form-control ps-5" placeholder="Search by title, message or student...">
                </div>
            </div>
            <div class="col-md-3">
                <select class="form-select" id="typeFilter">
                    <option value="">All Categories</option>
                    <option value="SYSTEM">System Update</option>
                    <option value="ANNOUNCEMENT">Announcement</option>
                    <option value="ALERT">Urgent Alert</option>
                </select>
            </div>
        </div>
    </div>

    <div class="card-body p-0 mt-3">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="text-muted small text-uppercase" style="letter-spacing: 0.5px;">
                    <tr>
                        <th class="ps-4 fw-medium border-bottom-0">Title & Content</th>
                        <th class="fw-medium border-bottom-0">Target</th>
                        <th class="fw-medium border-bottom-0">Sent At</th>
                        <th class="pe-4 fw-medium border-bottom-0 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody class="border-top-0" id="notifications-table-body">
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">
                            <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Loading history...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card-footer bg-transparent border-top p-4" id="pagination-container"></div>
</div>

<!-- Compose Modal -->
<div class="modal fade" id="composeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-bottom-0 p-4">
                <h5 class="modal-title fw-bold">Compose New Alert</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 pt-0">
                <form id="composeForm">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Title</label>
                        <input type="text" name="title" class="form-control rounded-3" placeholder="e.g. Scholarship Result Released" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Category</label>
                        <select name="type" class="form-select rounded-3">
                            <option value="SYSTEM">System Update</option>
                            <option value="ANNOUNCEMENT">Announcement</option>
                            <option value="ALERT">Urgent Alert</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Message</label>
                        <textarea name="message" class="form-control rounded-3" rows="4" placeholder="Type your message here..." required></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-muted text-uppercase">Recipient Scope</label>
                        <div class="d-flex gap-4 p-3 rounded-4 bg-body-tertiary">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="scope" id="scopeBroadcast" value="broadcast" checked>
                                <label class="form-check-label small" for="scopeBroadcast">Broadcast (All)</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="scope" id="scopeIndividual" value="individual">
                                <label class="form-check-label small" for="scopeIndividual">Individual Student</label>
                            </div>
                        </div>
                    </div>
                    <div id="studentSelectWrapper" class="mb-4 d-none">
                        <label class="form-label small fw-bold text-muted text-uppercase">Select Student</label>
                        <select name="user_id" class="form-select rounded-3">
                            <option value="">Choose a student...</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}">{{ ($student->profile->first_name ?? '') . ' ' . ($student->profile->last_name ?? $student->username) }} ({{ $student->email }})</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top-0 p-4">
                <button type="button" class="btn btn-link text-muted px-4 text-decoration-none shadow-none" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-eskoylar-primary text-white px-5 py-2 rounded-3 shadow-sm" id="sendNotificationBtn">
                    <i data-lucide="send" class="me-2" style="width: 18px;"></i> Send Now
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@vite(['resources/js/modules/admin/notifications.js'])
@endpush
