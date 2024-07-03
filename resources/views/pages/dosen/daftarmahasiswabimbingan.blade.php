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
                <th>No</th>
                <th>NIM</th>
                <th>Nama Mahasiswa</th>
                <th>Program Studi</th>
                <th>No HP/WA</th>
                <th>Judul Tugas Akhir</th>
                <th>BAB</th>
                
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
