@extends('layout.master')
@section('title', 'Daftar Konsultasi Bimbingan')

@section('content')
<div class="container">
    <h2>Daftar Konsultasi Bimbingan</h2>
    <hr>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-3 text-start">
            <!-- Tambah Konsultasi Button -->
            <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#createKonsultasiModal" style="width: 100%;">
                <i class="fas fa-plus"></i> Tambah Konsultasi
            </button>
        </div>
        <div class="col-3 text-end">
            <!-- Print Konsultasi Bimbingan Button -->
            <a href="{{ route('print-konsultasi-bimbingan') }}" target="_blank" class="btn btn-primary" style="width: 100%;">
                <i class="fas fa-print"></i> Print Konsultasi </a>
        </div>
    </div>
</div>




    <table id="konsultasiTable" class="table table-bordered">
        <thead>
            <tr>
                <th class="text-center">NO</th>
                <th class="text-center">Tanggal</th>
                <th class="text-center">Mahasiswa </th>
                <th class="text-center">Topik </th>
                <th class="text-center">Pembahasan</th>
                <th class="text-center">Status</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($konsultasis as $konsultasi)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $konsultasi->tanggal }}</td>
                    <td>{{ $konsultasi->mahasiswaBimbingan->mahasiswa->nama }}</td>
                    <td>{{ $konsultasi->topik }}</td>
                    <td>{{ $konsultasi->Pembahasan }}</td>

                    <td>
                        @if($konsultasi->status == 'Ditolak')
                            <span class="badge bg-danger badge-pill">{{ ucfirst($konsultasi->status) }}</span>
                        @elseif($konsultasi->status == 'Diproses')
                            <span class="badge bg-secondary badge-pill">{{ ucfirst($konsultasi->status) }}</span>
                        @elseif($konsultasi->status == 'Diterima')
                            <span class="badge bg-success badge-pill">{{ ucfirst($konsultasi->status) }}</span>
                        @endif
                    </td>
                    <td>
                        @if($konsultasi->status == 'Diproses')
                            <form action="{{ route('konsultasi.destroy', $konsultasi->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        @endif
                    </td>
                    
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal Create Konsultasi -->
<div class="modal fade" id="createKonsultasiModal" tabindex="-1" aria-labelledby="createKonsultasiModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createKonsultasiModalLabel">Tambah Konsultasi Bimbingan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('konsultasi.store') }}" method="POST">
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
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                    </div>
                    <div class="mb-3">
                        <label for="topik" class="form-label">Topik</label>
                        <textarea class="form-control" id="topik" name="topik" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah</button>
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
                }
            },
            "dom": '<"top"lf>rt<"bottom"ip><"clear">'
        });
    });
</script>
@endsection
