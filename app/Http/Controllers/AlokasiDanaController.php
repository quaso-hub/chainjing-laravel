<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AlokasiDana;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;


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
        $validated = $request->validate([
            'nama_program' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:0',
            'tanggal' => 'required|date',
            'keterangan' => 'required|string',
        ]);

        $validated['status_blockchain'] = 'pending';

        $alokasi = AlokasiDana::create($validated);

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
            'nama_program' => 'required|string|max:255',
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

    public function recordToBlockchain(AlokasiDana $alokasi_dana)
    {
        // Keamanan: Cek apakah statusnya masih 'pending'
        if ($alokasi_dana->status_blockchain !== 'pending') {
            return back()->with('error', 'Data ini sudah pernah dicatat atau sedang diproses.');
        }

        $apiUrl = 'http://localhost:3000/api/alokasi-dana';

        // Buat ID unik untuk transaksi blockchain
        $blockchain_id = 'dana_' . uniqid();

        try {
            $response = Http::withoutVerifying()->timeout(15)->post($apiUrl, [
                'id' => $blockchain_id,
                'nama_program' => $alokasi_dana->nama_program,
                'jumlah' => $alokasi_dana->jumlah,
                'tanggal' => $alokasi_dana->tanggal,
                'keterangan' => $alokasi_dana->keterangan,
            ]);

            if ($response->successful()) {
                // Jika sukses, update status di database lokal
                $alokasi_dana->update([
                    'status_blockchain' => 'recorded',
                    'tx_id' => $response->json('data.ID') ?? $blockchain_id // Ambil ID dari response
                ]);
                return back()->with('success', 'Alokasi dana berhasil dicatat di blockchain!');
            } else {
                return back()->with('error', 'Gagal mencatat ke blockchain. Server merespon dengan error.');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Tidak dapat terhubung ke server blockchain.');
        }
    }
}
