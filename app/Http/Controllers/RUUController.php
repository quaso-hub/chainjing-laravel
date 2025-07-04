<?php

namespace App\Http\Controllers;

use App\Models\RUU;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RUUController extends Controller
{
    public function index(Request $request)
    {
        $query = RUU::query();

        if ($request->has('keyword')) {
            $query->where('judul', 'like', '%' . $request->keyword . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $ruus = $query->paginate(10);

        if (in_array(Auth::user()->jabatan_id, [1, 4])) { // 1=Admin, 4=Pimpinan
            // Admin & Pimpinan melihat halaman manajemen yang lengkap
            return view('ruu.index', compact('ruus'));
        } else {
            // Anggota biasa melihat daftar sederhana
            return view('ruu.list', compact('ruus'));
        }
    }

    public function create()
    {
        return view('ruu.create');
    }

    // app/Http/Controllers/RUUController.php

    public function store(Request $request)
    {
        $user = Auth::user();

        // 1. Definisikan aturan validasi dasar
        $rules = [
            'judul' => 'required|string|max:255|unique:ruu,judul',
            'deskripsi' => 'required|string',
        ];

        // Jika yang submit adalah Admin, dia wajib mengisi status
        if ($user->jabatan_id == 1) { // 1 = Admin
            $rules['status'] = 'required|in:DRAFT,VOTING';
        }

        $validated = $request->validate($rules);

        // 2. Siapkan data dasar yang akan disimpan
        $dataToCreate = [
            'judul'     => $validated['judul'],
            'deskripsi' => $validated['deskripsi'],
            'user_id'   => $user->id,
        ];

        // 3. Tentukan status berdasarkan peran
        if ($user->jabatan_id == 1) { // Jika Admin
            // Ambil status dari form yang sudah divalidasi
            $dataToCreate['status'] = $validated['status'];
        } else { // Jika Anggota, Pimpinan, atau peran lain yang boleh membuat
            // Paksa status menjadi 'DRAFT' secara otomatis
            $dataToCreate['status'] = 'DRAFT';
        }

        // 4. Simpan ke Database
        RUU::create($dataToCreate);

        // 5. Berikan response JSON
        return response()->json(['message' => 'RUU berhasil diajukan.']);
    }

    public function show($id)
    {
        $data = RUU::findOrFail($id);
        return view('ruu.show', compact('data'));
    }

    public function edit($id)
    {
        $data = RUU::findOrFail($id);
        return view('ruu.edit', compact('data'));
    }

    public function update(Request $request, RUU $ruu)
    {
        $user = Auth::user();
        $rules = [];
        $dataToUpdate = [];

        // Logika untuk Pimpinan (jabatan_id: 4)
        if ($user->jabatan_id == 4) {
            // Pimpinan hanya boleh mengubah status dan jadwal voting
            $rules = [
                'status' => 'required|in:DRAFT,VOTING',
            ];
            // Jika statusnya diubah menjadi 'VOTING', maka jadwal wajib diisi
            if ($request->input('status') == 'VOTING') {
                $rules['voting_mulai'] = 'required|date';
                $rules['voting_selesai'] = 'required|date|after:voting_mulai';
            }
            // Validasi request berdasarkan aturan yang sudah dibuat
            $dataToUpdate = $request->validate($rules);
        }
        // Logika untuk Admin (jabatan_id: 1)
        elseif ($user->jabatan_id == 1) {
            // Admin boleh mengubah semuanya
            $rules = [
                'judul' => 'required|string|max:255|unique:ruu,judul,' . $ruu->id,
                'deskripsi' => 'required|string',
                'status' => 'required|in:DRAFT,VOTING',
            ];
            // Sama seperti pimpinan, jika statusnya 'VOTING', jadwal wajib diisi
            if ($request->input('status') == 'VOTING') {
                $rules['voting_mulai'] = 'required|date';
                $rules['voting_selesai'] = 'required|date|after:voting_mulai';
            }
            // Validasi request berdasarkan aturan yang sudah dibuat
            $dataToUpdate = $request->validate($rules);
        }
        // Jika bukan Admin atau Pimpinan
        else {
            abort(403, 'Anda tidak memiliki izin untuk melakukan aksi ini.');
        }

        // Jika status diubah kembali ke DRAFT, hapus jadwal voting
        if ($request->input('status') == 'DRAFT') {
            $dataToUpdate['voting_mulai'] = null;
            $dataToUpdate['voting_selesai'] = null;
        }

        // Lakukan update ke database dengan data yang sudah divalidasi
        $ruu->update($dataToUpdate);

        return response()->json(['message' => 'RUU berhasil diperbarui.']);
    }

    public function destroy($id)
    {
        RUU::destroy($id);
        return redirect()->route('ruu.index')->with('success', 'RUU berhasil dihapus');
    }
}
