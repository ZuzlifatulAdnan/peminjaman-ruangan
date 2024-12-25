<?php

namespace App\Http\Controllers;

use App\Models\Gedung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class GedungController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $type_menu = 'gedung';
        $keyword = trim($request->input('nama'));
        $gedungs = Gedung::when($request->nama, function ($query, $nama) {
            $query->where('nama', 'like', '%' . $nama . '%');
        })->latest()->paginate(10);

        $gedungs->appends(['nama' => $keyword]);

        return view('pages.gedung.index', compact('type_menu', 'gedungs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $type_menu = 'gedung';

        return view('pages.gedung.create', compact('type_menu'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'nama' => 'required|string',
        ]);

        Gedung::create([
            'nama' => $request->nama
        ]);

        //jika proses berhsil arahkan kembali ke halaman users dengan status success
        return Redirect::route('gedung.index')->with('success', 'Gedung berhasil di tambah.');
    }

    /**
     * Display the specified resource.
     */
    public function edit(Gedung $gedung)
    {
        $type_menu = 'gedung';

        return view('pages.gedung.edit', compact('gedung', 'type_menu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function update(Request $request, Gedung $gedung)
    {
        // Validate the form data
        $request->validate([
            'nama' => 'required|string',
        ]);

        $gedung->update([
            'nama' => $request->nama
        ]);

        return Redirect::route('gedung.index')->with('success', 'Gedung berhasil di ubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gedung $gedung)
    {
        $gedung->delete();
        return Redirect::route('gedung.index')->with('success', 'Gedung berhasil di hapus.');
    }
}
