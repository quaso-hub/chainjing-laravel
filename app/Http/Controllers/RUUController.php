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

        $user = Auth::user();
        if ($user->jabatan_id === 1) {
            return view('ruu.index', compact('ruus'));
        }

        return view('ruu.list', compact('ruus'));
    }

    public function create()
    {
        return view('ruu.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|unique:ruu,judul',
            'deskripsi' => 'required',
            'status' => 'required|in:DRAFT,VOTING'
        ]);

        RUU::create($validated);
        return response()->json(['message' => 'RUU berhasil ditambahkan.']);
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

    public function update(Request $request, $id)
    {
        $data = RUU::findOrFail($id);
        $data->update($request->all());
        return redirect()->route('ruu.index')->with('success', 'RUU berhasil diperbarui');
    }

    public function destroy($id)
    {
        RUU::destroy($id);
        return redirect()->route('ruu.index')->with('success', 'RUU berhasil dihapus');
    }
}
