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
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            $pemesanans = Pemesanan::where('status', 'Diterima')
                ->where('waktu_selesai', '<=', now()->addMinutes(15))
                ->get();
    
            foreach ($pemesanans as $pemesanan) {
                $pemesanan->user->notify(new PemesananStatusNotification($pemesanan, '15 menit lagi'));
            }
        })->everyMinute();
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
