<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CekJabatan
{
    public function handle($request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $userRole = Auth::user()->jabatan_id;

        if (!in_array($userRole, $roles)) {
            abort(403, 'Akses ditolak.');
        }

        return $next($request);
    }
}
