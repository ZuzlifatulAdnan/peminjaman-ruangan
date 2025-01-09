<?php

namespace App\Console\Commands;

use App\Models\Pemesanan;
use App\Services\FonnteService;
use Illuminate\Console\Command;

class SendWhatsAppReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:whatsapp-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send WhatsApp reminders for accepted room bookings that will expire in 15 minutes';
    protected $fonnteService;

    public function __construct(FonnteService $fonnteService)
    {
        parent::__construct();
        $this->fonnteService = $fonnteService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = now();
        $fifteenMinutesLater = $now->copy()->addMinutes(15);

        // Ambil peminjaman yang statusnya 'Diterima' dan akan habis dalam 15 menit
        $peminjaman = Pemesanan::where('status', 'Diterima')
            ->where('waktu_selesai', '<=', $fifteenMinutesLater)
            ->where('waktu_selesai', '>', $now)
            ->with('user') // Pastikan relasi user ada
            ->get();

        foreach ($peminjaman as $item) {
            $this->sendWhatsAppNotification($item);
        }
    }
    protected function sendWhatsAppNotification($peminjaman)
    {
        $message = 'Reminder: Your room booking will expire in 15 minutes.';
        $phone = $peminjaman->user->no_whatsapp; // Pastikan kolom ini ada di tabel users

        $response = $this->fonnteService->sendMessage($phone, $message);

        if (isset($response['success']) && $response['success']) {
            $this->info('Reminder sent to ' . $phone);
        } else {
            $this->error('Failed to send reminder to ' . $phone);
        }
    }
}
