# Troubleshooting Guide

## Black Screen Issue

If you see a black screen when running the application, try these steps in order:

### 1. Check if the database is set up
```bash
# Make sure the database file exists
# On Windows:
type nul > database\database.sqlite

# On Linux/Mac:
touch database/database.sqlite

# Run migrations
php artisan migrate --seed
```

### 2. Build the frontend assets
```bash
# Install dependencies if not done
npm install

# Build the assets
npm run build

# Or for development with hot reload
npm run dev
```

### 3. Clear all caches
```bash
php artisan optimize:clear
php artisan view:clear
php artisan config:clear
php artisan route:clear
```

### 4. Generate Wayfinder routes (for TypeScript route helpers)
```bash
php artisan wayfinder:generate
```

### 5. Check browser console for errors
- Open your browser's developer tools (F12)
- Check the Console tab for JavaScript errors
- Check the Network tab to see if assets are loading

### 6. Verify the server is running
```bash
# Start the development server
composer dev

# Or start services individually:
# Terminal 1:
php artisan serve

# Terminal 2:
php artisan queue:work

# Terminal 3:
npm run dev
```

### 7. Check file permissions (Linux/Mac)
```bash
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

## Common Errors

### "Route not found" error
**Solution:** Run `php artisan route:clear` and `php artisan wayfinder:generate`

### "Database not found" error
**Solution:** Make sure `database/database.sqlite` exists and `.env` has `DB_CONNECTION=sqlite`

### Assets not loading (404 errors)
**Solution:** Run `npm run build` or `npm run dev`

### "Class not found" errors
**Solution:** Run `composer dump-autoload`

### Flash messages not showing
**Solution:** Already integrated! Flash messages should work now.

### TypeScript errors in IDE
**Solution:** Run `npm run types` to check for type errors

## Quick Reset

If nothing works, try a complete reset:

```bash
# 1. Clear everything
php artisan optimize:clear
rm -rf node_modules
rm -rf vendor
rm database/database.sqlite

# 2. Reinstall
composer install
npm install

# 3. Setup fresh
touch database/database.sqlite
php artisan key:generate
php artisan migrate --seed
php artisan wayfinder:generate

# 4. Build
npm run build

# 5. Run
composer dev
```

## Still Having Issues?

1. Check Laravel logs: `storage/logs/laravel.log`
2. Check browser console (F12 → Console tab)
3. Verify PHP version: `php -v` (requires 8.2+)
4. Verify Node version: `node -v` (requires 18+)
5. Make sure ports 8000 and 5173 are not in use

## Windows-Specific Issues

### "php: command not found"
- Make sure PHP is in your system PATH
- Or use: `C:\path\to\php\php.exe artisan ...`

### "touch: command not found"
```cmd
# Use this instead:
type nul > database\database.sqlite
```

### "Permission denied" on Windows
- Run your terminal as Administrator
- Or disable antivirus temporarily for the project folder

## Mac/Linux-Specific Issues

### SQLite not working
```bash
# Install SQLite
# Ubuntu/Debian:
sudo apt-get install sqlite3 php-sqlite3

# Mac:
brew install sqlite
```

### Port already in use
```bash
# Find what's using port 8000:
lsof -i :8000

# Kill the process:
kill -9 <PID>

# Or use a different port:
php artisan serve --port=8080
```
