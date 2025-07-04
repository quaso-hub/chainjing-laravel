<?php

namespace App\Http\Controllers;

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

        $ruus = $query->latest('updated_at')->paginate(8);

        return view('dashboard.publik', compact('ruus'));
    }
}
