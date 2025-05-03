<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RevisiRUU;
use App\Models\RUU;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RevisiRUUController extends Controller
{
    public function index()
    {
        $revisi = RevisiRUU::with(['user', 'ruu'])->latest()->get();
        return view('revisi_ruu.index', compact('revisi'));
    }
    public function create()
    {
        $ruus = RUU::all();
        return view('revisi_ruu.create', compact('ruus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ruu_id' => 'required|exists:ruu,id',
            'alasan' => 'required|string|max:1000',
        ]);

        RevisiRUU::create([
            'user_id' => Auth::id(),
            'ruu_id' => $request->ruu_id,
            'alasan' => $request->alasan,
        ]);

        return redirect()->route('revisi_ruu.index')->with('success', 'Revisi RUU berhasil diajukan.');
    }
    public function show($id)
    {
        $data = RevisiRUU::findOrFail($id);
        return view('revisi_ruu.show', compact('data'));
    }

    public function edit($id)
    {
        $data = RevisiRUU::findOrFail($id);
        $ruus = RUU::all();
        $users = User::all();
        return view('revisi_ruu.edit', compact('data', 'ruus', 'users'));
    }

    public function update(Request $request, $id)
    {
        $data = RevisiRUU::findOrFail($id);
        $data->update($request->all());
        return redirect()->route('revisi-ruu.index')->with('success', 'Revisi berhasil diperbarui');
    }

    public function destroy(RevisiRUU $revisi_ruu)
    {
        $revisi_ruu->delete();
        return response()->json(['success' => true]);
    }
}
