@extends('layouts.app')

@section('content')
<div class="page-inner">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
            <h3 class="fw-bold mb-3">Selamat datang, Admin.</h3>
            <h6 class="op-7 mb-2">Kelola data dan pengawasan penuh terhadap sistem RUU.</h6>
        </div>
    </div>

    <!-- Statistic Cards -->
    <div class="row">
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body ">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-primary bubble-shadow-small">
                                <i class="fas fa-file-alt"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Total RUU</p>
                                <h4 class="card-title">-</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body ">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-success bubble-shadow-small">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Total User</p>
                                <h4 class="card-title">-</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body ">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-warning bubble-shadow-small">
                                <i class="fas fa-check-square"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Voting Tercatat</p>
                                <h4 class="card-title">-</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body ">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-danger bubble-shadow-small">
                                <i class="fas fa-edit"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Revisi Masuk</p>
                                <h4 class="card-title">-</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Aksi Cepat -->
    {{-- <div class="row">
        <div class="col-md-12">
            <div class="card card-round">
                <div class="card-body">
                    <div class="d-flex justify-content-around flex-wrap gap-3">
                        <a href="{{ route('ruu.index') }}" class="btn btn-primary btn-round btn-lg">
                            <i class="fas fa-file-alt me-1"></i> RUU Management
                        </a>
                        <a href="{{ route('users.index') }}" class="btn btn-info btn-round btn-lg">
                            <i class="fas fa-users-cog me-1"></i> User Management
                        </a>
                        <a href="{{ route('voting.index') }}" class="btn btn-success btn-round btn-lg">
                            <i class="fas fa-vote-yea me-1"></i> Voting Logs
                        </a>
                        <a href="{{ route('revisi-ruu.index') }}" class="btn btn-warning btn-round btn-lg">
                            <i class="fas fa-edit me-1"></i> Revisi RUU
                        </a>
                        <a href="{{ route('alokasi-dana.index') }}" class="btn btn-secondary btn-round btn-lg">
                            <i class="fas fa-coins me-1"></i> Alokasi Dana
                        </a>
                        <a href="{{ route('jabatan.index') }}" class="btn btn-dark btn-round btn-lg">
                            <i class="fas fa-briefcase me-1"></i> Jabatan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <!-- Grafik Statistik -->
    <div class="row">
        <div class="col-md-8">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-head-row">
                        <div class="card-title">Voting & Revisi Trend</div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="min-height: 300px;">
                        <canvas id="trendChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-title">Status RUU</div>
                </div>
                <div class="card-body">
                    <div class="progress-card">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted">Disahkan</span>
                            <span class="text-muted fw-bold">40%</span>
                        </div>
                        <div class="progress mb-2">
                            <div class="progress-bar bg-success" style="width: 40%"></div>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted">Dalam Revisi</span>
                            <span class="text-muted fw-bold">35%</span>
                        </div>
                        <div class="progress mb-2">
                            <div class="progress-bar bg-warning" style="width: 35%"></div>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted">Gagal</span>
                            <span class="text-muted fw-bold">25%</span>
                        </div>
                        <div class="progress mb-2">
                            <div class="progress-bar bg-danger" style="width: 25%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Aktivitas -->
    <div class="row">
        <div class="col-md-6">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-title">Revisi Terbaru</div>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>RUU</th>
                                <th>Oleh</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>RUU Perlindungan Data</td>
                                <td>Dewan A</td>
                                <td>2024-04-30</td>
                            </tr>
                            <tr>
                                <td>RUU Energi Terbarukan</td>
                                <td>Dewan B</td>
                                <td>2024-04-29</td>
                            </tr>
                            <tr>
                                <td>RUU Kesejahteraan Sosial</td>
                                <td>Dewan C</td>
                                <td>2024-04-28</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-title">Voting Terakhir</div>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>RUU</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>RUU Pendidikan</td>
                                <td><span class="badge bg-success">Disetujui</span></td>
                                <td>2024-04-30</td>
                            </tr>
                            <tr>
                                <td>RUU Transportasi</td>
                                <td><span class="badge bg-danger">Ditolak</span></td>
                                <td>2024-04-29</td>
                            </tr>
                            <tr>
                                <td>RUU Pajak Digital</td>
                                <td><span class="badge bg-warning">Tertunda</span></td>
                                <td>2024-04-28</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Notifikasi Singkat -->
    <div class="row">
        <div class="col-md-12">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-title">Log Aktivitas Terbaru</div>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">[2024-04-30 10:00] RUU Perlindungan Data direvisi oleh Dewan A</li>
                        <li class="list-group-item">[2024-04-29 09:30] Voting RUU Energi Terbarukan disetujui</li>
                        <li class="list-group-item">[2024-04-28 14:15] RUU Kesejahteraan Sosial gagal voting</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        var ctx = document.getElementById('trendChart').getContext('2d');
        var trendChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu'],
                datasets: [
                    {
                        label: 'Voting',
                        borderColor: '#177dff',
                        data: [12, 19, 3, 5, 2, 3],
                        fill: false
                    },
                    {
                        label: 'Revisi',
                        borderColor: '#f3545d',
                        data: [2, 3, 20, 5, 1, 4],
                        fill: false
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    </script>
    @endpush
</div>
@endsection