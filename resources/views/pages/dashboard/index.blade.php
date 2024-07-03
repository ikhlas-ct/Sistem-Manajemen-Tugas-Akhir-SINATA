@extends('layout.master')
@section('title', 'Dashboard')
@section('content')
    @php
        use App\Helpers\FiturHelper;
    @endphp
    <div class="container-fluid">
        <!--  Row 1 -->
        <div class="row">
            @if (FiturHelper::showDosen())
            <div class="col-lg-4 mb-4">
                <div class="card card-custom">
                    <img src="{{ asset('assets/images/products/lautan.jpg') }}" class="card-img" alt="Mahasiswa Bimbingan">
                
                    <div class="card-img-overlay mt-3 d-flex align-items-center">
                        <div style="flex: 1;">
                            <h5 class="card-title text-white">Mahasiswa Bimbingan</h5>
                            <h3 class="fw-bold text-white">0</h3>
                        </div>
                        <div>
                            <i class="fas fa-users fa-4x"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card card-custom">
                    <img src="{{ asset('assets/images/products/sakura.jpg') }}" class="card-img" alt="Pengujian Mahasiswa">
                    <div class="card-img-overlay mt-3 d-flex align-items-center">
                        <div style="flex: 1;">
                            <h5 class="card-title text-white">Pengujian Mahasiswa</h5>
                            <h3 class="fw-bold text-white">0</h3>
                        </div>
                        <div>
                            <i class="fas fa-user-check fa-4x"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card card-custom">
                    <img src="{{ asset('assets/images/products/gunung.jpeg') }}" class="card-img" alt="Bimbingan Skripsi">
                    <div class="card-img-overlay mt-3 d-flex align-items-center">
                        <div style="flex: 1;">
                            <h5 class="card-title text-white">Bimbingan Skripsi</h5>
                            <h3 class="fw-bold text-white">0</h3>
                        </div>
                        <div>
                            <i class="fas fa-book-open fa-4x"></i>
                        </div>
                    </div>
                    
                </div>
            </div>
        @endif
            @if (FiturHelper::showKaprodi())
                <div class="col-lg-4">
                    <div class="card overflow-hidden">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-9 fw-semibold">Dashboard Kaprodi</h5>
                         
                        </div>
                    </div>
                </div>
            @endif
            @if (FiturHelper::showMahasiswa())
                <div class="col-lg-4">
                    <div class="card overflow-hidden">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-9 fw-semibold">Dashboard Mahasiswa</h5>
                          
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('styles')
<style>
    .card-custom {
        position: relative;
        color: white;
        height: 200px; 
    }
    .card-custom .card-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
  
</style>
    
@endsection