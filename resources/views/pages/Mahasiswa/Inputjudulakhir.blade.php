@extends('layout.master')
@section('title', 'Daftar Judul Tugas Akhir')

@section('content')
<div class="container">
    <h2>Daftar Judul Tugas Akhir</h2>
    <hr>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->has('status'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ $errors->first('status') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

  <!-- Peringatan Status -->
  @foreach($judulTugasAkhirs as $judul)
  @if($judul->status == 'diproses')
      <div class="alert alert-info mt-5 border-3 border-primary" role="alert">
          <i class="fas fa-exclamation-circle" style="font-size: 1.5rem;"></i> 
          <span style="font-size: 1.5rem;" class="fw-bold">Informasi</span> <br>
          🔄 <span style="color: red">Judul tugas akhir anda sedang diproses hanya saat diproses anda bisa menghapus atau merubah judul tugas akhir anda</span>. Hubungi dosen pembimbing Anda untuk memintak validasi.
      </div>
  @elseif($judul->status == 'diterima')
      <div class="alert alert-success mt-5 border-4 border-success" role="alert">
          <i class="fas fa-exclamation-circle" style="font-size: 1.5rem;"></i> 
          <span style="font-size: 1.5rem;" class="fw-bold">Informasi</span> <br>
          ✅ Judul Tugas Akhir Anda sudah diterima. Untuk merubah atau menghapus, hubungi dosen pembimbing Anda.
      </div>
  @endif
@endforeach


    <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#createJudulModal">
        <i class="fas fa-plus"></i> Tambah Judul Tugas Akhir
    </button>
    
    <table id="judulTugasAkhirTable" class="table table-bordered">
        <thead>
            <tr>
                <th class="text-center" >NO</th>
                <th class="text-center">Mahasiswa Bimbingan</th>
                <th class="text-center">Judul</th>
                <th class="text-center">Deskripsi</th>
                <th class="text-center">File</th>
                <th class="text-center">Status</th>
                <th class="text-center">Aksi</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($judulTugasAkhirs as $judul)
                <tr class="">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $judul->mahasiswaBimbingan->mahasiswa->nama }}</td>
                    <td>{{ $judul->judul }}</td>
                    <td>{{ $judul->deskripsi }}</td>
                    <td><a href="{{ asset('uploads/tugas-akhir/' . $judul->file_judul) }}" target="_blank">Lihat File</a></td>
            
                    <td>
                        @if($judul->status == 'ditolak')
                            <span class="badge bg-danger badge-pill">{{ ucfirst($judul->status) }}</span>
                        @elseif($judul->status == 'diproses')
                            <span class="badge bg-secondary badge-pill">{{ ucfirst($judul->status) }}</span>
                        @elseif($judul->status == 'diterima')
                            <span class="badge bg-success badge-pill">{{ ucfirst($judul->status) }}</span>
                        @endif
                    </td>
                    <td>
                        @if($judul->status == 'diproses')
                            <form action="{{ route('judul_tugas_akhir_destroy', $judul->id) }}" method="POST">
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

<!-- Modal Create Judul -->
<div class="modal fade" id="createJudulModal" tabindex="-1" aria-labelledby="createJudulModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createJudulModalLabel">Tambah Judul Tugas Akhir</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('judul_tugas_akhir.store') }}" method="POST" enctype="multipart/form-data">
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
                        <label for="judul" class="form-label">Judul</label>
                        <input type="text" class="form-control" id="judul" name="judul" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="file_judul" class="form-label">File Judul</label>
                        <input type="file" class="form-control" id="file_judul" name="file_judul" required>
                        <small>Pastikan judul dan data yang akan diinputkan sesuai </small>
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
        $('#judulTugasAkhirTable').DataTable({
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
