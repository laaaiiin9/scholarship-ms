@extends('layouts.admin')
@section('header_title', 'Scholarships')
@section('title', 'Admin Scholarships')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold mb-1">Manage Scholarships</h4>
            <p class="text-muted mb-0">View, edit, and manage all scholarship programs.</p>
        </div>
        <button class="btn btn-eskoylar-primary text-white d-flex align-items-center gap-2 rounded-3 shadow-sm px-4 py-2" data-bs-toggle="modal" data-bs-target="#scholarshipModal" id="btnNewScholarship">
            <i data-lucide="plus-circle" style="width: 18px;"></i>
            New Scholarship
        </button>
    </div>

    <!-- Table Card -->
    <div class="card border-0 shadow-sm rounded-4">
        <!-- Search & Filter Header -->
        <div class="card-header bg-transparent border-bottom-0 p-4 pb-0">
            <div class="row align-items-center justify-content-between g-3">
                <div class="col-md-6 col-lg-5">
                    <div class="position-relative">
                        <i data-lucide="search" class="position-absolute top-50 translate-middle-y ms-3 text-muted" style="width: 16px;"></i>
                        <input type="text" id="searchInput" class="form-control ps-5" placeholder="Search scholarships by name or description...">
                    </div>
                </div>
                <div class="col-md-auto d-flex gap-2">
                    <select class="form-select text-muted" style="min-width: 150px;">
                        <option value="">All Statuses</option>
                        <option value="active">Active</option>
                        <option value="closed">Closed</option>
                        <option value="draft">Draft</option>
                    </select>
                    <button class="btn btn-outline-secondary d-flex align-items-center gap-2">
                        <i data-lucide="filter" style="width: 16px; height: 16px;"></i>
                        <span class="d-none d-sm-inline">Filters</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="card-body p-0 mt-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="text-muted" style="font-size: 0.8rem;">
                        <tr>
                            <th class="ps-4 fw-medium border-bottom-0">Name</th>
                            <th class="fw-medium border-bottom-0">Description</th>
                            <th class="fw-medium border-bottom-0">Max Amount</th>
                            <th class="fw-medium border-bottom-0">Created By</th>
                            <th class="pe-4 fw-medium border-bottom-0 text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0" id="scholarships-table-body">
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">
                                <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Loading...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="card-footer bg-transparent border-top p-4" id="pagination-container">
            <!-- Rendered by JS -->
        </div>
    </div>
</div>

<!-- Scholarship Form Modal -->
<div class="modal fade" id="scholarshipModal" tabindex="-1" aria-labelledby="scholarshipModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-bottom-0 p-4 pb-0">
                <h5 class="modal-title fw-bold" id="scholarshipModalLabel">New Scholarship</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 pt-2">
                <form id="scholarshipForm">
                    <input type="hidden" id="scholarship_id" name="id">
                    <div class="mb-3">
                        <label for="name" class="form-label text-sm fw-medium">Scholarship Program Name</label>
                        <input type="text" class="form-control" id="name" name="name" required placeholder="e.g. Merit Based 2026">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label text-sm fw-medium">Short Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required placeholder="Details about this scholarship..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="max_amount" class="form-label text-sm fw-medium">Maximum Grant Amount</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" step="1" class="form-control" id="max_amount" name="max_amount" required placeholder="0.00">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top-0 p-4">
                <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-eskoylar-primary text-white px-4" id="saveScholarshipBtn">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteScholarshipModal" tabindex="-1" aria-labelledby="deleteScholarshipModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-bottom-0 p-4 pb-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-4 pb-5">
                <div class="text-danger mb-4 d-flex justify-content-center">
                    <div class="bg-danger-subtle rounded-circle p-3">
                        <i data-lucide="alert-triangle" style="width: 48px; height: 48px;"></i>
                    </div>
                </div>
                <h4 class="fw-bold mb-2">Delete Scholarship?</h4>
                <p class="text-muted mb-4">You are about to delete this scholarship program. All associated records will be permanently removed. This action cannot be undone.</p>
                <div class="d-flex justify-content-center gap-3">
                    <button type="button" class="btn btn-outline-secondary px-5" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger px-5" id="confirmDeleteScholarshipBtn">Yes, Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection