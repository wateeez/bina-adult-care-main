# AWS Free Tier Guide: Hosting Laravel + MySQL Database

This is a step-by-step guide for beginners to host a Laravel website with a MySQL database on AWS Free Tier using **Elastic Beanstalk** and **RDS**.

---

## 0. Checklist Before Starting
- AWS account created.
- Laravel project on your computer.
- MySQL database on your computer (or .sql file).
- Optional: domain name.

---

## 1. Prepare Laravel Project for Upload
1. Open your Laravel folder.
2. Delete or rename `.env` file.
3. Ensure `public` folder exists.
4. Right-click project folder → "Send to → Compressed (zipped) folder" → `laravel.zip`.

---

## 2. Create Elastic Beanstalk App
1. Go to **Elastic Beanstalk** in AWS Console.
2. Click **Create application**.
3. Fill in:
   - Application name: e.g., `MyLaravelApp`
   - Platform: PHP
   - Presets: Free tier
   - Application code: Upload your `laravel.zip`
4. Click **Create application**.
5. Wait 5–10 minutes until environment status = Green.
6. Click the URL to see your Laravel site.

---

## 3. Create MySQL Database on RDS
1. Go to **RDS → Databases → Create database**.
2. Choose:
   - Engine: MySQL
   - Template: Free tier
   - DB instance identifier: `laraveldb`
   - Master username: `admin`
   - Password: secure password
   - DB instance class: `db.t3.micro`
   - Storage: leave default (20GB)
   - Public access: No (private)
3. Click **Create database**.
4. Wait until status = Available.

---

## 4. Find Database Connection Info
- Endpoint: e.g., `laraveldb.xxxxx.us-east-1.rds.amazonaws.com`
- Port: 3306
- Username: `admin`
- Password: the one you set

---

## 5. Connect Elastic Beanstalk to RDS
1. Go to **Elastic Beanstalk → Environments → Configuration → Software → Edit**.
2. Under **Environment properties**, add:
   - APP_ENV = production
   - APP_DEBUG = false
   - APP_KEY = (from local `php artisan key:generate --show`)
   - DB_CONNECTION = mysql
   - DB_HOST = RDS endpoint
   - DB_PORT = 3306
   - DB_DATABASE = database name
   - DB_USERNAME = admin
   - DB_PASSWORD = your password
3. Click **Apply**.

---

## 6. Import Existing MySQL Database

### Step 1: Export Local Database
- Using phpMyAdmin: Select DB → Export → Quick → SQL → Go → download `.sql` file.
- Using MySQL Workbench/DBeaver: Server → Data Export → Self-Contained File → Start Export → `.sql` file.

### Step 2: Allow Connection to RDS
1. Go to **RDS → Databases → your instance → Connectivity & security**.
2. Under **Public access**, temporarily select Yes.
3. Go to **VPC security groups → Inbound rules → Edit**:
   - Type: MYSQL/Aurora (3306)
   - Source: My IP
   - Save rules

### Step 3: Import Database Using MySQL Workbench
1. Open MySQL Workbench → New Connection:
   - Hostname: RDS endpoint
   - Port: 3306
   - Username: admin
   - Password: your password
2. Open connection.
3. File → Open SQL Script → select `.sql` file.
4. Click ⚡ (Run) → import complete.

### Step 4: Disable Public Access
- Go back to **RDS → Modify → Public access = No**.
- Remove inbound rule from your IP for security.

---

## 7. Test Laravel App
- Go to Elastic Beanstalk URL → your Laravel site should now show with the imported database data.

---

## Optional Next Steps
- Add a domain via Route 53 or other registrar.
- Add HTTPS using AWS Certificate Manager.
- Stop or terminate resources when not in use to avoid charges.

---

This completes your **Laravel + MySQL setup on AWS Free Tier**.