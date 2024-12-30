<?php

namespace App\Console;

use App\Models\Pemesanan;
use App\Notifications\PemesananStatusNotification;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            app(\App\Http\Controllers\PeminjamanController::class)->kirimNotifikasiHabis();
        })->everyMinute(); // Jalankan setiap menit
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }

}
