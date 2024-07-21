@extends('layout.master')

@section('title', 'Validasi Seminar Komprehensif')

@section('content')
<div class="container">
    <h2>Validasi Seminar Komprehensif</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="datatable-container mb-3">
        <table id="SeminarKomprehensifTable" class="table table-bordered mt-3">
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
                @foreach ($SeminarKomprehensifs as $SeminarKomprehensif)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $SeminarKomprehensif->mahasiswaBimbingan->mahasiswa->nama }}</td>
                        <td>{{ $SeminarKomprehensif->mahasiswaBimbingan->dosenpembimbing->dosen->nama }}</td>
                        <td>{{ $SeminarKomprehensif->mahasiswaBimbingan->acceptedJudulTugasAkhirs->judul }}</td>
                       
                        <td>
                            <a href="{{ route('prodi.kompre.atur', ['id' => $SeminarKomprehensif->id]) }}" class="btn btn-success btn-sm">
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
        $('#SeminarKomprehensifTable').DataTable({
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
