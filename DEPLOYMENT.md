# Bina Adult Care - Deployment Guide

## Pre-Deployment Checklist

### 1. Environment Configuration
Create a `.env` file on your production server with these settings:

```bash
APP_NAME="Bina Adult Care"
APP_ENV=production
APP_KEY=base64:YOUR_APP_KEY_HERE
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database

MAIL_MAILER=smtp
MAIL_HOST=smtp.your-email-provider.com
MAIL_PORT=587
MAIL_USERNAME=your-email@domain.com
MAIL_PASSWORD=your-email-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="info@binaadultcare.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### 2. Optimize for Production
```bash
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link
```

### 3. Security Settings
- Set `APP_DEBUG=false`
- Set `APP_ENV=production`
- Use strong `APP_KEY` (generate with `php artisan key:generate`)
- Enable HTTPS/SSL certificate
- Update CORS settings if needed

## Deployment Methods

### Method 0: GitHub Actions (CI + SSH Deploy)

This repository ships with two workflows in `.github/workflows/`:

| File | Purpose |
| ---- | ------- |
| `ci.yml` | Run Composer install, spin up MySQL service, run migrations, tests, and build Vite assets on push/PR to `main`. |
| `deploy.yml` | (Template) Deploy code to a Linux server over SSH + rsync when pushing to `main` or triggering manually. |

GitHub Pages cannot run PHP, so deployment targets a real server (VPS, managed host, etc.). The workflow assumes you already configured a web server (see Method 2) and created a production `.env` on the server.

#### Enable CI (already active)
Nothing to do—`ci.yml` runs automatically on pushes/PRs to `main`.

#### Enable Deploy Workflow
1. Generate / choose an SSH key (no passphrase) dedicated for deploys: `ssh-keygen -t ed25519 -f deploy_key`.
2. Add the public key to the server's `~/.ssh/authorized_keys` for the deploy user (e.g. `deploy`).
3. Add repository Secrets (Settings → Secrets and variables → Actions):
   - `SSH_HOST` (e.g. `your.server.com`)
   - `SSH_USER` (e.g. `deploy`)
   - `SSH_PRIVATE_KEY` (paste private key contents)
   - `SSH_PATH` (absolute path, e.g. `/var/www/bina-adult-care-main`)
4. Edit `deploy.yml` replacing all placeholder tokens `<SSH_HOST>`, `<SSH_USER>`, `<SSH_PRIVATE_KEY>`, `<SSH_PATH>` with `
   `${{ secrets.SSH_HOST }}`, etc.
5. Commit the change. On next push to `main` the workflow will:
   - Checkout code
   - Add SSH key & known host
   - rsync files (excluding vendor/node_modules)
   - Run production install & optimize commands remotely

#### Optional Hardening
Add a build stage to produce assets locally and upload only `public/build` to minimize server Node requirements. Example additional steps (before rsync):
```yaml
  - name: Build assets locally
    run: |
      npm ci
      npm run build
```
Then remove on-server `npm ci && npm run build` from the remote command block.

#### Zero-Downtime Idea
Adopt release directories (e.g. `/var/www/app/releases/<timestamp>` + symlink `current`) and update the workflow to deploy into a new release folder, then atomically `ln -sfn`. Tools like Deployer or Laravel Envoy can formalize this later.

---

### Method 1: Shared Hosting (cPanel)

**Requirements:**
- PHP 8.2 or higher
- MySQL 5.7 or higher
- Composer access (or upload vendor folder)

**Steps:**

1. **Upload Files:**
   - Upload ALL files to `/home/username/laravel` (outside public_html)
   - Upload ONLY `public` folder contents to `/public_html`

2. **Update index.php in public_html:**
   ```php
   <?php
   require __DIR__.'/../laravel/vendor/autoload.php';
   $app = require_once __DIR__.'/../laravel/bootstrap/app.php';
   ```

3. **Create Database:**
   - Create MySQL database via cPanel
   - Import `database/bina_adult_care.sql` or run migrations

4. **Set Permissions:**
   ```bash
   chmod -R 755 storage
   chmod -R 755 bootstrap/cache
   ```

5. **Configure .env:**
   - Copy `.env.example` to `.env`
   - Update database credentials
   - Set `APP_URL` to your domain

6. **Run Setup (via SSH if available):**
   ```bash
   cd /home/username/laravel
   php artisan key:generate
   php artisan migrate --force
   php artisan db:seed --force
   php artisan storage:link
   ```

---

### Method 2: VPS/Cloud Server (Ubuntu/Debian)

**Requirements:**
- Ubuntu 20.04 or higher
- Root/sudo access

**Steps:**

1. **Install Dependencies:**
   ```bash
   sudo apt update
   sudo apt install php8.2 php8.2-fpm php8.2-mysql php8.2-mbstring php8.2-xml php8.2-gd php8.2-curl php8.2-zip nginx mysql-server composer git
   ```

2. **Clone Repository:**
   ```bash
   cd /var/www
   sudo git clone https://github.com/wateeez/bina-adult-care-main.git
   cd bina-adult-care-main
   sudo composer install --optimize-autoloader --no-dev
   ```

3. **Setup Database:**
   ```bash
   sudo mysql
   CREATE DATABASE bina_adult_care;
   CREATE USER 'bina_user'@'localhost' IDENTIFIED BY 'strong_password';
   GRANT ALL PRIVILEGES ON bina_adult_care.* TO 'bina_user'@'localhost';
   FLUSH PRIVILEGES;
   EXIT;
   ```

4. **Configure Environment:**
   ```bash
   sudo cp .env.example .env
   sudo nano .env  # Edit with your settings
   sudo php artisan key:generate
   ```

5. **Set Permissions:**
   ```bash
   sudo chown -R www-data:www-data /var/www/bina-adult-care-main
   sudo chmod -R 775 storage bootstrap/cache
   ```

6. **Run Migrations:**
   ```bash
   php artisan migrate --force
   php artisan db:seed --force
   php artisan storage:link
   php artisan optimize
   ```

7. **Configure Nginx:**
   ```bash
   sudo nano /etc/nginx/sites-available/bina-adult-care
   ```
   
   Add this configuration:
   ```nginx
   server {
       listen 80;
       server_name yourdomain.com www.yourdomain.com;
       root /var/www/bina-adult-care-main/public;

       add_header X-Frame-Options "SAMEORIGIN";
       add_header X-Content-Type-Options "nosniff";

       index index.php;

       charset utf-8;

       location / {
           try_files $uri $uri/ /index.php?$query_string;
       }

       location = /favicon.ico { access_log off; log_not_found off; }
       location = /robots.txt  { access_log off; log_not_found off; }

       error_page 404 /index.php;

       location ~ \.php$ {
           fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
           fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
           include fastcgi_params;
       }

       location ~ /\.(?!well-known).* {
           deny all;
       }
   }
   ```

8. **Enable Site and Restart:**
   ```bash
   sudo ln -s /etc/nginx/sites-available/bina-adult-care /etc/nginx/sites-enabled/
   sudo nginx -t
   sudo systemctl restart nginx
   ```

9. **Setup SSL with Let's Encrypt:**
   ```bash
   sudo apt install certbot python3-certbot-nginx
   sudo certbot --nginx -d yourdomain.com -d www.yourdomain.com
   ```

---

### Method 3: Heroku (Platform-as-a-Service)

1. **Create Procfile:**
   ```
   web: vendor/bin/heroku-php-apache2 public/
   ```

2. **Deploy:**
   ```bash
   heroku login
   heroku create bina-adult-care
   heroku addons:create cleardb:ignite
   git push heroku main
   heroku config:set APP_KEY=$(php artisan key:generate --show)
   heroku run php artisan migrate --force
   heroku run php artisan db:seed --force
   ```

---

## Post-Deployment Tasks

1. **Test the Website:**
   - Visit your domain
   - Test admin login: `/admin/login`
   - Check all pages load correctly
   - Test image uploads

2. **Setup Automated Backups:**
   ```bash
   # Add to crontab
   0 2 * * * mysqldump -u username -p password bina_adult_care > /backups/db_$(date +\%Y\%m\%d).sql
   ```

3. **Monitor Logs:**
   ```bash
   tail -f storage/logs/laravel.log
   ```

4. **Setup Email (Optional):**
   - Configure SMTP settings in `.env`
   - Test contact form submissions

## Troubleshooting

### 500 Internal Server Error
- Check `storage/logs/laravel.log`
- Verify permissions: `chmod -R 775 storage bootstrap/cache`
- Clear cache: `php artisan cache:clear`

### Images Not Showing
- Run: `php artisan storage:link`
- Verify permissions on `storage/app/public`

### Database Connection Error
- Check `.env` database credentials
- Verify MySQL is running
- Test connection: `php artisan tinker` then `DB::connection()->getPdo();`

### 404 on All Routes
- Check Nginx/Apache configuration
- Verify `public/.htaccess` exists
- Enable mod_rewrite (Apache)

## Recommended Hosting Providers

- **Shared Hosting:** SiteGround, Bluehost (with SSH access)
- **VPS:** DigitalOcean, Linode, Vultr
- **Managed Laravel:** Laravel Forge, Ploi, Cloudways
- **Free (for testing):** Heroku Free Tier, Railway.app

## Support

For deployment issues, check:
- Laravel Docs: https://laravel.com/docs/deployment
- Server Requirements: https://laravel.com/docs/deployment#server-requirements
