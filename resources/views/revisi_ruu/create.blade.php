@extends('layouts.app')

@section('content')
<div class="page-inner">
    <div class="page-header flex-column flex-md-row d-flex justify-content-between align-items-start align-items-md-center gap-2">
        <div>
            <h4 class="page-title">Ajukan Revisi RUU</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 m-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard.anggota') }}">
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('revisi_ruu.index') }}">Revisi RUU</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Ajukan</li>
                </ol>
            </nav>
        </div>
    </div>

    <x-flash-message />

    <div class="card">
        <div class="card-body">
            <form action="{{ route('revisi_ruu.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="ruu_id" class="form-label">Pilih RUU</label>
                    <select name="ruu_id" id="ruu_id"
                        class="form-control @error('ruu_id') is-invalid @enderror" required>
                        <option value="">-- Pilih RUU --</option>
                        @foreach($ruus as $ruu)
                            <option value="{{ $ruu->id }}">{{ $ruu->judul }}</option>
                        @endforeach
                    </select>
                    @error('ruu_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="alasan" class="form-label">Alasan Revisi</label>
                    <textarea name="alasan" id="alasan" rows="4"
                        class="form-control @error('alasan') is-invalid @enderror" required>{{ old('alasan') }}</textarea>
                    @error('alasan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i> Ajukan Revisi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
