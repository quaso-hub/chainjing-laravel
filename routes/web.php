<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RUUController;
use App\Http\Controllers\VotingController;
use App\Http\Controllers\RevisiRUUController;
use App\Http\Controllers\AlokasiDanaController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\CekJabatan;

// Models for anggota dashboard
use App\Models\RUU;
use App\Models\Voting;
use App\Models\RevisiRUU;

Route::get('/', function () {
    return view('dashboard.publik');
});

Auth::routes();

// -------------------- DASHBOARD --------------------
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/admin', fn () => view('dashboard.admin'))->name('dashboard.admin');

    Route::get('/dashboard/anggota', function () {
        $user = Auth::user();

        $totalRuuAktif = RUU::where('status', 'VOTING')->count();
        $totalVotingSaya = Voting::where('users_id', $user->id)->count();
        $totalRevisiSaya = RevisiRUU::where('created_by', $user->id)->count();

        $lastVote = Voting::with('ruu')->where('users_id', $user->id)->latest()->first();
        $lastRevisi = RevisiRUU::with('ruu')->where('created_by', $user->id)->latest()->first();

        return view('dashboard.anggota', compact(
            'totalRuuAktif',
            'totalVotingSaya',
            'totalRevisiSaya',
            'lastVote',
            'lastRevisi'
        ));
    })->name('dashboard.anggota');

    Route::get('/dashboard/publik', fn () => view('dashboard.publik'))->name('dashboard.publik');
});

// -------------------- PROFILE --------------------
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// -------------------- ADMIN ONLY (jabatan_id = 1) --------------------
Route::middleware(['auth', CekJabatan::class . ':1'])->group(function () {
    Route::resource('jabatan', JabatanController::class);
    Route::resource('users', UserController::class);
    Route::resource('ruu', RUUController::class)->except(['update', 'destroy']);
    Route::put('ruu/{ruu}', [RUUController::class, 'update'])->name('ruu.update');
    Route::delete('ruu/{ruu}', [RUUController::class, 'destroy'])->name('ruu.destroy');
    Route::resource('alokasi_dana', AlokasiDanaController::class)->except(['create', 'edit', 'show']);
});

// -------------------- ADMIN + ANGGOTA (jabatan_id = 1,2) --------------------
Route::middleware(['auth', CekJabatan::class . ':1,2'])->group(function () {
    Route::get('ruu', [RUUController::class, 'index'])->name('ruu.index');

    // Voting
    Route::resource('voting', VotingController::class)->only(['index', 'destroy']);
    Route::get('/voting/vote', [VotingController::class, 'vote'])->name('voting.vote');
    Route::post('/voting/store', [VotingController::class, 'store'])->name('voting.store');

    // Revisi RUU
    Route::resource('revisi_ruu', RevisiRUUController::class)->only(['index', 'create', 'store', 'destroy']);

    Route::get('/riwayat/history', [VotingController::class, 'history'])->name('riwayat.history');
});

// -------------------- PUBLIK (jabatan_id = 3) --------------------
Route::middleware(['auth', CekJabatan::class . ':3'])->group(function () {
    Route::get('/ruu-publik', [RUUController::class, 'index'])->name('ruu.publik');
});
