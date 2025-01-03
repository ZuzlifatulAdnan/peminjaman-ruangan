<?php

namespace App\Http\Controllers;

use App\Models\Gedung;
use App\Models\Ruangan;
use App\Models\Ukm;
use App\Models\User;
use Illuminate\Http\Request;

class BerandaController extends Controller
{
    public function index()
    {
        $type_menu = 'beranda';
        $totalUser = User::count();
        $totalUKM = Ukm::count();
        $totalRuangan = Ruangan::count();
        $totalGedung = Gedung::count();
        // Ambil semua ruangan dengan gedung terkait
        $ruangans = Ruangan::with('gedung')->get();
        return view('pages.beranda.index', compact(
            'type_menu',
            'totalUser',
            'totalUKM',
            'totalRuangan',
            'totalGedung',
            'ruangans'
        ));
    }
}
