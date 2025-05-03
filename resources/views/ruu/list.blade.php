@extends('layouts.app')

@section('content')
<div class="page-inner">
    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <h4 class="page-title">Daftar RUU</h4>
            <nav aria-label="breadcrumb" class="d-inline-block ms-2">
                <ol class="breadcrumb bg-transparent p-0 m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.anggota') }}"><i class="fas fa-home"></i> Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Daftar RUU</li>
                </ol>
            </nav>
        </div>
    </div>

    <x-flash-message />

    <div class="card">
        <div class="card-body table-responsive">
            <form method="GET" class="row mb-3">
                <div class="col-md-4">
                    <input type="text" name="keyword" class="form-control" placeholder="Cari berdasarkan judul..." value="{{ request('keyword') }}">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-control">
                        <option value="">-- Filter Status --</option>
                        <option value="DRAFT" {{ request('status') == 'DRAFT' ? 'selected' : '' }}>DRAFT</option>
                        <option value="VOTING" {{ request('status') == 'VOTING' ? 'selected' : '' }}>VOTING</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Filter</button>
                </div>
            </form>

            <table class="table table-striped table-hover">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Judul</th>
                        <th>Deskripsi</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ruus as $ruu)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $ruu->judul }}</td>
                        <td>{{ Str::limit($ruu->deskripsi, 80) }}</td>
                        <td>
                            <span class="badge {{ $ruu->status === 'VOTING' ? 'bg-success' : 'bg-secondary' }}">
                                {{ $ruu->status }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada RUU ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-3 d-flex justify-content-center">
                {{ $ruus->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection


@push('scripts')
<script>
    $(document).ready(function () {
        setupAjaxFilter({
            searchSelector: '#search',
            filterSelector: '#statusFilter',
            tableContainer: '#ruu-list-container',
            fetchUrl: "{{ route('ruu.index') }}"
        });
    });
</script>
@endpush
