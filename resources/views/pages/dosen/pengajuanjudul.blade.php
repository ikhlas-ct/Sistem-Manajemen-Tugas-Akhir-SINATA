@extends('layout.master')

@section('title', 'Persetujuan Judul Tugas Akhir')

@section('content')
<div class="container">
    <h1>Persetujuan Judul Tugas Akhir</h1>
    <hr>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table" id="judulTugasAkhirTable">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Mahasiswa</th>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>File</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($judulTugasAkhirs as $index => $judul)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $judul->mahasiswaBimbingan->mahasiswa->nama }}</td>
                    <td>{{ $judul->judul }}</td>
                    <td>{{ $judul->deskripsi }}</td>
                    <td><a href="{{ asset('uploads/tugas-akhir/' . $judul->file_judul) }}" target="_blank">Lihat File</a></td>

                    <td>
                        <form action="{{ route('dosen.judul_tugas_akhir.approve', $judul->id) }}" method="POST" class="approval-form" style="display:inline;">
                            @csrf
                            <button type="button" class="btn btn-success approval-button">
                                <i class="fas fa-check"></i> Terima
                            </button>
                        </form>
                        <form action="{{ route('dosen.judul_tugas_akhir.reject', $judul->id) }}" method="POST" class="approval-form" style="display:inline;">
                            @csrf
                            <button type="button" class="btn btn-danger approval-button">
                                <i class="fas fa-times"></i> Tolak
                            </button>
                        </form>
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
        $('#judulTugasAkhirTable').DataTable({
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

        $('.approval-button').on('click', function() {
            var form = $(this).closest('form');
            var action = $(this).text().trim();
            var saran = prompt("Apakah Anda yakin ingin " + action.toLowerCase() + " judul ini? Berikan saran atau nasehat:");

            if (saran !== null) {
                $('<input>').attr({
                    type: 'hidden',
                    name: 'saran',
                    value: saran
                }).appendTo(form);

                form.submit();
            }
        });
    });
</script>
@endsection
