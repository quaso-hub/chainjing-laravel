<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Voting;
use App\Models\RUU;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class VotingController extends Controller
{
    public function index(Request $request)
    {
        $query = Voting::with(['user', 'ruu']);

        if ($request->has('search')) {
            $query->whereHas('ruu', function ($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%');
            })->orWhereHas('user', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%');
            });
        }

        $votings = $query->latest()->paginate(10);

        if ($request->ajax()) {
            return view('voting.index', compact('votings'))->render();
        }

        return view('voting.index', compact('votings'));
    }

    public function create()
    {
        $users = User::all();
        $ruus = RUU::all();
        return view('voting.create', compact('users', 'ruus'));
    }

    public function store(Request $request)
    {
        // 1. Validasi input dasar dari form
        $request->validate([
            'ruu_id' => 'required|exists:ruu,id',
            'pilihan' => 'required|in:SETUJU,TOLAK,ABSTAIN',
        ]);

        $user = Auth::user();
        $ruu = RUU::findOrFail($request->ruu_id);

        // 2. Logika Pengecekan Bisnis
        // Cek apakah RUU statusnya VOTING
        if ($ruu->status !== 'VOTING') {
            return back()->with('error', 'RUU ini tidak sedang dalam sesi voting.');
        }

        // Cek apakah sesi voting sedang aktif (berdasarkan jadwal)
        if (!$ruu->voting_mulai || !now()->between($ruu->voting_mulai, $ruu->voting_selesai)) {
            return back()->with('error', 'Sesi voting untuk RUU ini belum dimulai atau telah berakhir.');
        }

        // Cek apakah user sudah pernah vote untuk RUU ini
        $existingVote = Voting::where('users_id', $user->id)
            ->where('ruu_id', $ruu->id)
            ->first();

        if ($existingVote) {
            return back()->with('error', 'Anda sudah pernah memberikan suara untuk RUU ini.');
        }

        // 3. Proses Penyimpanan jika semua pengecekan lolos
        try {
            $vote_id = uniqid('vote_');
            $timestamp = now();

            // Simpan ke database lokal
            Voting::create([
                'vote_id' => $vote_id,
                'users_id' => $user->id,
                'ruu_id' => $request->ruu_id,
                'pilihan' => $request->pilihan,
                'waktu_vote' => $timestamp,
            ]);

            // Data untuk dikirim ke blockchain
            $blockchainData = [
                'vote_id' => $vote_id,
                'anggota_id' => (string)$user->id,
                'ruu_id' => (string)$request->ruu_id,
                'pilihan' => $request->pilihan,
                'timestamp' => $timestamp->toIso8601String(),
            ];

            // Kirim ke Node.js API
            $response = Http::post('http://localhost:3000/api/vote', $blockchainData);

            // Log response untuk debugging
            // Log::info('Blockchain response:', ['body' => $response->body()]);

            if ($response->successful()) {
                return back()->with('success', 'Suara berhasil disimpan dan dicatat di blockchain ✔️');
            } else {
                return back()->with('warning', 'Vote tersimpan di database, tapi gagal dicatat di blockchain. Error: ' . $response->json('error', 'Unknown Error'));
            }
        } catch (\Exception $e) {
            // Log::error('Vote Gagal Total:', ['message' => $e->getMessage()]);
            return back()->with('error', 'Terjadi kesalahan sistem saat menyimpan suara: ' . $e->getMessage());
        }
    }


    public function show($id)
    {
        $data = Voting::findOrFail($id);
        return view('voting.show', compact('data'));
    }

    public function edit($id)
    {
        $data = Voting::findOrFail($id);
        $users = User::all();
        $ruus = RUU::all();
        return view('voting.edit', compact('data', 'users', 'ruus'));
    }

    public function update(Request $request, $id)
    {
        $data = Voting::findOrFail($id);
        $data->update($request->all());
        return redirect()->route('voting.index')->with('success', 'Voting berhasil diperbarui');
    }

    public function destroy(Voting $voting)
    {
        $voting->delete();
        return response()->json(['message' => 'Berhasil dihapus']);
    }

    public function vote(Request $request)
    {
        $query = RUU::with(['voting' => function ($q) {
            $q->where('users_id', Auth::id());
        }]);

        if ($request->has('keyword')) {
            $query->where('judul', 'like', '%' . $request->keyword . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $ruus = $query->paginate(10);

        return view('voting.vote', compact('ruus'));
    }

    public function history(Request $request)
    {
        $user = Auth::user();

        $query = Voting::with('ruu')->where('users_id', $user->id);

        if ($request->filled('keyword')) {
            $query->whereHas('ruu', function ($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->keyword . '%');
            });
        }

        $votings = $query->orderByDesc('created_at')->paginate(10);

        return view('riwayat.history', compact('votings'));
    }
}
