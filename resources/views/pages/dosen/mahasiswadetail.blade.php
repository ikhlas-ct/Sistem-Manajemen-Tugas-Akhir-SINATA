@extends('layout.master')

@section('title', 'Detail Mahasiswa Bimbingan')

@section('content')
<div class="container">
    <div class="row">
        <h3>Detail Mahasiswa Bimbingan Skripsi</h3>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <h4>Informasi Mahasiswa</h4>
            <table class="table">
                <tbody>
                    <tr>
                        <th class="text-center" colspan="2">
                            @if ($mahasiswaBimbingan->mahasiswa->gambar)
                                <img src="{{ asset($mahasiswaBimbingan->mahasiswa->gambar) }}" alt="Foto Profil Mahasiswa" class="img-fluid rounded-circle" width="200" height="200">
                            @else
                                <img src="{{ asset('assets/images/profile/user-1.jpg') }}" alt="Foto Profil Mahasiswa" class="img-fluid rounded-circle" width="200" height="200">
                            @endif
                        </th>
                    </tr>
                    <tr>
                        <th>NIM</th>
                        <td>{{ $mahasiswaBimbingan->mahasiswa->nim }}</td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td>{{ $mahasiswaBimbingan->mahasiswa->nama }}</td>
                    </tr>
                    <tr>
                        <th>Program Studi</th>
                        <td>{{ $mahasiswaBimbingan->mahasiswa->fakultas }}</td>
                    </tr>
                    <tr>
                        <th>No HP/WA</th>
                        <td>{{ $mahasiswaBimbingan->mahasiswa->no_hp }}</td>
                    </tr>
                    <tr>
                        <th>Judul Tugas Akhir</th>
                        <td>{{ $judulTugasAkhir->judul ?? '-' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="col-md-6">
            <h4>Detail Tugas Akhir</h4>
            @if ($judulTugasAkhir)
            <table class="table">
                <tbody>
                    <tr>
                        <th>Judul Tugas Akhir</th>
                        <td>{{ $judulTugasAkhir->judul }}</td>
                    </tr>
                    <!-- Add more details about the thesis if needed -->
                </tbody>
            </table>
            @else
            <p>Belum ada judul tugas akhir yang diterima untuk mahasiswa ini.</p>
            @endif
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-12">
            <h4>Logbook Terbaru</h4>
            @if ($logbook)
            <table class="table">
                <tbody>
                    <tr>
                        <th>Tanggal</th>
                        <td>{{ $logbook->tanggal }}</td>
                    </tr>
                    <tr>
                        <th>Materi Bimbingan</th>
                        <td>{{ $logbook->materi_bimbingan }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>{{ ucfirst($logbook->status) }}</td>
                    </tr>
                    <!-- Add more details about the logbook if needed -->
                </tbody>
            </table>
            @else
            <p>Belum ada logbook yang tercatat untuk mahasiswa ini.</p>
            @endif
        </div>
    </div>
</div>
@endsection
