import './bootstrap';
import 'bootstrap';

import './services/form';

import { createIcons, icons } from 'lucide';

createIcons({ icons });

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

// Student Modules
import './modules/student/scholarships';
import './modules/student/application';
import './modules/student/tracking';
import './modules/student/profile';
import './modules/student/verification';
import './modules/student/renewals';
import './modules/student/analytics';