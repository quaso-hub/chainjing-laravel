<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jabatan;

class JabatanController extends Controller
{
    public function index()
    {
        $jabatans = Jabatan::all(); // Atau gunakan pagination jika perlu
        return view('jabatan.index', compact('jabatans'));
    }
    public function create()
    {
        return view('jabatan.create');
    }

    public function store(Request $request)
    {
        $request->validate(['nama' => 'required']);
        Jabatan::create($request->all());
        return redirect()->route('jabatan.index')->with('success', 'Jabatan berhasil ditambahkan');
    }

    public function show($id)
    {
        $data = Jabatan::findOrFail($id);
        return view('jabatan.show', compact('data'));
    }

    public function edit($id)
    {
        $data = Jabatan::findOrFail($id);
        return view('jabatan.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = Jabatan::findOrFail($id);
        $data->update($request->all());
        return redirect()->route('jabatan.index')->with('success', 'Jabatan berhasil diperbarui');
    }

    public function destroy($id)
    {
        Jabatan::destroy($id);
        return redirect()->route('jabatan.index')->with('success', 'Jabatan berhasil dihapus');
    }
}
