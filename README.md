# Bina Adult Care - Website

A professional caregiving services website built with Laravel, featuring a complete CMS for managing services, content, benefits, and contact inquiries.

## ✨ Features

- 🏠 **Dynamic Frontend**: Responsive pages with database-driven content
- 🔐 **Admin Dashboard**: Secure admin panel for content management
- 📝 **Services Management**: Add, edit, delete services with image uploads
- 🎁 **Benefits System**: Customizable benefits with icon picker
- 📧 **Contact Form**: Message submission and management
- 🖼️ **Content Management**: Edit page content with background images
- 🎨 **Visual Icon Picker**: Choose from 48+ Font Awesome icons
- 📱 **Responsive Design**: Mobile-friendly interface

## 🚀 Quick Start

### Prerequisites

- PHP 8.2 or higher
- Composer
- MySQL 5.7 or higher
- Node.js & NPM (optional, for asset compilation)

### Installation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/wateeez/bina-adult-care-main.git
   cd bina-adult-care-main
   ```

2. **Install dependencies:**
   ```bash
   composer install
   ```

3. **Set up environment:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure database in `.env`:**
   ```ini
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=bina_adult_care
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

5. **Create database:**
   ```sql
   CREATE DATABASE bina_adult_care;
   ```

6. **Run migrations and seed data:**
   ```bash
   php artisan migrate --seed
   ```

7. **Create storage symlink:**
   ```bash
   php artisan storage:link
   ```

8. **Start development server:**
   ```bash
   php artisan serve
   ```

Visit `http://localhost:8000` to see your website!

## 🔑 Default Admin Credentials

- **Email:** admin@bina-adult-care.com
- **Password:** admin123

⚠️ **Important:** Change these credentials after first login!

## 📁 Project Structure

```
bina-adult-care-main/
├── app/
│   ├── Http/Controllers/
│   │   ├── FrontendController.php
│   │   ├── WebAuthController.php
│   │   └── Admin/              # Admin panel controllers
│   ├── Models/                  # Eloquent models
│   └── Middleware/
├── database/
│   ├── migrations/             # Database schema
│   ├── seeders/                # Default data
│   └── bina_adult_care.sql    # SQL dump
├── public/
│   ├── css/                    # Stylesheets
│   ├── js/                     # JavaScript files
│   └── storage/                # Symlink to storage/app/public
├── resources/views/
│   ├── frontend/               # Public pages
│   └── admin/                  # Admin panel views
├── routes/
│   ├── web.php                 # Web routes
│   └── api.php                 # API routes
└── storage/app/public/
    ├── services/               # Service images
    └── content/                # Content images
```

## 🎯 Admin Panel Features

Access the admin panel at `/admin/login`

### Dashboard
- Quick stats overview
- Recent contact messages
- Services preview

### Services Management
- Create/Edit/Delete services
- Upload service images (JPEG, PNG, GIF up to 2MB)
- Manage service descriptions

### Benefits Management
- Add/Edit/Delete benefits
- Visual icon picker with 48+ icons
- Custom descriptions
- Order management

### Content Management
- Edit page content
- Upload background images for hero sections
- Manage content for home, about, contact pages

### Contact Messages
- View all contact form submissions
- Read detailed messages
- Delete processed messages

## 🚢 Deployment

See [DEPLOYMENT.md](DEPLOYMENT.md) for comprehensive deployment instructions covering:
- Shared hosting (cPanel)
- VPS/Cloud servers
- Platform-as-a-Service (Heroku)

## 📝 Routes

### Public Routes
- `/` - Home page
- `/about` - About page
- `/services` - Services listing
- `/contact` - Contact form

### Admin Routes
- `/admin/login` - Admin login
- `/admin/dashboard` - Dashboard
- `/admin/services` - Services management
- `/admin/benefits` - Benefits management
- `/admin/contacts` - Contact messages
- `/admin/content` - Content management

## 🛠️ Development

### Run Tests
```bash
php artisan test
```

### Clear Caches
```bash
php artisan cache:clear
php artisan view:clear
php artisan config:clear
php artisan route:clear
```

### Optimize for Production
```bash
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 📊 Database Schema

- **users** - Admin users
- **user_admin** - Admin user relationships
- **services** - Service listings with images
- **benefits** - Benefits with icons
- **contents** - Page content with background images
- **contacts** - Contact form submissions

## 🔧 Configuration

Key configuration files:
- `.env` - Environment variables
- `config/app.php` - Application settings
- `config/database.php` - Database configuration
- `config/filesystems.php` - Storage configuration

## 📚 Documentation

- [Deployment Guide](DEPLOYMENT.md) - Comprehensive deployment instructions
- [Cleanup Summary](CLEANUP_SUMMARY.md) - Project optimization details
- [Laravel Docs](https://laravel.com/docs) - Framework documentation

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📄 License

This project is proprietary software. All rights reserved.

## 👨‍💻 Maintainer

**wateeez** - [GitHub Profile](https://github.com/wateeez)

## 🙏 Acknowledgments

- Laravel Framework
- Font Awesome Icons
- Bootstrap (Admin Panel)

---

**Version:** 1.0.0  
**Last Updated:** November 6, 2025  
**Status:** ✅ Production Ready

