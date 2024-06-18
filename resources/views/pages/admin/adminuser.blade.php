@extends('layout.master')
@section('title', 'Daftar Ruangan')
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
    <h2>Daftar Ruangan</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tambahkan Tombol Tambah Ruangan -->
    <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#createRoomModal">
        <i class="fas fa-plus"></i> Tambah Ruangan
    </button>

    <div class="datatable-container mb-3">
        <table id="roomsTable" class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Ruangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ruangans as $ruangan)
                    <tr>
                        <td>{{ $ruangan->id }}</td>
                        <td>{{ $ruangan->nama }}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editRoomModal" data-id="{{ $ruangan->id }}" data-nama="{{ $ruangan->nama }}"><i class="fas fa-edit"></i> Edit</button>
                            <form action="{{ route('admin.ruangans.delete', $ruangan->id) }}" method="POST" style="display: inline-block;">
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

<!-- Modal Tambah Ruangan -->
<div class="modal fade" id="createRoomModal" tabindex="-1" aria-labelledby="createRoomModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createRoomModalLabel">Tambah Ruangan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.ruangans.tambah') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Ruangan</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Ruangan -->
<div class="modal fade" id="editRoomModal" tabindex="-1" aria-labelledby="editRoomModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRoomModalLabel">Edit Ruangan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editRoomForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="editNama" class="form-label">Nama Ruangan</label>
                        <input type="text" class="form-control" id="editNama" name="nama" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#roomsTable').DataTable({
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

        $('#editRoomModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var roomId = button.data('id');
            var nama = button.data('nama');

            var modal = $(this);
            modal.find('#editNama').val(nama);

            $('#editRoomForm').attr('action', '/admin/ruangans/' + roomId);
        });
    });
</script>

@endsection
