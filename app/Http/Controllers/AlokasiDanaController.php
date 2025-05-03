<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AlokasiDana;

class AlokasiDanaController extends Controller
{
    public function index()
    {
        $alokasi = AlokasiDana::latest()->get();
        return view('alokasi_dana.index', compact('alokasi'));
    }

    public function create()
    {
        return view('alokasi_dana.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'jumlah' => 'required|numeric',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        $alokasi = AlokasiDana::create($request->all());

        return response()->json(['success' => true, 'data' => $alokasi]);
    }

    public function show($id)
    {
        $data = AlokasiDana::findOrFail($id);
        return view('alokasi_dana.show', compact('data'));
    }

    public function edit($id)
    {
        $data = AlokasiDana::findOrFail($id);
        return view('alokasi_dana.edit', compact('data'));
    }

    public function update(Request $request, AlokasiDana $alokasi_dana)
    {
        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'jumlah' => 'required|numeric',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        $alokasi_dana->update($request->all());

        return response()->json(['success' => true, 'data' => $alokasi_dana]);
    }
    public function destroy(AlokasiDana $alokasi_dana)
    {
        $alokasi_dana->delete();
        return response()->json(['success' => true]);
    }
}
