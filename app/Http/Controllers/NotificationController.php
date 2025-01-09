<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Services\FonnteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    public function sendNotificationsAutomatically()
    {
        // Ambil peminjaman dengan status 'diterima' yang hampir selesai
        $pemesanans = Pemesanan::where('status', 'diterima')
            ->where('waktu_selesai', '<=', now()->addMinutes(15)) // Waktu selesai < 15 menit dari sekarang
            ->where('waktu_selesai', '>', now()) // Masih belum selesai
            ->with('user', 'ruangan') // Pastikan relasi user dan ruangan terload
            ->get();

        $fonnteService = new FonnteService();

        foreach ($pemesanans as $pemesanan) {
            // Ambil nomor WhatsApp dari relasi user
            $phoneNumber = $pemesanan->user->no_whatsapp;

            // Buat pesan notifikasi
            $message = "Halo, " . $pemesanan->user->name . 
                       "! Peminjaman Anda untuk ruangan " . $pemesanan->ruangan->nama . 
                       " hampir selesai. Harap menyelesaikan pemakaian sebelum " . 
                       $pemesanan->waktu_selesai->format('H:i') . ".";

            // Kirim pesan melalui Fonnte
            $response = $fonnteService->sendMessage($phoneNumber, $message);

            // Logging untuk debugging (opsional)
            // if (isset($response['status']) && $response['status'] == 'success') {
            //     \Log::info("Notifikasi berhasil dikirim ke: {$phoneNumber}");
            // } else {
            //     \Log::error("Gagal mengirim notifikasi ke: {$phoneNumber}", $response);
            // }
        }
    }
}
