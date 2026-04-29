import { createIcons, icons } from 'lucide';
import { showToast } from '../../utils/toast';

document.addEventListener('DOMContentLoaded', () => {

    const form = document.getElementById('profileForm');
    if (!form) return;

    createIcons({ icons });

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const btn = document.getElementById('submitBtn');
        const originalHtml = btn.innerHTML;

        // Validation (Basic)
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Saving...';

        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        try {
            const response = await fetch('/student/profile/update', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            if (response.ok && result.success) {
                showToast(result.message, 'success');
            } else {
                let errorMsg = result.message || 'An error occurred while updating profile.';
                if (result.errors) {
                    errorMsg = Object.values(result.errors).flat().join('<br>');
                }
                showToast(errorMsg, 'error');
            }
        } catch (error) {
            console.error('Profile update error:', error);
            showToast('Network error while updating profile.', 'error');
        } finally {
            btn.disabled = false;
            btn.innerHTML = originalHtml;
            createIcons({ icons });
        }
    });

    // Profile Picture Upload
    const uploadBtn = document.getElementById('uploadPictureBtn');
    const fileInput = document.getElementById('profilePictureInput');
    const avatarContainer = document.getElementById('profileAvatarContainer');

    if (uploadBtn && fileInput) {
        uploadBtn.addEventListener('click', () => fileInput.click());

        fileInput.addEventListener('change', async (e) => {
            const file = e.target.files[0];
            if (!file) return;

            const originalBtnHtml = uploadBtn.innerHTML;
            uploadBtn.disabled = true;
            uploadBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';

            const formData = new FormData();
            formData.append('profile_picture', file);
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            try {
                const response = await fetch('/student/profile/picture', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                });

                const result = await response.json();

                if (response.ok && result.success) {
                    if (avatarContainer) {
                        avatarContainer.innerHTML = `<img src="${result.path}" alt="Profile" class="w-100 h-100 object-fit-cover" id="profileAvatar">`;
                    }
                    
                    // Update all other avatars on page
                    document.querySelectorAll('.avatar-circle').forEach(avatar => {
                        if (avatar.id !== 'profileAvatarContainer') {
                            avatar.innerHTML = `<img src="${result.path}" alt="Profile" class="w-100 h-100 object-fit-cover rounded-circle">`;
                            avatar.style.background = 'transparent';
                        }
                    });

                    showToast(result.message, 'success');
                } else {
                    showToast(result.message || 'Failed to upload image', 'error');
                }
            } catch (error) {
                console.error('Upload error:', error);
                showToast('Network error while uploading image.', 'error');
            } finally {
                uploadBtn.disabled = false;
                uploadBtn.innerHTML = originalBtnHtml;
                createIcons({ icons });
            }
        });
    }

});
