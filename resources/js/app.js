import './bootstrap';
import 'bootstrap';

import './services/api';

import { createIcons, icons } from 'lucide';

createIcons({ icons });

// Admin Modules
import './modules/admin/scholarships';
import './modules/admin/applicationPeriod';
import './modules/admin/requirement';
import './modules/admin/applications';
import './modules/admin/users';

// Student Modules
import './modules/student/scholarships';
import './modules/student/application';
import './modules/student/tracking';