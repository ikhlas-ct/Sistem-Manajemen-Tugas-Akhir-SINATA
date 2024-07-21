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
                    <th>No</th>
                    <th>Dosen Penguji 1</th>
                    <th>Dosen Penguji 2</th>
                    <th>Nilai Penguji 1</th>
                    <th>Nilai Penguji 2</th>
                    <th>Total Nilai</th> <!-- Kolom baru -->
                    <th>Status Lulus</th>
                    <th>Detail Print</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">1</td>
                    <td>{{ $acceptedProposal->dosenPenguji1->nama }}</td>
                    <td>{{ $acceptedProposal->dosenPenguji2->nama }}</td>
                    <td>{{ number_format($nilaiAkhirDosenPenguji1, 2) }}</td>
                    <td>{{ number_format($nilaiAkhirDosenPenguji2, 2) }}</td>
                    <td>{{ number_format(($nilaiAkhirDosenPenguji1 + $nilaiAkhirDosenPenguji2) / 2, 2) }}</td> <!-- Kolom baru -->
                    <td>{{ $statusLulus }}</td>
                    <td>
                        <a href="{{ route('mahasiswa_print_proposal', $acceptedProposal->id) }}" class="btn btn-info" target="_blank">
                            <i class="fas fa-print"></i> Print
                        </a>
                    </td>
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
