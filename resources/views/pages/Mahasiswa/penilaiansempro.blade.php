@extends('layout.master')

@section('title', 'Penilaian Seminar Proposal')

@section('content')
<div class="container">
    <h1>Penilaian Seminar Proposal</h1>
    
    {{-- Accepted Proposal Section --}}
    @if($acceptedProposal)
        <h2>Accepted Seminar Proposal</h2>
        <table class="table" id="acceptedProposalTable">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>Nama Mahasiswa</th>
                    <th>Dosen Penguji 1</th>
                    <th>Dosen Penguji 2</th>
                    <th>Nilai Penguji 1</th>
                    <th>Nilai Penguji 2</th>
                    
                    <th>Status Lulus</th>

                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">1</td>
                    <td>{{ $acceptedProposal->mahasiswaBimbingan->mahasiswa->nama }}</td>
                    <td>{{ $acceptedProposal->dosenPenguji1->nama }}</td>
                    <td>{{ $acceptedProposal->dosenPenguji2->nama }}</td>
                    <td>{{ $acceptedProposal->nilai_penguji_1 }}</td>
                    <td>{{ $acceptedProposal->nilai_penguji_2 }}</td>
                    <td>{{ $acceptedProposal->status_lulus }}</td>
                </tr>
            </tbody>
        </table>
    @else
        <p>No accepted proposal found.</p>
    @endif

        
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
   
        
        $('#acceptedProposalTable').DataTable({
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
