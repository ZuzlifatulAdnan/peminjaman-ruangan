<?php

namespace App\Console\Commands;

use App\Models\Pemesanan;
use App\Services\FonnteService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendReminder extends Command
{
    // Signature untuk Artisan CLI
    protected $signature = 'reminder:send';

    // Deskripsi Command
    protected $description = 'Kirim pengingat otomatis 15 menit sebelum waktu selesai peminjaman';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        try {
            // Waktu sekarang
            $currentTime = Carbon::now();

            // Ambil semua pemesanan yang waktunya selesai dalam 15 menit dari waktu sekarang
            $peminjamans = Pemesanan::where('status', 'Diterima') // Status harus 'Diterima'
                ->where('waktu_selesai', '>=', $currentTime) // Waktu selesai belum lewat
                ->where('waktu_selesai', '<=', $currentTime->addMinutes(15)) // Dalam 15 menit ke depan
                ->get();

            // Jika tidak ada peminjaman yang perlu diingatkan
            if ($peminjamans->isEmpty()) {
                $this->info('Tidak ada peminjaman yang membutuhkan pengingat saat ini.');
                return;
            }

            // Proses setiap pemesanan yang membutuhkan pengingat
            foreach ($peminjamans as $pemesanan) {
                // Ambil nomor telepon pengguna
                $userPhone = $pemesanan->user->phone ?? null;

                // Jika nomor telepon tidak ada, lanjutkan ke pemesanan berikutnya
                if (!$userPhone) {
                    $this->warn("Pemesanan ID {$pemesanan->id} tidak memiliki nomor telepon.");
                    continue;
                }

                // Buat pesan pengingat
                $message = "Halo, {$pemesanan->user->name}!\n\n" .
                           "Pengingat: Waktu peminjaman ruangan Anda hampir selesai.\n" .
                           "Ruangan: {$pemesanan->ruangan->nama}\n" .
                           "Waktu selesai: " . Carbon::parse($pemesanan->waktu_selesai)->format('H:i') . "\n\n" .
                           "Mohon segera menyelesaikan penggunaan ruangan. Terima kasih!";

                // Kirim pesan menggunakan Fonnte
                app(FonnteService::class)->sendMessage($userPhone, $message);

                // Log pengiriman pesan pengingat
                $this->info("Pengingat berhasil dikirim ke {$userPhone} untuk pemesanan ID {$pemesanan->id}.");
            }
        } catch (\Exception $e) {
            // Tangani error jika ada
            $this->error("Error: " . $e->getMessage());
        }
    }
}
