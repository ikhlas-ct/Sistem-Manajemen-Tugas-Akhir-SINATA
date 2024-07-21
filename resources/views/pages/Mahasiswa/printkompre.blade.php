<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device=device-width, initial-scale=1.0">
    <title>Print Penilaian Seminar Komprehensif</title>
    <style>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #000;
        }
        .header {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header img {
            width: 125px;
        }
        .header h3, .header p {
            text-align: center;
            margin: 0;
        }
        .header .header-content {
            flex: 1;
            padding: 0 20px;
        }
        .info {
            display: grid;
            grid-template-columns: 150px auto;
            gap: 8px 16px;
            margin-top: 20px;
        }
        .info p {
            margin: 0;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .table th, .table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        .table th {
            background-color: #f2f2f2;
        }
        .criteria {
            margin-top: 20px;
            font-weight: bold;
        }
        .comments, .final-score {
            margin-top: 20px;
            border: 1px solid #000;
            padding: 10px;
        }
        .comments h4, .final-score h4 {
            text-align: center;
            margin-top: 0;
        }
        @media print {
            .no-print {
                display: none;
            }
            .print-title {
                display: none;
            }
            .page-break {
                page-break-before: always;
            }
        }
        hr {
            border: none;
            border-top: 1px solid #000;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header mt-30" style="border-bottom: 2px solid black; padding-bottom: 10px;">
            <div>
                <img src="{{ asset('assets/images/logos/universitylogo.png') }}" alt="Logo" class="img-fluid">
            </div>
            <div class="header-content" style="text-align: center;">
                <h4 style="margin: 0;">KEMENTERIAN PENDIDIKAN DAN KEBUDAYAAN<br>UNIVERSITAS SINATA<br>FAKULTAS KEGURUAN DAN ILMU PENDIDIKAN</h4>
                <p style="margin: 0;">Jalan Khatib Sulaiman - Lolong Belanti, Kota Padang 25173<br>Telp: (0711) 580058, 580085 Fax: (0711) 580058<br>Laman: https://SINATA.ac.id/, email: support@SINATA.ac.id</p>
            </div>
        </div>
        <h4 style="text-align: center">PENILAIAN SEMINAR KOMPREHENSIF</h4>
        <div class="info">
            <p>Nama Mahasiswa</p>
            <p>: {{ $acceptedProposal->mahasiswaBimbingan->mahasiswa->nama }}</p>
            <p>NIM</p>
            <p>: {{ $acceptedProposal->mahasiswaBimbingan->mahasiswa->nim }}</p>
            <p>Program Studi</p>
            <p>: {{ $acceptedProposal->mahasiswaBimbingan->mahasiswa->fakultas }}</p>
            <p>Hari/Tanggal</p>
            <p>: {{ \Carbon\Carbon::parse($acceptedProposal->tanggal_waktu)->isoFormat('dddd, D MMMM YYYY') }}</p>
            <p>Penguji 1</p>
            <p>: {{ $acceptedProposal->dosenPenguji1->nama }}</p>
            <p>Penguji 2</p>
            <p>: {{ $acceptedProposal->dosenPenguji2->nama }}</p>
            <p>Judul Proposal</p>
            <p>: {{ $acceptedJudulTugasAkhir->judul }}</p>
        </div>

        @php
            $criteriaQuestions = [];
            $criteriaLetters = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I'];
        @endphp
        @foreach($acceptedProposal->penilaianSeminarKomprehensif as $penilaian)
            @php
                $criteriaName = $penilaian->pertanyaan->penilaian->nama;
                $questionText = $penilaian->pertanyaan->pertanyaan;
                $bobot = $penilaian->pertanyaan->bobot;
                $penguji1Score = $penilaian->dosen_id == $acceptedProposal->dosen_penguji_1_id ? $penilaian->nilai : null;
                $penguji2Score = $penilaian->dosen_id == $acceptedProposal->dosen_penguji_2_id ? $penilaian->nilai : null;

                if (!isset($criteriaQuestions[$criteriaName])) {
                    $criteriaQuestions[$criteriaName] = [];
                }

                if (!isset($criteriaQuestions[$criteriaName][$questionText])) {
                    $criteriaQuestions[$criteriaName][$questionText] = [
                        'bobot' => $bobot,
                        'nilaiPenguji1' => $penguji1Score,
                        'nilaiPenguji2' => $penguji2Score,
                    ];
                } else {
                    if ($penguji1Score !== null) {
                        $criteriaQuestions[$criteriaName][$questionText]['nilaiPenguji1'] = $penguji1Score;
                    }
                    if ($penguji2Score !== null) {
                        $criteriaQuestions[$criteriaName][$questionText]['nilaiPenguji2'] = $penguji2Score;
                    }
                }
            @endphp
        @endforeach
        
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Pertanyaan</th>
                    <th>Bobot</th>
                    <th>Nilai Penguji 1</th>
                    <th>Nilai Penguji 2</th>
                </tr>
            </thead>
            <tbody>
                @php $index = 1; $criteriaIndex = 0; @endphp
                @foreach($criteriaQuestions as $criteria => $questions)
                    <tr>
                        <td colspan="5" class="criteria">{{ $criteriaLetters[$criteriaIndex++] }}.{{ $criteria }}</td>
                    </tr>
                    @foreach($questions as $question => $nilai)
                        <tr>
                            <td>{{ $index++ }}</td>
                            <td>{{ $question }}</td>
                            <td>{{ $nilai['bobot'] }}</td>
                            <td>{{ $nilai['nilaiPenguji1'] ?? '-' }}</td>
                            <td>{{ $nilai['nilaiPenguji2'] ?? '-' }}</td>
                        </tr>
                    @endforeach
                @endforeach
                <tr>
                    <td colspan="2"><strong>Total </strong></td>
                    <td><strong>{{ $totalBobotDosenPenguji1 }}</strong></td>
                    <td><strong>{{ number_format($totalNilaiDosenPenguji1, 0) }}</strong></td>
                    <td><strong>{{ number_format($totalNilaiDosenPenguji2, 0) }}</strong></td>
                </tr>
            </tbody>
        </table>

        <!-- Signature Section -->
        <div class="signature-section" style="margin-top: 20px; display: flex; justify-content: space-between;">
            <div class="signature" style="text-align: center; flex: 1; margin-right: 20px;">
                <p style="margin-bottom: 100px;"><strong>Dosen Penguji 1</strong></p>
                <p style="font-weight: bold; margin: 0;">{{ $acceptedProposal->dosenPenguji1->nama }}</p>
                <p style="font-weight: bold; margin: 0; display: inline-block; border-top: 1px solid #000; padding-top: 5px;">NIDN: {{ $acceptedProposal->dosenPenguji1->nidn }}</p>
            </div>
            <div class="signature" style="text-align: center; flex: 1; margin-left: 20px;">
                <p style="margin-bottom: 100px;"><strong>Dosen Penguji 2</strong></p>
                <p style="font-weight: bold; margin: 0;">{{ $acceptedProposal->dosenPenguji2->nama }}</p>
                <p style="font-weight: bold; margin: 0; display: inline-block; border-top: 1px solid #000; padding-top: 5px;">NIDN: {{ $acceptedProposal->dosenPenguji2->nidn }}</p>
            </div>
        </div>
    </div>

    <div class="container">

        <div class="page-break"></div>
        <div class="header mt-30" style="border-bottom: 2px solid black; padding-bottom: 10px;">
            <div>
                <img src="{{ asset('assets/images/logos/universitylogo.png') }}" alt="Logo" class="img-fluid">
            </div>
            <div class="header-content" style="text-align: center;">
                <h4 style="margin: 0;">KEMENTERIAN PENDIDIKAN DAN KEBUDAYAAN<br>UNIVERSITAS SINATA<br>FAKULTAS KEGURUAN DAN ILMU PENDIDIKAN</h4>
                <p style="margin: 0;">Jalan Khatib Sulaiman - Lolong Belanti, Kota Padang 25173<br>Telp: (0711) 580058, 580085 Fax: (0711) 580058<br>Laman: https://SINATA.ac.id/, email: support@SINATA.ac.id</p>
            </div>
        </div>
        
    
        <h4 style="text-align: center">KEPUTUSAN PENILAIAN SEMINAR PROPOSAL SKRIPSI</h4>
        <div class="info">
            <p>Nama Mahasiswa</p>
            <p>: {{ $acceptedProposal->mahasiswaBimbingan->mahasiswa->nama }}</p>
            <p>NIM</p>
            <p>: {{ $acceptedProposal->mahasiswaBimbingan->mahasiswa->nim }}</p>
            <p>Judul Proposal</p>
            <p>: {{ $acceptedJudulTugasAkhir->judul }}</p>
        </div>
    
        <div class="comments">
            <h4>Proposal Yang Direvisi</h4>
            <hr>
            @if(!empty($acceptedProposal->komentar_penguji_1))
                <p><strong>Revisi Penguji 1:</strong> {{ $acceptedProposal->komentar_penguji_1 }}</p>
            @else
                <p><strong>Revisi Penguji 1:</strong> -</p>
            @endif
            @if(!empty($acceptedProposal->komentar_penguji_2))
                <p><strong>Revisi Penguji 2:</strong> {{ $acceptedProposal->komentar_penguji_2 }}</p>
            @else
                <p><strong>Revisi Penguji 2:</strong> -</p>
            @endif
        </div>
        
    
        <div class="final-score">
            <h4>Nilai Akhir</h4>
            <hr>
            <p><strong>Nilai Rata-Rata:</strong> Nilai Akhir = (Σ (Nilai × Bobot)) / Σ Bobot</p>
            <table class="score-table">
                <tr>
                    <td>Total Nilai Penguji 1</td>
                    <td>: {{ number_format($nilaiAkhirDosenPenguji1, 2) }}</td>
                </tr>
                <tr>
                    <td>Total Nilai Penguji 2</td>
                    <td>: {{ number_format($nilaiAkhirDosenPenguji2, 2) }}</td>
                </tr>
                <tr>
                    <td>Nilai Rata-rata</td>
                    <td>: {{ number_format($totalNilaiAkhr, 2) }}</td>
                </tr>
                <tr>
                    <td>Status Lulus</td>
                    <td>: {{ $statusLulus }}</td>
                </tr>
            </table>
        </div>
        <!-- Signature Section -->
    <div class="signature-section" style="margin-top: 20px; display: flex; justify-content: space-between;">
        <div class="signature" style="text-align: center; flex: 1; margin-right: 20px;">
            <p style="margin-bottom: 100px;"><strong>Dosen Penguji 1</strong></p>
            <p style="font-weight: bold; margin: 0; ">{{ $acceptedProposal->dosenPenguji1->nama }}</p>
            <p style="font-weight: bold; margin: 0; display: inline-block; border-top: 1px solid #000; padding-top: 5px;">NIDN: {{ $acceptedProposal->dosenPenguji1->nidn }}</p>
        </div>
        <div class="signature" style="text-align: center; flex: 1; margin-left: 20px;">
            <p style="margin-bottom: 100px;"><strong>Dosen Penguji 2</strong></p>
            <p style="font-weight: bold; margin: 0;">{{ $acceptedProposal->dosenPenguji2->nama }}</p>
            <p style="font-weight: bold; margin: 0; display: inline-block; border-top: 1px solid #000; padding-top: 5px;">NIDN: {{ $acceptedProposal->dosenPenguji2->nidn }}</p>
        </div>
    </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
