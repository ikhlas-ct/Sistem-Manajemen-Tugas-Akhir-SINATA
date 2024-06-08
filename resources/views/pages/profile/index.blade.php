@extends('layout.master')
@section('title', 'Dashboard')
@section('content')
    @php
        use App\Helpers\FiturHelper;
    @endphp
    <div class="container-fluid">
        <h5 class="card-title fw-semibold mb-4">Profile</h5>
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
                                        src="{{ asset('storage/' . $user->prodi->gambar) }}" alt="Profile Image">
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
                                                <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', $user->prodi->nama) }}">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="nidn" class="form-label">NIDN</label>
                                                <input type="text" class="form-control" id="nidn" name="nidn" value="{{ old('nidn', $user->prodi->nidn) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="departemen" class="form-label">Departemen</label>
                                                <input type="text" class="form-control" id="departemen" name="departemen" value="{{ old('departemen', $user->prodi->departemen) }}">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="no_hp" class="form-label">No HP</label>
                                                <input type="number" class="form-control" id="no_hp" name="no_hp" value="{{ old('no_hp', $user->prodi->no_hp) }}">
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
                                    <div class="d-grid"> 
                                        <button type="submit" class="btn btn-primary mt-3">Update Profile</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <h2>Ganti Password</h2>
                            <div class="mb-3">
                                <label for="password_lama" class="form-label">Password Lama</label>
                                <input type="password" class="form-control" id="password_lama" name="password_lama">
                            </div>
                            <div class="mb-3">
                                <label for="password_baru" class="form-label">Password Baru</label>
                                <input type="password" class="form-control" id="password_baru" name="password_baru">
                            </div>
                            <div class="mb-3">
                                <label for="konfirmasi_password" class="form-label">Konfirmasi Password</label>
                                <input type="password" class="form-control" id="konfirmasi_password" name="konfirmasi_password">
                            </div>
                        </div>
                    </div>
                    <div class="d-grid"> 
                        <button type="submit" class="btn btn-primary mt-3">Ganti Password</button>
                    </div>
                </div>
            @endif
            @if (FiturHelper::showDosen())
                <div class="card-body">
                    <form action="{{ route('profileUpdate') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-4 d-flex align-items-center">
                                <div class="position-relative d-inline-block">
                                    <img id="current-profile-image" class="img-fluid img-thumbnail rounded-5"
                                        src="{{ asset('assets/images/profile/user-1.jpg') }}" alt="">
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
                                            <input type="text" class="form-control" id="nidn" name="nidn">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="nama" class="form-label">Nama</label>
                                            <input type="text" class="form-control" id="nama" name="nama">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="fakultas" class="form-label">Departemen</label>
                                            <input type="text" class="form-control" id="fakultas" name="fakultas">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for=no_hp" class="form-label">No HP</label>
                                            <input type="number" class="form-control" id="no_hp" name="no_hp">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="alamat" class="form-label">Alamat</label>
                                            <textarea class="form-control" id="alamat" name="alamat" rows="2"></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="deskripsi" class="form-label">Deskripsi</label>
                                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="2"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-grid"> 
                                    <button type="submit" class="btn btn-primary mt-3">Update Profile</button>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <h2>Ganti Password</h2>
                                <div class="mb-3">
                                    <label for="password_lama" class="form-label">Password Lama</label>
                                    <input type="password" class="form-control" id="password_lama" name="password_lama">
                                </div>
                                <div class="mb-3">
                                    <label for="password_baru" class="form-label">Password Baru</label>
                                    <input type="password" class="form-control" id="password_baru" name="password_baru">
                                </div>
                                <div class="mb-3">
                                    <label for="konfirmasi_password" class="form-label">Konfirmasi Password</label>
                                    <input type="password" class="form-control" id="konfirmasi_password" name="konfirmasi_password">
                                </div>
                            </div>
                        </div>
                        <div class="d-grid"> 
                            <button type="submit" class="btn btn-primary mt-3">Ganti Password</button>
                        </div>
                    </form>
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
                                        src="{{ asset('storage/' . $user->mahasiswa->gambar) }}" alt="Profile Image">
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
                                                <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', $user->mahasiswa->nama) }}">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="nim" class="form-label">NIM</label>
                                                <input type="text" class="form-control" id="nim" name="nim" value="{{ old('nim', $user->mahasiswa->nim) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="fakultas" class="form-label">Fakultas</label>
                                                <input type="text" class="form-control" id="fakultas" name="fakultas" value="{{ old('fakultas', $user->mahasiswa->fakultas) }}">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="no_hp" class="form-label">No HP</label>
                                                <input type="number" class="form-control" id="no_hp" name="no_hp" value="{{ old('no_hp', $user->mahasiswa->no_hp) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label for="alamat" class="form-label">Alamat</label>
                                                <textarea class="form-control" id="alamat" name="alamat" rows="2">{{ old('alamat', $user->mahasiswa->alamat) }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-grid"> 
                                        <button type="submit" class="btn btn-primary mt-3">Update Profile</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <h2>Ganti Password</h2>
                            <div class="mb-3">
                                <label for="password_lama" class="form-label">Password Lama</label>
                                <input type="password" class="form-control" id="password_lama" name="password_lama">
                            </div>
                            <div class="mb-3">
                                <label for="password_baru" class="form-label">Password Baru</label>
                                <input type="password" class="form-control" id="password_baru" name="password_baru">
                            </div>
                            <div class="mb-3">
                                <label for="konfirmasi_password" class="form-label">Konfirmasi Password</label>
                                <input type="password" class="form-control" id="konfirmasi_password" name="konfirmasi_password">
                            </div>
                        </div>
                    </div>
                    <div class="d-grid"> 
                        <button type="submit" class="btn btn-primary mt-3">Ganti Password</button>
                    </div>
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
