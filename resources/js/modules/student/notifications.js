/**
 * Student Notification Page Module
 * Handles "mark as read" interaction on the student notifications page.
 */
(function initStudentNotifications() {
    const notifList = document.getElementById('student-notif-list');
    if (!notifList && !document.querySelector('[id^="notification-"]')) return;

    const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    window.markAsRead = async function (id) {
        try {
            const response = await fetch(`/student/notifications/${id}/read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrf,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            });

            if (response.ok) {
                const item = document.getElementById(`notification-${id}`);
                if (!item) return;

                item.classList.replace('border-primary', 'border-transparent');
                item.classList.remove('bg-primary', 'bg-opacity-10');

                const btn = item.querySelector('button');
                if (btn) btn.remove();

                const dot = item.querySelector('.badge.bg-primary');
                if (dot) dot.remove();
            }
        } catch (error) {
            console.error('Error marking as read:', error);
        }
    };
})();
