#!/bin/bash

echo "===================================="
echo "E-commerce Shopping Cart Setup"
echo "===================================="
echo ""

echo "Step 1: Creating SQLite database..."
if [ -f database/database.sqlite ]; then
    echo "Database file already exists, skipping..."
else
    touch database/database.sqlite
    echo "Database file created!"
fi
echo ""

echo "Step 2: Running migrations and seeders..."
php artisan migrate --seed
if [ $? -ne 0 ]; then
    echo "ERROR: Migration failed!"
    echo "Make sure PHP is installed and in your PATH"
    exit 1
fi
echo ""

echo "Step 3: Generating route definitions..."
php artisan wayfinder:generate
echo ""

echo "Step 4: Building frontend assets..."
npm run build
if [ $? -ne 0 ]; then
    echo "ERROR: Build failed!"
    echo "Make sure Node.js and npm are installed"
    exit 1
fi
echo ""

echo "===================================="
echo "Setup Complete!"
echo "===================================="
echo ""
echo "Login credentials:"
echo "  Regular User: test@example.com / password"
echo "  Admin User:   admin@example.com / password"
echo ""
echo "To start the application, run:"
echo "  composer dev"
echo ""
echo "Then visit: http://localhost:8000"
echo ""
