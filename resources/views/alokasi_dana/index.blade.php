@extends('layouts.app')

@section('content')
    <div class="page-inner">
        <div
            class="page-header flex-column flex-md-row d-flex justify-content-between align-items-start align-items-md-center gap-2">
            <div class="mb-2">
                <h4 class="page-title">Manajemen Alokasi Dana</h4>
                <nav aria-label="breadcrumb" class="d-inline-block ms-2">
                    <ol class="breadcrumb bg-transparent p-0 m-0">
                        {{-- Sesuaikan dengan dashboard Bendahara --}}
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
                            <th>Status Blockchain</th> {{-- KOLOM BARU --}}
                            <th width="200">Aksi</th> {{-- Lebarkan kolom aksi --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($alokasi as $item)
                            <tr id="alokasi-row-{{ $item->id }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama_program }}</td>
                                <td>Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}</td>

                                {{-- TAMPILKAN STATUS BLOCKCHAIN --}}
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

                                {{-- TAMPILKAN AKSI DINAMIS --}}
                                <td>
                                    @if ($item->status_blockchain == 'pending')
                                        {{-- Tombol untuk mencatat ke blockchain --}}
                                        <form action="{{ route('alokasi_dana.record', $item->id) }}" method="POST"
                                            class="d-inline-block"
                                            onsubmit="return confirm('Anda yakin ingin mencatat data ini ke blockchain? Aksi ini tidak dapat dibatalkan.');">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm" data-bs-toggle="tooltip"
                                                title="Catat ke Blockchain">
                                                <i class="fas fa-shield-alt"></i> Catat
                                            </button>
                                        </form>

                                        {{-- Tombol Edit & Delete hanya untuk data pending --}}
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
                                        {{-- Jika sudah tercatat, tampilkan ID Transaksi --}}
                                        <button class="btn btn-info btn-sm" data-bs-toggle="tooltip"
                                            title="ID Transaksi di Blockchain: {{ $item->tx_id }}">
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

    {{-- Modal Create/Edit tidak perlu diubah, sudah bagus --}}
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

            // ... (sisa script untuk modal tambah, edit, delete tidak perlu diubah) ...
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
        });
    </script>
@endpush
