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
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 ">
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
                    <div class="col-lg-4 ">
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
                    <div class="col-lg-4 ">
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
                </div>
                <div class="row vh-60">
                    <div class="col-12">
                        <div class="card card-custom h-75 ">
                            <img src="{{ asset('assets/images/products/51.jpg') }}" class="card-img h-100" alt="Bimbingan Skripsi" style="object-fit: cover;">
                            <div class="card-img-overlay d-flex align-items-center justify-content-center">
                                <h5 class="card-title text-white text-center">Selamat Datang di Menu Utama <br> Sistem Informasi Manajemen Skripsi Universitas Sinata</h5>
                            </div>
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
            <div class="col-lg-12">
                <div class="card overflow-hidden">
                    <div class="card-body p-4">
                        <h5 class="card-title mb-9 fw-semibold">Dashboard Mahasiswa</h5>
                        
                        <!-- Progress Skripsi Saya Section -->
                        <div class="progress-skripsi">
                            <h6 class="mb-4">Progress Skripsi Saya</h6>
                            <div class="progress-container">
                                <ul class="progress-steps">
                                    <li class="step completed">
                                        <div class="step-number">1</div>
                                        <div class="step-label">Pemilihan Pembimbing</div>
                                    </li>
                                    <li class="step">
                                        <div class="step-number">2</div>
                                        <div class="step-label">Proses Bimbingan Skripsi</div>
                                    </li>
                                    <li class="step">
                                        <div class="step-number">3</div>
                                        <div class="step-label">Logbook Bab <br> 1 dan 3</div>
                                    </li>
                                    <li class="step">
                                        <div class="step-number">4</div>
                                        <div class="step-label">Seminar Proposal</div>
                                    </li>
                                    <li class="step">
                                        <div class="step-number">5</div>
                                        <div class="step-label">Logbook Bab 4 dan 5</div>
                                    </li>
                                    <li class="step">
                                        <div class="step-number">6</div>
                                        <div class="step-label">Seminar Komprehensif</div>
                                    </li>
                                    <li class="step">
                                        <div class="step-number">7                                                        </div>
                                        <div class="step-label">Selesai</div>
                                    </li>
                                </ul>
                            </div>
        
                            <div class="skripsi-details mt-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6>JUDUL:</h6>
                                        <p>Studi kinerja algoritma similaritas untuk identifikasi dan pemetaan pernyataan SWOT</p>
                                    </div>
                                    <div class="col-md-6">
                                        <h6>Jurusan:</h6>
                                        <p>Sistem Informasi</p>
                                    </div>
                                    <div class="col-md-6">
                                        <h6>PEMBIMBING:</h6>
                                        <p>Husni Thamrin - 100</p>
                                    </div>
                                    <div class="col-md-6">
                                        <h6>JADWAL KONSULTASI:</h6>
                                        <p>15/July/2024</p>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <h6>Deskripsi:</h6>
                                    <p>
                                        SWOT merupakan singkatan dari Strength (kekuatan), Weakness (kelemahan), Opportunity (peluang), dan Threat (ancaman). Analisis SWOT merupakan cara untuk menentukan kekuatan dan kelemahan sebuah lembaga, peluang yang dimiliki, dan ancaman yang mungkin dihadapi oleh sebuah lembaga. Setelah berbagai faktor SWOT diketahui, selanjutnya lembaga dapat menyusun perencanaan strategis dengan mempertimbangkan berbagai faktor tersebut. Salah satu tahapan penting dalam skripsi adalah untuk menentukan sebuah pernyataan atau kalimat SWOT. Skripsi ini berupaya melakukan pemetaan pernyataan atau kalimat SWOT dengan algoritma klasifikasi dan analisis sentimen.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- End Progress Skripsi Saya Section -->
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

    .progress-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    .progress-steps {
        list-style: none;
        display: flex;
        justify-content: space-between;
        width: 100%;
        padding: 0;
        margin: 0;
    }
    .progress-steps .step {
        text-align: center;
        position: relative;
        flex: 1;
    }
    .progress-steps .step::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        height: 4px;
        width: 100%;
        background-color: #ddd;
        z-index: -1;
    }
    .progress-steps .step.completed::before {
        background-color: #007bff;
    }
    .progress-steps .step:first-child::before {
        display: none;
    }
    .progress-steps .step .step-number {
        width: 40px;
        height: 40px;
        background-color: #ddd;
        border-radius: 50%;
        line-height: 40px;
        margin: 0 auto 10px;
        position: relative;
        z-index: 1;
    }
    .progress-steps .step.completed .step-number {
        background-color: #007bff;
        color: white;
    }
    .progress-steps .step .step-label {
        font-size: 14px;
        color: #333;
    }
</style>
@endsection