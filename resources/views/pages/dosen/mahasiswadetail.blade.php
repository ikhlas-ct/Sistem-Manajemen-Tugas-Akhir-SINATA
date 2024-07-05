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
                    <tr>
                        <th>Riwayat Konsultasi</th>
                        <td><a href="{{ route('dosenprintkonsultasi', ['mahasiswaBimbinganId' => $mahasiswaBimbingan->id]) }}" class="btn btn-primary ml-3">Print Riwayat Konsultasi</a></td>
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
            @if ($logbooks->count() > 0)
            <table class="table" id="mahasiswadetail"> 
                <thead>
                    <tr>
                        <th class="text-center">NO</th>
                        <th class="text-center">Judul</th>
                        <th class="text-center">Bab</th>
                        <th class="text-center">Deskripsi</th>
                        <th class="text-center">File</th>
                        <th class="text-center">Status</th>

                        
                    </tr>
                </thead>
                <tbody>
                    @foreach ($logbooks as $logbook)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $logbook->judul_tugas_akhir }}</td>
                        <td class="text-center">{{ $logbook->bab }}</td>
                        <td >{{ ucfirst($logbook->deskripsi) }}</td>
                        <td class="text-center">
                            <a href="{{ asset('uploads/logbook/' . $logbook->file_path) }}" target="_blank">      
                                <i class="fas fa-file fa-2x text-success"></i>
                            </a>                    
                        </td>
                        <td class="text-center align-middle">
                            <span class="badge bg-success">{{ ucfirst($logbook->status) }}</span>
                        </td>
                        
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p>Belum ada logbook yang diterima untuk mahasiswa ini.</p>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#mahasiswadetail').DataTable({
            "pagingType": "full_numbers",
            "language": {
                "search": "Cari:",
                "paginate": {
                    "first": "Awal",
                    "last": "Akhir",
                    "next": "Berikutnya",
                    "previous": "Sebelumnya"
                },
                "emptyTable": "Tidak ada data di dalam tabel",
                "zeroRecords": "Tidak ditemukan data yang sesuai"
            },
            "dom": '<"top"lf>rt<"bottom"ip><"clear">'
        });

    });
        
</script>
@endsection


