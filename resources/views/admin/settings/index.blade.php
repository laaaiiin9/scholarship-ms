@extends('layouts.admin')
@section('title', 'System Settings')
@section('header_title', 'System Settings')

@section('content')
<div class="container-fluid p-0">
    <div class="row g-4">
        <!-- Main Settings Form -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-transparent border-bottom-0 p-4 pb-0">
                    <h5 class="fw-bold mb-1">Global Configuration</h5>
                    <p class="text-muted small">Manage site-wide preferences and system behaviors.</p>
                </div>
                <div class="card-body p-4">
                    <form id="settingsForm">
                        <!-- Branding Section -->
                        <div class="mb-5">
                            <h6 class="text-uppercase text-muted fw-bold small mb-3" style="letter-spacing: 1px;">Branding & Identity</h6>
                            <div class="row g-3">
                                <div class="col-md-6 mb-3">
                                    <label for="site_name" class="form-label text-sm fw-medium">Site Title</label>
                                    <input type="text" class="form-control" id="site_name" name="site_name" 
                                        value="{{ $settings['site_name'] ?? config('app.name') }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="primary_color" class="form-label text-sm fw-medium">Primary Brand Color</label>
                                    <div class="input-group">
                                        <input type="color" class="form-control form-control-color" id="primary_color" name="primary_color" 
                                            value="{{ $settings['primary_color'] ?? '#0d6efd' }}" title="Choose your color">
                                        <input type="text" class="form-control" value="{{ $settings['primary_color'] ?? '#0d6efd' }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- System Controls -->
                        <div class="mb-5">
                            <h6 class="text-uppercase text-muted fw-bold small mb-3" style="letter-spacing: 1px;">System Controls</h6>
                            
                            <div class="d-flex align-items-center justify-content-between p-3 bg-body-tertiary rounded-4 border mb-3">
                                <div>
                                    <h6 class="mb-1 fw-bold">Student Registration</h6>
                                    <p class="text-muted small mb-0">Allow new students to create accounts on the platform.</p>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="registration_enabled" value="1" 
                                        {{ ($settings['registration_enabled'] ?? '1') == '1' ? 'checked' : '' }} style="width: 45px; height: 22px;">
                                </div>
                                <input type="hidden" name="registration_enabled" value="0" id="registration_enabled_hidden">
                            </div>

                            <div class="d-flex align-items-center justify-content-between p-3 bg-body-tertiary rounded-4 border">
                                <div>
                                    <h6 class="mb-1 fw-bold text-danger">Maintenance Mode</h6>
                                    <p class="text-muted small mb-0">Put the site in maintenance mode. Only admins will have access.</p>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="maintenance_mode" value="1" 
                                        {{ ($settings['maintenance_mode'] ?? '0') == '1' ? 'checked' : '' }} style="width: 45px; height: 22px;">
                                </div>
                                <input type="hidden" name="maintenance_mode" value="0" id="maintenance_mode_hidden">
                            </div>
                        </div>

                        <!-- Support Settings -->
                        <div class="mb-4">
                            <h6 class="text-uppercase text-muted fw-bold small mb-3" style="letter-spacing: 1px;">Support & Contact</h6>
                            <div class="mb-3">
                                <label for="support_email" class="form-label text-sm fw-medium">Support Email Address</label>
                                <input type="email" class="form-control" id="support_email" name="support_email" 
                                    value="{{ $settings['support_email'] ?? 'support@eskoylar.com' }}">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end pt-3 border-top">
                            <button type="submit" class="btn btn-eskoylar-primary text-white px-5 py-2 rounded-3 shadow-sm" id="saveSettingsBtn">
                                <i data-lucide="save" style="width: 18px;" class="me-2"></i> Save Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 text-center mb-4">
                <div class="avatar-circle mx-auto bg-warning-subtle text-warning mb-3" style="width: 60px; height: 60px;">
                    <i data-lucide="alert-triangle" style="width: 30px;"></i>
                </div>
                <h5 class="fw-bold mb-2">Critical Actions</h5>
                <p class="text-muted small mb-4">Changes made here affect the entire platform immediately. Please proceed with caution.</p>
                <div class="d-grid gap-2 text-start">
                    <button class="btn btn-outline-danger btn-sm rounded-3 py-2">
                        <i data-lucide="refresh-cw" style="width: 14px;" class="me-2"></i> Clear System Cache
                    </button>
                    <button class="btn btn-outline-secondary btn-sm rounded-3 py-2">
                        <i data-lucide="history" style="width: 14px;" class="me-2"></i> View Audit Logs
                    </button>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h6 class="fw-bold mb-3 small text-uppercase">System Information</h6>
                <div class="d-flex justify-content-between mb-2 small">
                    <span class="text-muted">Version:</span>
                    <span class="fw-medium text-body">2.4.0-premium</span>
                </div>
                <div class="d-flex justify-content-between mb-2 small">
                    <span class="text-muted">Environment:</span>
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle">{{ strtoupper(config('app.env')) }}</span>
                </div>
                <div class="d-flex justify-content-between small">
                    <span class="text-muted">Last Config Update:</span>
                    <span class="text-body">{{ date('M d, H:i') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
