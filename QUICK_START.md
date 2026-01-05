# Quick Start Guide

## Automated Setup (Recommended)

### Windows:
```cmd
setup.bat
```

### Mac/Linux:
```bash
chmod +x setup.sh
./setup.sh
```

## Manual Setup (5 minutes)

1. **Install dependencies**
```bash
composer install
npm install
```

2. **Setup environment**
```bash
cp .env.example .env
php artisan key:generate
```

3. **Create database and seed data**

**Windows (Command Prompt):**
```cmd
type nul > database\database.sqlite
php artisan migrate --seed
```

**Windows (PowerShell):**
```powershell
New-Item -Path database\database.sqlite -ItemType File -Force
php artisan migrate --seed
```

**Mac/Linux:**
```bash
touch database/database.sqlite
php artisan migrate --seed
```

4. **Generate routes and build assets**
```bash
php artisan wayfinder:generate
npm run build
```

## Run the Application

**Easiest way - Single command:**
```bash
composer dev
```

This runs everything you need:
- Laravel server at http://localhost:8000
- Queue worker for email notifications
- Vite dev server with hot reload

## Login Credentials

**Regular User:**
- Email: `test@example.com`
- Password: `password`

**Admin User (receives low stock alerts):**
- Email: `admin@example.com`
- Password: `password`

## Test the Features

1. Visit http://localhost:8000
2. Login with test user credentials
3. Click "Products" in the sidebar
4. Add items to cart
5. View cart and update quantities
6. Complete checkout
7. Products with ≤5 stock will trigger email notifications to admin

## View Email Notifications

Emails are logged in development mode. To see them:
```bash
tail -f storage/logs/laravel.log
```

## Stop the Application

Press `Ctrl+C` in the terminal running `composer dev`

## Need Help?

See [README.md](README.md) for detailed documentation.
