import TableService from '../../services/admin/table';
import { showToast } from '../../utils/toast';
import { createIcons, icons } from 'lucide';
import FormService from '../../services/admin/form';

document.addEventListener('DOMContentLoaded', () => {
    const tableBodyId = 'users-table-body';
    if (!document.getElementById(tableBodyId)) return;

    // 1. Initialize Table
    const tableService = new TableService({
        tableBodyId: tableBodyId,
        paginationContainerId: 'pagination-container',
        searchInputId: 'searchInput',
        endpoint: '/admin/users',
        renderRow: (item) => {
            const date = new Date(item.created_at).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
            const role = item.roles?.[0]?.name || 'N/A';
            const fullName = item.profile ? `${item.profile.first_name} ${item.profile.last_name}` : item.username;
            const initials = fullName.charAt(0).toUpperCase();

            return `
                <tr>
                    <td class="ps-4">
                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar-circle sm bg-secondary-subtle text-secondary fw-bold">${initials}</div>
                            <div>
                                <h6 class="mb-0 fw-bold text-body">${fullName}</h6>
                                <small class="text-muted">${item.email}</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge bg-body-tertiary text-muted border px-2 py-1">${role.toUpperCase()}</span>
                    </td>
                    <td>
                        <div class="form-check form-switch">
                            <input class="form-check-input status-toggle" type="checkbox" data-id="${item.id}" ${item.is_active ? 'checked' : ''}>
                            <span class="small ${item.is_active ? 'text-success' : 'text-danger'}">${item.is_active ? 'Active' : 'Inactive'}</span>
                        </div>
                    </td>
                    <td class="text-muted">${date}</td>
                    <td class="pe-4 text-end">
                        <button class="btn btn-sm btn-icon btn-outline-eskoylar-primary rounded-3 shadow-sm edit-user-btn" data-id="${item.id}" title="Edit User">
                            <i data-lucide="pencil" style="width: 16px;"></i>
                        </button>
                    </td>
                </tr>
            `;
        }
    });

    // 2. Role Filter
    const roleFilter = document.getElementById('roleFilter');
    if (roleFilter) {
        roleFilter.addEventListener('change', (e) => {
            tableService.extraParams.role = e.target.value;
            tableService.currentPage = 1;
            tableService.fetchData();
        });
    }

    // 3. Edit User Logic
    document.getElementById(tableBodyId).addEventListener('click', async (e) => {
        const btn = e.target.closest('.edit-user-btn');
        if (btn) {
            const userId = btn.dataset.id;
            try {
                const response = await fetch(`/admin/users/${userId}/fetch`, {
                    headers: { 'Accept': 'application/json' }
                });
                const user = await response.json();

                if (response.ok) {
                    // Fill modal fields
                    document.getElementById('edit_user_id').value = user.id;
                    document.getElementById('edit_first_name').value = user.profile?.first_name || '';
                    document.getElementById('edit_last_name').value = user.profile?.last_name || '';
                    document.getElementById('edit_username').value = user.username;
                    document.getElementById('edit_email').value = user.email;
                    document.getElementById('edit_role_id').value = user.roles?.[0]?.id || '';

                    // Show modal
                    const modal = new bootstrap.Modal(document.getElementById('editUserModal'));
                    modal.show();
                } else {
                    showToast('Failed to fetch user data', 'error');
                }
            } catch (err) {
                showToast('Network error', 'error');
            }
        }
    });

    // 4. Update User Form
    const editUserForm = document.getElementById('editUserForm');
    if (editUserForm) {
        editUserForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const userId = document.getElementById('edit_user_id').value;
            const btn = document.getElementById('submitEditUserBtn');
            const originalHtml = btn.innerHTML;

            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Updating...';

            const formData = new FormData(editUserForm);
            // Append _method for Laravel PUT request
            formData.append('_method', 'PUT');

            try {
                const response = await fetch(`/admin/users/${userId}`, {
                    method: 'POST', // Use POST with _method=PUT
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                const data = await response.json();

                if (response.ok && data.success) {
                    showToast(data.message, 'success');
                    bootstrap.Modal.getInstance(document.getElementById('editUserModal')).hide();
                    tableService.fetchData();
                } else {
                    showToast(data.message || 'Error updating user', 'error');
                }
            } catch (err) {
                showToast('Network error', 'error');
            } finally {
                btn.disabled = false;
                btn.innerHTML = originalHtml;
            }
        });
    }

    // 5. Status Toggle Listener (Delegated)
    document.getElementById(tableBodyId).addEventListener('change', async (e) => {
        if (e.target.classList.contains('status-toggle')) {
            const userId = e.target.dataset.id;
            const originalChecked = !e.target.checked;
            
            try {
                const response = await fetch(`/admin/users/${userId}/toggle-status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });
                const data = await response.json();

                if (response.ok && data.success) {
                    showToast(data.message, 'success');
                    // Update text label next to switch
                    const label = e.target.nextElementSibling;
                    if (data.is_active) {
                        label.textContent = 'Active';
                        label.className = 'small text-success';
                    } else {
                        label.textContent = 'Inactive';
                        label.className = 'small text-danger';
                    }
                } else {
                    showToast(data.message || 'Error updating status', 'error');
                    e.target.checked = originalChecked;
                }
            } catch (err) {
                showToast('Network error', 'error');
                e.target.checked = originalChecked;
            }
        }
    });

    createIcons({ icons });
});
