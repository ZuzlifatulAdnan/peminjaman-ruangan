<?php

namespace App\Http\Controllers;

use App\Exports\PemesananExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
class ExportController extends Controller
{
    public function showExportForm()
    {
        return view('pages.pemesanan.export');
    }

    public function export(Request $request)
    {
        $request->validate([
            'bulan' => 'required|integer|between:1,12',
            'tahun' => 'required|integer|min:2000|max:' . date('Y'),
        ]);

        return Excel::download(
            new PemesananExport($request->bulan, $request->tahun),
            'pemesanan_' . $request->bulan . '_' . $request->tahun . '.xlsx'
        );
    }
}
