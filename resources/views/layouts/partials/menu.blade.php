@php
    $active = fn($route) => request()->routeIs($route) ? 'active' : '';
    $activeLike = fn($pattern) => request()->routeIs($pattern) || request()->is("$pattern/*") ? 'active' : '';

    $dashboardRoute = match (Auth::user()->jabatan_id) {
        1 => 'dashboard.admin',
        2 => 'dashboard.anggota',
        3 => 'dashboard.publik',
        default => 'dashboard.admin',
    };
@endphp

<ul class="nav nav-secondary">
    {{-- Dashboard --}}
    <li class="nav-item {{ $active($dashboardRoute) }}">
        <a href="{{ route($dashboardRoute) }}">
            <i class="fas fa-home"></i>
            <p>Dashboard</p>
        </a>
    </li>

    {{-- Admin (Jabatan 1) --}}
    @if (Auth::user()->jabatan_id == 1)
        <li class="nav-item {{ $activeLike('ruu') }}">
            <a href="{{ route('ruu.index') }}">
                <i class="fas fa-gavel"></i>
                <p>RUU Management</p>
            </a>
        </li>
        <li class="nav-item {{ $activeLike('users') }}">
            <a href="{{ route('users.index') }}">
                <i class="fas fa-users-cog"></i>
                <p>User Management</p>
            </a>
        </li>
        <li class="nav-item {{ $activeLike('voting') }}">
            <a href="{{ route('voting.index') }}">
                <i class="fas fa-check-square"></i>
                <p>Voting Logs</p>
            </a>
        </li>
        <li class="nav-item {{ $activeLike('revisi_ruu') }}">
            <a href="{{ route('revisi_ruu.index') }}">
                <i class="fas fa-edit"></i>
                <p>Revisi RUU</p>
            </a>
        </li>
        <li class="nav-item {{ $activeLike('alokasi_dana') }}">
            <a href="{{ route('alokasi_dana.index') }}">
                <i class="fas fa-coins"></i>
                <p>Alokasi Dana</p>
            </a>
        </li>
        <li class="nav-item {{ $activeLike('jabatan') }}">
            <a href="{{ route('jabatan.index') }}">
                <i class="fas fa-briefcase"></i>
                <p>Jabatan</p>
            </a>
        </li>

        {{-- Anggota (Jabatan 2) --}}
    @elseif(Auth::user()->jabatan_id == 2)
        <li class="nav-item {{ $activeLike('ruu') }}">
            <a href="{{ route('ruu.index') }}">
                <i class="fas fa-book"></i>
                <p>Daftar RUU</p>
            </a>
        </li>
        <li class="nav-item {{ $activeLike('voting') }}">
            <a href="{{ route('voting.vote') }}">
                <i class="fas fa-volume-off"></i>
                <p>Berikan Suara</p>
            </a>
        </li>
        <li class="nav-item {{ $activeLike('revisi_ruu') }}">
            <a href="{{ route('revisi_ruu.index') }}">
                <i class="fas fa-pen"></i>
                <p>Revisi RUU</p>
            </a>
        </li>
        <li class="nav-item {{ $activeLike('riwayat.history') }}">
            <a href="{{ route('riwayat.history') }}">
                <i class="fas fa-history"></i>
                <p>Riwayat Aktivitas</p>
            </a>
        </li>

        {{-- Publik (Jabatan 3) --}}
    @elseif(Auth::user()->jabatan_id == 3)
        <li class="nav-item {{ $active('ruu.publik') }}">
            <a href="{{ route('ruu.publik') }}">
                <i class="fas fa-file-alt"></i>
                <p>Lihat Daftar RUU</p>
            </a>
        </li>
    @endif
</ul>
