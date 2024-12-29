<?php

namespace App\Exports;

use App\Models\Pemesanan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithFilters;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class PemesananExport implements FromCollection, WithHeadings, WithMapping
{
    protected $bulan;
    protected $tahun;

    // Constructor to accept filters
    public function __construct($bulan, $tahun)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    // Define the headings for the Excel file
    public function headings(): array
    {
        return [
            'No',
            'Nama Pemesan',
            'Gedung || Ruangan',
            'Tanggal Pemesanan',
            'Status Pesanan',
            'Waktu Pemesanan',
        ];
    }

    // Filter and map the data
    public function collection()
    {
        $query = Pemesanan::query();

        // Apply filters if provided
        if ($this->bulan) {
            $query->whereMonth('tanggal_pesan', $this->bulan);
        }
        
        if ($this->tahun) {
            $query->whereYear('tanggal_pesan', $this->tahun);
        }

        // Get the filtered data
        return $query->get();
    }

    // Map the data to the Excel columns
    public function map($pemesanan): array
    {
        return [
            $pemesanan->id,
            $pemesanan->user->name,
            $pemesanan->ruangan->gedung->nama . ' || ' . $pemesanan->ruangan->nama,
            Carbon::parse($pemesanan->tanggal_pesan)->format('d/m/Y'),
            $pemesanan->status,
            $pemesanan->waktu_mulai . ' - ' . $pemesanan->waktu_selesai,
        ];
    }
}
