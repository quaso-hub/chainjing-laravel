@extends('layouts.app')

@section('content')
    <div class="page-inner">
        <div class="page-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
            <div>
                <h4 class="page-title">Manajemen RUU</h4>
                <nav aria-label="breadcrumb" class="d-inline-block ms-2">
                    <ol class="breadcrumb bg-transparent p-0 m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.admin') }}"><i class="fas fa-home"></i>
                                Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">RUU</li>
                    </ol>
                </nav>
            </div>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createRUUModal">
                <i class="fas fa-plus"></i> Tambah RUU
            </button>
        </div>

        <x-modal-create id="createRUUModal" labelledby="createRUUModalLabel" title="Tambah RUU" formId="formCreateRUU"
            action="{{ route('ruu.store') }}" submitText="Simpan">
            <div class="mb-3">
                <label for="judul" class="form-label">Judul</label>
                <input id="judul" type="text" name="judul" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select id="status" name="status" class="form-control" required>
                    <option value="DRAFT">DRAFT</option>
                    <option value="VOTING">VOTING</option>
                </select>
            </div>
        </x-modal-create>

        <x-modal-edit id="editRUUModal" labelledby="editRUUModalLabel" title="Edit RUU" formId="editRUUForm" action=""
            submitText="Simpan">
            <input type="hidden" id="edit-id">
            <div class="mb-3">
                <label for="edit-judul">Judul</label>
                <input type="text" id="edit-judul" name="judul" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="edit-deskripsi">Deskripsi</label>
                <textarea id="edit-deskripsi" name="deskripsi" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
                <label for="edit-status">Status</label>
                <select id="edit-status" name="status" class="form-control">
                    <option value="DRAFT">DRAFT</option>
                    <option value="VOTING">VOTING</option>
                </select>
            </div>
        </x-modal-edit>

        <x-flash-message />

        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <x-search-bar id="search" placeholder="Cari RUU..." />
                    </div>
                    <div class="col-md-6">
                        <x-status-filter :options="['DRAFT' => 'DRAFT', 'VOTING' => 'VOTING']" />
                    </div>
                </div>

                <div class="table-responsive">
                    <div id="ruu-table-container">
                        <table id="ruu-table" class="table table-striped table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Judul</th>
                                    <th>Deskripsi</th>
                                    <th>Status</th>
                                    <th width="150">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ruus as $ruu)
                                    <tr id="ruu-row-{{ $ruu->id }}">
                                        <td>{{ $ruu->id }}</td>
                                        <td>{{ $ruu->judul }}</td>
                                        <td>{{ Str::limit($ruu->deskripsi, 80) }}</td>
                                        <td>
                                            <span
                                                class="badge {{ $ruu->status === 'VOTING' ? 'bg-success' : 'bg-primary' }} text-white">
                                                {{ $ruu->status }}
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-warning btn-sm edit-ruu-btn"
                                                data-id="{{ $ruu->id }}" data-judul="{{ $ruu->judul }}"
                                                data-deskripsi="{{ $ruu->deskripsi }}" data-status="{{ $ruu->status }}"
                                                data-bs-toggle="modal" data-bs-target="#editRUUModal">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            <button type="button" class="btn btn-danger btn-sm delete-ruu-btn"
                                                data-url="{{ route('ruu.destroy', $ruu->id) }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Belum ada RUU.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center mt-3" id="pagination">
                            {{ $ruus->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            handleAjaxFormSubmit('formCreateRUU');
            handleAjaxFormSubmit('editRUUForm');

            window.bindDynamicEvents = function() {
                $('.delete-ruu-btn').click(function() {
                    const url = $(this).data('url');
                    confirmDeleteAjax(url);
                });

                $('.edit-ruu-btn').click(function() {
                    $('#edit-id').val($(this).data('id'));
                    $('#edit-judul').val($(this).data('judul'));
                    $('#edit-deskripsi').val($(this).data('deskripsi'));
                    $('#edit-status').val($(this).data('status'));
                    $('#editRUUForm').attr('action', `/ruu/${$(this).data('id')}`);
                });
            };

            bindDynamicEvents();

            enableAjaxPagination('#ruu-table-container', '#pagination');

            setupAjaxFilter({
                searchSelector: '#search',
                filterSelector: '#statusFilter',
                tableContainer: '#ruu-table-container',
                fetchUrl: "{{ route('ruu.index') }}"
            });
        });
    </script>
@endpush
