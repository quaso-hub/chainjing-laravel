@extends('layouts.app')

@section('content')
<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Riwayat Voting</h4>
    </div>

    {{-- Pencarian --}}
    <div class="row mb-3">
        <div class="col-md-6">
            <form action="{{ route('voting.index') }}" method="GET" class="form-inline">
                <input type="text" name="keyword" class="form-control mr-2" placeholder="Cari RUU..." value="{{ request('keyword') }}">
                <button type="submit" class="btn btn-primary">Cari</button>
            </form>
        </div>
    </div>

    {{-- Tabel Riwayat Voting --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Daftar Riwayat Voting</div>
                </div>
                <div class="card-body">
                    @if($votings->count())
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Judul RUU</th>
                                        <th>Pilihan</th>
                                        <th>Waktu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($votings as $index => $vote)
                                        <tr>
                                            <td>{{ $votings->firstItem() + $index }}</td>
                                            <td>{{ $vote->ruu->judul }}</td>
                                            <td>
                                                @if($vote->pilihan === 'SETUJU')
                                                    <span class="badge badge-success">Setuju</span>
                                                @elseif($vote->pilihan === 'TIDAK_SETUJU')
                                                    <span class="badge badge-danger">Tidak Setuju</span>
                                                @else
                                                    <span class="badge badge-secondary">{{ $vote->pilihan }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $vote->created_at->format('d M Y H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Paginasi --}}
                        <div class="d-flex justify-content-center">
                            {{ $votings->withQueryString()->links() }}
                        </div>
                    @else
                        <div class="alert alert-info" role="alert">
                            Belum ada riwayat voting.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
