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
                                <li class="step {{ $judul ? 'completed' : '' }}">
                                    <div class="step-number">1</div>
                                    <div class="step-label">Pemilihan Pembimbing</div>
                                </li>
                                <li class="step {{ $konsultasis->count() > 0 ? 'completed' : '' }}">
                                    <div class="step-number">2</div>
                                    <div class="step-label">Proses Bimbingan Skripsi</div>
                                </li>
                                <li class="step {{ $seminarProposal ? 'completed' : '' }}">
                                    <div class="step-number">3</div>
                                    <div class="step-label">Seminar Proposal</div>
                                </li>
                                <li class="step {{ $seminarKomprehensif ? 'completed' : '' }}">
                                    <div class="step-number">4</div>
                                    <div class="step-label">Seminar Komprehensif</div>
                                </li>
                                <li class="step {{ $judul && $seminarKomprehensif && $seminarProposal && $konsultasis->count() > 0 ? 'completed' : '' }}">
                                    <div class="step-number">5</div>
                                    <div class="step-label">Selesai</div>
                                </li>
                            </ul>
                        </div>

                        <div class="skripsi-details mt-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>JUDUL:</h6>
                                    <p>{{ $judul ? $judul->judul : 'Belum ditentukan' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h6>Jurusan:</h6>
                                    <p>{{ $mahasiswa->jurusan }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h6>PEMBIMBING:</h6>
                                    <p>{{ $pembimbing ? $pembimbing->nama : 'Belum ditentukan' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h6>JADWAL KONSULTASI:</h6>
                                    <p>{{ $konsultasis->count() > 0 ? $konsultasis->last()->jadwal_konsultasi : 'Belum ada jadwal' }}</p>
                                </div>
                            </div>
                            <div class="mt-4">
                                <h6>Deskripsi:</h6>
                                <p>
                                    {{ $judul ? $judul->deskripsi : 'Belum ada deskripsi' }}
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
