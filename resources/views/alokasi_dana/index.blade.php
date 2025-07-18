@extends('layouts.app')

@section('content')
    <div class="page-inner">
        <div
            class="page-header flex-column flex-md-row d-flex justify-content-between align-items-start align-items-md-center gap-2">
            <div class="mb-2">
                <h4 class="page-title">Manajemen Alokasi Dana</h4>
                <nav aria-label="breadcrumb" class="d-inline-block ms-2">
                    <ol class="breadcrumb bg-transparent p-0 m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.anggota') }}"><i class="fas fa-home"></i>
                                Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Alokasi Dana</li>
                    </ol>
                </nav>
            </div>
            <button class="btn btn-primary mt-2 mt-md-0" data-bs-toggle="modal" data-bs-target="#modalAlokasiDana">
                <i class="fas fa-plus"></i> Buat Proposal Dana
            </button>
        </div>

        <x-flash-message />

        <div class="card">
            <div class="card-body">
                <table id="alokasi-dana-table" class="table table-striped table-hover" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nama Program</th>
                            <th>Jumlah</th>
                            <th>Tanggal</th>
                            <th>Status Blockchain</th>
                            <th width="200">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($alokasi as $item)
                            <tr id="alokasi-row-{{ $item->id }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama_program }}</td>
                                <td>Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}</td>

                                <td>
                                    @if ($item->status_blockchain == 'recorded')
                                        <span class="badge bg-success">
                                            <i class="fas fa-check-circle me-1"></i> Tercatat
                                        </span>
                                    @else
                                        <span class="badge bg-warning text-dark">
                                            <i class="fas fa-clock me-1"></i> Pending
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    @if ($item->status_blockchain == 'pending')
                                        <form id="record-form-{{ $item->id }}"
                                            action="{{ route('alokasi_dana.record', $item->id) }}" method="POST"
                                            class="d-inline-block">
                                            @csrf
                                            <button type="button" class="btn btn-success btn-sm record-btn"
                                                data-form-id="record-form-{{ $item->id }}" data-bs-toggle="tooltip"
                                                title="Catat ke Blockchain">
                                                <i class="fas fa-shield-alt"></i> Catat
                                            </button>
                                        </form>


                                        <button class="btn btn-warning btn-sm edit-alokasi-btn"
                                            data-id="{{ $item->id }}" data-nama_program="{{ $item->nama_program }}"
                                            data-jumlah="{{ $item->jumlah }}" data-tanggal="{{ $item->tanggal }}"
                                            data-keterangan="{{ $item->keterangan }}" data-bs-toggle="tooltip"
                                            title="Edit Proposal">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm delete-alokasi-btn"
                                            data-url="{{ route('alokasi_dana.destroy', $item->id) }}"
                                            data-bs-toggle="tooltip" title="Hapus Proposal">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @else
                                        <button class="btn btn-info btn-sm view-dana-detail-btn" data-bs-toggle="modal"
                                            data-bs-target="#alokasiDetailModal" data-alokasi-id="{{ $item->tx_id }}"
                                            data-nama-program="{{ $item->nama_program }}">
                                            <i class="fas fa-info-circle"></i> Detail
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <x-modal-create id="modalAlokasiDana" labelledby="modalAlokasiLabel" title="Proposal Alokasi Dana" formId="formAlokasi"
        action="{{ route('alokasi_dana.store') }}" submitText="Simpan">
        <input type="hidden" id="alokasi-id">
        <div class="form-group">
            <label for="nama_program">Nama Program</label>
            <input type="text" name="nama_program" id="nama_program" class="form-control" required>
        </div>
        <div class="form-group mt-3">
            <label for="jumlah">Jumlah (Rp)</label>
            <input type="number" name="jumlah" id="jumlah" class="form-control" required>
        </div>
        <div class="form-group mt-3">
            <label for="tanggal">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control" required>
        </div>
        <div class="form-group mt-3">
            <label for="keterangan">Keterangan</label>
            <textarea name="keterangan" id="keterangan" rows="3" class="form-control"></textarea>
        </div>
    </x-modal-create>

    <div class="modal fade" id="alokasiDetailModal" tabindex="-1" aria-labelledby="alokasiDetailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="alokasiDetailModalLabel">Memuat Data...</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="alokasi-data-container">
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
        $(document).ready(function() {
            // Inisialisasi Tooltip dari Bootstrap
            $('[data-bs-toggle="tooltip"]').tooltip();

            $('#alokasi-dana-table').DataTable({
                responsive: true,
                scrollX: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json'
                }
            });
            $('.record-btn').click(function(e) {
                e.preventDefault()

                const formId = $(this).data('form-id');
                const form = $('#' + formId);

                Swal.fire({
                    title: 'Anda Yakin?',
                    text: "Data ini akan dicatat secara permanen di blockchain dan tidak dapat dibatalkan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Catat ke Blockchain!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                })
            });

            // Tambah Alokasi
            $('#modalAlokasiDana').on('show.bs.modal', function() {
                $('#formAlokasi').trigger('reset');
                $('#formAlokasi').attr('action', "{{ route('alokasi_dana.store') }}");
                $('#formAlokasi').find('input[name="_method"]').remove();
            });

            // Edit Alokasi
            $('.edit-alokasi-btn').click(function() {
                const data = $(this).data();
                $('#modalAlokasiDana').modal('show');
                $('#alokasi-id').val(data.id);
                $('#nama_program').val(data.nama_program);
                $('#jumlah').val(data.jumlah);
                $('#tanggal').val(data.tanggal);
                $('#keterangan').val(data.keterangan);

                $('#formAlokasi').attr('action', `/alokasi_dana/${data.id}`);
                if (!$('#formAlokasi input[name="_method"]').length) {
                    $('#formAlokasi').prepend('<input type="hidden" name="_method" value="PUT">');
                }
            });

            // Delete Alokasi
            $('.delete-alokasi-btn').click(function() {
                const url = $(this).data('url');
                confirmDeleteAjax(url);
            });

            handleAjaxFormSubmit('formAlokasi');

            $('.view-dana-detail-btn').on('click', function() {
                const alokasiId = $(this).data('alokasi-id');
                const namaProgram = $(this).data('nama-program');
                const modalContainer = $('#alokasi-data-container');
                const modalTitle = $('#alokasiDetailModalLabel');

                modalTitle.text('Detail Blockchain: ' + namaProgram);
                modalContainer.html(
                    '<div class="text-center my-5"><div class="spinner-border"></div><p class="mt-2">Memuat...</p></div>'
                );

                $.ajax({
                    url: `/audit/alokasi-dana/${alokasiId}`,
                    type: 'GET',
                    success: function(data) {
                        let contentHtml = `
                            <p class="text-muted small">Data berikut diambil langsung dari ledger blockchain.</p>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between"><strong>ID Transaksi:</strong> <code class="text-monospace small">${data.ID}</code></li>
                                <li class="list-group-item d-flex justify-content-between"><strong>Nama Program:</strong> ${data.NamaProgram}</li>
                                <li class="list-group-item d-flex justify-content-between"><strong>Jumlah:</strong> Rp ${Number(data.Jumlah).toLocaleString('id-ID')}</li>
                                <li class="list-group-item d-flex justify-content-between"><strong>Tanggal Alokasi:</strong> ${new Date(data.Tanggal).toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' })}</li>
                                <li class="list-group-item d-flex justify-content-between"><strong>Dicatat di Blockchain:</strong> ${new Date(data.TimestampPencatatan).toLocaleString('id-ID')}</li>
                            </ul>
                            <div class="mt-3">
                                <strong>Keterangan:</strong>
                                <p class="mt-1 p-3 bg-light rounded">${data.Keterangan}</p>
                            </div>
                        `;
                        modalContainer.html(contentHtml);
                    },
                    error: function(jqXHR) {
                        const errorMsg = jqXHR.responseJSON?.message || 'Gagal memuat data.';
                        modalContainer.html('<div class="alert alert-danger text-center">' +
                            errorMsg +
                            '</div>');
                    }
                });
            });

        });
    </script>
@endpush
