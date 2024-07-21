@extends('layout.master')

@section('title', 'Persetujuan Seminar Proposal Mahasiswa')

@section('content')
<div class="container">
    <h1>Persetujuan Seminar Proposal Mahasiswa</h1>
    <hr>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table" id="semproTable">
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">Nama Mahasiswa</th>
                <th class="text-center">Judul Proposal</th>
                <th class="text-center">File KHS</th>
                <th class="text-center">Kartu Bimbingan</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($seminarProposals as $index => $sempro)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ $sempro->mahasiswaBimbingan->mahasiswa->nama }}</td>
                    <td class="text-center">
                        @if($sempro->mahasiswaBimbingan->judulTugasAkhirs->isNotEmpty())
                            {{ $sempro->mahasiswaBimbingan->judulTugasAkhirs->last()->judul }}
                        @else
                            Tidak ada judul tugas akhir
                        @endif
                    </td>
                    <td class="text-center">
                        <a href="{{ asset('uploads/seminar_proposals/' . $sempro->file_KHS) }}" target="_blank">
                            <i class="fas fa-file fa-2x text-success"></i>
                        </a>
                    </td>
                    <td class="text-center">
                        <a href="{{ asset('uploads/seminar_proposals/' . $sempro->Kartu_Bimbingan) }}" target="_blank">
                            <i class="fas fa-file fa-2x text-success"></i>
                        </a>
                    </td>
                    <td class="text-center">
                        <form action="{{ route('dosen.sempro.approve', $sempro->id) }}" method="POST" class="approval-form" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-success approval-button" onclick="return confirm('Apakah Anda yakin ingin menerima proposal ini?')">
                                <i class="fas fa-check"></i> Terima
                            </button>
                        </form>
                        <form action="{{ route('dosen.sempro.reject', $sempro->id) }}" method="POST" class="approval-form" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-danger approval-button" onclick="return confirm('Apakah Anda yakin ingin menolak proposal ini?')">
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
        $('#semproTable').DataTable({
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

@section('styles')
<style>
    .text-center th {
        text-align: center;
    }
</style>
@endsection
