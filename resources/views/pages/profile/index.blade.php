@extends('layout.master')

@section('title', 'Dashboard')

@section('content')
    @php
        use App\Helpers\FiturHelper;
    @endphp

    <div class="container-fluid">
        <h4 class="card-title fw-semibold mb-4">Profile</h4>
        <div class="card">
            @if (FiturHelper::showKaprodi())
                <div class="card-body">
                    <form action="{{ route('profileUpdateProdi') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-4 d-flex align-items-center">
                                <div class="position-relative d-inline-block">
                                    <img id="current-profile-image" class="img-fluid img-thumbnail rounded-5"
                                        src="{{ asset($user->prodi->gambar) }}" alt="Profile Image">
                                    <span class="position-absolute top-0 end-0 p-4">
                                        <div id="profile-image" class="bg-white p-2 rounded-2 cursor-pointer">
                                            <i class="fas fa-camera fs-5"></i>
                                        </div>
                                    </span>
                                </div>
                                <input type="file" class="d-none" name="gambar" id="gambar">
                            </div>
                            <div class="col-8 d-flex align-items-center">
                                <div class="w-100">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="nama" class="form-label">Nama</label>
                                                <input type="text" class="form-control" id="nama" name="nama"
                                                    value="{{ old('nama', $user->prodi->nama) }}">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="nidn" class="form-label">NIDN</label>
                                                <input type="text" class="form-control" id="nidn" name="nidn"
                                                    value="{{ old('nidn', $user->prodi->nidn) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="departemen" class="form-label">Departemen</label>
                                                <input type="text" class="form-control" id="departemen" name="departemen"
                                                    value="{{ old('departemen', $user->prodi->departemen) }}">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="no_hp" class="form-label">No HP</label>
                                                <input type="number" class="form-control" id="no_hp" name="no_hp"
                                                    value="{{ old('no_hp', $user->prodi->no_hp) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label for="alamat" class="form-label">Alamat</label>
                                                <textarea class="form-control" id="alamat" name="alamat" rows="2">{{ old('alamat', $user->prodi->alamat) }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary mt-3 w-100">Update Profile</button>
                            </div>
                        </div>
                    </form>
                    <hr>
                    <form action="{{ route('passwordUpdateProdi') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-12">
                                <h5 style="color: #2a3547" class="fw-semibold my-3">Ganti Password</h5>
                                <!-- Menampilkan error umum di atas form -->
                                <div class="mb-3">
                                    <label for="password_lama" class="form-label text-muted">Password Lama</label>
                                    <input placeholder="Masukan password lama" type="password"
                                        class="form-control @error('password_lama') is-invalid @enderror" id="password_lama"
                                        name="password_lama" value="{{ old('password_lama') }}">
                                    @error('password_lama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="password_baru" class="form-label text-muted">Password Baru</label>
                                    <input placeholder="Masukan password baru" type="password"
                                        class="form-control @error('password_baru') is-invalid @enderror" id="password_baru"
                                        name="password_baru" value="{{ old('password_baru') }}">
                                    @error('password_baru')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="konfirmasi_password" class="form-label text-muted">Konfirmasi
                                        Password</label>
                                    <input placeholder="Konfirmasi password" type="password"
                                        class="form-control @error('password_baru_confirmation') is-invalid @enderror"
                                        id="konfirmasi_password" name="password_baru_confirmation"
                                        value="{{ old('password_baru_confirmation') }}">
                                    @error('password_baru_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="d-grid my-3">
                            <button type="submit" class="btn btn-primary mt-3">Ganti Password</button>
                        </div>
                    </form>
                </div>
            @endif
            @if (FiturHelper::showDosen())
                <div class="card-body">
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
                    <form action="{{ route('dosen.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-4 d-flex align-items-center">
                                <div class="position-relative d-inline-block">
                                    <img id="current-profile-image" class="img-fluid img-thumbnail rounded-5"
                                        src="{{ Auth::user()->dosen->gambar ? asset(Auth::user()->dosen->gambar) : asset('assets/images/profile/user-1.jpg') }}"
                                        alt="Current Profile Image">
                                    <span class="position-absolute top-0 end-0 p-4">
                                        <div id="profile-image" class="bg-white p-2 rounded-2 cursor-pointer">
                                            <i class="fas fa-camera fs-5"></i>
                                        </div>
                                    </span>
                                </div>
                                <input type="file" class="d-none" name="gambar" id="gambar">
                            </div>
                            <div class="col-8">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="nidn" class="form-label">NIDN</label>
                                            <input type="text" class="form-control" id="nidn" name="nidn"
                                                value="{{ Auth::user()->dosen->nidn }}">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="nama" class="form-label">Nama</label>
                                            <input type="text" class="form-control" id="nama" name="nama"
                                                value="{{ Auth::user()->dosen->nama }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="fakultas" class="form-label">Departemen</label>
                                            <input type="text" class="form-control" id="department" name="department"
                                                value="{{ Auth::user()->dosen->department }}">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="no_hp" class="form-label">No HP</label>
                                            <input type="text" class="form-control" id="no_hp" name="no_hp"
                                                value="{{ Auth::user()->dosen->no_hp }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="alamat" class="form-label">Alamat</label>
                                            <textarea class="form-control" id="alamat" name="alamat" rows="2">{{ Auth::user()->dosen->alamat }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="deskripsi" class="form-label">Deskripsi</label>
                                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="2">{{ Auth::user()->dosen->deskripsi }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary mt-3">Update Profile</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <h2>Ganti Password dan Username</h2>
                            @if (session('password'))
                                <div class="alert alert-success">
                                    {{ session('password') }}
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
                            <form action="{{ route('dosen.update.password') }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control @error('username') is-invalid @enderror"
                                        id="username" name="username"
                                        value="{{ old('username', Auth::user()->username) }}">
                                    @error('username')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password_lama" class="form-label">Password Lama</label>
                                    <input type="password"
                                        class="form-control @error('password_lama') is-invalid @enderror"
                                        id="password_lama" name="password_lama">
                                    @error('password_lama')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input id="password" type="password" class="form-control" name="password" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password-confirm" class="form-label">Confirm Password</label>
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required>
                                    <div id="password-error" class="text-danger mt-2" style="display:none;">Passwords do
                                        not match!</div>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary mt-3">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            @endif
            @if (FiturHelper::showMahasiswa())
                <div class="card-body">
                    <form action="{{ route('profileUpdate') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-4 d-flex align-items-center">
                                <div class="position-relative d-inline-block">
                                    <img id="current-profile-image" class="img-fluid img-thumbnail rounded-5"
                                        src="{{ asset($user->mahasiswa->gambar) }}" alt="Profile Image">
                                    <span class="position-absolute top-0 end-0 p-4">
                                        <div id="profile-image" class="bg-white p-2 rounded-2 cursor-pointer">
                                            <i class="fas fa-camera fs-5"></i>
                                        </div>
                                    </span>
                                </div>
                                <input type="file" class="d-none" name="gambar" id="gambar">
                            </div>
                            <div class="col-8 d-flex align-items-center">
                                <div class="w-100">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="nama" class="form-label text-muted">Nama</label>
                                                <input type="text" class="form-control" id="nama" name="nama"
                                                    value="{{ old('nama', $user->mahasiswa->nama) }}">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="nim" class="form-label text-muted">NIM</label>
                                                <input type="text" class="form-control" id="nim" name="nim"
                                                    value="{{ old('nim', $user->mahasiswa->nim) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="fakultas" class="form-label text-muted">Fakultas</label>
                                                <input type="text" class="form-control" id="fakultas"
                                                    name="fakultas"
                                                    value="{{ old('fakultas', $user->mahasiswa->fakultas) }}">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="no_hp" class="form-label text-muted">No HP</label>
                                                <input type="number" class="form-control" id="no_hp" name="no_hp"
                                                    value="{{ old('no_hp', $user->mahasiswa->no_hp) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label for="alamat" class="form-label text-muted">Alamat</label>
                                                <textarea class="form-control" id="alamat" name="alamat" rows="2">{{ old('alamat', $user->mahasiswa->alamat) }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary mt-3 w-100">Update Profile</button>
                            </div>
                        </div>
                    </form>
                    <hr>
                    <form action="{{ route('passwordUpdateMahasiswa') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-12">
                                <h5 style="color: #2a3547" class="fw-semibold my-3">Ganti Password</h5>
                                <!-- Menampilkan error umum di atas form -->
                                <div class="mb-3">
                                    <label for="password_lama" class="form-label text-muted">Password Lama</label>
                                    <input placeholder="Masukan password lama" type="password"
                                        class="form-control @error('password_lama') is-invalid @enderror"
                                        id="password_lama" name="password_lama" value="{{ old('password_lama') }}">
                                    @error('password_lama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="password_baru" class="form-label text-muted">Password Baru</label>
                                    <input placeholder="Masukan password baru" type="password"
                                        class="form-control @error('password_baru') is-invalid @enderror"
                                        id="password_baru" name="password_baru" value="{{ old('password_baru') }}">
                                    @error('password_baru')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="konfirmasi_password" class="form-label text-muted">Konfirmasi
                                        Password</label>
                                    <input placeholder="Konfirmasi password" type="password"
                                        class="form-control @error('password_baru_confirmation') is-invalid @enderror"
                                        id="konfirmasi_password" name="password_baru_confirmation"
                                        value="{{ old('password_baru_confirmation') }}">
                                    @error('password_baru_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="d-grid my-3">
                            <button type="submit" class="btn btn-primary mt-3">Ganti Password</button>
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $("#profile-image").click(function() {
                $("#gambar").click();
            });

            $("#gambar").change(function(event) {
                let reader = new FileReader();
                reader.onload = function() {
                    let output = document.getElementById('current-profile-image');
                    output.src = reader.result;
                };
                reader.readAsDataURL(event.target.files[0]);
            });
        });
    </script>
@endsection
