@extends('layout.master')

@section('title', 'Ajukan Proposal Seminar')

@section('content')
<div class="container">

    <!-- Display accepted proposal details -->
    @if($acceptedProposal)
        <div class="card ">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Rincian Jadwal Seminar Proposal Tugas Akhir</h4>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-3"><strong>NIM</strong></div>
                    <div class="col-md-9">: {{ $acceptedProposal->mahasiswaBimbingan->mahasiswa->nim }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3"><strong>Nama</strong></div>
                    <div class="col-md-9">: {{ $acceptedProposal->mahasiswaBimbingan->mahasiswa->nama }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3"><strong>Judul</strong></div>
                    <div class="col-md-9">: {{ $judulTugasAkhir->judul ?? '-' }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3"><strong>Ruangan</strong></div>
                    <div class="col-md-9">: {{ $acceptedProposal->ruangan->nama }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3"><strong>Tanggal</strong></div>
                    <div class="col-md-9">: {{ $acceptedProposal->tanggal_waktu->format('d M Y') }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3"><strong>Waktu</strong></div>
                    <div class="col-md-9">: {{ $acceptedProposal->tanggal_waktu->format('H:i') }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3"><strong>Dosen Pembimbing</strong></div>
                    <div class="col-md-9">: {{ $acceptedProposal->mahasiswaBimbingan->dosenPembimbing->dosen->nama }}</div>
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
                        <td>{{ $acceptedProposal->dosenPenguji1->nidn }}</td>
                        <td>{{ $acceptedProposal->dosenPenguji1->nama }}</td>
                        <td>Penguji 1</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>{{ $acceptedProposal->dosenPenguji2->nidn }}</td>
                        <td>{{ $acceptedProposal->dosenPenguji2->nama }}</td>
                        <td>Penguji 2</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    @else
    <!-- Loop through seminarProposals to display status messages -->
    @foreach($seminarProposals as $proposal)
    @if($proposal->validasi_pembimbing == 'diproses' || $proposal->validasi_pembimbing == 'valid')
    @if($proposal->status_prodi == 'diproses' || $proposal->status_prodi == 'diterima')
        @if($proposal->validasi_pembimbing == 'diproses')

        <div class="alert alert-info mt-5 border-3 border-primary" role="alert">
            <i class="fas fa-exclamation-circle" style="font-size: 1.5rem;"></i> 
            <span style="font-size: 1.5rem;" class="fw-bold">Informasi</span> <br>
            🔄 Pengajuan Seminar Proposal Mu sedang Diproses. Hubungi Dosen Pembimbing Mu untuk memintak Validasi.
        </div>
    @elseif($proposal->validasi_pembimbing == 'valid')
        <div class="alert alert-success mt-5 border-4 border-success" role="alert">
            <i class="fas fa-exclamation-circle" style="font-size: 1.5rem;"></i> 
            <span style="font-size: 1.5rem; "class="fw-bold">Informasi</span> <br>
            <br>    ✅ Pengajuan Seminar Proposal Mu sudah tervalidasi oleh Dosen Pembimbing. Hubungi prodi mu untuk memintak jadwal Seminar mu.
        </div>
    @endif
    @endif
@endif
@endforeach
































@endif

    <h2>Ajukan Proposal Seminar</h2>
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
                <th class="text-center">Mahasiswa Bimbingan</th>
                <th class="text-center">File KHS</th>
                <th class="text-center">Kartu Bimbingan</th>
                <th class="text-center">Validasi Pembimbing</th>
                <th class="text-center">Status Seminar</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($seminarProposals as $proposal)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $proposal->mahasiswaBimbingan->mahasiswa->nama }}</td>
                    <td class="text-center"><a href="{{ asset('uploads/seminar_proposals/' . $proposal->file_KHS) }}" target="_blank">                            <i class="fas fa-file fa-2x text-success"></i>
                    </a></td>
                    <td class="text-center"><a href="{{ asset('uploads/seminar_proposals/' . $proposal->Kartu_Bimbingan) }}" target="_blank"><i class="fas fa-file fa-2x text-success"></i>
                    </a></td>
            
                    <td class="text-center">
                        @if($proposal->validasi_pembimbing == 'ditolak')
                            <span class="badge bg-danger badge-pill">{{ ucfirst($proposal->validasi_pembimbing) }}</span>
                        @elseif($proposal->validasi_pembimbing == 'diproses')
                            <span class="badge bg-secondary badge-pill">{{ ucfirst($proposal->validasi_pembimbing) }}</span>
                        @elseif($proposal->validasi_pembimbing == 'valid')
                            <span class="badge bg-success badge-pill">{{ ucfirst($proposal->validasi_pembimbing) }}</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($proposal->status_prodi == 'direvisi')
                            <span class="badge bg-danger badge-pill">{{ ucfirst($proposal->status_prodi) }}</span>
                        @elseif($proposal->status_prodi == 'diproses')
                            <span class="badge bg-secondary badge-pill">{{ ucfirst($proposal->status_prodi) }}</span>
                        @elseif($proposal->status_prodi == 'diterima')
                            <span class="badge bg-success badge-pill">{{ ucfirst($proposal->status_prodi) }}</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($proposal->validasi_pembimbing == 'diproses')
                            <form action="{{ route('mahasiswa_proposal.destroy', $proposal->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus proposal ini?');">
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
                <form action="{{ route('mahasiswa_proposal.store') }}" method="POST" enctype="multipart/form-data">
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
                        <label for="file_KHS" class="form-label">File KHS</label>
                        <input type="file" class="form-control" id="file_KHS" name="file_KHS" required>
                    </div>
                    <div class="mb-3">
                        <label for="Kartu_Bimbingan" class="form-label">Kartu Bimbingan</label>
                        <input type="file" class="form-control" id="Kartu_Bimbingan" name="Kartu_Bimbingan" required>
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
