<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## 🎓 Eskoylar: Scholarship Management Suite

Eskoylar is a high-fidelity, centralized scholarship management platform designed to connect students with academic opportunities through a streamlined, premium interface.

### 🚀 Key Features

#### 🛡️ Administrator Panel
- **Data Intelligence Dashboard**: Interactive charts (Line & Doughnut) for tracking application trends and outcomes via Chart.js.
- **Dynamic Scholarship Management**: Full CRUD for scholarship programs, multi-stage application periods, and requirement mapping.
- **Reporting & Export Engine**: Advanced filtering of applicants with one-click CSV data exports.
- **System Configuration**: Global controls for site branding, registration toggles, and maintenance modes.
- **User Governance**: Centralized management of student identities and account statuses.

#### 🎓 Student Experience
- **Personalized Tracking**: Real-time progress monitoring of all submitted applications.
- **Premium Scholarship Catalog**: A high-fidelity, filtered search grid to find suitable opportunities.
- **Comprehensive Identity Management**: Extended profiles capturing essential data (Contact, Address, Birth Date) for scholarship validation.
- **Automated Communication**: Instant email notifications for submissions and status updates.

### 🛠️ Tech Stack
- **Backend**: Laravel 11.x
- **Frontend**: Vanilla JS, SCSS, Bootstrap 5.3, Lucide Icons, Chart.js
- **Database**: MySQL / MariaDB
- **Build Tool**: Vite

### 🏁 Getting Started

1. **Clone the repository**:
   ```bash
   git clone https://github.com/your-username/scholarship-ms.git
   ```
2. **Setup environment**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
3. **Install dependencies**:
   ```bash
   composer install
   npm install
   ```
4. **Run migrations & build**:
   ```bash
   php artisan migrate
   npm run build
   ```
5. **Start server**:
   ```bash
   php artisan serve
   ```

---
*Built for the next generation of scholars.*