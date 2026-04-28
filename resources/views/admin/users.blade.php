@extends('layouts.admin')
@section('header_title', 'User Management')
@section('title', 'Admin Users')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold mb-1">Users & Access Control</h4>
            <p class="text-muted mb-0">Control system access and manage user credentials.</p>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card border-0 shadow-sm rounded-4">
        <!-- Search & Filter Header -->
        <div class="card-header bg-transparent border-bottom-0 p-4 pb-0">
            <div class="row align-items-center justify-content-between g-3">
                <div class="col-md-6 col-lg-5">
                    <div class="position-relative">
                        <i data-lucide="search" class="position-absolute top-50 translate-middle-y ms-3 text-muted" style="width: 16px;"></i>
                        <input type="text" id="searchInput" class="form-control ps-5" placeholder="Search name, username or email...">
                    </div>
                </div>
                <div class="col-md-auto d-flex gap-2">
                    <select class="form-select text-muted" id="roleFilter" style="min-width: 160px;">
                        <option value="">All Roles</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="card-body p-0 mt-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="text-muted" style="font-size: 0.8rem;">
                        <tr>
                            <th class="ps-4 fw-medium border-bottom-0">User Account</th>
                            <th class="fw-medium border-bottom-0">Role</th>
                            <th class="fw-medium border-bottom-0">Status</th>
                            <th class="fw-medium border-bottom-0">Joined Date</th>
                            <th class="pe-4 fw-medium border-bottom-0 text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0" id="users-table-body">
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
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

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-bottom-0 p-4">
                <h5 class="modal-title fw-bold">Edit System User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editUserForm">
                @csrf
                <input type="hidden" name="user_id" id="edit_user_id">
                <div class="modal-body p-4 pt-0">
                    <p class="text-muted small mb-4">Update access credentials and basic profile information.</p>
                    
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-medium text-sm">First Name</label>
                            <input type="text" name="first_name" id="edit_first_name" class="form-control" required placeholder="John">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium text-sm">Last Name</label>
                            <input type="text" name="last_name" id="edit_last_name" class="form-control" required placeholder="Doe">
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-medium text-sm">Username</label>
                            <input type="text" name="username" id="edit_username" class="form-control" required placeholder="johndoe">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium text-sm">Role Assignment</label>
                            <select name="role_id" id="edit_role_id" class="form-select" required>
                                <option value="" disabled selected>Select role...</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-medium text-sm">Email Address</label>
                        <input type="email" name="email" id="edit_email" class="form-control" required placeholder="john@example.com">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-medium text-sm">Password (Leave blank to keep current)</label>
                        <input type="password" name="password" class="form-control" placeholder="New password if changing">
                    </div>
                </div>
                <div class="modal-footer border-top-0 p-4">
                    <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-eskoylar-primary text-white px-4" id="submitEditUserBtn">Update Account</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
