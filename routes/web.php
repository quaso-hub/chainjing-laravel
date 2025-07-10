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
use App\Http\Controllers\PublicDashboardController;
use App\Http\Controllers\BlockchainAuditController; // Jangan lupa import

use App\Http\Middleware\CekJabatan;

// Models for anggota dashboard
use App\Models\RUU;
use App\Models\Voting;
use App\Models\RevisiRUU;

Route::get('/', [PublicDashboardController::class, 'index'])->name('publik.dashboard');
Route::get('/audit/ruu/{ruuId}/votes', [BlockchainAuditController::class, 'getVotes'])->name('blockchain.getVotes');
Route::get('/audit/alokasi-dana/{alokasiId}', [BlockchainAuditController::class, 'getAlokasiDana'])->name('blockchain.getAlokasiDana');
Auth::routes();

// -------------------- DASHBOARD --------------------
Route::middleware(['auth'])->group(function () {
    Route::middleware(CekJabatan::class . ':1')->get('/dashboard/admin', fn() => view('dashboard.admin'))->name('dashboard.admin');

    Route::middleware(CekJabatan::class . ':2,4,5')->get('/dashboard/anggota', function () {
        $user = Auth::user();

        $totalRuuAktif = RUU::where('status', 'VOTING')->count();
        $totalVotingSaya = Voting::where('users_id', $user->id)->count();
        $totalRevisiSaya = RevisiRUU::where('user_id', $user->id)->count();

        $lastVote = Voting::with('ruu')->where('users_id', $user->id)->latest()->first();
        $lastRevisi = RevisiRUU::with('ruu')->where('user_id', $user->id)->latest()->first();

        return view('dashboard.anggota', compact(
            'totalRuuAktif',
            'totalVotingSaya',
            'totalRevisiSaya',
            'lastVote',
            'lastRevisi'
        ));
    })->name('dashboard.anggota');

    Route::get('/dashboard/publik', [PublicDashboardController::class, 'index'])->name('dashboard.publik');
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
    // Route::put('ruu/{ruu}', [RUUController::class, 'update'])->name('ruu.update');
    // Route::delete('ruu/{ruu}', [RUUController::class, 'destroy'])->name('ruu.destroy');
    Route::delete('revisi_ruu/{revisi_ruu}', [RevisiRUUController::class, 'destroy'])->name('revisi_ruu.destroy');
    Route::resource('alokasi_dana', AlokasiDanaController::class)->except(['create', 'edit', 'show']);
});

// -------------------- ADMIN + PIMPINAN (jabatan_id = 1,4) --------------------
Route::middleware(['auth', CekJabatan::class . ':1,4'])->group(function () {
    // HANYA UPDATE DAN DELETE YANG KHUSUS ADMIN & PIMPINAN
    Route::put('ruu/{ruu}', [RUUController::class, 'update'])->name('ruu.update');
    Route::delete('ruu/{ruu}', [RUUController::class, 'destroy'])->name('ruu.destroy');
});

// BENDAHARA
Route::middleware(['auth', CekJabatan::class . ':5'])->group(function () {
    // HANYA UPDATE DAN DELETE YANG KHUSUS ADMIN & PIMPINAN
    Route::resource('alokasi_dana', AlokasiDanaController::class);
    Route::post('alokasi_dana/{alokasi_dana}/record', [AlokasiDanaController::class, 'recordToBlockchain'])->name('alokasi_dana.record');
});

// -------------------- ADMIN + ANGGOTA + PIMPINAN + BENDAHARA (jabatan_id = 1,2,4,5) --------------------
Route::middleware(['auth', CekJabatan::class . ':1,2,4,5'])->group(function () {
    Route::get('ruu', [RUUController::class, 'index'])->name('ruu.index');
    Route::resource('ruu', RUUController::class)->except(['edit', 'update', 'destroy']);

    // Voting
    Route::resource('voting', VotingController::class)->only(['index', 'destroy']);
    Route::get('/voting/vote', [VotingController::class, 'vote'])->name('voting.vote');
    Route::post('/voting/store', [VotingController::class, 'store'])->name('voting.store');

    // Revisi RUU
    Route::resource('revisi_ruu', RevisiRUUController::class)->only(['index', 'create', 'store',]);

    Route::get('/riwayat/history', [VotingController::class, 'history'])->name('riwayat.history');
});

// -------------------- PUBLIK (jabatan_id = 3) --------------------
Route::middleware(['auth', CekJabatan::class . ':3'])->group(function () {
    Route::get('/ruu-publik', [RUUController::class, 'index'])->name('ruu.publik');
});

Route::middleware(['auth', CekJabatan::class . ':4'])->group(function () {
    Route::post('revisi-ruu/{revisi_ruu}/apply', [RevisiRUUController::class, 'apply'])->name('revisi_ruu.apply');
    Route::post('revisi-ruu/{revisi_ruu}/reject', [RevisiRUUController::class, 'reject'])->name('revisi_ruu.reject');
});
