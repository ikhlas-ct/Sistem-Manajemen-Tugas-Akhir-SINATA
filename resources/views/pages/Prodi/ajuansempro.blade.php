@extends('layout.master')

@section('title', 'Validasi Seminar Proposal')

@section('content')
<div class="container">
    <h2>Validasi Seminar Proposal</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="datatable-container mb-3">
        <table id="seminarProposalTable" class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Nama Mahasiswa</th>
                    <th class="text-center">Dosen Pembimbing</th>
                    <th class="text-center">Judul Proposal</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($seminarProposals as $seminarProposal)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $seminarProposal->mahasiswaBimbingan->mahasiswa->nama }}</td>
                        <td>{{ $seminarProposal->mahasiswaBimbingan->dosenpembimbing->dosen->nama }}</td>
                        <td>{{ $seminarProposal->mahasiswaBimbingan->acceptedJudulTugasAkhirs->judul }}</td>
                        <td>
                            <a href="{{ route('seminar-proposal.atur', ['id' => $seminarProposal->id]) }}" class="btn btn-success btn-sm">
                                <i class="fa fa-check"></i> Atur Jadwal Seminar
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#seminarProposalTable').DataTable({
            "pagingType": "full_numbers",
            "language": {
                "search": "Cari:",
                "paginate": {
                    "first": "Awal",
                    "last": "Akhir",
                    "next": "Berikutnya",
                    "previous": "Sebelumnya"
                },
                "emptyTable": "Tidak ada pengajuan di dalam tabel",
                "zeroRecords": "Tidak ditemukan data yang sesuai"
            },
            "dom": '<"top"lf>rt<"bottom"ip><"clear">'
        });
    });
</script>
@endsection
