@extends('layouts.app')

@section('content')
<div class="page-inner">
    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <h4 class="page-title">Profil Pengguna</h4>
            <nav aria-label="breadcrumb" class="d-inline-block ms-2">
                <ol class="breadcrumb bg-transparent p-0 m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.admin') }}"><i class="fas fa-home"></i> Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Profil</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row justify-content-center mt-4">
        <div class="col-md-8">
            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-1"></i> {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white fw-bold">
                    <i class="fas fa-user-cog me-1"></i> Perbarui Informasi Profil
                </div>
                <div class="card-body">
                    <form id="profileForm" method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Alamat Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <div class="mb-3">
                            <label for="password" class="form-label">Kata Sandi Baru <span class="text-muted small">(Opsional)</span></label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Minimal 8 karakter">
                            @error('password')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi Baru</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $('#profileForm').on('submit', function (e) {
        e.preventDefault();
        const form = this;

        Swal.fire({
            title: 'Konfirmasi Perubahan',
            text: 'Masukkan password Anda untuk menyimpan perubahan.',
            input: 'password',
            inputPlaceholder: 'Password',
            inputAttributes: {
                autocapitalize: 'off',
                autocomplete: 'current-password'
            },
            showCancelButton: true,
            confirmButtonText: 'Konfirmasi',
            cancelButtonText: 'Batal',
            showLoaderOnConfirm: true,
            preConfirm: (password) => {
                if (!password) {
                    Swal.showValidationMessage('Password wajib diisi!');
                } else {
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'confirm_password',
                        value: password
                    }).appendTo(form);
                    form.submit();
                }
            },
            allowOutsideClick: () => !Swal.isLoading()
        });
    });
</script>
@endpush
