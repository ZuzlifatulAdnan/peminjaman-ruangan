<?php

namespace App\Http\Controllers;

use App\Models\Gedung;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class RuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $type_menu = 'ruangan';
        $gedungs = Gedung::all();

        // Input filters
        $keyword = trim($request->input('nama'));
        $gedungId = trim($request->input('gedung_id'));
        $status = trim($request->input('status'));

        // Query ruangans with filters
        $ruangans = Ruangan::with('gedung')
            ->when($keyword, function ($query, $nama) {
                $query->where('nama', 'like', '%' . $nama . '%');
            })
            ->when($gedungId, function ($query, $gedungId) {
                $query->where('gedung_id', $gedungId);
            })
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(10);

        // Append query parameters to pagination links
        $ruangans->appends([
            'nama' => $keyword,
            'gedung_id' => $gedungId,
            'status' => $status,
        ]);


        // arahkan ke file pages/ruangans/index.blade.php
        return view('pages.ruangan.index', compact('type_menu', 'ruangans', 'gedungs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $type_menu = 'ruangan';
        $gedungs = Gedung::orderBy('nama', 'asc')->get();

        // arahkan ke file pages/ruangan/create.blade.php
        return view('pages.ruangan.create', compact('type_menu', 'gedungs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'gedung_id' => 'required|integer|exists:gedungs,id',
            'status' => 'required|string|in:Tersedia,Tidak Tersedia',
        ]);

        Ruangan::create([
            'nama' => $request->nama,
            'gedung_id' => $request->gedung_id,
            'status' => $request->status,
        ]);

        //jika proses berhsil arahkan kembali ke halaman ruangan dengan status success
        return Redirect::route(route: 'ruangan.index')->with('success', 'Ruangan berhasil di tambah.');
    }

    /**
     * Display the specified resource.
     */
    public function edit(Ruangan $ruangan)
    {
        $type_menu = 'user';
        $gedungs = Gedung::all();

        // arahkan ke file pages/ruangan/edit
        return view('pages.ruangan.edit', compact('ruangan', 'type_menu', 'gedungs'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function update(Request $request, Ruangan $ruangan)
    {
        // Validate the form data
        $request->validate([
            'nama' => 'required|string',
            'gedung_id' => 'required|integer',
            'status' => 'required|string',
        ]);

        // Update the user data
        $ruangan->update([
            'nama' => $request->nama,
            'gedung_id' => $request->gedung_id,
            'status' => $request->status,
        ]);

        return Redirect::route('ruangan.index')->with('success', 'Ruangan berhasil di ubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ruangan $ruangan)
    {
        $ruangan->delete();
        return Redirect::route('ruangan.index')->with('success', 'Ruangan berhasil di hapus.');
    }
}
