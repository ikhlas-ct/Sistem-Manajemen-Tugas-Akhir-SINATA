@extends('layout.master')
@section('title', 'Daftar Logbook')

@section('content')
<div class="container">
    <h2>Daftar Logbook</h2>
    <hr>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif


    <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#createLogbookModal">
        <i class="fas fa-plus"></i> Tambah Logbook
    </button>
      


    <table id="logbookTable" class="table table-bordered">
        <thead>
            <tr>
                <th class="text-center">NO</th>
                <th class="text-center">Mahasiswa Bimbingan</th>
                <th class="text-center">Bab</th>
                <th class="text-center">Judul</th>
                <th class="text-center">Deskripsi</th>
                <th class="text-center">File</th>
                <th class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($logbooks as $logbook)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $logbook->mahasiswaBimbingan->mahasiswa->nama }}</td>
                    <td>{{ $logbook->bab }}</td>
                    <td>{{ $logbook->judul_tugas_akhir }}</td>
                    <td>{{ $logbook->deskripsi }}</td>

                    <td>
                        <a href="{{ asset('uploads/logbook/' .$logbook->file_path) }}" target="_blank">Lihat File</a>                    
                    </td>


                    <td>
                        @if ($logbook->status == 'Direvisi')
                            <span class="badge bg-danger badge-pill">{{ ucfirst($logbook->status) }}</span>
                        @elseif ($logbook->status == 'Diproses')
                            <span class="badge bg-secondary badge-pill">{{ ucfirst($logbook->status) }}</span>
                        @elseif ($logbook->status == 'Diterima')
                            <span class="badge bg-success badge-pill">{{ ucfirst($logbook->status) }}</span>
                        @endif
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal Create Logbook -->
<div class="modal fade" id="createLogbookModal" tabindex="-1" aria-labelledby="createLogbookModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createLogbookModalLabel">Tambah Logbook</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('logbook.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="mahasiswa_bimbingan_id" class="form-label">Mahasiswa Bimbingan</label>
                        <select class="form-select" id="mahasiswa_bimbingan_id" name="mahasiswa_bimbingan_id" required>
                            @foreach ($mahasiswaBimbingans as $bimbingan)
                                <option value="{{ $bimbingan->id }}">{{ $bimbingan->mahasiswa->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="judul_tugas_akhir" class="form-label">Judul Tugas Akhir</label>
                        <input type="text" class="form-control" id="judul_tugas_akhir" name="judul_tugas_akhir" value="{{ $judulTugasAkhir ? $judulTugasAkhir->judul : '' }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="file" class="form-label">File</label>
                        <input type="file" class="form-control" id="file" name="file" required>
                        <small class="fs-3">Pastikan Data yang akan kamu inputkan benar dan jelas</small>

                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
                </div>
        </div>
    </div>
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
                }
            },
            "dom": '<"top"lf>rt<"bottom"ip><"clear">'
        });
    });
</script>
@endsection
