<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Voting;
use App\Models\RUU;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
        $request->validate([
            'users_id' => 'required',
            'ruu_id' => 'required',
            'pilihan' => 'required',
        ]);

        Voting::create($request->all());
        return redirect()->route('voting.index')->with('success', 'Voting berhasil ditambahkan');
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
