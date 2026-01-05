# E-commerce Shopping Cart System

A simple and elegant e-commerce shopping cart system built with Laravel, Inertia.js, React, and Tailwind CSS.

## Features

- **Product Browsing**: Browse products with details including name, price, description, and stock quantity
- **Shopping Cart Management**: Add products to cart, update quantities, and remove items
- **User Authentication**: Secure authentication using Laravel Fortify
- **Stock Management**: Real-time stock tracking with low stock indicators
- **Low Stock Notifications**: Automated email notifications to admin users when products run low on stock (≤5 items)
- **Responsive Design**: Beautiful UI built with Tailwind CSS and shadcn/ui components
- **Queue System**: Background job processing for email notifications

## Tech Stack

- **Backend**: Laravel 12
- **Frontend**: React 19 with TypeScript
- **State Management**: Inertia.js
- **Styling**: Tailwind CSS 4
- **UI Components**: Radix UI & shadcn/ui
- **Database**: SQLite (configurable)
- **Queue**: Database driver (configurable)
- **Mail**: Log driver for development (configurable)

## Installation

### Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js 18+ and npm
- SQLite (or your preferred database)

### Setup Instructions

1. **Clone the repository** (if you haven't already)

2. **Install dependencies**

```bash
composer install
npm install
```

3. **Environment Configuration**

```bash
cp .env.example .env
php artisan key:generate
```

4. **Database Setup**

The project uses SQLite by default. Create the database file:

```bash
touch database/database.sqlite
```

Or update `.env` to use your preferred database.

5. **Run Migrations and Seed Database**

```bash
php artisan migrate --seed
```

This will create:
- Products table with 10 sample products
- Cart items table
- Users table with admin flag
- Two test users:
  - Regular user: `test@example.com` (password: `password`)
  - Admin user: `admin@example.com` (password: `password`)

6. **Build Frontend Assets**

```bash
npm run build
```

## Running the Application

### Development Mode

The easiest way to run the application in development is using the `dev` script which runs the server, queue worker, and Vite concurrently:

```bash
composer dev
```

This command runs:
- Laravel development server on `http://localhost:8000`
- Queue worker for processing jobs
- Vite dev server for hot module replacement

### Alternatively, run each service separately:

**Terminal 1 - Laravel Server:**
```bash
php artisan serve
```

**Terminal 2 - Queue Worker:**
```bash
php artisan queue:work
```

**Terminal 3 - Vite Dev Server:**
```bash
npm run dev
```

## Usage

### User Accounts

**Regular User:**
- Email: `test@example.com`
- Password: `password`

**Admin User (receives low stock notifications):**
- Email: `admin@example.com`
- Password: `password`

### Features Walkthrough

1. **Register/Login**: Create a new account or use the test credentials above
2. **Browse Products**: Navigate to the Products page to view all available products
3. **Add to Cart**: Click "Add to Cart" on any product (stock permitting)
4. **Manage Cart**: View your cart, update quantities, or remove items
5. **Checkout**: Complete your order (this updates stock levels)
6. **Low Stock Alerts**: When stock drops to 5 or below, admin users receive email notifications

### Low Stock Notification System

When a product's stock reaches 5 items or fewer after checkout:
1. A `LowStockNotification` job is dispatched to the queue
2. The queue worker processes the job
3. An email is sent to all admin users with product details
4. In development, emails are logged to `storage/logs/laravel.log`

To view logged emails in development:
```bash
tail -f storage/logs/laravel.log
```

## Project Structure

### Backend (Laravel)

```
app/
├── Http/Controllers/
│   ├── ProductController.php    # Product listing and viewing
│   └── CartController.php        # Cart CRUD and checkout
├── Models/
│   ├── Product.php              # Product model with stock methods
│   ├── CartItem.php             # Cart item model
│   └── User.php                 # User model with cart relationship
├── Jobs/
│   └── LowStockNotification.php # Queue job for email alerts
└── Mail/
    └── LowStockMail.php         # Email notification

database/
├── migrations/
│   ├── 2026_01_05_000001_create_products_table.php
│   ├── 2026_01_05_000002_create_cart_items_table.php
│   └── 2026_01_05_000003_add_is_admin_to_users_table.php
└── seeders/
    ├── DatabaseSeeder.php       # Seeds users
    └── ProductSeeder.php        # Seeds sample products
```

### Frontend (React)

```
resources/js/
├── pages/
│   ├── Products/
│   │   └── Index.tsx           # Product listing page
│   └── Cart/
│       └── Index.tsx           # Shopping cart page
└── components/
    └── app-sidebar.tsx         # Navigation with Products & Cart links
```

## Configuration

### Email Configuration

By default, emails are logged to the Laravel log file. To use a real mail service:

1. Update `.env` with your mail provider settings:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_FROM_ADDRESS=noreply@example.com
```

### Queue Configuration

The default queue connection is `database`. To use Redis or other drivers:

1. Update `.env`:

```env
QUEUE_CONNECTION=redis
```

2. Install required packages and configure accordingly

## Database Schema

### Products Table
- `id`: Primary key
- `name`: Product name
- `description`: Product description
- `price`: Decimal price
- `stock_quantity`: Available stock
- `image_url`: Product image URL

### Cart Items Table
- `id`: Primary key
- `user_id`: Foreign key to users
- `product_id`: Foreign key to products
- `quantity`: Item quantity
- Unique constraint on `user_id` and `product_id`

### Users Table (Extended)
- `is_admin`: Boolean flag for admin users

## API Routes

All routes require authentication:

```
GET    /products              # List all products
GET    /products/{id}         # View single product (not currently used in UI)
GET    /cart                  # View cart
POST   /cart                  # Add item to cart
PUT    /cart/{id}             # Update cart item quantity
DELETE /cart/{id}             # Remove item from cart
POST   /cart/checkout         # Process checkout
```

## Best Practices Followed

- **MVC Architecture**: Clean separation of concerns
- **Eloquent ORM**: Database relationships and queries
- **Queue System**: Asynchronous email processing
- **Authorization**: User-specific cart items
- **Validation**: Input validation on all forms
- **Type Safety**: TypeScript for frontend code
- **Component-based UI**: Reusable React components
- **Responsive Design**: Mobile-first approach

## Testing

Run PHP tests:
```bash
php artisan test
```

Run TypeScript type checking:
```bash
npm run types
```

Run linting:
```bash
npm run lint
```

## Troubleshooting

**Queue not processing:**
- Ensure `php artisan queue:work` is running
- Check `QUEUE_CONNECTION=database` in `.env`

**Emails not sending:**
- Check `MAIL_MAILER=log` in `.env`
- View logs: `tail -f storage/logs/laravel.log`

**Stock not updating:**
- Ensure queue worker is running for low stock notifications

**Frontend not updating:**
- Clear browser cache
- Rebuild assets: `npm run build`

## License

This project is open-sourced software licensed under the MIT license.
