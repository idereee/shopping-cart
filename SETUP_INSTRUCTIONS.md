# Setup Instructions - Fix "no such table: products" Error

## The Problem
You're seeing: `SQLSTATE[HY000]: General error: 1 no such table: products`

This means the database tables haven't been created yet.

## The Solution

Run these commands in your terminal **from the project root directory**:

### Step 1: Create the SQLite database file

**Windows (Command Prompt):**
```cmd
cd d:\projects\shopping-inertia
type nul > database\database.sqlite
```

**Windows (PowerShell):**
```powershell
cd d:\projects\shopping-inertia
New-Item -Path database\database.sqlite -ItemType File -Force
```

**Mac/Linux:**
```bash
cd /d/projects/shopping-inertia
touch database/database.sqlite
```

### Step 2: Run migrations to create tables
```bash
php artisan migrate --seed
```

This will:
- Create the `products` table
- Create the `cart_items` table
- Add `is_admin` column to `users` table
- Create 2 test users (regular and admin)
- Seed 10 sample products

### Step 3: Generate route definitions
```bash
php artisan wayfinder:generate
```

### Step 4: Build frontend assets
```bash
npm run build
```

### Step 5: Start the application
```bash
composer dev
```

## Expected Output

After running `php artisan migrate --seed`, you should see:

```
Migration table created successfully.
Migrating: 0001_01_01_000000_create_users_table
Migrated:  0001_01_01_000000_create_users_table (XX.XXms)
Migrating: 0001_01_01_000001_create_cache_table
Migrated:  0001_01_01_000001_create_cache_table (XX.XXms)
Migrating: 0001_01_01_000002_create_jobs_table
Migrated:  0001_01_01_000002_create_jobs_table (XX.XXms)
Migrating: 2025_08_26_100418_add_two_factor_columns_to_users_table
Migrated:  2025_08_26_100418_add_two_factor_columns_to_users_table (XX.XXms)
Migrating: 2026_01_05_000001_create_products_table
Migrated:  2026_01_05_000001_create_products_table (XX.XXms)
Migrating: 2026_01_05_000002_create_cart_items_table
Migrated:  2026_01_05_000002_create_cart_items_table (XX.XXms)
Migrating: 2026_01_05_000003_add_is_admin_to_users_table
Migrated:  2026_01_05_000003_add_is_admin_to_users_table (XX.XXms)

Seeding database.
```

## Verify It Worked

Check that the database file was created and populated:

```bash
# Check file exists and has data
ls -lh database/database.sqlite

# Or on Windows:
dir database\database.sqlite

# Should show a file with size > 0 KB
```

## Quick Check with Tinker

```bash
php artisan tinker
```

Then run:
```php
\App\Models\Product::count();
// Should return: 10

\App\Models\User::count();
// Should return: 2

exit
```

## Now Visit the Site

1. Start the dev server: `composer dev`
2. Open http://localhost:8000
3. Login with: `test@example.com` / `password`
4. Click "Products" in the sidebar
5. You should see 10 products!

## Still Not Working?

### If you see "database is locked"
```bash
# Stop all running processes
# Then delete and recreate the database:
rm database/database.sqlite
touch database/database.sqlite
php artisan migrate --seed
```

### If migrations fail
```bash
# Reset the database completely:
php artisan migrate:fresh --seed
```

### If you see "Class not found"
```bash
composer dump-autoload
php artisan migrate --seed
```
