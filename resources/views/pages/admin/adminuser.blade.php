@extends('layout.master')
@section('title', 'Daftar Pengguna')
@section('content')
<div class="container">
    <style>
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
            margin-right: 20px;
        }

        .truncate {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 300px;
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
            max-width: 300px;
        }
    </style>
    <h2>Daftar Pengguna</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
        
    <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#createUserModal">
        <i class="fas fa-user-plus"></i> Create User
    </button>

    <div class="row mb-4 ">
        <div class="col-md-3 mb-3">
            <select id="roleFilter" class="form-select form-select-custom text-center"  style="background-color: #007bff; color: white;">
                <option value="" style="background-color: white; color: black;">-- Semua Role --</option>
                <option value="admin" style="background-color: white; color: black;">Admin</option>
                <option value="mahasiswa" style="background-color: white; color: black;">Mahasiswa</option>
                <option value="dosen" style="background-color: white; color: black;">Dosen</option>
                <option value="kaprodi" style="background-color: white; color: black;">Prodi</option>
            </select>
        </div>
        <div class="col-md-3">
            <select id="programStudiFilter" class="form-select form-select-custom" style="background-color: #28a745; color: white;">
                <option value="" style="background-color: white; color: black;">-- Semua Program Studi --</option>
                <option value="Teknik Informatika" style="background-color: white; color: black;">Teknik Informatika</option>
                <option value="Sistem Informasi" style="background-color: white; color: black;">Sistem Informasi</option>
                <option value="Teknik Elektro" style="background-color: white; color: black;">Teknik Elektro</option>
                <!-- Add other options as needed -->
            </select>
        </div>
    </div>
    

    <div class="datatable-container mb-3">
        <table id="usersTable" class="table table-bordered mt-3">
            <thead class="text-center">
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Detail</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->role }}</td>
                        <td>
                            @if($user->role == 'admin' && $user->admin)
                                Nama: {{ $user->admin->nama }}<br>
                                No HP: {{ $user->admin->no_hp }}<br>
                                Alamat: <span class="truncate" data-full-text="{{ $user->admin->alamat }}">{{ Str::limit($user->admin->alamat, 100) }}</span>
                            @elseif($user->role == 'mahasiswa' && $user->mahasiswa)
                                Nama: {{ $user->mahasiswa->nama }}<br>
                                No HP: {{ $user->mahasiswa->no_hp }}<br>
                                Alamat: <span class="truncate" data-full-text="{{ $user->mahasiswa->alamat }}">{{ Str::limit($user->mahasiswa->alamat, 100) }}</span>
                            @elseif($user->role == 'dosen' && $user->dosen)
                                Nama: {{ $user->dosen->nama }}<br>
                                No HP: {{ $user->dosen->no_hp }}<br>
                                Alamat: <span class="truncate" data-full-text="{{ $user->dosen->alamat }}">{{ Str::limit($user->dosen->alamat, 100) }}</span>
                            @elseif($user->role == 'kaprodi' && $user->prodi)
                                Nama: {{ $user->prodi->nidn }}<br>
                                No HP: {{ $user->prodi->nama }}<br>
                                Fakultas: {{ $user->prodi->departemen }}<br>
                            @else
                                -
                            @endif
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editUserModal" data-id="{{ $user->id }}" data-username="{{ $user->username }}"><i class="fas fa-edit"></i> Edit</button>
                            <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Create User -->
<div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createUserModalLabel">Create User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.users.tambah') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select" id="role" name="role" required>
                            <option value="admin">Admin</option>
                            <option value="mahasiswa">Mahasiswa</option>
                            <option value="dosen">Dosen</option>
                            <option value="kaprodi">Prodi</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit User -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editUserForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="editUsername" class="form-label">Username</label>
                        <input type="text" class="form-control" id="editUsername" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="editPassword" class="form-label">Password</label>
                        <input type="password" class="form-control" id="editPassword" name="password">
                        <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password.</small>
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
        var table = $('#usersTable').DataTable({
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

        // Filter by role
        $('#roleFilter').on('change', function () {
            table.column(2).search(this.value).draw();
        });

        // Filter by program studi
        $('#programStudiFilter').on('change', function () {
            table.column(3).search(this.value).draw();
        });

        $('#editUserModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var userId = button.data('id');
            var username = button.data('username');

            var modal = $(this);
            modal.find('#editUsername').val(username);

            $('#editUserForm').attr('action', '/admin/users/' + userId);
        });
    });
</script>
@endsection
