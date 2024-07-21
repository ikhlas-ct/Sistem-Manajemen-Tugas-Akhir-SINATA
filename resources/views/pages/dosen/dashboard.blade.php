@extends('layout.master')

@section('title', 'Daftar Seminar Proposal')

@section('content')
<div class="container mt-5">
    <div class="col-lg-12">
        <div class="card overflow-hidden">
            <div class="card-body p-4">
                <h5 class="card-title mb-9 fw-semibold">Dashboard Mahasiswa</h5>
                
                <!-- Progress Skripsi Saya Section -->
                <div class="progress-skripsi">
                    <h6 class="mb-4">Progress Skripsi Saya</h6>
                    <div class="progress-container">
                        <ul class="progress-steps">
                            <li class="step {{ isset($judul) ? 'completed' : '' }}">
                                <div class="step-number">1</div>
                                <div class="step-label">Pemilihan Pembimbing</div>
                            </li>
                            <li class="step {{ isset($konsultasis) && count($konsultasis) > 0 ? 'completed' : '' }}">
                                <div class="step-number">2</div>
                                <div class="step-label">Proses Bimbingan Skripsi</div>
                            </li>
                            <li class="step {{ isset($seminarProposal) ? 'completed' : '' }}">
                                <div class="step-number">3</div>
                                <div class="step-label">Seminar Proposal</div>
                            </li>
                            <li class="step {{ isset($seminarKomprehensif) ? 'completed' : '' }}">
                                <div class="step-number">4</div>
                                <div class="step-label">Seminar Komprehensif</div>
                            </li>
                            <li class="step {{ isset($judul) && $judul->status == 'selesai' ? 'completed' : '' }}">
                                <div class="step-number">5</div>
                                <div class="step-label">Selesai</div>
                            </li>
                        </ul>
                    </div>

                    <div class="skripsi-details mt-4">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>JUDUL:</h6>
                                <p>{{ $judul->judul ?? 'Belum ada judul' }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6>Jurusan:</h6>
                                <p>{{ $mahasiswa->jurusan ?? 'Tidak diketahui' }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6>PEMBIMBING:</h6>
                                <p>{{ $pembimbing->dosen->nama ?? 'Belum ada pembimbing' }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6>JADWAL KONSULTASI:</h6>
                                <p>{{ $konsultasis->first()->tanggal ?? 'Belum ada jadwal konsultasi' }}</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <h6>Deskripsi:</h6>
                            <p>
                                {{ $judul->deskripsi ?? 'Belum ada deskripsi' }}
                            </p>
                        </div>
                    </div>
                </div>
                <!-- End Progress Skripsi Saya Section -->
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    
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