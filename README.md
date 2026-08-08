# HTDC - Hajee Mohammad Danesh Science & Technology College

A comprehensive web application for Hajee Mohammad Danesh Science & Technology College (HTDC) managing student admissions, teacher applications, attendance, notices, gallery, and administrative operations.

## Features

### Student Management
- Online student application submission
- Application tracking with PIN code
- PDF generation for applications
- Bulk application management

### Teacher Management
- Teacher application submission
- Document upload (photos, certificates, marksheet scans)
- Application status tracking

### Attendance System
- Daily attendance tracking
- Program-wise attendance reports
- Bulk attendance creation

### Content Management
- Notice board with rich text content
- Gallery management with image uploads
- Slider/banner management
- Custom page management (multi-level hierarchy)
- Form downloads management
- Teacher & staff vacant posts
- Website links management

### Administrative Panel
- Role-based access control (Admin, Editor, Viewer)
- Single session enforcement
- Database export functionality
- User management
- Site settings management

### Multi-language Support
- English and Bengali language support
- Dynamic content translation

### External API Integration
- Admission API integration
- Student statistics
- Program, session, group data

## Requirements

- **PHP**: ^8.0.2
- **Laravel**: ^9.19
- **MySQL**: 5.7+ or 8.0+
- **Node.js**: ^16.0 (for frontend assets)
- **Composer**: ^2.0

## Installation

### 1. Clone the Repository

```bash
git clone <repository-url>
cd htdc-project
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install Node Dependencies

```bash
npm install
```

### 4. Environment Configuration

```bash
cp .env.example .env
php artisan key:generate
```

### 5. Configure `.env` File

```env
APP_NAME=HTDC
APP_ENV=production
APP_KEY=<generated-key>
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=htdc
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password

MAIL_MAILER=smtp
MAIL_HOST=your-mail-host
MAIL_PORT=465
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-mail-password
MAIL_ENCRYPTION=ssl

SESSION_SECURE_COOKIE=true
```

### 6. Database Setup

```bash
php artisan migrate --force
php artisan db:seed
```

### 7. Storage Link

```bash
php artisan storage:link
```

### 8. Cache Optimization

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Running the Application

### Development

```bash
php artisan serve
npm run dev
```

### Production

```bash
# Run queue worker
php artisan queue:work --sleep=3 --tries=3

# Or use Supervisor (recommended)
# Configure supervisor for queue:work
```

## API Endpoints

### Public Data APIs
| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/programs/admission` | Get admission programs |
| GET | `/api/sessions/admission` | Get admission sessions |
| GET | `/api/groups` | Get all groups |
| GET | `/api/occupations/all` | Get occupations |
| GET | `/api/qualifications/all` | Get qualifications |
| GET | `/api/districts/all` | Get districts |
| GET | `/api/boards/all` | Get education boards |
| GET | `/api/constants` | Get application constants |

### Protected APIs (Requires Sanctum Token)
| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/applications` | List applications |
| GET | `/api/applications/{id}` | Get application details |
| POST | `/api/applications/{id}/status` | Update application status |
| GET | `/api/daily-attendance` | Get attendance data |
| POST | `/api/daily-attendance` | Store attendance data |

## Admin Panel

### Default Credentials

**Super Admin:**
- Email: `info@htdc.edu.bd`
- Password: `Htdc@2026!Secure`

> **Important:** Change the password after first login!

### Access URLs

- **Admin Panel:** `https://your-domain.com/admin/login`
- **Super Admin:** `https://your-domain.com/super-admin/login`

## Security Features

- CSRF protection enabled
- XSS protection with HTML sanitization
- Rate limiting on sensitive routes
- Session encryption enabled
- Security headers (X-Frame-Options, X-Content-Type-Options, etc.)
- Password hashing with bcrypt
- Single session enforcement
- Mass assignment protection

## Project Structure

```
app/
├── Console/Commands/    # Artisan commands
├── Exceptions/          # Exception handling
├── Helpers/             # Helper functions
├── Http/
│   ├── Controllers/     # Application controllers
│   ├── Middleware/       # HTTP middleware
│   └── Kernel.php       # HTTP kernel
├── Jobs/                # Queue jobs
├── Models/              # Eloquent models
├── Providers/           # Service providers
├── Services/            # Business logic services
└── View/                # View components

database/
├── migrations/          # Database migrations
├── seeders/             # Database seeders
└── factories/           # Model factories

resources/
├── views/               # Blade templates
├── css/                 # Stylesheets
└── js/                  # JavaScript files

routes/
├── web.php              # Web routes
├── api.php              # API routes
└── console.php          # Console routes
```

## Queue Configuration

The application uses Redis for queue processing:

```env
QUEUE_CONNECTION=redis
```

Run queue worker:

```bash
php artisan queue:work --sleep=3 --tries=3
```

## Deployment

### Recommended Stack

- **Server:** Ubuntu 22.04 LTS
- **Web Server:** Nginx with PHP-FPM
- **PHP:** 8.1+
- **Database:** MySQL 8.0
- **Cache/Queue:** Redis

### Deployment Steps

1. Clone repository on server
2. Install dependencies (`composer install --no-dev --optimize-autoloader`)
3. Configure `.env` with production values
4. Run migrations (`php artisan migrate --force`)
5. Set storage link (`php artisan storage:link`)
6. Configure Nginx/Apache
7. Set up Supervisor for queue worker
8. Configure SSL certificate

## License

Proprietary - Hajee Mohammad Danesh Science & Technology College
