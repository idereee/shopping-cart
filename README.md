# E-commerce Shopping Cart System

A modern e-commerce shopping cart application built with Laravel 12, React 19 (TypeScript), Inertia.js, and Tailwind CSS with shadcn/ui components.

## 🎥 Demo Video

[Video Walkthrough](https://www.loom.com/share/0124b576e7564293ba0934fda5595c7b) - Complete demo and code explanation

## ✨ Features

- **Product Browsing**: Browse products with details including name, price, description, and stock quantity
- **Shopping Cart Management**: Add products to cart, update quantities, and remove items
- **User Authentication**: Secure authentication using Laravel Fortify
- **Real-time Stock Management**: Live stock tracking with low stock indicators (≤5 items highlighted)
- **Low Stock Email Notifications**: Automated background job sends alerts to admin users when products run low
- **Daily Sales Report**: Scheduled job runs every evening at 6 PM, emailing order summaries to admin users
- **Queue System**: Background job processing for scalable email delivery
- **Responsive Design**: Beautiful, modern UI built with Tailwind CSS 4 and shadcn/ui components
- **TypeScript**: Full type safety in React components

## 🛠️ Tech Stack

- **Backend**: Laravel 12
- **Frontend**: React 19 with TypeScript
- **State Management**: Inertia.js (SPA without building an API)
- **Styling**: Tailwind CSS 4
- **UI Components**: Radix UI & shadcn/ui
- **Database**: SQLite (development), configurable for production
- **Queue**: Database driver (configurable)
- **Mail**: Log driver for development (configurable)
- **Authentication**: Laravel Fortify

## 📋 Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js 20+ and npm
- SQLite (or your preferred database)

## 🚀 Installation

### 1. Clone the Repository
```bash
git clone https://github.com/idereee/shopping-cart.git
cd shopping-cart
```

### 2. Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### 3. Environment Configuration
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Database Setup

**For SQLite (default):**
```bash
# Create database file
touch database/database.sqlite
```

**For other databases:**

Update `.env` with your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=shopping_cart
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 5. Run Migrations and Seed Database
```bash
php artisan migrate --seed
```

This creates:
- **Products table** with 10 sample products (including low-stock items)
- **Cart items table** for user-specific carts
- **Orders and order items tables** for checkout functionality
- **Users table** with admin flag
- **Two test users:**
  - Regular user: `test@example.com` / `password`
  - Admin user: `admin@example.com` / `password` (receives email notifications)

### 6. Build Frontend Assets

**For development:**
```bash
npm run dev
```

**For production:**
```bash
npm run build
```

## 🏃 Running the Application

### Option 1: All-in-One Development Script (Recommended)
```bash
composer dev
```

This single command runs:
- Laravel development server on `http://localhost:8000`
- Queue worker for processing background jobs
- Vite dev server for hot module replacement

### Option 2: Run Services Separately

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

**Terminal 4 - Scheduler (Optional, for testing scheduled jobs):**
```bash
php artisan schedule:work
```

## 👤 Test Accounts

**Regular User:**
- Email: `test@example.com`
- Password: `password`

**Admin User (receives all email notifications):**
- Email: `admin@example.com`
- Password: `password`

## 📖 Usage Guide

### Basic Workflow

1. **Register/Login**: Create a new account or use test credentials
2. **Browse Products**: Navigate to Products page to view all available items
3. **Add to Cart**: Click "Add to Cart" on any product (if stock is available)
4. **Manage Cart**: View cart, update quantities, or remove items
5. **Checkout**: Complete your order to create an order record and update stock

### Low Stock Notification System

**How it works:**

When a product's stock reaches **5 items or fewer** after checkout:

1. A `LowStockNotification` job is automatically dispatched to the queue
2. The queue worker processes the job in the background
3. An email notification is sent to **all admin users** with:
   - Product name
   - Current stock level
   - Price information
4. In development mode, emails are logged to `storage/logs/laravel.log`

**Testing low stock notifications:**

1. Login and add a low-stock product to cart (look for items with ≤5 stock, highlighted in red)
2. Complete checkout
3. Observe queue worker terminal - should show "Processing job"
4. Check email logs:
```bash
   tail -f storage/logs/laravel.log
```
5. Look for "Subject: Low Stock Alert: [Product Name]"

### Daily Sales Report System

**How it works:**

A scheduled job runs **daily at 6:00 PM**:

1. Collects all orders placed during the current day
2. Generates a comprehensive report including:
   - Total number of orders
   - Total revenue
   - Detailed breakdown of each order (items, quantities, prices)
3. Emails the report to all admin users
4. In development, emails are logged to `storage/logs/laravel.log`

**Testing the daily sales report manually:**
```bash
# Run the command directly (no need to wait for 6 PM)
php artisan sales:daily-report
```

**View the email:**
```bash
# Watch logs in real-time
tail -f storage/logs/laravel.log

# Or open in editor
notepad storage/logs/laravel.log  # Windows
cat storage/logs/laravel.log      # Mac/Linux
```

Look for "Subject: Daily Sales Report - [Date]"

## 📁 Project Structure

### Backend (Laravel)
```
app/
├── Http/
│   └── Controllers/
│       ├── ProductController.php      # Product listing
│       └── CartController.php          # Cart CRUD & checkout logic
├── Models/
│   ├── Product.php                    # Product model with stock methods
│   ├── CartItem.php                   # Cart item model
│   ├── Order.php                      # Order model
│   ├── OrderItem.php                  # Order line items
│   └── User.php                       # User model with cart relationship
├── Jobs/
│   ├── LowStockNotification.php       # Queue job for low stock alerts
│   └── DailySalesReportJob.php        # Queue job for sales reports
└── Mail/
    ├── LowStockMail.php               # Low stock email template
    └── DailySalesReportMail.php       # Daily sales email template

database/
├── migrations/
│   ├── create_products_table.php
│   ├── create_cart_items_table.php
│   ├── create_orders_table.php
│   ├── create_order_items_table.php
│   └── add_is_admin_to_users_table.php
└── seeders/
    ├── DatabaseSeeder.php             # Seeds test users
    └── ProductSeeder.php              # Seeds 10 sample products

routes/
├── web.php                            # Web routes (products, cart, checkout)
└── console.php                        # Scheduled task configuration
```

### Frontend (React + TypeScript)
```
resources/js/
├── pages/
│   ├── Products/
│   │   └── Index.tsx                 # Product listing page
│   └── Cart/
│       └── Index.tsx                 # Shopping cart page
├── components/
│   ├── ui/                           # shadcn/ui components
│   └── app-sidebar.tsx               # Navigation sidebar
└── types/
    └── index.d.ts                    # TypeScript type definitions
```

## ⚙️ Configuration

### Email Configuration

**Development (default):**

Emails are logged to `storage/logs/laravel.log`:
```env
MAIL_MAILER=log
```

**Production:**

Update `.env` with your mail provider:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_FROM_ADDRESS=noreply@example.com
MAIL_FROM_NAME="${APP_NAME}"
```

### Queue Configuration

**Development (default):**

Uses database driver:
```env
QUEUE_CONNECTION=database
```

**Production:**

Consider using Redis for better performance:
```env
QUEUE_CONNECTION=redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

### Scheduled Tasks

The daily sales report runs automatically at 6 PM when the Laravel scheduler is active.

**In production**, add this cron entry:
```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

**In development**, run:
```bash
php artisan schedule:work
```

## 🗄️ Database Schema

### Products Table
- `id`: Primary key
- `name`: Product name (string)
- `description`: Product description (text, nullable)
- `price`: Product price (decimal 10,2)
- `stock_quantity`: Available stock (integer)
- `image_url`: Product image URL (string, nullable)
- `created_at`, `updated_at`: Timestamps

### Cart Items Table
- `id`: Primary key
- `user_id`: Foreign key → users
- `product_id`: Foreign key → products
- `quantity`: Item quantity (integer)
- `created_at`, `updated_at`: Timestamps
- **Unique constraint**: `user_id` + `product_id` (one row per product per user)

### Orders Table
- `id`: Primary key
- `user_id`: Foreign key → users
- `total_amount`: Order total (decimal 10,2)
- `created_at`, `updated_at`: Timestamps

### Order Items Table
- `id`: Primary key
- `order_id`: Foreign key → orders
- `product_id`: Foreign key → products
- `quantity`: Item quantity (integer)
- `price`: Price at time of purchase (decimal 10,2)
- `created_at`, `updated_at`: Timestamps

### Users Table (Extended)
- Standard Laravel user fields
- `is_admin`: Boolean flag (default: false)
- Admin users receive all email notifications

## 🛣️ API Routes

All routes require authentication (except login/register):
```
GET    /products              # List all products
GET    /cart                  # View user's cart
POST   /cart                  # Add item to cart
PUT    /cart/{id}             # Update cart item quantity
DELETE /cart/{id}             # Remove item from cart
POST   /cart/checkout         # Process checkout & create order
```

## 🧪 Testing

### Manual Testing Checklist

- [ ] Register a new user account
- [ ] Browse products page
- [ ] Add product to cart
- [ ] Update cart item quantity
- [ ] Remove item from cart
- [ ] Checkout successfully
- [ ] Verify stock quantity decreased
- [ ] Check low stock email in logs (for items with ≤5 stock)
- [ ] Run `php artisan sales:daily-report`
- [ ] Verify daily sales email in logs

### Automated Testing

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

## 🐛 Troubleshooting

**Queue not processing jobs:**
- Ensure `php artisan queue:work` is running
- Check `QUEUE_CONNECTION=database` in `.env`
- Verify jobs table exists: `php artisan queue:table && php artisan migrate`

**Emails not appearing:**
- Check `MAIL_MAILER=log` in `.env`
- View logs: `tail -f storage/logs/laravel.log`
- Ensure queue worker is running

**Stock not updating after checkout:**
- Verify checkout process completes without errors
- Check `orders` and `order_items` tables have records
- Review Laravel logs: `storage/logs/laravel.log`

**Low stock notifications not sending:**
- Ensure product stock is ≤5
- Verify queue worker is running
- Check that admin user exists (`is_admin = 1`)
- Review job processing in queue worker terminal

**Scheduled jobs not running:**
- In development: Run `php artisan schedule:work`
- In production: Ensure cron job is configured
- Test manually: `php artisan sales:daily-report`

**Frontend not updating:**
- Clear browser cache (Ctrl+F5)
- Rebuild assets: `npm run build`
- Check browser console for errors

## 🏗️ Best Practices Implemented

- **MVC Architecture**: Clean separation of concerns
- **Eloquent ORM**: Proper use of relationships and query builder
- **Queue System**: Asynchronous processing for email delivery
- **Authorization**: User-specific cart items with proper access control
- **Validation**: Input validation on all user inputs
- **Type Safety**: TypeScript for compile-time type checking
- **Component-based UI**: Reusable React components with shadcn/ui
- **Responsive Design**: Mobile-first approach with Tailwind CSS
- **Database Transactions**: Atomic operations for checkout process
- **Error Handling**: Graceful error handling throughout
- **Scheduled Tasks**: Laravel scheduler for automated jobs
- **Clean Code**: PSR standards, meaningful variable names, proper documentation

## 📦 Dependencies

### PHP (via Composer)
- laravel/framework: ^12.0
- laravel/fortify: ^1.0
- inertiajs/inertia-laravel: ^2.0

### JavaScript (via npm)
- react: ^19.0
- react-dom: ^19.0
- @inertiajs/react: ^2.0
- @radix-ui/*: Various UI primitives
- tailwindcss: ^4.0
- typescript: ^5.0
- vite: ^7.0

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 👨‍💻 Author

**Idersaihan Tsedendorj**
- Email: idereee@gmail.com
- GitHub: [@idereee](https://github.com/idereee)

## 📝 Notes

- **Time to Complete**: Approximately 8 hours
- **Development Approach**: Started with backend (models, controllers, jobs) then built React frontend with TypeScript for type safety
- **Key Decisions**: 
  - Used React instead of Vue for better TypeScript integration
  - Implemented shadcn/ui for professional, modern UI components
  - Database-backed cart (not session-based) as specified in requirements
  - Queue-based email delivery for scalability
  - Scheduled tasks using Laravel's built-in scheduler

## 🙏 Acknowledgments

Built as a practical task demonstration showcasing:
- Laravel best practices
- Modern React development with TypeScript
- Queue-based background processing
- Scheduled task automation
- Professional UI/UX design

---

For questions or issues, please open an issue on GitHub or contact me directly.