@extends('layout.master')

@section('title', 'Daftar Konsultasi')

@section('content')

<div class="container">
    <h1>Daftar Pengajuan Konsultasi</h1>
    <hr>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table" id="konsultasiTable">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Mahasiswa</th>
                <th>Topik</th>
                <th>Pembahasan</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($konsultasis as $index => $konsultasi)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $konsultasi->mahasiswaBimbingan->mahasiswa->nama }}</td>
                    <td>{{ $konsultasi->topik }}</td>
                    <td>
                        <span class="short-text" title="{{ $konsultasi->Pembahasan }}">
                            {{ Str::limit($konsultasi->Pembahasan, 50) }}
                        </span>
                    </td>
                    <td>{{ $konsultasi->tanggal }}</td>
                    <td>
                        @if($konsultasi->status == 'Ditolak')
                            <span class="badge bg-danger">Ditolak</span>
                        @elseif($konsultasi->status == 'Diterima')
                            <span class="badge bg-success">Diterima</span>
                        @else
                            <span class="badge bg-secondary">Diproses</span>
                        @endif
                    </td>
                    <td>
                        <button type="button" class="btn btn-primary respond-button" data-id="{{ $konsultasi->id }}">Respon</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal -->
    <div class="modal fade" id="respondModal" tabindex="-1" aria-labelledby="respondModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="respondModalLabel">Respon Konsultasi</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="respondForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="Diterima">Diterima</option>
                                <option value="Ditolak">Ditolak</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="Pembahasan">Pembahasan</label>
                            <textarea name="Pembahasan" id="Pembahasan" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#konsultasiTable').DataTable({
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

        $('.respond-button').on('click', function() {
            var konsultasiId = $(this).data('id');
            $('#respondForm').attr('action', '/dosen/konsultasi/respond/' + konsultasiId);
            $('#respondModal').modal('show');
        });
    });
</script>
@endsection

@section('styles')
<style>
    .short-text {
        display: inline-block;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 150px;
    }
    .short-text:hover {
        cursor: pointer;
    }
</style>

@endsection
