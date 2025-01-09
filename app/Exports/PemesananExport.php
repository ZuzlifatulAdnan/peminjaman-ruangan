<?php

namespace App\Exports;

use App\Models\Pemesanan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PemesananExport implements FromCollection, WithHeadings
{
    protected $bulan;
    protected $tahun;

    // Constructor untuk menerima parameter bulan dan tahun
    public function __construct($bulan = null, $tahun = null)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    // Mengambil data yang akan diekspor
    public function collection()
    {
        return Pemesanan::with(['user', 'ruangan', 'ukm'])
            ->when($this->bulan, function ($query) {
                $query->whereMonth('tanggal_pesan', $this->bulan);
            })
            ->when($this->tahun, function ($query) {
                $query->whereYear('tanggal_pesan', $this->tahun);
            })
            ->get()
            ->map(function ($pemesanan) {
                return [
                    'Nama User' => $pemesanan->user->name ?? '-',
                    'Ruangan' => $pemesanan->ruangan->nama ?? '-',
                    'UKM' => $pemesanan->ukm->nama ?? '-',
                    'Tanggal Pesan' => $pemesanan->tanggal_pesan,
                    'Waktu Mulai' => $pemesanan->waktu_mulai,
                    'Waktu Selesai' => $pemesanan->waktu_selesai,
                    'Tujuan' => $pemesanan->tujuan ?? '-',
                    'Status' => $pemesanan->status ?? '-',
                ];
            });
    }

    // Menambahkan header untuk file Excel
    public function headings(): array
    {
        return [
            'Nama User',
            'Ruangan',
            'UKM',
            'Tanggal Pesan',
            'Waktu Mulai',
            'Waktu Selesai',
            'Tujuan',
            'Status',
        ];
    }
}
