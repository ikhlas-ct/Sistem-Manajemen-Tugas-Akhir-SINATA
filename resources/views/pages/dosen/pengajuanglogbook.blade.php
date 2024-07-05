@extends('layout.master')

@section('title', 'Persetujuan Logbook Mahasiswa')

@section('content')
<div class="container">
    <h1>Persetujuan Logbook Mahasiswa</h1>
    <hr>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table" id="logbookTable">
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">Nama Mahasiswa</th>
                <th class="text-center">Judul</th>
                <th class="text-center">Bab</th>
                <th class="text-center">Deskripsi</th>
                <th class="text-center">File</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logbooks as $index => $logbook)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ $logbook->mahasiswaBimbingan->mahasiswa->nama }}</td>
                    <td>{{ $logbook->judul_tugas_akhir }}</td>
                    <td>{{ $logbook->bab }}</td>
                    <td>{{ $logbook->deskripsi }}</td>
                    <td class="text-center">
                        <a href="{{ asset('uploads/logbook/' . $logbook->file_path) }}" target="_blank">
                            <i class="fas fa-file fa-2x text-success"></i>
                        </a>
                    </td>
                    <td class="text-center">
                        <form action="{{ route('dosen.logbook.approve', $logbook->id) }}" method="POST" class="approval-form" style="display:inline;">
                            @csrf
                            <button type="button" class="btn btn-success approval-button">
                                <i class="fas fa-check"></i> Terima
                            </button>
                        </form>
                        <form action="{{ route('dosen.logbook.reject', $logbook->id) }}" method="POST" class="approval-form" style="display:inline;">
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
        $('#logbookTable').DataTable({
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
            var respon = prompt("Apakah Anda yakin ingin " + action.toLowerCase() + " logbook ini? Berikan saran atau nasehat:");

            if (respon !== null) {
                $('<input>').attr({
                    type: 'hidden',
                    name: 'respon',
                    value: respon
                }).appendTo(form);

                form.submit();
            }
        });
    });
</script>
@endsection

@section('styles')
<style>
    .text-center th {
        text-align: center;
    }
</style>
@endsection
