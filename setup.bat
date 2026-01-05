@echo off
echo ====================================
echo E-commerce Shopping Cart Setup
echo ====================================
echo.

echo Step 1: Creating SQLite database...
if exist database\database.sqlite (
    echo Database file already exists, skipping...
) else (
    type nul > database\database.sqlite
    echo Database file created!
)
echo.

echo Step 2: Running migrations and seeders...
php artisan migrate --seed
if %errorlevel% neq 0 (
    echo ERROR: Migration failed!
    echo Make sure PHP is installed and in your PATH
    pause
    exit /b 1
)
echo.

echo Step 3: Generating route definitions...
php artisan wayfinder:generate
echo.

echo Step 4: Building frontend assets...
call npm run build
if %errorlevel% neq 0 (
    echo ERROR: Build failed!
    echo Make sure Node.js and npm are installed
    pause
    exit /b 1
)
echo.

echo ====================================
echo Setup Complete!
echo ====================================
echo.
echo Login credentials:
echo   Regular User: test@example.com / password
echo   Admin User:   admin@example.com / password
echo.
echo To start the application, run:
echo   composer dev
echo.
echo Then visit: http://localhost:8000
echo.
pause
