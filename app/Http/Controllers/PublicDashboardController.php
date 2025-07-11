<?php

namespace App\Http\Controllers;

use App\Models\AlokasiDana;
use Illuminate\Http\Request;
use App\Models\RUU; // Jangan lupa import model RUU

class PublicDashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard publik dengan data RUU.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = RUU::withCount(['voting', 'revisi'])
            ->where('status', 'VOTING');

        // Jika ada input pencarian
        if ($request->filled('keyword')) {
            $query->where('judul', 'like', '%' . $request->keyword . '%');
        }

        $votingSummary = RUU::with('voting')
            ->where('status', 'VOTING')
            ->get()
            ->map(function ($ruu) {
                $setuju = $ruu->voting->where('pilihan', 'SETUJU')->count();
                $tidak = $ruu->voting->where('pilihan', 'TOLAK')->count();
                $total = $setuju + $tidak;

                return [
                    'judul' => $ruu->judul,
                    'deskripsi' => $ruu->deskripsi,
                    'setuju' => $setuju,
                    'tidak' => $tidak,
                    'total' => $total,
                    'persen_setuju' => $total > 0 ? round(($setuju / $total) * 100) : 0,
                    'persen_tidak' => $total > 0 ? round(($tidak / $total) * 100) : 0,
                ];
            })
            ->sortByDesc('total')
            ->values();

        $votingTop3 = $votingSummary->take(3);

        $ruus = $query->latest('updated_at')->paginate(4);

        $alokasiList = AlokasiDana::where('status_blockchain', 'recorded')->latest('tanggal')->get();
        $alokasiTop3 = $alokasiList->take(3);

        $totalAnggaran = $alokasiList->sum('jumlah');
        $jumlahProgram = $alokasiList->count();
        $penggunaanTerakhir = $alokasiList->first();

        return view('dashboard.publik', compact(
            'ruus',
            'votingTop3',
            'votingSummary',
            'alokasiList',
            'alokasiTop3',
            'totalAnggaran',
            'jumlahProgram',
            'penggunaanTerakhir'
        ));
    }
}
