@extends('layout.master')

@section('title', 'Daftar Mahasiswa Bimbingan')

@section('content')
<div class="container">
    <div class="row">
        <h3>Daftar Mahasiswa Bimbingan Skripsi</h3>
    </div>
    <hr>
    <table class="table" id="studentsTable">
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">NIM</th>
                <th class="text-center">Nama Mahasiswa</th>
                <th class="text-center">Program Studi</th>
                <th class="text-center">No HP/WA</th>
                <th class="text-center">Judul Tugas Akhir</th>
                <th class="text-center">BAB</th>
                <th class="text-center">Detail</th> <!-- Kolom untuk aksi -->
            </tr>
        </thead>
        <tbody>
            @foreach($mahasiswaBimbingans as $index => $mahasiswaBimbingan)
                @php
                    $judulTugasAkhir = $judulTugasAkhirs->firstWhere('mahasiswa_bimbingan_id', $mahasiswaBimbingan->id);
                    $logbook = $logbooks->where('mahasiswa_bimbingan_id', $mahasiswaBimbingan->id)->last();
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $mahasiswaBimbingan->mahasiswa->nim }}</td>
                    <td>{{ $mahasiswaBimbingan->mahasiswa->nama }}</td>
                    <td>{{ $mahasiswaBimbingan->mahasiswa->fakultas }}</td>
                    <td>{{ $mahasiswaBimbingan->mahasiswa->no_hp }}</td>
                    <td>{{ $judulTugasAkhir->judul ?? 'Belum Ada Judul Yang Diterima' }}</td>
                    <td>{{ $logbook->bab ?? 'Belum Ada' }}</td>
                    <td class="text-center">
                        <a href="{{ route('mahasiswa.detail', $mahasiswaBimbingan->id) }}" class="btn btn-primary">
                            <i class="fas fa-eye"></i> 
                        </a>
                    </td>
                    
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#studentsTable').DataTable({
            "pagingType": "full_numbers",
            "language": {
                "search": "Cari:",
                "paginate": {
                    "first": "Awal",
                    "last": "Akhir",
                    "next": "Berikutnya",
                    "previous": "Sebelumnya"
                }
            },
            "dom": '<"top"lf>rt<"bottom"ip><"clear">'
        });
    });
</script>
@endsection
