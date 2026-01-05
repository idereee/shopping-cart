<?php

namespace App\Jobs;

use App\Mail\LowStockMail;
use App\Models\Product;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class LowStockNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Product $product,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Get all admin users
        $admins = User::where('is_admin', true)->get();

        // Send email to each admin
        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new LowStockMail($this->product));
        }
    }
}
