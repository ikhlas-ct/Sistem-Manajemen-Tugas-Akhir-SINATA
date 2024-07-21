@extends('layout.master')

@section('title', 'Daftar Seminar Proposal')

@section('content')
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white text-center">
            <h2>Daftar Seminar Proposal</h2>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Mahasiswa</th>
                            <th>NIM</th>
                            <th>Judul Proposal</th>
                            <th>Dosen Penguji 1</th>
                            <th>Dosen Penguji 2</th>
                            <th>Tanggal Seminar</th>
                            <th>Nilai</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($seminarProposals as $index => $seminarProposal)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $seminarProposal->mahasiswaBimbingan->mahasiswa->nama }}</td>
                                <td>{{ $seminarProposal->mahasiswaBimbingan->mahasiswa->nim }}</td>
                                <td>{{ $seminarProposal->mahasiswaBimbingan->acceptedJudulTugasAkhirs->judul }}</td>
                                <td>{{ $seminarProposal->dosenPenguji1->nama ?? '-' }}</td>
                                <td>{{ $seminarProposal->dosenPenguji2->nama ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($seminarProposal->tanggal_waktu)->format('d M Y H:i') }}</td>
                                <td>{{ number_format($seminarProposal->nilaiAkhir, 2) }}</td>
                                <td>
                                    @php
                                        $seminarDate = \Carbon\Carbon::parse($seminarProposal->tanggal_waktu);
                                        $now = \Carbon\Carbon::now();
                                        $fourDaysAfter = $seminarDate->copy()->addDays(7);
                                    @endphp
                                    @if ($now->isBetween($seminarDate, $fourDaysAfter))
                                        <a href="{{ route('dosen_seminar.penilaian.create', $seminarProposal->id) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-edit"></i> Beri Penilaian
                                        </a>
                                    @else
                                        <button class="btn btn-secondary btn-sm" disabled>
                                            <i class="fas fa-edit"></i> Tidak Aktif
                                        </button>
                                    @endif
                                </td>
                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .card {
        border-radius: 0.5rem;
    }
    .card-header {
        border-top-left-radius: 0.5rem;
        border-top-right-radius: 0.5rem;
    }
    table {
        margin-bottom: 0;
    }
    thead {
        background-color: #343a40;
        color: white;
    }
    thead th {
        text-align: center;
    }
    .table-responsive {
        margin-top: 20px;
    }
</style>
@endsection
