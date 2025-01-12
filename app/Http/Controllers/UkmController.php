<?php

namespace App\Http\Controllers;

use App\Models\Ukm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class UkmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $type_menu = 'ukm';
        $keyword = trim($request->input('nama'));
        $ukms = Ukm::when($request->nama, function ($query, $nama) {
            $query->where('nama', 'like', '%' . $nama . '%');
        })->latest()->paginate(4);

        $ukms->appends(['nama' => $keyword]);

        return view('pages.ukm.index', compact('type_menu', 'ukms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $type_menu = 'ukm';

        return view('pages.ukm.create', compact('type_menu'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'nama' => 'required|string',
            'nama_ketua' => 'required|string',
            'nomer_ketua' => 'required|string|min:10',
        ]);

        Ukm::create([
            'nama' => $request->nama,
            'nama_ketua' => $request->nama_ketua,
            'nomer_ketua' => $request->nomer_ketua
        ]);

        //jika proses berhsil arahkan kembali ke halaman users dengan status success
        return Redirect::route('ukm.index')->with('success', 'UKM berhasil di tambah.');
    }

    /**
     * Display the specified resource.
     */
    public function edit(Ukm $ukm)
    {
        $type_menu = 'ukm';

        return view('pages.ukm.edit', compact('ukm', 'type_menu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function update(Request $request, Ukm $ukm)
    {
        // Validate the form data
        $request->validate([
            'nama' => 'required|string',
            'nama_ketua' => 'required|string',
            'nomer_ketua' => 'required|string|min:10',
        ]);

        $ukm->update([
            'nama' => $request->nama,
            'nama_ketua' => $request->nama_ketua,
            'no_ketua' => $request->no_ketua,
        ]);

        return Redirect::route('ukm.index')->with('success', 'UKM berhasil di ubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ukm $ukm)
    {
        $ukm->delete();
        return Redirect::route('ukm.index')->with('success', 'UKM berhasil di hapus.');
    }
}
