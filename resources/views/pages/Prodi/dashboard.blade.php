@extends('layout.master')

@section('title', 'Dashboard Kaprodi')

@section('content')
<div class="container h-100 d-flex flex-column">
  <h1>Dashboard Kaprodi</h1>
  <div class="d-flex justify-content-between mb-4"> <!-- Ubah dari row menjadi d-flex -->
    <div class="col-lg-3 p-0">
        <div class="card card-custom h-100">
            <div class="card-body d-flex flex-column align-items-center justify-content-center text-white bg-info">
                <i class="fas fa-file-alt fa-2x mb-2"></i> <!-- Menambahkan margin-bottom pada ikon -->
                <h6 class="card-title mt-2">Proposal Skripsi</h6> <!-- Menambahkan margin-top pada teks -->
            </div>
        </div>
    </div>
    <div class="col-lg-3 p-1">
        <div class="card card-custom h-100">
            <div class="card-body d-flex flex-column align-items-center justify-content-center text-white bg-success">
                <i class="fas fa-user fa-2x mb-2"></i>
                <h5 class="card-title mt-2">Dosen Pembimbing</h5>
            </div>
        </div>
    </div>
    <div class="col-lg-3 p-1">
        <div class="card card-custom h-100">
            <div class="card-body d-flex flex-column align-items-center justify-content-center text-white bg-warning">
                <i class="fas fa-chalkboard-teacher fa-2x mb-2"></i>
                <h5 class="card-title mt-2">Seminar Proposal</h5>
            </div>
        </div>
    </div>
    <div class="col-lg-3 p-1">
        <div class="card card-custom h-100">
            <div class="card-body d-flex flex-column align-items-center justify-content-center text-white bg-danger">
                <i class="fas fa-comments fa-2x mb-2"></i>
                <h5 class="card-title mt-2">Seminar Komprehensif</h5>
            </div>
        </div>
    </div>
    <div class="col-lg-3 p-1">
        <div class="card card-custom h-100">
            <div class="card-body d-flex flex-column align-items-center justify-content-center text-white bg-secondary">
                <i class="fas fa-gavel fa-2x mb-2"></i>
                <h5 class="card-title mt-2">Sidang Skripsi</h5>
            </div>
        </div>
    </div>
  </div>
  <!-- Bagian bawah tetap tidak berubah -->
  <div class="row mt-4">
    <div class="card card-custom">
        <img src="{{ asset('assets/images/products/51.jpg') }}" class="card-img" alt="Welcome Image">
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
    padding-left: 0; /* Menghapus padding kiri dari container */
    padding-right: 0; /* Menghapus padding kanan dari container */
}

.row {
    margin-left: 0; /* Menghapus margin kiri dari row */
    margin-right: 0; /* Menghapus margin kanan dari row */
}

.card-custom {
    position: relative;
    overflow: hidden;
    height: 50vh; /* Set the desired height */
    margin-bottom: 0; /* Menghapus margin bawah dari card */
}

.card-img {
    width: 100%;
    height: auto;
    object-fit: contain; /* Ensure the entire image is visible */
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
