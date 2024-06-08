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
                    <form action="{{ route('profileUpdate') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-4 d-flex align-items-center">
                                <div class="position-relative d-inline-block">
                                    @dd(Auth::user()->dosen->gambar)
                                    <img id="current-profile-image" class="img-fluid img-thumbnail rounded-5"
                                        src="{{ Auth::user()->dosen->gambar ? asset('storage/' . Auth::user()->dosen->gambar) : asset('assets/images/profile/user-1.jpg') }}" 
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
                                            <label for="no_hp" class="form-label">No HP</label>
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
                                            <input type="text" class="form-control" id="nidn" name="nidn" value="{{ Auth::user()->dosen->nidn }}">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="nama" class="form-label">Nama</label>
                                            <input type="text" class="form-control" id="nama" name="nama" value="{{Auth::user()->dosen->nama}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="fakultas" class="form-label">Departemen</label>
                                            <input type="text" class="form-control" id="department" name="department" value="{{ Auth::user()->dosen->department }}">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="no_hp" class="form-label">No HP</label>
                                            <input type="text" class="form-control" id="no_hp" name="no_hp" value="{{ Auth::user()->dosen->no_hp }}">
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
                                    <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username', Auth::user()->username) }}">
                                    @error('username')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                        
                                <div class="mb-3">
                                    <label for="password_lama" class="form-label">Password Lama</label>
                                    <input type="password" class="form-control @error('password_lama') is-invalid @enderror" id="password_lama" name="password_lama">
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
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                    <div id="password-error" class="text-danger mt-2" style="display:none;">Passwords do not match!</div>
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
                                        src="{{ asset('storage/' . $user->gambar) }}" alt="Current Profile Image">
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
                                                <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', $user->nama) }}">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="nim" class="form-label">NIM</label>
                                                <input type="text" class="form-control" id="nim" name="nim" value="{{ old('nim', $user->nim) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="fakultas" class="form-label">Fakultas</label>
                                                <input type="text" class="form-control" id="fakultas" name="fakultas" value="{{ old('fakultas', $user->fakultas) }}">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="no_hp" class="form-label">No HP</label>
                                                <input type="number" class="form-control" id="no_hp" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label for="alamat" class="form-label">Alamat</label>
                                                <textarea class="form-control" id="alamat" name="alamat" rows="2">{{ old('alamat', $user->alamat) }}</textarea>
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
