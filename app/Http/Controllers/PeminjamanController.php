<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\Ruangan;
use App\Models\Ukm;
use App\Services\FonnteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $type_menu = 'pemesanan';
        // Ambil data user yang sedang login
        $user = Auth::user();
        // Input values from the request
        $keyword = trim($request->input('nama_ruangan')); // Updated to filter by room name
        $status = $request->input('status');
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');
        $sort = $request->input('sort'); // Handle sort by created_at

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
        $pemesanans = Pemesanan::with(['user', 'ruangan', 'ruangan.gedung'])
            ->where('user_id', $user->id) // Filter berdasarkan user_id
            ->when($keyword, function ($query, $keyword) {
                $query->whereHas('ruangan', function ($q) use ($keyword) {
                    $q->where('nama', 'like', '%' . $keyword . '%'); // Cari berdasarkan nama ruangan
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
            })->when($sort, function ($query, $sort) {
                $query->orderBy('created_at', $sort); // Sort by created_at in ascending or descending order
            })
            ->latest()
            ->paginate(10);

        // Append query parameters to pagination links
        $pemesanans->appends([
            'nama_ruangan' => $keyword, // Updated to pass room name filter
            'status' => $status,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'sort' => $sort,
        ]);

        // arahkan ke file pages/users/index.blade.php
        return view('pages.pesanan.riwayat', compact('type_menu', 'pemesanans', 'months', 'years', 'statusOptions'));
    }

    public function detail($id)
    {
        $type_menu = 'pemesanan';
        $pemesanan = Pemesanan::find($id);
        return view('pages.pesanan.show', compact('pemesanan', 'type_menu'));
    }
    public function input()
    {
        $type_menu = 'pemesanan';
        $ruangans = Ruangan::where('status', 'Tersedia')->get();
        $ukms = Ukm::all();

        return view('pages.pesanan.index', compact('type_menu', 'ruangans', 'ukms'));
    }
    public function store(Request $request, FonnteService $fonnteService)
    {
        $request->validate([
            'ruangan_id' => 'required',
            'tanggal_pesan' => 'required|date',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i',
            'ukm_id' => 'nullable',
            'tujuan' => 'nullable|string',
        ]);

        // Simpan data peminjaman ruangan
        $pemesanan = Pemesanan::create([
            'user_id' => auth()->id(),
            'ruangan_id' => $request->ruangan_id,
            'tanggal_pesan' => $request->tanggal_pesan,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'ukm_id' => $request->ukm_id,
            'tujuan' => $request->tujuan,
            'status' => 'Diproses',
        ]);
        // Kirim notifikasi WhatsApp menggunakan Fonnte
        $userPhone = auth()->user()->no_whatsapp; // Pastikan kolom phone ada di tabel users
        $message = "Halo, " . auth()->user()->name . "!\n\n" .
            "Pemesanan ruangan berhasil diajukan:\n" .
            "Ruangan: " . $pemesanan->ruangan->nama . "\n" .
            "Tanggal: " . $pemesanan->tanggal_pesan . "\n" .
            "Waktu: " . $pemesanan->waktu_mulai . " WIB  -  " . $pemesanan->waktu_selesai . " WIB \n" .
            "Status: Diproses.\n\n" .
            "Terima kasih telah menggunakan sistem kami.";

        $fonnteService->sendMessage($userPhone, $message);

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman ruangan berhasil diajukan!');
    }
    public function proses(Request $request)
    {
        $type_menu = 'pemesanan';
        // Ambil data filter
        $ruanganId = $request->get('ruangan');
        $nama = $request->get('nama');

        // Query data pemesanan
        $pemesanans = Pemesanan::with(['user', 'ruangan.gedung'])
            ->when($ruanganId, function ($query, $ruanganId) {
                $query->where('ruangan_id', $ruanganId);
            })
            ->when($nama, function ($query, $nama) {
                $query->whereHas('user', function ($query) use ($nama) {
                    $query->where('name', 'like', "%$nama%");
                });
            })->where('status', 'Diproses')
            ->paginate(10);

        // Ambil daftar ruangan
        $ruangans = Ruangan::with('gedung')->get();

        return view('pages.pesanan.proses', compact('pemesanans', 'ruangans', 'type_menu'));
    }

    // Show the form to edit the Pemesanan
    public function editProses(Pemesanan $pemesanan)
    {
        $type_menu = 'pemesanan';
        // Directly pass Pemesanan to the view
        return view('pages.pesanan.editProses', compact('pemesanan', 'type_menu'));
    }

    // Handle the update of the Pemesanan status
    public function updateProses(Request $request, Pemesanan $pemesanan)
    {
        // Validate the incoming request data
        $request->validate([
            'status' => 'required|in:Diterima,Diproses,Ditolak', // Ensure the status is one of the valid options
        ]);
        // Mendapatkan status sebelumnya sebelum pembaruan
        $previousStatus = $pemesanan->status;
        // Update the Pemesanan status
        $pemesanan->update([
            'status' => $request->status,
        ]);

        // ubah status ruangan menjadi 'Tidak Tersedia'
        if ($request->status === 'Diterima' && $previousStatus !== 'Diterima') {
            $ruangan = $pemesanan->ruangan;  // Mengambil data ruangan terkait
            if ($ruangan) {
                $ruangan->update(['status' => 'Tidak Tersedia']); // Mengubah status ruangan menjadi 'Tidak Tersedia'
            }
        }
        // Kirim notifikasi WhatsApp menggunakan Fonnte
        $userPhone = $pemesanan->user->no_whatsapp; // Pastikan kolom phone ada di tabel users
        $message = "Halo, " . $pemesanan->user->name . "!\n\n" .
            "Status pemesanan ruangan Anda telah diperbarui:\n" .
            "Ruangan: " . $pemesanan->ruangan->nama . "\n" .
            "Tanggal: " . $pemesanan->tanggal_pesan . "\n" .
            "Waktu: " . $pemesanan->waktu_mulai . " WIB - " . $pemesanan->waktu_selesai . " WIB \n" .
            "Status: " . $request->status . ".\n\n" .
            "Terima kasih telah menggunakan sistem kami.";

        // Kirim pesan hanya jika nomor telepon tersedia
        if ($userPhone) {
            $fonnteService = app(FonnteService::class);
            $fonnteService->sendMessage($userPhone, $message);
        }
        // Redirect back with a success message
        return redirect()->route('peminjaman.proses')->with('success', 'Proses peminjaman berhasil diperbarui!');
    }
    public function terima(Request $request)
    {
        $type_menu = 'pemesanan';
        // Ambil data filter
        $ruanganId = $request->get('ruangan');
        $nama = $request->get('nama');

        // Query data pemesanan
        $pemesanans = Pemesanan::with(['user', 'ruangan.gedung'])
            ->when($ruanganId, function ($query, $ruanganId) {
                $query->where('ruangan_id', $ruanganId);
            })
            ->when($nama, function ($query, $nama) {
                $query->whereHas('user', function ($query) use ($nama) {
                    $query->where('name', 'like', "%$nama%");
                });
            })->where('status', 'Diterima')
            ->paginate(10);

        // Ambil daftar ruangan
        $ruangans = Ruangan::with('gedung')->get();

        return view('pages.pesanan.terima', compact('type_menu', 'ruangans', 'pemesanans'));
    }
    public function editTerima(Pemesanan $pemesanan)
    {
        $type_menu = 'pemesanan';
        // Directly pass Pemesanan to the view
        return view('pages.pesanan.editTerima', compact('pemesanan', 'type_menu'));
    }

    // Handle the update of the Pemesanan status
    public function updateTerima(Request $request, Pemesanan $pemesanan)
    {
        // Validate the incoming request data
        $request->validate([
            'status' => 'required|in:Selesai,Diterima,Diproses,Ditolak', // Ensure the status is one of the valid options
        ]);
        // Mendapatkan status sebelumnya sebelum pembaruan
        $previousStatus = $pemesanan->status;
        // Update the Pemesanan status
        $pemesanan->update([
            'status' => $request->status,
        ]);

        // ubah status ruangan menjadi 'Tersedia'
        if ($request->status === 'Selesai' && $previousStatus !== 'Selesai') {
            $ruangan = $pemesanan->ruangan;  // Mengambil data ruangan terkait
            if ($ruangan) {
                $ruangan->update(['status' => 'Tersedia']); // Mengubah status ruangan menjadi 'Tersedia'
            }
        }
        // Kirim notifikasi WhatsApp menggunakan Fonnte
        $userPhone = $pemesanan->user->no_whatsapp; // Pastikan kolom phone ada di tabel users
        $message = "Halo, " . $pemesanan->user->name . "!\n\n" .
            "Status pemesanan ruangan Anda telah diperbarui:\n" .
            "Ruangan: " . $pemesanan->ruangan->nama . "\n" .
            "Tanggal: " . $pemesanan->tanggal_pesan . "\n" .
            "Waktu: " . $pemesanan->waktu_mulai . " WIB  - " . $pemesanan->waktu_selesai . " WIB \n" .
            "Status: " . $request->status . ".\n\n" .
            "Terima kasih telah menggunakan sistem kami.";

        // Kirim pesan hanya jika nomor telepon tersedia
        if ($userPhone) {
            $fonnteService = app(FonnteService::class);
            $fonnteService->sendMessage($userPhone, $message);
        }
        // Redirect back with a success message
        return redirect()->route('peminjaman.terima')->with('success', 'Terima peminjaman berhasil diperbarui!');
    }
    public function kirimNotifikasiHabis()
    {
        // Ambil semua pemesanan yang statusnya "Diterima"
        $pemesanans = Pemesanan::with(['user', 'ruangan.gedung'])
            ->where('status', 'Diterima')
            ->get()
            ->filter(function ($pemesanan) {
                $waktuSelesai = Carbon::parse($pemesanan->waktu_selesai);
                $waktuSekarang = Carbon::now();

                // Filter pemesanan dengan waktu selesai < 15 menit dari sekarang
                return $waktuSelesai->greaterThan($waktuSekarang) &&
                       $waktuSekarang->diffInMinutes($waktuSelesai, false) <= 15;
            });

        foreach ($pemesanans as $pemesanan) {
            try {
                $userPhone = $pemesanan->user->no_whatsapp; // Nomor WhatsApp pengguna
                $message = "Halo, " . $pemesanan->user->name . "!\n\n" .
                    "Peminjaman ruangan Anda akan berakhir kurang dari 15 menit:\n" .
                    "Ruangan: " . $pemesanan->ruangan->nama . "\n" .
                    "Tanggal: " . $pemesanan->tanggal_pesan . "\n" .
                    "Waktu: " . $pemesanan->waktu_mulai . " WIB - " . $pemesanan->waktu_selesai . " WIB\n" .
                    "Status: Diterima.\n\n" .
                    "Mohon bersiap untuk mengosongkan ruangan.\n" .
                    "Terima kasih telah menggunakan sistem kami.";

                // Pastikan nomor WhatsApp tersedia
                if ($userPhone) {
                    $fonnteService = app(FonnteService::class); // Panggil service Fonnte
                    $fonnteService->sendMessage($userPhone, $message);
                } else {
                    Log::warning("Nomor WhatsApp kosong untuk pemesanan ID: {$pemesanan->id}");
                }
            } catch (\Exception $e) {
                Log::error("Error saat mengirim notifikasi untuk pemesanan ID: {$pemesanan->id}. Pesan error: " . $e->getMessage());
            }
        }

        return response()->json(['message' => 'Notifikasi telah dikirim.']);
    }
}
