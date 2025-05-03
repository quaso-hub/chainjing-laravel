
@extends('layouts.app')

@section('content')
<div class="page-inner">
    <div class="page-header flex-column flex-md-row d-flex justify-content-between align-items-start align-items-md-center gap-2">
        <div>
            <h4 class="page-title">Manajemen Jabatan</h4>
            <nav aria-label="breadcrumb" class="d-inline-block ms-2">
                <ol class="breadcrumb bg-transparent p-0 m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.admin') }}"><i class="fas fa-home"></i> Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Jabatan</li>
                </ol>
            </nav>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createJabatanModal">
            <i class="fas fa-plus"></i> Tambah Jabatan
        </button>
    </div>

    <x-modal-create id="createJabatanModal" labelledby="createJabatanModalLabel" title="Tambah Jabatan" formId="formCreateJabatan"
        action="{{ route('jabatan.store') }}" submitText="Simpan">
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Jabatan</label>
            <input id="nama" type="text" name="nama" class="form-control" required>
        </div>
    </x-modal-create>

    <x-modal-edit id="editJabatanModal" labelledby="editJabatanModalLabel" title="Edit Jabatan" formId="formEditJabatan"
        action="" submitText="Simpan">
        <input type="hidden" id="edit-id">
        <div class="mb-3">
            <label for="edit-nama">Nama Jabatan</label>
            <input type="text" id="edit-nama" name="nama" class="form-control" required>
        </div>
    </x-modal-edit>

    <x-flash-message />

    <div class="card">
        <div class="card-body table-responsive">
            <table id="jabatan-table" class="table table-striped table-hover">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nama Jabatan</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jabatans as $jabatan)
                    <tr id="jabatan-row-{{ $jabatan->id }}">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $jabatan->nama }}</td>
                        <td>
                            <button class="btn btn-warning btn-sm edit-jabatan-btn" data-id="{{ $jabatan->id }}"
                                data-nama="{{ $jabatan->nama }}" data-bs-toggle="modal" data-bs-target="#editJabatanModal">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm delete-jabatan-btn"
                                data-url="{{ route('jabatan.destroy', $jabatan->id) }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
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
        handleAjaxFormSubmit('formCreateJabatan');
        handleAjaxFormSubmit('formEditJabatan');

        $('.delete-jabatan-btn').click(function () {
            confirmDeleteAjax($(this).data('url'));
        });

        $('.edit-jabatan-btn').click(function () {
            $('#edit-id').val($(this).data('id'));
            $('#edit-nama').val($(this).data('nama'));
            $('#formEditJabatan').attr('action', `/jabatan/${$(this).data('id')}`);
        });

        $('#jabatan-table').DataTable({
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json'
            }
        });
    });
</script>
@endpush
