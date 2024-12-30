<?php

namespace App\Exports;

use App\Models\Pemesanan;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PemesananExport implements FromQuery, WithHeadings, WithMapping
{
    protected $bulan;
    protected $tahun;

    public function __construct($bulan, $tahun)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function query()
    {
        // Query Pemesanan data with optional filters for bulan and tahun
        $query = Pemesanan::with(['user', 'ruangan']);

        if ($this->bulan) {
            $query->whereMonth('tanggal_pesan', $this->bulan);
        }

        if ($this->tahun) {
            $query->whereYear('tanggal_pesan', $this->tahun);
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Pemesan',
            'Ruangan',
            'Status',
            'Tanggal Pemesanan',
            'Tujuan',
        ];
    }

    public function map($pemesan): array
    {
        return [
            $pemesan->id,
            $pemesan->user->name,
            $pemesan->ruangan->nama,
            $pemesan->status,
            $pemesan->tanggal_pesan->format('d-m-Y'),
            $pemesan->tujuan,
        ];
    }
}
