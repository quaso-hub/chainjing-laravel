@extends('layouts.publik')

@section('content')
    <!-- Hero Section -->
    <section id="hero" class="hero section bg-light">
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="hero-content" data-aos="fade-up" data-aos-delay="200">
                        <div class="company-badge mb-4">
                            <i class="bi bi-gear-fill me-2"></i>
                            Pemantauan Publik Digital
                        </div>

                        <h1 class="mb-4">
                            Selamat Datang di <br>
                            <span class="accent-text">Chainjing</span>
                        </h1>

                        <p class="mb-4 mb-md-5">
                            Platform transparan untuk partisipasi masyarakat dalam penyusunan dan pengawasan RUU serta dana
                            publik.
                        </p>

                        <div class="hero-buttons">
                            <a href="#fitur" class="btn btn-primary me-2">Eksplorasi Perubahan</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="hero-image" data-aos="zoom-out" data-aos-delay="300">
                        <img src="{{ asset('assets/img/illustration-1.webp') }}" alt="Hero" class="img-fluid">
                        <div class="customers-badge">
                            <div class="customer-avatars">
                                <img src="{{ asset('assets/img/avatar-1.webp') }}" alt="" class="avatar">
                                <img src="{{ asset('assets/img/avatar-2.webp') }}" alt="" class="avatar">
                                <img src="{{ asset('assets/img/avatar-3.webp') }}" alt="" class="avatar">
                                <img src="{{ asset('assets/img/avatar-4.webp') }}" alt="" class="avatar">
                                <img src="{{ asset('assets/img/avatar-5.webp') }}" alt="" class="avatar">
                                <span class="avatar more">12K+</span>
                            </div>
                            <p class="mb-0 mt-2">Warga telah terlibat aktif memantau legislasi & anggaran</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section: Daftar RUU -->
    <section id="daftar-ruu" class="section mt-5">
        <div class="container" data-aos="fade-up">

            <!-- Search Form -->
            <form action="{{ route('publik.dashboard') }}" method="GET">
                <div class="input-group mb-5 shadow-sm rounded-pill">
                    <input type="text" name="keyword" class="form-control border-0 py-3 ps-4 rounded-start-pill"
                        placeholder="Cari RUU berdasarkan kata kunci…" value="{{ request('keyword') }}">
                    <button type="submit" class="btn btn-primary px-4 rounded-end-pill">
                        <i class="bi bi-search"></i> Cari
                    </button>
                </div>
            </form>

            <div class="row">
                <div class="col-lg-12">
                    <div class="row g-4">
                        @forelse($ruus as $ruu)
                            <div class="col-md-6">
                                <div class="card h-100 shadow-sm border-0">
                                    <div class="card-body">
                                        {{-- Logika Status Dinamis --}}
                                        @if ($ruu->voting_mulai)
                                            {{-- Cek dulu apakah jadwalnya ada --}}
                                            @if (now()->between($ruu->voting_mulai, $ruu->voting_selesai))
                                                <span class="badge bg-success mb-2">Aktif</span>
                                            @else
                                                <span class="badge bg-secondary mb-2">Selesai</span>
                                            @endif
                                        @else
                                            {{-- Jika tidak ada jadwal, tampilkan status dari DB --}}
                                            <span class="badge bg-info mb-2">{{ $ruu->status }}</span>
                                        @endif

                                        <h5 class="card-title">{{ $ruu->judul }}</h5>
                                        <p class="card-text text-muted small">{{ Str::limit($ruu->deskripsi, 100) }}</p>

                                        <ul class="list-unstyled text-muted small mt-3">
                                            <li>
                                                <i class="bi bi-calendar-event me-2"></i>
                                                @if ($ruu->updated_at)
                                                    {{ $ruu->updated_at->translatedFormat('d M Y') }}
                                                @else
                                                    -
                                                @endif
                                            </li>
                                            <li>
                                                <i class="bi bi-bar-chart me-2"></i>
                                                {{ $ruu->voting_count }} suara masuk
                                            </li>
                                            <li>
                                                <i class="bi bi-pencil-square me-2"></i>
                                                {{ $ruu->revisi_count }} usulan revisi
                                            </li>
                                        </ul>

                                        <button class="btn btn-outline-primary btn-sm mt-2 view-blockchain-btn"
                                            data-bs-toggle="modal" data-bs-target="#blockchainDetailModal"
                                            data-ruu-id="{{ $ruu->id }}" data-ruu-judul="{{ $ruu->judul }}">
                                            <i class="bi-shield-check"></i> Verifikasi Blockchain
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center py-5">
                                <i class="bi bi-search display-4 text-muted"></i>
                                <h5 class="mt-3">RUU tidak ditemukan</h5>
                                <p class="text-muted">Tidak ada RUU yang cocok dengan kriteria pencarian Anda.</p>
                                <a href="{{ route('publik.dashboard') }}">Tampilkan semua RUU</a>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination Links -->
                    <div class="mt-5 d-flex justify-content-center">
                        {{ $ruus->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>


    </section>

    <!-- Section: Voting Summary -->
    <section id="voting" class="section py-5 bg-light border-top">
        <div class="container" data-aos="fade-up">
            <!-- Header -->
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-3"><i class="bi bi-bar-chart-line-fill text-primary me-2"></i>Ringkasan Voting RUU
                </h2>
                <p class="text-muted">Rekap suara publik terhadap rancangan undang-undang yang sedang dibahas. Seluruh data
                    bersifat transparan dan hanya untuk informasi.</p>
            </div>

            <!-- Table -->
            <div class="table-responsive shadow-sm rounded-4 overflow-hidden">
                <table class="table table-hover table-borderless align-middle mb-0">
                    <thead class="table-light">
                        <tr class="text-uppercase small text-muted">
                            <th>Judul RUU</th>
                            <th class="text-center">Setuju</th>
                            <th class="text-center">Tidak Setuju</th>
                            <th class="text-center">Total Voting</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @forelse($votingTop3 as $v)
                            <tr>
                                <td>
                                    <strong>{{ $v['judul'] }}</strong>
                                    <div class="small text-muted">{{ Str::limit($v['deskripsi'], 100) }}</div>
                                </td>
                                <td class="text-center text-success fw-semibold">{{ $v['setuju'] }}</td>
                                <td class="text-center text-danger fw-semibold">{{ $v['tidak'] }}</td>
                                <td class="text-center">{{ $v['total'] }}</td>
                                <td class="text-center"><span class="badge bg-success">Aktif</span></td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <div class="progress rounded-pill" style="height: 18px;">
                                        <div class="progress-bar bg-success" style="width: {{ $v['persen_setuju'] }}%">
                                            Setuju {{ $v['persen_setuju'] }}%</div>
                                        <div class="progress-bar bg-danger" style="width: {{ $v['persen_tidak'] }}%">
                                            Tidak {{ $v['persen_tidak'] }}%</div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Belum ada voting aktif.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Button -->
            <div class="text-center mt-4">
                <button class="btn btn-outline-dark rounded-pill px-4" data-bs-toggle="modal"
                    data-bs-target="#votingDetailModal">
                    <i class="bi bi-bar-chart-line"></i> Lihat Semua Voting
                </button>
                <div class="mt-3">
                    <small class="text-muted">Voting baru akan ditampilkan saat status RUU menjadi
                        <strong>Aktif</strong>.</small>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal: Voting Detail -->
    <div class="modal fade" id="votingDetailModal" tabindex="-1" aria-labelledby="votingDetailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Voting RUU</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body small">
                    <input type="text" class="form-control mb-4" placeholder="Cari RUU...">
                    <ul class="list-group list-group-flush">
                        @forelse($votingSummary as $v)
                            <li class="list-group-item">
                                <strong>{{ $v['judul'] }}</strong>
                                <div class="text-muted small mb-2">
                                    Voting saat ini: <strong>Setuju: {{ $v['persen_setuju'] }}%</strong>, Tidak Setuju:
                                    {{ $v['persen_tidak'] }}%
                                </div>
                                <div class="progress mb-2" style="height: 8px;">
                                    <div class="progress-bar bg-success" style="width: {{ $v['persen_setuju'] }}%"></div>
                                    <div class="progress-bar bg-danger" style="width: {{ $v['persen_tidak'] }}%"></div>
                                </div>
                                <small class="text-muted">Total suara: {{ $v['total'] }}</small>
                            </li>
                        @empty
                            <li class="list-group-item text-center text-muted">Belum ada data voting aktif.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Dana Publik -->
    <!-- Section: Dana Publik -->
    <section id="dana" class="section py-5 bg-light border-top">
        <div class="container" data-aos="fade-up">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-3"><i class="bi bi-cash-stack text-primary me-2"></i>Transparansi Dana Publik</h2>
                <p class="text-muted">Informasi penggunaan anggaran publik secara transparan dan real-time. Semua data
                    hanya bersifat informatif dan tidak dimanipulasi.</p>
            </div>

            <!-- Statistik -->
            <div class="row mb-4">
                <div class="col-md-4 mb-3">
                    <div class="bg-white rounded-4 shadow-sm p-4 text-center">
                        <h6 class="text-muted small mb-2">Total Anggaran</h6>
                        <h5 class="mb-0 fw-bold">Rp {{ number_format($totalAnggaran, 0, ',', '.') }}</h5>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="bg-white rounded-4 shadow-sm p-4 text-center">
                        <h6 class="text-muted small mb-2">Jumlah Program</h6>
                        <h5 class="mb-0 text-success fw-bold">{{ $jumlahProgram }} kegiatan</h5>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="bg-white rounded-4 shadow-sm p-4 text-center">
                        <p class="mb-0 text-dark">{{ $penggunaanTerakhir->nama_program ?? '-' }}</p>
                        <small
                            class="text-muted">{{ \Carbon\Carbon::parse($penggunaanTerakhir->tanggal)->translatedFormat('d F Y') }}</small>
                    </div>
                </div>
            </div>

            <!-- Tabel Dana -->
            <div class="table-responsive shadow-sm rounded-4 overflow-hidden">
                <table class="table table-hover table-borderless align-middle mb-0 bg-white">
                    <thead class="table-light text-uppercase small text-muted">
                        <tr>
                            <th>Tanggal</th>
                            <th>Kegiatan</th>
                            <th>Jumlah</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($alokasiTop3 as $item)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-M-Y') }}</td>
                                <td>{{ $item->nama_program }}</td>
                                <td>Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                                <td class="text-end">
                                    <button class="btn btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#detailDanaModal" data-alokasi-id="{{ $item->tx_id }}"
                                        data-nama="{{ $item->nama_program }}">
                                        <i class="bi-shield-check"></i> Verifikasi Blockchain
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- View More -->
            <div class="text-center mt-4">
                <button class="btn btn-outline-dark rounded-pill px-4 py-2" data-bs-toggle="modal"
                    data-bs-target="#viewMoreDanaModal">
                    <i class="bi bi-three-dots"></i> Lihat Lebih Banyak
                </button>
            </div>
        </div>
    </section>

    <!-- Modal: Verifikasi Blockchain Dana -->
    <div class="modal fade" id="detailDanaModal" tabindex="-1" aria-labelledby="detailDanaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailDanaModalLabel">Memuat Data...</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body" id="dana-blockchain-container"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: View More Dana -->
    <div class="modal fade" id="viewMoreDanaModal" tabindex="-1" aria-labelledby="viewMoreDanaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Alokasi Dana Publik</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Search -->
                    <div class="input-group mb-4 shadow-sm rounded-pill">
                        <input type="text" class="form-control border-0 py-2 ps-4 rounded-start-pill"
                            placeholder="Cari kegiatan atau tanggal...">
                        <button class="btn btn-primary px-4 rounded-end-pill"><i class="bi bi-search"></i></button>
                    </div>

                    <!-- List Dana -->
                    <div class="row g-3">
                        @foreach ($alokasiList as $item)
                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body small">
                                        <h6 class="fw-bold mb-1">{{ $item->nama_program }}</h6>
                                        <p class="text-muted mb-2 small">Tanggal:
                                            {{ \Carbon\Carbon::parse($item->tanggal)->format('d-M-Y') }}</p>
                                        <p class="text-muted mb-2 small">Jumlah: Rp
                                            {{ number_format($item->jumlah, 0, ',', '.') }}</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="badge bg-secondary">Selesai</span>
                                            <button class="btn btn-outline-primary" data-bs-toggle="modal"
                                                data-bs-target="#detailDanaModal" data-alokasi-id="{{ $item->tx_id }}"
                                                data-nama="{{ $item->nama_program }}">
                                                <i class="bi-shield-check"></i> Verifikasi Blockchain
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- MODAL SINGLE UNTUK TAMPILAN DATA BLOCKCHAIN -->
    <div class="modal fade" id="blockchainDetailModal" tabindex="-1" aria-labelledby="blockchainDetailModalLabel"
        aria-hidden="true">
        {{-- ... Isi modal tidak berubah ... --}}
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="blockchainDetailModalLabel">Memuat Data...</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="blockchain-data-container">
                    {{-- Konten akan diisi oleh JavaScript --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>


@endsection


@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('detailDanaModal');

            modal.addEventListener('show.bs.modal', function(event) {
                const btn = event.relatedTarget;
                const body = modal.querySelector('.modal-body');

                const alokasiId = btn.dataset.alokasiId;
                const namaProgram = btn.dataset.nama;

                document.getElementById('detailDanaModalLabel').textContent = 'Verifikasi Blockchain: ' +
                    namaProgram;

                body.innerHTML = `
            <div class="d-flex justify-content-center my-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <strong class="ms-2">Mengambil data dari Blockchain...</strong>
            </div>
         `;

                fetch(`/audit/alokasi-dana/${alokasiId}`)
                    .then(response => {
                        if (!response.ok) throw response;
                        return response.json();
                    })
                    .then(data => {
                        const html = `
                    <p class="text-muted small">Data ini bersumber langsung dari blockchain ledger.</p>
                    <table class="table table-bordered table-sm">
                        <tr>
                            <th>Program</th>
                            <td>${data.NamaProgram || '-'}</td>
                        </tr>
                        <tr>
                            <th>Tanggal</th>
                            <td>${data.Tanggal ? new Date(data.Tanggal).toLocaleDateString('id-ID') : '-'}</td>
                        </tr>
                        <tr>
                            <th>Jumlah</th>
                            <td>Rp ${Number(data.Jumlah || 0).toLocaleString('id-ID')}</td>
                        </tr>
                        <tr>
                            <th>Keterangan</th>
                            <td>${data.Keterangan || '-'}</td>
                        </tr>
                        <tr>
                            <th>TX ID</th>
                            <td><code class="text-monospace small">${data.ID || '-'}</code></td>
                        </tr>
                        <tr>
                            <th>Waktu Pencatatan</th>
                            <td>${data.TimestampPencatatan ? new Date(data.TimestampPencatatan).toLocaleString('id-ID') : '-'}</td>
                        </tr>
                    </table>
                `;
                        body.innerHTML = html;
                    })
                    .catch(async err => {
                        let msg = 'Gagal memuat data.';
                        if (err.json) {
                            const res = await err.json();
                            msg = res.message || msg;
                        }
                        body.innerHTML = `
                    <div class="alert alert-danger text-center">
                        <h6>Gagal Memuat</h6>
                        <p>${msg}</p>
                    </div>
                `;
                    });
            });
        });


        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('detailDanaModal');

            modal.addEventListener('show.bs.modal', function(event) {
                const btn = event.relatedTarget;
                const nama = btn.getAttribute('data-nama');
                const tanggal = btn.getAttribute('data-tanggal');
                const jumlah = btn.getAttribute('data-jumlah');
                const keterangan = btn.getAttribute('data-keterangan');

                const html = `
            <p><strong>Kegiatan:</strong> ${nama}</p>
            <p><strong>Tanggal:</strong> ${tanggal}</p>
            <p><strong>Jumlah:</strong> ${jumlah}</p>
            <hr>
            <p><strong>Keterangan:</strong> ${keterangan}</p>
            `;

                modal.querySelector('#modalDanaBody').innerHTML = html;
            });
        });

        $(document).ready(function() {
            // Event listener untuk semua tombol dengan class '.view-blockchain-btn'
            $('.view-blockchain-btn').on('click', function() {
                console.log("Tombol Verifikasi Ditekan! RUU ID:", $(this).data('ruu-id'));

                // Ambil data dari tombol yang diklik
                const ruuId = $(this).data('ruu-id');
                const ruuJudul = $(this).data('ruu-judul');
                const modalContainer = $('#blockchain-data-container');
                const modalTitle = $('#blockchainDetailModalLabel');

                // 1. Set judul modal dan tampilkan loading spinner
                modalTitle.text('Data Vote untuk: ' + ruuJudul);
                modalContainer.html(`
                <div class="d-flex justify-content-center my-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <strong class="ms-3">Menarik data dari Blockchain...</strong>
                </div>
            `);

                // 2. Buat AJAX call ke controller Laravel kita
                $.ajax({
                    url: `/audit/ruu/${ruuId}/votes`,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        let tableHtml = `
                        <p class="text-muted small">Data berikut diambil langsung dari ledger blockchain yang tidak dapat diubah (immutable) untuk menjamin transparansi.</p>
                        <table class="table table-sm table-striped table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Vote ID</th>
                                    <th>Pilihan</th>
                                    <th>Timestamp</th>
                                </tr>
                            </thead>
                            <tbody>
                    `;

                        if (data.length > 0) {
                            data.forEach(vote => {
                                tableHtml += `
                                <tr>
                                    <td class="small text-monospace" style="word-break: break-all;">${vote.ID}</td>
                                    <td>${vote.Pilihan}</td>
                                    <td>${new Date(vote.Timestamp).toLocaleString('id-ID')}</td>
                                </tr>
                            `;
                            });
                        } else {
                            tableHtml +=
                                '<tr><td colspan="3" class="text-center">Belum ada data vote di blockchain untuk RUU ini.</td></tr>';
                        }

                        tableHtml += '</tbody></table>';
                        modalContainer.html(tableHtml);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error("AJAX Error:", jqXHR.responseJSON);
                        const errorMsg = jqXHR.responseJSON?.message || 'Gagal memuat data.';
                        modalContainer.html(`
                        <div class="alert alert-danger text-center">
                            <h5>Terjadi Kesalahan</h5>
                            <p>${errorMsg}</p>
                        </div>
                    `);
                    }
                });
            });

            function showDetailRUU(judul, status, deskripsi, dibuat, voting, revisi) {
                document.getElementById('detailJudul').textContent = judul;
                document.getElementById('detailStatus').textContent = status;
                document.getElementById('detailDeskripsi').textContent = deskripsi;
                document.getElementById('detailDibuat').textContent = dibuat;
                document.getElementById('detailVoting').textContent = voting;
                document.getElementById('detailRevisi').textContent = revisi;
            }

            document.getElementById('searchVoting').addEventListener('input', function() {
                const keyword = this.value.toLowerCase();
                const items = document.querySelectorAll('.voting-item');
                items.forEach(item => {
                    const text = item.textContent.toLowerCase();
                    item.style.display = text.includes(keyword) ? 'block' : 'none';
                });
            });
        });
    </script>
@endpush
