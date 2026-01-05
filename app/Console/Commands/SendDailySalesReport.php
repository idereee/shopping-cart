<?php

namespace App\Console\Commands;

use App\Mail\DailySalesReport;
use App\Models\Order;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendDailySalesReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sales:daily-report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send daily sales report to admin users';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Generating daily sales report...');

        // Get yesterday's orders (since this runs in the evening for the completed day)
        $yesterday = now()->subDay()->startOfDay();
        $endOfYesterday = now()->subDay()->endOfDay();

        $orders = Order::with('user')
            ->whereBetween('created_at', [$yesterday, $endOfYesterday])
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate totals
        $totalRevenue = $orders->sum('total');
        $totalItems = $orders->sum('items_count');
        $date = $yesterday->format('F j, Y');

        // Get all admin users
        $admins = User::where('is_admin', true)->get();

        if ($admins->isEmpty()) {
            $this->warn('No admin users found. Skipping email.');
            return self::FAILURE;
        }

        // Send email to each admin
        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(
                new DailySalesReport($orders, $date, $totalRevenue, $totalItems)
            );
        }

        $this->info("Daily sales report sent to {$admins->count()} admin(s).");
        $this->info("Orders: {$orders->count()} | Items: {$totalItems} | Revenue: \${$totalRevenue}");

        return self::SUCCESS;
    }
}
