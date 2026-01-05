<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;


// Schedule daily sales report to run every evening at 6 PM
Schedule::command('sales:daily-report')->dailyAt('18:00');
