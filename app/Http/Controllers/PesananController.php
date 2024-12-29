<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\Ruangan;
use App\Models\Ukm;
use App\Notifications\PemesananStatusNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;

class PesananController extends Controller
{
    public function index()
    {
        $type_menu = 'pemesanan';
        $ruangans = Ruangan::all();
        $ukms = Ukm::all();

        return view('pages.pesanan.index', compact('type_menu', 'ruangans', 'ukms'));
    }

    public function store(){

    }
    public function create()
    {
        $type_menu = 'pemesanan';
        $ruangans = Ruangan::all();
        $ukms = Ukm::all();

        return view('pages.pesanan.index', compact('type_menu', 'ruangans', 'ukms'));
    }
    public function update(){

    }
    
}
