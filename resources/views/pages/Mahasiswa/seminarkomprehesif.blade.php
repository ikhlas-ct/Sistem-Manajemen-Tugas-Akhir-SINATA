@extends('layout.master')

@section('title', 'Ajukan Proposal Seminar Komprehensif')

@section('content')
<div class="container">

    <!-- Display accepted proposal details -->
    @if($acceptedKomprehensif)
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Rincian Jadwal Seminar Komprehensif</h4>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-3"><strong>NIM</strong></div>
                    <div class="col-md-9">: {{ $acceptedKomprehensif->mahasiswaBimbingan->mahasiswa->nim }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3"><strong>Nama</strong></div>
                    <div class="col-md-9">: {{ $acceptedKomprehensif->mahasiswaBimbingan->mahasiswa->nama }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3"><strong>Judul</strong></div>
                    <div class="col-md-9">: {{ $judulTugasAkhir->judul ?? '-' }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3"><strong>Ruangan</strong></div>
                    <div class="col-md-9">: {{ $acceptedKomprehensif->ruangan->nama }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3"><strong>Tanggal</strong></div>
                    <div class="col-md-9">: {{ \Carbon\Carbon::parse($acceptedKomprehensif->tanggal_waktu)->format('d M Y') }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3"><strong>Waktu</strong></div>
                    <div class="col-md-9">: {{ \Carbon\Carbon::parse($acceptedKomprehensif->tanggal_waktu)->format('H:i') }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3"><strong>Dosen Pembimbing</strong></div>
                    <div class="col-md-9">: {{ $acceptedKomprehensif->mahasiswaBimbingan->dosenPembimbing->dosen->nama }}</div>
                </div>
            </div>

            <table class="table table-bordered mt-3">
                <thead>
                    <tr class="bg-success text-white">
                        <th>No</th>
                        <th>NIDN</th>
                        <th>Nama Dosen</th>
                        <th>Sebagai Dosen</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>{{ $acceptedKomprehensif->dosenPenguji1->nidn }}</td>
                        <td>{{ $acceptedKomprehensif->dosenPenguji1->nama }}</td>
                        <td>Penguji 1</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>{{ $acceptedKomprehensif->dosenPenguji2->nidn }}</td>
                        <td>{{ $acceptedKomprehensif->dosenPenguji2->nama }}</td>
                        <td>Penguji 2</td>
                    </tr>
                </tbody>
            </table>
        </div>
    @else
        <!-- Loop through seminarProposals to display status messages -->
        @foreach($SeminarKomprehensifs as $kompre)
        @if($kompre->validasi_pembimbing == 'diproses' || $kompre->validasi_pembimbing == 'valid')
            @if($kompre->status_prodi == 'diproses' || $kompre->status_prodi == 'diterima')
                @if($kompre->validasi_pembimbing == 'diproses')
                    <div class="alert alert-info mt-5 border-3 border-primary" role="alert">
                        <i class="fas fa-exclamation-circle" style="font-size: 1.5rem;"></i>
                        <span style="font-size: 1.5rem;" class="fw-bold">Informasi</span> <br>
                        🔄 Pengajuan Seminar Komprehensif Mu sedang Diproses. Hubungi Dosen Pembimbing Mu untuk meminta Validasi.
                    </div>
                @elseif($kompre->validasi_pembimbing == 'valid')
                    <div class="alert alert-success mt-5 border-4 border-success" role="alert">
                        <i class="fas fa-exclamation-circle" style="font-size: 1.5rem;"></i>
                        <span style="font-size: 1.5rem;" class="fw-bold">Informasi</span> <br>
                        ✅ Pengajuan Seminar Komprehensif Mu sudah tervalidasi oleh Dosen Pembimbing. Hubungi prodi mu untuk meminta jadwal Seminar mu.
                    </div>
                @endif
            @endif
        @endif
    @endforeach
    
    @endif

    <h2>Ajukan Seminar Komprehensif</h2>
    <hr>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#createProposalModal">
        <i class="fas fa-plus"></i> Ajukan Proposal
    </button>

    <!-- Table to display proposals -->
    <table id="proposalTable" class="table table-bordered">
        <thead>
            <tr>
                <th class="text-center">NO</th>
                <th class="text-center">File Transkrip Nilai</th>
                <th class="text-center">Kartu Bimbingan</th>
                <th class="text-center">Sertifikat PKL</th>
                <th class="text-center">KRS</th>
                <th class="text-center">Validasi Pembimbing</th>
                <th class="text-center">Status Ujian</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($SeminarKomprehensifs as $kompre)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center"><a href="{{ asset('uploads/seminar_komprehensif/' . $kompre->transkrip_nilai) }}" target="_blank"><i class="fas fa-file fa-2x text-success"></i></a></td>
                    <td class="text-center"><a href="{{ asset('uploads/seminar_komprehensif/' . $kompre->Kartu_Bimbingan) }}" target="_blank"><i class="fas fa-file fa-2x text-success"></i></a></td>
                    <td class="text-center"><a href="{{ asset('uploads/seminar_komprehensif/' . $kompre->sertifikat_pkl) }}" target="_blank"><i class="fas fa-file fa-2x text-success"></i></a></td>
                    <td class="text-center"><a href="{{ asset('uploads/seminar_komprehensif/' . $kompre->KRS) }}" target="_blank"><i class="fas fa-file fa-2x text-success"></i></a></td>

                    <td class="text-center">
                        @if($kompre->validasi_pembimbing == 'ditolak')
                            <span class="badge bg-danger badge-pill">{{ ucfirst($kompre->validasi_pembimbing) }}</span>
                        @elseif($kompre->validasi_pembimbing == 'diproses')
                            <span class="badge bg-secondary badge-pill">{{ ucfirst($kompre->validasi_pembimbing) }}</span>
                        @elseif($kompre->validasi_pembimbing == 'valid')
                            <span class="badge bg-success badge-pill">{{ ucfirst($kompre->validasi_pembimbing) }}</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($kompre->status_prodi == 'direvisi')
                            <span class="badge bg-danger badge-pill">{{ ucfirst($kompre->status_prodi) }}</span>
                        @elseif($kompre->status_prodi == 'diproses')
                            <span class="badge bg-secondary badge-pill">{{ ucfirst($kompre->status_prodi) }}</span>
                        @elseif($kompre->status_prodi == 'diterima')
                            <span class="badge bg-success badge-pill">{{ ucfirst($kompre->status_prodi) }}</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($kompre->validasi_pembimbing == 'diproses')
                            <form action="{{ route('seminar_komprehensif.destroy', $kompre->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash-alt"></i> Hapus
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal Create Proposal -->
<div class="modal fade" id="createProposalModal" tabindex="-1" aria-labelledby="createProposalModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createProposalModalLabel">Ajukan Proposal Seminar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('seminar_komprehensif.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="mahasiswa_bimbingan_id" class="form-label">Mahasiswa Bimbingan</label>
                        <select class="form-select" id="mahasiswa_bimbingan_id" name="mahasiswa_bimbingan_id" required>
                            @foreach ($mahasiswaBimbingans as $bimbingan)
                                <option value="{{ $bimbingan->id }}">{{ $bimbingan->mahasiswa->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="transkrip_nilai" class="form-label">Transkrip Nilai</label>
                        <input type="file" class="form-control" id="transkrip_nilai" name="transkrip_nilai" required>
                    </div>
                    <div class="mb-3">
                        <label for="Kartu_Bimbingan" class="form-label">Kartu Bimbingan</label>
                        <input type="file" class="form-control" id="Kartu_Bimbingan" name="Kartu_Bimbingan" required>
                    </div>
                    <div class="mb-3">
                        <label for="sertifikat_pkl" class="form-label">Sertifikat PKL</label>
                        <input type="file" class="form-control" id="sertifikat_pkl" name="sertifikat_pkl" required>
                    </div>
                    <div class="mb-3">
                        <label for="KRS" class="form-label">KRS</label>
                        <input type="file" class="form-control" id="KRS" name="KRS" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Ajukan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#proposalTable').DataTable({
            "pagingType": "full_numbers",
            "language": {
                "search": "Cari:",
                "paginate": {
                    "first": "Awal",
                    "last": "Akhir",
                    "next": "Berikutnya",
                    "previous": "Sebelumnya"
                }
            },
            "dom": '<"top"lf>rt<"bottom"ip><"clear">'
        });
    });
</script>
@endsection
