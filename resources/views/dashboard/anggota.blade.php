@extends('layouts.app')

@section('content')
<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Dashboard Anggota</h4>
        <p class="text-muted">Selamat datang kembali, {{ Auth::user()->nama }}. Pantau kegiatan dan progress RUU Anda.</p>
    </div>

    {{-- Summary Panel --}}
    <div class="row">
        <div class="col-md-3">
            <x-stat-card title="RUU Aktif" :value="$totalRuuAktif" icon="fas fa-gavel" color="primary" />
        </div>
        <div class="col-md-3">
            <x-stat-card title="Suara Anda" :value="$totalVotingSaya" icon="fas fa-vote-yea" color="success" />
        </div>
        <div class="col-md-3">
            <x-stat-card title="Revisi Dikirim" :value="$totalRevisiSaya" icon="fas fa-edit" color="warning" />
        </div>
        <div class="col-md-3">
            <x-stat-card title="Agenda Terkini" value="3" icon="fas fa-calendar-alt" color="info" />
        </div>
    </div>

    {{-- Aktivitas Terakhir --}}
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card card-info">
                <div class="card-header">
                    <div class="card-title">📊 Aktivitas Terakhir Anda</div>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li><strong>Voting Terakhir:</strong> {{ $lastVote?->ruu->judul ?? 'Belum ada' }}</li>
                        <li><strong>Revisi Terakhir:</strong> {{ $lastRevisi?->ruu->judul ?? 'Belum ada' }}</li>
                        <li><strong>Update Terakhir:</strong> {{ $lastVote?->created_at?->diffForHumans() ?? '-' }}</li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Agenda Voting Minggu Ini --}}
        <div class="col-md-6">
            <div class="card card-warning">
                <div class="card-header">
                    <div class="card-title">🗓️ Agenda Voting Minggu Ini</div>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li><strong>RUU Perlindungan Data:</strong> Batas: 5 Mei 2025</li>
                        <li><strong>RUU Energi Terbarukan:</strong> Batas: 8 Mei 2025</li>
                        <li><strong>RUU Pendidikan Nasional:</strong> Batas: 11 Mei 2025</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Info Sistem --}}
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="alert alert-primary shadow-sm border-0" role="alert">
                <strong>📢 Info:</strong> Pastikan Anda melakukan voting dan pengajuan revisi sebelum batas waktu berakhir.
            </div>
        </div>
    </div>
</div>
@endsection
