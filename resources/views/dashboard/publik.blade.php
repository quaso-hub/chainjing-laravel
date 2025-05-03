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

            <!-- Search -->
            <div class="input-group mb-5 shadow-sm rounded-pill">
                <input type="text" class="form-control border-0 py-3 ps-4 rounded-start-pill"
                    placeholder="Cari RUU berdasarkan kata kunci…">
                <button class="btn btn-primary px-4 rounded-end-pill">
                    <i class="bi bi-search"></i> Cari
                </button>
            </div>

            <div class="row">
                <div class="col-lg-9">

                    <div class="row g-4">
                        <!-- Loop RUU -->
                        @for ($i = 1; $i <= 4; $i++)
                            <div class="col-md-6">
                                <div class="card h-100 shadow-sm border-0">
                                    <div class="card-body">
                                        <span class="badge bg-success mb-2">Aktif</span>
                                        <h5 class="card-title">RUU Perlindungan Data Pribadi {{ $i }}</h5>
                                        <p class="card-text text-muted small">Mengatur perlindungan data pribadi warga
                                            negara terhadap penyalahgunaan informasi digital.</p>
                                        <ul class="list-unstyled text-muted small">
                                            <li><i class="bi bi-calendar-event me-2"></i>Diperbarui 25 Apr 2025</li>
                                            <li><i class="bi bi-bar-chart me-2"></i>210 suara</li>
                                            <li><i class="bi bi-pencil-square me-2"></i>5 revisi</li>
                                        </ul>
                                        <button class="btn btn-outline-primary btn-sm mt-2" data-bs-toggle="modal"
                                            data-bs-target="#detailModal">Lihat Detail</button>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>

                    <!-- View More Button -->
                    <div class="text-center mt-5">
                        <button class="btn btn-outline-dark rounded-pill px-4 py-2" data-bs-toggle="modal"
                            data-bs-target="#viewMoreModal">
                            <i class="bi bi-three-dots"></i> Lihat Lebih Banyak
                        </button>
                    </div>

                </div>

                <!-- Sidebar RUU Populer -->
                <div class="col-lg-3">
                    <div class="bg-white p-4 rounded-4 shadow-sm">
                        <h6 class="fw-bold mb-3"><i class="bi bi-stars me-2 text-warning"></i>RUU Populer</h6>
                        <ul class="list-unstyled small text-muted">
                            <li class="d-flex justify-content-between align-items-center mb-3">
                                <span>Digitalisasi Pemerintah</span>
                                <span class="badge rounded-pill bg-primary">350</span>
                            </li>
                            <li class="d-flex justify-content-between align-items-center mb-3">
                                <span>Perlindungan Konsumen</span>
                                <span class="badge rounded-pill bg-primary">290</span>
                            </li>
                            <li class="d-flex justify-content-between align-items-center">
                                <span>Energi Terbarukan</span>
                                <span class="badge rounded-pill bg-primary">255</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal: Lihat Lebih Banyak -->
    <div class="modal fade" id="viewMoreModal" tabindex="-1" aria-labelledby="viewMoreModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Daftar RUU Lainnya</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        @for ($i = 5; $i <= 15; $i++)
                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body small">
                                        <span class="badge bg-secondary mb-1">Selesai</span>
                                        <h6 class="mb-1">RUU Kesejahteraan Sosial {{ $i }}</h6>
                                        <p class="text-muted mb-1">Deskripsi singkat RUU ke-{{ $i }}.</p>
                                        <small class="text-muted d-block"><i class="bi bi-bar-chart"></i> 100 suara &nbsp;
                                            <i class="bi bi-pencil-square"></i> 2 revisi</small>

                                        <button class="btn btn-sm btn-outline-primary mt-2" data-bs-toggle="modal"
                                            data-bs-target="#detailModal" data-bs-dismiss="" {{-- tidak menutup modal utama --}}
                                            onclick="showDetailRUU('RUU Kesejahteraan Sosial {{ $i }}', 'Selesai', 'Deskripsi lengkap RUU ke-{{ $i }}.', '20 Apr 2025', 100, 2)">
                                            Lihat Detail
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal: Lihat Detail -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail RUU</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body small text-muted">
                    <p><strong>Judul:</strong> <span id="detailJudul"></span></p>
                    <p><strong>Status:</strong> <span id="detailStatus"></span></p>
                    <p><strong>Deskripsi:</strong> <span id="detailDeskripsi"></span></p>
                    <p><strong>Dibuat:</strong> <span id="detailDibuat"></span></p>
                    <p><strong>Jumlah Voting:</strong> <span id="detailVoting"></span></p>
                    <p><strong>Jumlah Revisi:</strong> <span id="detailRevisi"></span></p>
                    <hr>
                    <p><strong>Catatan Tambahan:</strong> Usulan revisi akan ditutup pada <span
                            class="fw-semibold text-dark">1 Mei 2025</span>. Publik dapat menyampaikan tanggapan hingga
                        tanggal tersebut.</p>
                    <p><strong>Regulasi Terkait:</strong> Pasal 5 KUHP, UU ITE No. 11 Tahun 2008, dan peraturan pelaksana
                        lainnya.</p>
                    <p><strong>Institusi Terkait:</strong> Kementerian Kominfo, DPR Komisi I, dan Lembaga Perlindungan Data
                        Nasional.</p>
                </div>

            </div>
        </div>
    </div>










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
                        <!-- RUU Aktif -->
                        <tr>
                            <td>
                                <strong>RUU Pendidikan Nasional</strong>
                                <div class="small text-muted">Mengatur standar pendidikan dan kurikulum nasional.</div>
                            </td>
                            <td class="text-center text-success fw-semibold">85</td>
                            <td class="text-center text-danger fw-semibold">15</td>
                            <td class="text-center">100</td>
                            <td class="text-center"><span class="badge bg-success">Aktif</span></td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                <div class="progress rounded-pill" style="height: 18px;">
                                    <div class="progress-bar bg-success" style="width: 85%">Setuju 85%</div>
                                    <div class="progress-bar bg-danger" style="width: 15%">Tidak 15%</div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <strong>RUU Teknologi & Data</strong>
                                <div class="small text-muted">Menjamin keamanan data pribadi dalam dunia digital.</div>
                            </td>
                            <td class="text-center text-success fw-semibold">52</td>
                            <td class="text-center text-danger fw-semibold">48</td>
                            <td class="text-center">100</td>
                            <td class="text-center"><span class="badge bg-success">Aktif</span></td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                <div class="progress rounded-pill" style="height: 18px;">
                                    <div class="progress-bar bg-success" style="width: 52%">Setuju 52%</div>
                                    <div class="progress-bar bg-danger" style="width: 48%">Tidak 48%</div>
                                </div>
                            </td>
                        </tr>

                        <!-- RUU Selesai -->
                        <tr>
                            <td>
                                <strong>RUU Kesejahteraan Sosial</strong>
                                <div class="small text-muted">Fokus pada perlindungan sosial dan kesejahteraan masyarakat
                                    rentan.</div>
                            </td>
                            <td colspan="3" class="text-center text-muted">Voting Ditutup</td>
                            <td class="text-center"><span class="badge bg-secondary">Selesai</span></td>
                        </tr>
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
                        @for ($i = 1; $i <= 10; $i++)
                            <li class="list-group-item">
                                <strong>RUU Digital {{ $i }}</strong>
                                <div class="text-muted small mb-2">Voting saat ini: <strong>Setuju:
                                        {{ 40 + $i }}%</strong>, Tidak Setuju: {{ 60 - $i }}%</div>
                                <div class="progress mb-2" style="height: 8px;">
                                    <div class="progress-bar bg-success" style="width: {{ 40 + $i }}%"></div>
                                    <div class="progress-bar bg-danger" style="width: {{ 60 - $i }}%"></div>
                                </div>
                                <small class="text-muted">Total suara: {{ 100 + $i * 3 }}</small>
                            </li>
                        @endfor
                    </ul>
                </div>
            </div>
        </div>
    </div>




    <!-- Section: Ringkasan Revisi -->
    <section id="revisi" class="section py-5 bg-white border-top">
        <div class="container" data-aos="fade-up">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-3"><i class="bi bi-pencil-square text-primary me-2"></i>Ringkasan Revisi RUU</h2>
                <p class="text-muted">Daftar RUU yang paling banyak diajukan revisi oleh masyarakat. Menandakan topik yang
                    kontroversial atau penting.</p>
            </div>

            <div class="accordion shadow-sm rounded-4 overflow-hidden" id="accordionRevisi">

                <!-- Example 1 -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button d-flex justify-content-between align-items-center" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapseOne">
                            <span>
                                <strong class="me-2">RUU Kesehatan Mental</strong>
                                <span class="badge bg-warning text-dark">Topik: Psikologi</span>
                            </span>
                            <span class="text-muted small ms-auto">7 revisi - Terakhir: 21 Apr 2025</span>
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionRevisi">
                        <div class="accordion-body small">
                            <strong>Revisi Terakhir:</strong> Perlu ditambahkan pasal tentang perlindungan pasien rawat
                            jalan.<br>
                            <strong>Diajukan:</strong> 21 Apr 2025<br>
                            <strong>Pengirim:</strong> Publik
                            <div class="text-end mt-3">
                                <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#detailRevisiModal">Lihat Selengkapnya</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Example 2 -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed d-flex justify-content-between align-items-center"
                            type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                            <span>
                                <strong class="me-2">RUU AI Nasional</strong>
                                <span class="badge bg-info text-dark">Topik: Teknologi</span>
                            </span>
                            <span class="text-muted small ms-auto">5 revisi - Terakhir: 15 Apr 2025</span>
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionRevisi">
                        <div class="accordion-body small">
                            <strong>Revisi Terakhir:</strong> Tambahkan batasan terhadap pemanfaatan AI dalam militer.<br>
                            <strong>Diajukan:</strong> 15 Apr 2025<br>
                            <strong>Pengirim:</strong> Komunitas Digital
                            <div class="text-end mt-3">
                                <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#detailRevisiModal">Lihat Selengkapnya</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Button -->
            <div class="text-center mt-4">
                <button class="btn btn-primary px-4 rounded-pill" data-bs-toggle="modal"
                    data-bs-target="#semuaRevisiModal">
                    <i class="bi bi-list-ul me-1"></i> Telusuri Semua Revisi
                </button>
            </div>
        </div>
    </section>

    <!-- Modal: Detail Revisi -->
    <div class="modal fade" id="detailRevisiModal" tabindex="-1" aria-labelledby="detailRevisiLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content rounded-4">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="detailRevisiLabel"><i
                            class="bi bi-info-circle me-2 text-primary"></i>Detail Revisi RUU</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body small text-muted">
                    <p><strong>Judul RUU:</strong> RUU Kesehatan Mental</p>
                    <p><strong>Topik:</strong> Psikologi</p>
                    <p><strong>Diajukan:</strong> 21 Apr 2025</p>
                    <p><strong>Pengusul:</strong> Publik</p>
                    <p><strong>Isi Usulan Revisi:</strong> <br>
                        Menambahkan ketentuan pasal baru mengenai layanan psikologis berbasis komunitas, terutama untuk
                        wilayah 3T (Tertinggal, Terdepan, Terluar).
                    </p>
                    <p><strong>Catatan Tambahan:</strong> Usulan akan ditinjau oleh komisi dalam 7 hari kerja.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Semua Revisi -->
    <div class="modal fade" id="semuaRevisiModal" tabindex="-1" aria-labelledby="semuaRevisiLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content rounded-4">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="semuaRevisiLabel"><i
                            class="bi bi-list-check me-2 text-primary"></i>Semua Usulan Revisi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <!-- Search Box -->
                    <div class="input-group mb-4 shadow-sm">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control border-start-0"
                            placeholder="Cari judul atau topik RUU…">
                    </div>

                    <!-- List Revisi -->
                    <div class="row g-3">
                        @for ($i = 1; $i <= 10; $i++)
                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body small">
                                        <span class="badge bg-warning text-dark mb-2">Topik: Kesehatan</span>
                                        <h6 class="fw-semibold">RUU Layanan Kesehatan Digital {{ $i }}</h6>
                                        <p class="text-muted">Revisi tentang pemerataan akses layanan kesehatan digital di
                                            seluruh Indonesia.</p>
                                        <ul class="list-unstyled small text-muted mb-0">
                                            <li><i class="bi bi-calendar3 me-2"></i>Diajukan: 20 Apr 2025</li>
                                            <li><i class="bi bi-person me-2"></i>Pengusul: Masyarakat</li>
                                        </ul>
                                        <div class="text-end mt-3">
                                            <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#detailRevisiModal">
                                                Detail
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>
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
                        <h6 class="text-muted small mb-2">Total Anggaran Bulan Ini</h6>
                        <h5 class="mb-0 fw-bold">Rp 1.200.000.000</h5>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="bg-white rounded-4 shadow-sm p-4 text-center">
                        <h6 class="text-muted small mb-2">Sisa Dana</h6>
                        <h5 class="mb-0 text-success fw-bold">Rp 250.000.000</h5>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="bg-white rounded-4 shadow-sm p-4 text-center">
                        <h6 class="text-muted small mb-2">Penggunaan Terakhir</h6>
                        <p class="mb-0 text-dark">Pengadaan Sistem Digital RUU</p>
                        <small class="text-muted">24 April 2025</small>
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
                        <tr>
                            <td>21-April-2025</td>
                            <td>Workshop Legislasi Mahasiswa</td>
                            <td>Rp 75.000.000</td>
                            <td class="text-end">
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#detailDanaModal">Lihat Detail</button>
                            </td>
                        </tr>
                        <tr>
                            <td>18-April-2025</td>
                            <td>Sosialisasi Kampus</td>
                            <td>Rp 50.000.000</td>
                            <td class="text-end">
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#detailDanaModal">Lihat Detail</button>
                            </td>
                        </tr>
                        <tr>
                            <td>15-April-2025</td>
                            <td>Pengembangan Sistem</td>
                            <td>Rp 100.000.000</td>
                            <td class="text-end">
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#detailDanaModal">Lihat Detail</button>
                            </td>
                        </tr>
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

    <!-- Modal: Detail Alokasi Dana -->
    <div class="modal fade" id="detailDanaModal" tabindex="-1" aria-labelledby="detailDanaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Alokasi Dana</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body small text-muted">
                    <p><strong>Kegiatan:</strong> Workshop Legislasi Mahasiswa</p>
                    <p><strong>Tanggal:</strong> 21 April 2025</p>
                    <p><strong>Jumlah:</strong> Rp 75.000.000</p>
                    <p><strong>Status:</strong> <span class="badge bg-warning">Berlangsung</span></p>
                    <hr>
                    <p><strong>Rincian:</strong> Biaya mencakup pemateri, akomodasi, dan konsumsi 150 peserta selama 2 hari
                        kegiatan workshop.</p>
                    <p><strong>Catatan Tambahan:</strong> Kegiatan diselenggarakan oleh Kementerian Hukum Mahasiswa
                        bekerjasama dengan DPR RI.</p>
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
                        @for ($i = 1; $i <= 10; $i++)
                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body small">
                                        <h6 class="fw-bold mb-1">Kegiatan Sosialisasi #{{ $i }}</h6>
                                        <p class="text-muted mb-2 small">Tanggal: 10-April-2025</p>
                                        <p class="text-muted mb-2 small">Jumlah: Rp
                                            {{ number_format(50000000 + $i * 5000000, 0, ',', '.') }}</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="badge bg-secondary">Selesai</span>
                                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                                data-bs-target="#detailDanaModal">Lihat Detail</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>











    @push('scripts')
        <script>
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
        </script>
    @endpush
@endsection
