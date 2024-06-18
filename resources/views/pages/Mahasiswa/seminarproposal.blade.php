@extends('layout.master')

@section('title', 'Ajukan Proposal Seminar')

@section('content')
<div class="container">

        <!-- Display accepted proposal details -->
   @if($acceptedProposal)
    <div class="card mt-5">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Rincian Jadwal Seminar Proposal Tugas Akhir</h4>
        </div>
        <div class="card-body">
            <p><strong>NIM:</strong> {{ $acceptedProposal->mahasiswaBimbingan->mahasiswa->nim }}</p>
            <p><strong>Nama:</strong> {{ $acceptedProposal->mahasiswaBimbingan->mahasiswa->nama }}</p>
            <p><strong>Judul:</strong> {{$judulTugasAkhir->judul}} </p>
            <p><strong>Ruangan:</strong> {{ $acceptedProposal->ruangan->nama }}</p>
            <p><strong>Tanggal:</strong> {{ $acceptedProposal->tanggal_waktu->format('d M Y') }}</p>
            <p><strong>Waktu:</strong> {{ $acceptedProposal->tanggal_waktu->format('H:i') }}</p>
            
            <p><strong>Dosen Pembimbing</strong> {{ $acceptedProposal->tanggal_waktu->format('H:i') }}</p>

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
                <th class="text-center">Status</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($seminarProposals as $proposal)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $proposal->mahasiswaBimbingan->mahasiswa->nama }}</td>
                    <td><a href="{{ asset('uploads/seminar_proposals/' . $proposal->file_KHS) }}" target="_blank">Lihat File</a></td>
                    <td><a href="{{ asset('uploads/seminar_proposals/' . $proposal->Kartu_Bimbingan) }}" target="_blank">Lihat File</a></td>
                    <td>
                        @if($proposal->status_prodi == 'ditolak')
                            <span class="badge bg-danger badge-pill">{{ ucfirst($proposal->status_prodi) }}</span>
                        @elseif($proposal->status_prodi == 'diproses')
                            <span class="badge bg-secondary badge-pill">{{ ucfirst($proposal->status_prodi) }}</span>
                        @elseif($proposal->status_prodi == 'diterima')
                            <span class="badge bg-success badge-pill">{{ ucfirst($proposal->status_prodi) }}</span>
                        @endif
                    </td>
                    <td>
                        @if($proposal->status_prodi == 'diproses')
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
