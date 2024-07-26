@extends('layout.master')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container h-100 d-flex flex-column">
  <h1>Dashboard Admin</h1>
  <div class="d-flex justify-content-between mb-4 flex-nowrap"> <!-- Ubah flex-wrap menjadi nowrap -->
    <div class="col-lg-3 p-0 mx-2">
        <div class="card card-custom h-100">
            <div class="card-body d-flex flex-column align-items-center justify-content-center text-white bg-primary">
                <i class="fas fa-users fa-2x mb-2"></i>
                <h6 class="card-title mt-2">Manage Users</h6>
            </div>
        </div>
    </div>
    <div class="col-lg-3 p-0 mx-2">
        <div class="card card-custom h-100">
            <div class="card-body d-flex flex-column align-items-center justify-content-center text-white bg-success">
                <i class="fas fa-door-open fa-2x mb-2"></i>
                <h5 class="card-title mt-2">RUangan</h5>
            </div>
        </div>
    </div>
    <div class="col-lg-3 p-0 mx-2">
        <div class="card card-custom h-100">
            <div class="card-body d-flex flex-column align-items-center justify-content-center text-white bg-warning">
                <i class="fas fa-chart-line fa-2x mb-2"></i>
                <h5 class="card-title mt-2">Reports</h5>
            </div>
        </div>
    </div>
    <div class="col-lg-3 p-0 mx-2">
        <div class="card card-custom h-100">
            <div class="card-body d-flex flex-column align-items-center justify-content-center text-white bg-danger">
                <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                <h5 class="card-title mt-2">Alerts</h5>
            </div>
        </div>
    </div>

  </div>
  <!-- Bagian bawah tetap tidak berubah -->
  <div class="row mt-4">
    <div class="card card-custom">
        <img src="{{ asset('assets/images/products/admin.jpg') }}" class="card-img" alt="Admin Dashboard Image">
        <div class="card-img-overlay d-flex align-items-center justify-content-center">
            <h5 class="card-title text-white text-center">
                Selamat di Admin Dashboard <br>
                Mengelola dan Mengawasi Operasi
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

.d-flex.flex-nowrap > .col-lg-3 {
    flex: 1 0 auto; /* Mencegah elemen flex dari mengecil terlalu banyak */
    max-width: 200px; /* Menetapkan lebar maksimum untuk menjaga proporsi */
}
</style>
@endsection
