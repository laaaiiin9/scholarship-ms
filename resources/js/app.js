import './bootstrap';
import 'bootstrap';
import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

import './services/form';

import { createIcons, icons } from 'lucide';
import { showToast } from './utils/toast';

import { initScrollAnimations } from './modules/scroll-animations';

import { initCookieConsent } from './modules/cookie-consent';
import './modules/public-scholarships';

createIcons({ icons });

// Expose utilities to window
window.showToast = showToast;

// Handle session flash messages and init animations
document.addEventListener('DOMContentLoaded', () => {
    const flash = document.body.dataset;
    if (flash.success) showToast(flash.success, 'success');
    if (flash.error) showToast(flash.error, 'error');

    initScrollAnimations();
    initCookieConsent();
});

// Theme logic
import './modules/theme';

// Shared Modules (run on all authenticated pages)
import './modules/notificationBell';

// Admin Modules
import './modules/admin/scholarships';
import './modules/admin/applicationPeriod';
import './modules/admin/requirement';
import './modules/admin/applications';
import './modules/admin/users';
import './modules/admin/reports';
import './modules/admin/settings';
import './modules/admin/renewalPeriod';
import './modules/admin/renewalReview';
import './modules/admin/disbursements';
import './modules/admin/analytics';

// Student Modules
import './modules/student/scholarships';
import './modules/student/application';
import './modules/student/tracking';
import './modules/student/profile';
import './modules/student/verification';
import './modules/student/renewals';
import './modules/student/renewalCreate';
import './modules/student/notifications';
import './modules/student/analytics';

// Admin Modules — notifications page
import './modules/admin/notifications';