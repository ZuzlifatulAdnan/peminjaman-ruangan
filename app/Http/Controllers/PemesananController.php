<?php

namespace App\Http\Controllers;

use App\Exports\PemesananExport;
use App\Models\Pemesanan;
use App\Models\Ruangan;
use App\Models\Ukm;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;

class PemesananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $type_menu = 'pemesanan';
        // Input values from the request
        $keyword = trim($request->input('nama'));
        $status = $request->input('status');
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');

        // Dynamic dropdown options
        $months = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];
        $years = range(date('Y') - 10, date('Y')); // Last 10 years
        $statusOptions = ['Selesai', 'Diterima', 'Ditolak', 'Diproses'];

        // Query the `pemesanan` data with filters
        $pemesanans = Pemesanan::with(['user', 'ruangan'])
            ->when($keyword, function ($query, $keyword) {
                $query->whereHas('user', function ($q) use ($keyword) {
                    $q->where('name', 'like', '%' . $keyword . '%');
                });
            })
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->when($bulan, function ($query, $bulan) {
                $query->whereMonth('tanggal_pesan', $bulan);
            })
            ->when($tahun, function ($query, $tahun) {
                $query->whereYear('tanggal_pesan', $tahun);
            })
            ->latest()
            ->paginate(10);

        // Append query parameters to pagination links
        $pemesanans->appends([
            'nama' => $keyword,
            'status' => $status,
            'bulan' => $bulan,
            'tahun' => $tahun,
        ]);

        // arahkan ke file pages/users/index.blade.php
        return view('pages.pemesanan.index', compact('type_menu', 'pemesanans', 'months', 'years', 'statusOptions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $type_menu = 'pemesanan';
        $users = User::all();
        $ruangans = Ruangan::all();
        $ukms = Ukm::all();

        // arahkan ke file pages/users/create.blade.php
        return view('pages.pemesanan.create', compact('type_menu', 'users', 'ruangans', 'ukms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validasi data dari form tambah user
        $request->validate([
            'user_id' => 'required',
            'ruangan_id' => 'required',
            'ukm_id' => 'nullable',
            'tanggal_pesan' => 'required',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'tujuan' => 'nullable',
            'status' => 'nullable',
        ]);
        //masukan data kedalam tabel users
        Pemesanan::create([
            'user_id' => $request->user_id,
            'ruangan_id' => $request->ruangan_id,
            'ukm_id' => $request->ukm_id,
            'tanggal_pesan' => $request->tanggal_pesan,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'tujuan' => $request->tujuan,
            'status' => $request->status,
        ]);

        //jika proses berhsil arahkan kembali ke halaman users dengan status success
        return Redirect::route('pemesanan.index')->with('success', 'Pemesanan berhasil di tambah.');
    }

    /**
     * Display the specified resource.
     */
    public function edit(Pemesanan $pemesanan)
    {
        $type_menu = 'pemesanan';
        $users = User::all();
        $ruangans = Ruangan::all();
        $ukms = Ukm::all();

        // arahkan ke file pages/users/edit
        return view('pages.pemesanan.edit', compact('pemesanan', 'type_menu', 'users', 'ruangans', 'ukms'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function update(Request $request, Pemesanan $pemesanan)
    {
        // Validate the form data
        $request->validate([
            'user_id' => 'required',
            'ruangan_id' => 'required',
            'ukm_id' => 'nullable',
            'tanggal_pesan' => 'required',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'tujuan' => 'nullable',
            'status' => 'nullable',
        ]);

        // Update the user data
        $pemesanan->update([
            'user_id' => $request->user_id,
            'ruangan_id' => $request->ruangan_id,
            'ukm_id' => $request->ukm_id,
            'tanggal_pesan' => $request->tanggal_pesan,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'tujuan' => $request->tujuan,
            'status' => $request->status,
        ]);

        return Redirect::route('pemesanan.index')->with('success', 'Pemesanan berhasil di ubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pemesanan $pemesanan)
    {
        $pemesanan->delete();
        return Redirect::route('pemesanan.index')->with('success', 'Pemesanan berhasil di hapus.');
    }
    public function show($id)
    {
        $type_menu = 'pemesanan';
        $pemesanan = Pemesanan::find($id);

        // arahkan ke file pages/users/edit
        return view('pages.pemesanan.show', compact('pemesanan', 'type_menu'));
    }
    public function exportFrom()
    {
        $months = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];
        $years = range(date('Y') - 10, date('Y'));
        return view('pages.pemesanan.export', compact('years', 'months'));
    }

    public function exportDownload(Request $request)
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
