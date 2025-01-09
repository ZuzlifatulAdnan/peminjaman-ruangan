<?php

namespace App\Http\Controllers;

use App\Exports\PemesananExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
class ExportController extends Controller
{
    public function index(Request $request)
    {
        // Validasi input bulan dan tahun
        $validated = $request->validate([
            'bulan' => 'required|numeric|between:1,12',
            'tahun' => 'required|numeric|digits:4',
        ]);
    
        $bulan = $validated['bulan'];
        $tahun = $validated['tahun'];
    
        // Nama file dinamis
        $fileName = 'pemesanan_' . $bulan . '_' . $tahun . '.xlsx';
    
        // Export file Excel
        return Excel::download(new PemesananExport($bulan, $tahun), $fileName);
    }
    
}
