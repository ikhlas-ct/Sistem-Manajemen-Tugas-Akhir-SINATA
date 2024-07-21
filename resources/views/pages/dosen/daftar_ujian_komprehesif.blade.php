@extends('layout.master')

@section('title', 'Daftar Ujian Komprehensif')

@section('content')
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white text-center">
            <h2>Daftar Ujian Komprehensif</h2>
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
                            <th>Tanggal Ujian</th>
                            <th>Nilai</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($seminarKomprehensif as $index => $seminar)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $seminar->mahasiswaBimbingan->mahasiswa->nama }}</td>
                                <td>{{ $seminar->mahasiswaBimbingan->mahasiswa->nim }}</td>
                                <td>{{ $seminar->mahasiswaBimbingan->acceptedJudulTugasAkhirs->judul }}</td>
                                <td>{{ $seminar->dosenPenguji1->nama ?? '-' }}</td>
                                <td>{{ $seminar->dosenPenguji2->nama ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($seminar->tanggal_waktu)->format('d M Y H:i') }}</td>
                                <td>{{ number_format($seminar->nilaiAkhir, 2) }}</td>
                                <td>
                                    @php
                                        $seminarDate = \Carbon\Carbon::parse($seminar->tanggal_waktu);
                                        $now = \Carbon\Carbon::now();
                                        $oneDayAfter = $seminarDate->copy()->addDays(1);
                                    @endphp
                                    @if ($now->between($seminarDate, $oneDayAfter))
                                    <a href="{{ route('dosen_komprehensif.penilaian.create', $seminar->id) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit"></i> Beri Penilaian Komprehensif
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
