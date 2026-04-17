import './bootstrap';
import 'bootstrap';

import './services/api';

import { createIcons, icons } from 'lucide';

createIcons({ icons });

// Admin Modules
import './modules/admin/scholarships';
import './modules/admin/applicationPeriod';
import './modules/admin/requirement';

// Student Modules
import './modules/student/scholarships';
import './modules/student/application';