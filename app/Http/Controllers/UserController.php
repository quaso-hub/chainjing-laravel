<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Jabatan;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // $data = User::with('jabatan')->get();
        // return view('users.index', compact('data'));
        $users = User::with('jabatan')->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $jabatans = Jabatan::all();
        return view('users.create', compact('jabatans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'jabatan_id' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        $request['password'] = Hash::make($request->password);
        User::create($request->all());

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan');
    }

    public function show($id)
    {
        $data = User::findOrFail($id);
        return view('users.show', compact('data'));
    }

    public function edit($id)
    {
        $data = User::findOrFail($id);
        $jabatans = Jabatan::all();
        return view('users.edit', compact('data', 'jabatans'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'jabatan_id' => 'required',
        ]);

        $user->update($request->only('name', 'email', 'jabatan_id'));

        return response()->json(['message' => 'Berhasil update user']);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'Berhasil hapus user']);
    }
}
