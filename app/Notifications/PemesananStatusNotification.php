<?php

namespace App\Notifications;

use App\Models\Pemesanan;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Http;

class PemesananStatusNotification extends Notification
{
    use Queueable;

    public $pemesanan;
    public $status;

    public function __construct(Pemesanan $pemesanan, $status)
    {
        $this->pemesanan = $pemesanan;
        $this->status = $status;
    }

    public function via($notifiable)
    {
        return ['mail', 'nexmo']; // Menggunakan email dan WhatsApp
    }

    // Notifikasi Email
    // public function toMail($notifiable)
    // {
    //     return (new MailMessage)
    //                 ->line('Status peminjaman ruangan Anda telah ' . $this->status)
    //                 ->action('Lihat Peminjaman', url('/reservations'))
    //                 ->line('Terima kasih telah menggunakan sistem peminjaman kami.');
    // }

    // Notifikasi WhatsApp melalui Fonnte API
    public function toNexmo($notifiable)
    {
        $apiKey = env('FONNTE_API_KEY'); // Ambil API Key dari .env
        $url = "https://api.fonnte.com/sendMessage";

        $phoneNumber = $this->pemesanan->user->no_whatsapp; // Pastikan nomor telepon ada di user model

        $response = Http::post($url, [
            'token' => $apiKey,
            'recipient' => $phoneNumber,
            'message' => 'Status peminjaman ruangan Anda telah ' . $this->status . '. Silakan cek status di aplikasi.'
        ]);

        return $response->successful();
    }
}
