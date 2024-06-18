@extends('layout.master')
@section('title', 'Daftar Judul Tugas Akhir')

@section('content')
<div class="container"> 
    <style>
    
      

    </style>
    <h2>Daftar Judul Tugas Akhir</h2>
    <hr>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link {{ request()->is('judul-tugas-akhir/diterima') ? 'active' : '' }}" href="{{ route('judul.filter', 'diterima') }}">Diterima</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('judul-tugas-akhir/diproses') ? 'active' : '' }}" href="{{ route('judul.filter', 'diproses') }}">Diproses</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('judul-tugas-akhir/ditolak') ? 'active' : '' }}" href="{{ route('judul.filter', 'ditolak') }}">Ditolak</a>
        </li>
    </ul>

    <table id="judulTugasAkhirTable" class="table table-bordered">
        <thead>
            <tr>
                <th class="text-center">NO</th>
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
                <tr >
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $judul->mahasiswaBimbingan->mahasiswa->nama }}</td>
                    <td class="pemotongan">{{ $judul->judul }}</td>
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
                            <form action="{{ route('judul.update_status', $judul->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="diterima">
                                <button type="submit" class="btn btn-success btn-sm" title="Diterima">✔️</button>
                            </form>
                    
                            <form action="{{ route('judul.update_status', $judul->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="ditolak">
                                <button type="submit" class="btn btn-danger btn-sm" title="Ditolak">❌</button>
                            </form>
                        @endif
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
                }
            },
            "dom": '<"top"lf>rt<"bottom"ip><"clear">'
        });
    });
</script>
@endsection
