@extends('layouts.app')

@section('content')
    <div class="page-inner">
        <div
            class="page-header flex-column flex-md-row d-flex justify-content-between align-items-start align-items-md-center gap-2">
            <div>
                <h4 class="page-title">Daftar Revisi RUU</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent p-0 m-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard.anggota') }}">
                                <i class="fas fa-home"></i> Dashboard
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Revisi RUU</li>
                    </ol>
                </nav>
            </div>
            @if (in_array(Auth::user()->jabatan_id, [2, 4, 5]))
                {{-- 2=Anggota, 4=Pimpinan, 5=Bendahara --}}
                <a href="{{ route('revisi_ruu.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Ajukan Revisi Baru
                </a>
            @endif
        </div>

        <x-flash-message />

        <div class="card">
            <div class="card-body">
                {{-- 1. HAPUS CLASS 'nowrap' DARI TABEL INI --}}
                <table id="revisi-ruu-table" class="table table-striped table-hover" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nama Pengusul</th>
                            <th>Judul RUU</th>
                            <th>Alasan Revisi</th>
                            <th>Tanggal Diajukan</th>
                            <th>Status</th>
                            @if (in_array(Auth::user()->jabatan_id, [1, 4]))
                                <th width="150">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($revisi as $item)
                            <tr id="revisi-row-{{ $item->id }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->user->nama ?? '-' }}</td>

                                {{-- 2. TAMBAHKAN STYLE PADA KOLOM PANJANG --}}
                                <td style="white-space: normal; word-wrap: break-word; max-width: 250px;">
                                    {{ $item->ruu->judul ?? '-' }}
                                </td>
                                <td style="white-space: normal; word-wrap: break-word; max-width: 300px;">
                                    {{ $item->alasan }}
                                </td>

                                <td>{{ $item->created_at->translatedFormat('d M Y H:i') }}</td>

                                <td>
                                    @if ($item->status == 'Diterapkan')
                                        <span class="badge bg-success">{{ $item->status }}</span>
                                    @elseif($item->status == 'Ditolak')
                                        <span class="badge bg-danger">{{ $item->status }}</span>
                                    @else
                                        <span class="badge bg-primary">{{ $item->status }}</span>
                                    @endif
                                </td>

                                @if (in_array(Auth::user()->jabatan_id, [1, 4]))
                                    <td>
                                        {{-- Tombol Aksi untuk Pimpinan (4) --}}
                                        @if (Auth::user()->jabatan_id == 4 && $item->status == 'Diajukan' && $item->ruu?->status == 'DRAFT')
                                            <div class="d-flex gap-1">
                                                {{-- Tombol Terapkan --}}
                                                <form action="{{ route('revisi_ruu.apply', $item->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm"
                                                        title="Terapkan Revisi">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                                {{-- Tombol Tolak --}}
                                                <form action="{{ route('revisi_ruu.reject', $item->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-warning btn-sm"
                                                        title="Tolak Revisi">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        @endif

                                        {{-- Tombol Aksi untuk Admin (1) --}}
                                        @if (Auth::user()->jabatan_id == 1)
                                            <button type="button" class="btn btn-danger btn-sm delete-revisi-btn"
                                                data-url="{{ route('revisi_ruu.destroy', $item->id) }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.delete-revisi-btn').click(function() {
                confirmDeleteAjax($(this).data('url'));
            });

            $('#revisi-ruu-table').DataTable({
                responsive: true,
                scrollX: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json'
                }
            });
        });
    </script>
@endpush
