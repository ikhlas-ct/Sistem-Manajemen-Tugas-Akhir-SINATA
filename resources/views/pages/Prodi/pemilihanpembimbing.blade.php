@extends('layout.master')
@section('title', 'Daftar Dosen Pembimbing')
@section('content')
<div class="container">
    <style>
        /* CSS khusus untuk memperbaiki jarak elemen "Show entries" */
        .dataTables_length {
            display: flex;
            align-items: center;
        }

        .dataTables_length label {
            display: flex;
            align-items: center;
        }

        .dataTables_length label span,
        .dataTables_length label select {
            margin-right: 20px; /* Adjust the margin as needed */
        }

        /* resources/css/app.css */
        .truncate {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 300px; /* Adjust as needed */
            display: inline-block;
            vertical-align: top;
        }

        .truncate:hover::after {
            content: attr(data-full-text);
            white-space: pre-wrap;
            position: absolute;
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 5px;
            z-index: 1000;
            max-width: 300px; /* Adjust as needed */
        }
    </style>
    <h2>Daftar Dosen Pembimbing</h2>

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

    <!-- Tambahkan Tombol Tambah Dosen Pembimbing -->
    <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#createDosenPembimbingModal">
        <i class="fas fa-user-plus"></i> Tambah Dosen Pembimbing
    </button>
    
    <!-- Tabs for filtering users by role -->
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link {{ request()->is('kaprodi/Pembimbing') ? 'active' : '' }}" href="{{ route('Pembimbing.dashboard') }}">
                <span class="btn btn-primary d-inline-flex align-items-center justify-content-center">
                    Semua <span class="badge bg-light text-dark ms-1">{{ $totalDosenPembimbing }}</span>
                </span>
            </a>
        </li>
        <!-- Tambahkan tab lainnya sesuai dengan kebutuhan untuk memfilter berdasarkan jenis dosen pembimbing -->
    </ul>

    <div class="datatable-container mb-3">
        <table id="dosenPembimbingTable" class="table table-bordered mt-3">
            <thead>
                <tr>
                    <td>{{ $loop->iteration }}</td>                  
                    <th>Dosen Pembimbing</th>
                    <th>Jenis Pembimbing</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dosenPembimbings as $dosenPembimbing)
                <tr>
                    <td>{{ $dosenPembimbing->id }}</td>
                    <td>{{ $dosenPembimbing->dosen->nama }}</td>
                    <td>{{ $dosenPembimbing->jenis_dosbing }}</td>
                    <td class="text-center">
                        <a href="{{ route('pembimbing.edit', $dosenPembimbing->id) }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-edit"></i> Edit
                        </a>>

                        <form action="{{ route('prodi.dosen-pembimbings.delete', $dosenPembimbing->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah Dosen Pembimbing -->
<div class="modal fade" id="createDosenPembimbingModal" tabindex="-1" aria-labelledby="createDosenPembimbingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createDosenPembimbingModalLabel">Tambah Dosen Pembimbing</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('prodi.dosen-pembimbings.tambah') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="dosen_id" class="form-label">Dosen</label>
                        <select class="form-select" id="dosen_id" name="dosen_id" required>
                            @foreach ($dosens as $dosen)
                                <option value="{{ $dosen->id }}">{{ $dosen->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="jenis_dosbing" class="form-label">Jenis Pembimbing</label>
                        <select class="form-select" id="jenis_dosbing" name="jenis_dosbing" required>
                            <option value="pembimbing 1">Pembimbing 1</option>
                        </select>
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
        // Inisialisasi DataTable
        $('#dosenPembimbingTable').DataTable({
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
