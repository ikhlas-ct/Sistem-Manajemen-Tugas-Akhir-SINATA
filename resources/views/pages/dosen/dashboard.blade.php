@extends('layout.master')

@section('title', 'Dashboard Dosen')

@section('content')
<div class="container h-100 d-flex flex-column">
  <h1>Dashboard Dosen</h1>
  <div class="row flex-grow-1">
    <div class="col-lg-4 ">
        <div class="card card-custom h-75">
            <img src="{{ asset('assets/images/products/lautan.jpg') }}" class="card-img h-100" alt="Mahasiswa Bimbingan" style="object-fit: cover;">
            <div class="card-img-overlay d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center" style="flex: 1;">
                    <div>
                        <h5 class="card-title text-white">Mahasiswa Bimbingan</h5>
                        <h3 class="fw-bold text-white">{{ $mahasiswaCount }}</h3>
                    </div>
                </div>
                <div>
                    <i class="fas fa-users fa-4x"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 ">
        <div class="card card-custom h-75">
            <img src="{{ asset('assets/images/products/sakura.jpg') }}" class="card-img h-100" alt="Pengujian Mahasiswa" style="object-fit: cover;">
            <div class="card-img-overlay d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center" style="flex: 1;">
                    <div>
                        <h5 class="card-title text-white">Pengujian Mahasiswa</h5>
                        <h3 class="fw-bold text-white">{{ $totalPenilaian }}</h3>
                    </div>
                </div>
                <div>
                    <i class="fas fa-user-check fa-4x"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 ">
        <div class="card card-custom h-75">
            <img src="{{ asset('assets/images/products/gunung.jpeg') }}" class="card-img h-100" alt="Bimbingan Skripsi" style="object-fit: cover;">
            <div class="card-img-overlay d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center" style="flex: 1;">
                    <div>
                        <h5 class="card-title text-white">Bimbingan Skripsi</h5>
                        <h3 class="fw-bold text-white">{{ $konsultasi }}</h3>
                    </div>
                </div>
                <div>
                    <i class="fas fa-book-open fa-4x"></i>
                </div>
            </div>
        </div>
    </div>
  </div>
  <div class="row">
    <div class="card card-custom">
        <img src="{{ asset('assets/images/products/51.jpg') }}" class="card-img" alt="Bimbingan Skripsi">
        <div class="card-img-overlay d-flex align-items-center justify-content-center">
            <h5 class="card-title text-white text-center">
                Selamat Datang di Menu Utama <br>
                Sistem Informasi Manajemen Skripsi Universitas Sinata
            </h5>
        </div>
    </div>
    
  </div>
</div>
@endsection

@section('styles')
<style>
html, body {
    height: 100%;
    overflow: hidden; /* Mencegah scroll pada seluruh halaman */
}

.container {
    height: 100%;
    overflow: hidden; /* Mencegah scroll pada kontainer utama */
}
.card-custom {
    position: relative;
    overflow: hidden;
    height: 50vh; /* Set the desired height */
    margin-bottom: 0; /* Menghapus margin bawah dari card */
}

.card-img {
    width: 100%;
    height: 100%; /* Sesuaikan tinggi gambar dengan container */
    object-fit: cover ; /* Menampilkan gambar secara proporsional */
    object-position: center; /* Memusatkan gambar di dalam container */
}

.card-img-overlay {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    display: flex;
    justify-content: center; /* Membuat konten di tengah secara horizontal */
    align-items: center; /* Membuat konten di tengah secara vertikal */
    padding: 20px;
    background: none; /* Menghapus background overlay */
}

.card-title {
    margin-bottom: 0;
}

.fas {
    margin-left: 20px; /* Memberikan jarak antara ikon dan teks */
}
</style>
@endsection
