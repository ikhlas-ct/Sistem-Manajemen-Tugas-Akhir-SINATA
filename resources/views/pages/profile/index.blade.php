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
                    <form>
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
                                <input type="file" class="d-none" name="profile-input" id="profile-input">
                            </div>
                            <div class="col-8">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="nama" class="form-label">Nama</label>
                                            <input type="text" class="form-control" id="nama" name="nama">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="nidn" class="form-label">NIDN</label>
                                            <input type="text" class="form-control" id="nidn" name="nidn">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="fakultas" class="form-label">Fakultas</label>
                                            <input type="text" class="form-control" id="fakultas" name="fakultas">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="no-telp" class="form-label">No Telp</label>
                                            <input type="number" class="form-control" id="no-telp" name="no-telp">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="deskripsi" class="form-label">Deskripsi</label>
                                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="2"></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="alamat" class="form-label">Alamat</label>
                                            <textarea class="form-control" id="alamat" name="alamat" rows="2"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-grid"> <button type="submit" class="btn btn-primary mt-3">Update</button></div>
                    </form>

                </div>
            @endif
            @if (FiturHelper::showDosen())
                <div class="card-body">
                    <h1>Tampilkan Profile Dosen</h1>
                </div>
            @endif
            @if (FiturHelper::showMahasiswa())
                <div class="card-body">
                    <h1>Tampilkan Profile Mahasiswa</h1>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $("#profile-image").click(function() {
                $("#profile-input").click();
            });

            $("#profile-input").change(function(event) {
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
