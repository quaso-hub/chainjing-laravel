@extends('layouts.app')

@section('content')
    <div class="page-inner">
        <div
            class="page-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
            <div>
                <h4 class="page-title">Manajemen Pengguna</h4>
                <nav aria-label="breadcrumb" class="d-inline-block ms-2">
                    <ol class="breadcrumb bg-transparent p-0 m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.admin') }}"><i class="fas fa-home"></i>
                                Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Pengguna</li>
                    </ol>
                </nav>
            </div>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUserModal">
                <i class="fas fa-plus"></i> Tambah Pengguna
            </button>
        </div>

        {{-- Flash Message --}}
        <x-flash-message />

        {{-- Table --}}
        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr id="user-row-{{ $user->id }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->nama }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->jabatan->nama ?? '-' }}</td>
                                <td>
                                    <button class="btn btn-warning btn-sm edit-user-btn" data-id="{{ $user->id }}"
                                        data-name="{{ $user->nama }}" data-email="{{ $user->email }}"
                                        data-role="{{ $user->jabatan_id }}" data-bs-toggle="modal"
                                        data-bs-target="#editUserModal">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm delete-user-btn"
                                        data-url="{{ route('users.destroy', $user->id) }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Belum ada pengguna.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Create Modal --}}
    <x-modal-create id="createUserModal" labelledby="createUserModalLabel" title="Tambah Pengguna" formId="formCreateUser"
        action="{{ route('users.store') }}" submitText="Simpan">
        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text" name="nama" id="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select name="jabatan_id" id="role" class="form-control" required>
                @foreach ($jabatans as $jb)
                    <option value="{{ $jb->id }}">{{ $jb->nama }}</option>
                @endforeach
                <!-- <option value="1">Admin</option>
                <option value="2">Anggota</option>
                <option value="3">Publik</option> -->
            </select>
        </div>
    </x-modal-create>

    {{-- Edit Modal --}}
    <x-modal-edit id="editUserModal" labelledby="editUserModalLabel" title="Edit Pengguna" formId="formEditUser"
        action="" submitText="Update">
        <input type="hidden" id="edit-id">
        <div class="mb-3">
            <label for="edit-name" class="form-label">Nama</label>
            <input type="text" name="nama" id="edit-name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="edit-email" class="form-label">Email</label>
            <input type="email" name="email" id="edit-email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="edit-role" class="form-label">Role</label>
            <select name="jabatan_id" id="edit-role" class="form-control" required>
                @foreach ($jabatans as $jb)
                    <option value="{{ $jb->id }}">{{ $jb->nama }}</option>
                @endforeach
                <!-- <option value="1">Admin</option>
                <option value="2">Anggota</option>
                <option value="3">Publik</option> -->
            </select>
        </div>
    </x-modal-edit>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            handleAjaxFormSubmit('formCreateUser');
            handleAjaxFormSubmit('formEditUser');

            $('.delete-user-btn').click(function() {
                const url = $(this).data('url');
                confirmDeleteAjax(url);
            });

            $('.edit-user-btn').click(function() {
                const id = $(this).data('id');
                const name = $(this).data('name');
                const email = $(this).data('email');
                const role = $(this).data('role');

                $('#edit-id').val(id);
                $('#edit-name').val(name);
                $('#edit-email').val(email);
                $('#edit-role').val(role);

                $('#formEditUser').attr('action', `/users/${id}`);
            });
        });
    </script>
@endpush
