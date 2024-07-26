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
                            <li class="step {{ $logbooks->count() > 2 ? 'completed' : '' }}">
                                <div class="step-number">3</div>
                                <div class="step-label">Logbook 1 dan 3</div>
                            </li>
                            <li class="step {{ $seminarProposal ? 'completed' : '' }}">
                                <div class="step-number">4</div>
                                <div class="step-label">Seminar Proposal</div>
                            </li>
                            <li class="step {{ $logbooks->count() > 5 ? 'completed' : '' }}">
                                <div class="step-number">5</div>
                                <div class="step-label">Logbook 4 dan 5</div>
                            </li>
                            <li class="step {{ $seminarKomprehensif ? 'completed' : '' }}">
                                <div class="step-number">6</div>
                                <div class="step-label">Seminar Komprehensif</div>
                            </li>
                            <li class="step {{ $judul && $seminarKomprehensif && $seminarProposal && $konsultasis->count() > 0 ? 'completed' : '' }}">
                                <div class="step-number">7</div>
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
                                <p>{{ $mahasiswa->fakultas }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6>PEMBIMBING:</h6>
                                <p>{{ $mahasiswaBimbingans->isEmpty() ? 'Belum ditentukan' : $mahasiswaBimbingans[0]->dosenPembimbing->dosen->nama }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6>JADWAL KONSULTASI:</h6>
                                <p>{{ $konsultasis->count() > 0 ? $konsultasis->last()->tanggal : 'Belum ada jadwal' }}</p>
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

@section('styles')
<style>
    .progress-container {
    position: relative;
    width: 100%;
    margin-bottom: 20px;
}

.progress-steps {
    list-style: none;
    display: flex;
    justify-content: space-between;
    padding: 0;
    margin: 0;
    position: relative;
}

.progress-steps .step {
    text-align: center;
    position: relative;
    flex: 1;
}

.progress-steps .step:not(:last-child)::after {
    content: '';
    position: absolute;
    top: 20px;
    right: -50%;
    width: calc(100% + 20px);
    height: 4px;
    background-color: #ddd;
    z-index: 0;
}

.progress-steps .step.completed::after {
    background-color: #00ff44;
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
    background-color: #00ff44;
    color: white;
}

.progress-steps .step .step-label {
    font-size: 14px;
    color: #333;
}

</style>
@endsection
