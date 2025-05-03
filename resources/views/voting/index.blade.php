@extends('layouts.app')

@section('content')
<div class="page-inner">
    <div class="page-header flex-column flex-md-row d-flex justify-content-between align-items-start align-items-md-center gap-2">
        <div>
            <h4 class="page-title">Voting Logs</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 m-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard.admin') }}">
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Voting</li>
                </ol>
            </nav>
        </div>
    </div>

    <x-flash-message />

    <div class="card">
        <div class="card-body">
            <table id="voting-table" class="table table-striped table-hover nowrap" style="width:100%">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nama RUU</th>
                        <th>Nama Pemilih</th>
                        <th>Hasil</th>
                        <th>Waktu</th>
                        <th width="80">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($votings as $vote)
                        <tr id="vote-row-{{ $vote->id }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $vote->ruu->judul ?? '-' }}</td>
                            <td>{{ $vote->user->nama ?? '-' }}</td>
                            <td>
                                <span class="badge {{ $vote->hasil === 'SETUJU' ? 'bg-success' : 'bg-danger' }}">
                                    {{ $vote->hasil }}
                                </span>
                            </td>
                            <td>{{ $vote->created_at->translatedFormat('d M Y H:i') }}</td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm delete-vote-btn"
                                    data-url="{{ route('voting.destroy', $vote->id) }}">
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
        $('.delete-vote-btn').click(function () {
            confirmDeleteAjax($(this).data('url'));
        });

        $('#voting-table').DataTable({
            responsive: true,
            scrollX: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json'
            }
        });
    });
</script>
@endpush
