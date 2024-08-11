<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('updateaccesstoken:amazon')->everyThirtyMinutes()->withoutOverlapping();

        $schedule->command('app:fba-shipment-reverse-sync')->everyFiveMinutes()->withoutOverlapping();
        $schedule->command('app:fba-shipment-items-reverse-sync')->everyMinute()->withoutOverlapping();

        $schedule->command('app:fetch-amazon-product')->everyFifteenMinutes()->withoutOverlapping();
        $schedule->command('app:fetch-amazon-fba-inventory')->cron('7,37 * * * *')->withoutOverlapping();

        $schedule->command('app:get-amazon-product-detail')->everyFiveMinutes()->withoutOverlapping();

        $schedule->command('app:update-feed-status')->everyMinute()->withoutOverlapping();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
