@extends('layouts.app')

@section('content')
<div class="page-inner">
    <div class="page-header flex-column flex-md-row d-flex justify-content-between align-items-start align-items-md-center gap-2">
        <div>
            <h4 class="page-title">Daftar Revisi RUU</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 m-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard.admin') }}">
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Revisi RUU</li>
                </ol>
            </nav>
        </div>
    </div>

    <x-flash-message />

    <div class="card">
        <div class="card-body">
            <table id="revisi-ruu-table" class="table table-striped table-hover nowrap" style="width:100%">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nama Pengusul</th>
                        <th>Judul RUU</th>
                        <th>Alasan Revisi</th>
                        <th>Tanggal Diajukan</th>
                        @if(Auth::user()->jabatan_id == 1)
                            <th width="80">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($revisi as $item)
                        <tr id="revisi-row-{{ $item->id }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->user->nama ?? '-' }}</td>
                            <td>{{ $item->ruu->judul ?? '-' }}</td>
                            <td>{{ $item->alasan }}</td>
                            <td>{{ $item->created_at->translatedFormat('d M Y H:i') }}</td>
                            @if(Auth::user()->jabatan_id == 1)
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm delete-revisi-btn"
                                        data-url="{{ route('revisi_ruu.destroy', $item->id) }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
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
    $(document).ready(function () {
        $('.delete-revisi-btn').click(function () {
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
