@extends('layouts.student')
@section('title', 'Scholarship Renewals')
@section('header_title', 'Renew Your Scholarships')

@section('content')
<div class="container-fluid p-0">
    <!-- Header Card -->
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 p-4 text-white" style="background: linear-gradient(135deg, #4f46e5 0%, #7e22ce 100%);">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-white bg-opacity-25 rounded-circle p-3">
                        <i data-lucide="refresh-cw" style="width: 32px; height: 32px;"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-1">Scholarship Renewal Center</h4>
                        <p class="mb-0 text-white-50">Manage your active scholarship extensions and track approval status.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Eligibility Section -->
    <h5 class="fw-bold mb-3 text-body">Eligible for Renewal</h5>
    <div class="row g-4 mb-5">
        @if($eligibleApplications->isEmpty())
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4 p-5 text-center bg-body-tertiary border-dashed">
                    <div class="mb-3 d-flex justify-content-center">
                        <div class="bg-white rounded-circle p-3 shadow-sm" style="width: 64px; height: 64px;">
                            <i data-lucide="info" class="text-muted" style="width: 32px; height: 32px;"></i>
                        </div>
                    </div>
                    <h6 class="fw-bold">No Open Renewal Windows</h6>
                    <p class="text-muted small mx-auto mb-0" style="max-width: 400px;">You are currently up to date. We'll notify you when your scholarships are open for the next semester's renewal.</p>
                </div>
            </div>
        @else
            @foreach($eligibleApplications as $app)
                @php $period = $app->scholarship->renewalPeriods->first(); @endphp
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden border-top border-eskoylar-primary border-4">
                        <div class="card-body p-4">
                            <div class="badge bg-primary-subtle text-primary mb-3 px-3 py-2 rounded-pill border border-primary-subtle">
                                <i data-lucide="clock" class="me-1" style="width: 14px;"></i> Open until {{ $period->end_date->format('M d') }}
                            </div>
                            <h5 class="fw-bold mb-2">{{ $app->scholarship->name }}</h5>
                            <div class="d-flex align-items-center gap-2 mb-4">
                                <span class="text-muted text-xs text-uppercase fw-bold">Original Grant:</span>
                                <span class="badge bg-body-tertiary text-muted fw-bold border px-2 py-1 rounded-3">#APP-{{ str_pad($app->id, 5, '0', STR_PAD_LEFT) }}</span>
                            </div>
                            
                            <div class="p-3 bg-body-tertiary rounded-3 mb-4">
                                <div class="d-flex justify-content-between mb-2 small">
                                    <span class="text-muted">Window:</span>
                                    <span class="fw-bold text-body">{{ $period->start_date->format('M d') }} - {{ $period->end_date->format('M d') }}</span>
                                </div>
                                <div class="d-flex justify-content-between small">
                                    <span class="text-muted">Type:</span>
                                    <span class="fw-bold text-body">Academic Renewal</span>
                                </div>
                            </div>

                            <a href="{{ route('student.renewals.create', $app->id) }}" class="btn btn-eskoylar-primary text-white w-100 py-3 rounded-3 shadow-sm d-flex align-items-center justify-content-center gap-2">
                                <i data-lucide="file-signature" style="width: 18px;"></i> Start Submission
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <!-- Submission History Section -->
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h5 class="fw-bold mb-0 text-body">My Renewal History</h5>
    </div>
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-body-tertiary text-muted small text-uppercase">
                    <tr>
                        <th class="ps-4 py-3 fw-bold border-0">Scholarship</th>
                        <th class="py-3 fw-bold border-0">Period</th>
                        <th class="py-3 fw-bold border-0">Status</th>
                        <th class="py-3 fw-bold border-0">Submitted</th>
                        <th class="pe-4 py-3 fw-bold border-0 text-end">Remarks</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @forelse($renewalHistory as $r)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold text-body">{{ $r->scholarship->name }}</div>
                                <div class="text-xs text-muted">Ref: #REN-{{ str_pad($r->id, 5, '0', STR_PAD_LEFT) }}</div>
                            </td>
                            <td class="small text-body">{{ $r->renewalPeriod->name ?? 'N/A' }}</td>
                            <td>
                                @php
                                    $color = 'secondary';
                                    switch($r->status) {
                                        case 'SUBMITTED': $color = 'info'; break;
                                        case 'UNDER_REVIEW': $color = 'warning'; break;
                                        case 'APPROVED': $color = 'success'; break;
                                        case 'REJECTED': $color = 'danger'; break;
                                    }
                                @endphp
                                <span class="badge bg-{{ $color }}-subtle text-{{ $color }} border border-{{ $color }}-subtle px-3 py-2 rounded-pill small fw-bold">
                                    {{ str_replace('_', ' ', $r->status) }}
                                </span>
                            </td>
                            <td class="text-muted small">
                                {{ $r->created_at->format('M d, Y') }}
                            </td>
                            <td class="pe-4 text-end">
                                @if($r->remarks)
                                    <button class="btn btn-sm btn-icon btn-white border shadow-sm rounded-3" data-bs-toggle="tooltip" title="{{ $r->remarks }}">
                                        <i data-lucide="message-square" style="width: 14px;"></i>
                                    </button>
                                @else
                                    <span class="text-muted italic small">No remarks yet</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <p class="mb-0">You haven't submitted any renewals yet.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
