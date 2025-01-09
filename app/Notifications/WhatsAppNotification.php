<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Services\FonnteService;

class WhatsAppNotification extends Notification
{
    use Queueable;

    protected $pemesanan;

    public function __construct($pemesanan)
    {
        $this->pemesanan = $pemesanan;
    }

    public function via($notifiable)
    {
        return ['custom']; // Menggunakan channel kustom untuk WhatsApp
    }

    public function toCustom($notifiable)
    {
        $fonnteService = new FonnteService();

        // Ambil nomor WhatsApp dari relasi user
        $phoneNumber = $this->pemesanan->user->no_whatsapp;

        // Pesan yang akan dikirimkan
        $message = "Halo, " . $this->pemesanan->user->name . 
                   "! Peminjaman Anda untuk ruangan " . $this->pemesanan->ruangan->nama . 
                   " hampir selesai. Harap menyelesaikan pemakaian sebelum " . 
                   $this->pemesanan->waktu_selesai->format('H:i') . ".";

        return $fonnteService->sendMessage($phoneNumber, $message);
    }
}
