<!-- resources/views/pages/Mahasiswa/print_konsultasi.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title class="no-print">Print Konsultasi Bimbingan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            border: 1px solid #000;
            padding: 20px;
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
        @media print {
            .no-print {
                display: none; 
            }
            .print-title {
                display: none; 
            }
        }
        hr {
            border: none; /* Menghapus border bawaan hr */
            border-top: 1px solid #000; /* Membuat garis dengan tebal 2px dan warna hitam */
            margin: 10px 0; /* Memberikan margin atas dan bawah */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div>
                <img src="{{ asset('assets/images/logos/universitylogo.png') }}" alt="Logo" class="img-fluid">
            </div>
            <div class="header-content">
                <h3>KEMENTERIAN PENDIDIKAN DAN KEBUDAYAAN<br>UNIVERSITAS SINATA<br>FAKULTAS KEGURUAN DAN ILMU PENDIDIKAN</h3>
                <p>Jalan Raya Palembang - Prabumulih Indralaya, Ogan Ilir 30662<br>Telp: (0711) 580058, 580085 Fax: (0711) 580058<br>Laman: www.fkip.unsri.ac.id, email: support@fkip.unsri.ac.id</p>
            </div>
        </div>
        <hr >
        <hr>
        <h2 style="text-align: center">Kartu Bimbingan Skripsi</h2>
        <div class="content" style="display: grid; grid-template-columns: 150px auto;">
            <p style="margin-bottom: 8px;">Nama Mahasiswa</p>
            <p style="margin-bottom: 8px;">:{{ $mahasiswa->nama }}</p>
            
            <p style="margin-bottom: 8px;">NIM</p>
            <p style="margin-bottom: 8px;">:{{ $mahasiswa->nim }}</p>
            
            <p style="margin-bottom: 8px;">Jurusan</p>
            <p style="margin-bottom: 8px;">:{{ $mahasiswa->fakultas }}</p>
            
            <p style="margin-bottom: 8px;">Judul Proposal</p>
            <p style="margin-bottom: 8px;">:{{ $judulTugasAkhir->judul }}</p>
            
            <p style="margin-bottom: 8px;">Pembimbing</p>
            <p style="margin-bottom: 8px;">:{{ $mahasiswaBimbingans[0]->dosenPembimbing->dosen->nama }}</p>
        </div>
        
        <table class="table">
            <thead>
                <tr>
                    <th style="text-align: center;">No</th>
                    <th style="text-align: center;">Tanggal</th>
                    <th style="text-align: center;">Pokok Bahasan</th>
                    <th style="text-align: center;">Pembahasan</th>
                    <th style="text-align: center;">Status</th> <!-- Using status as the signature of the supervisor -->
                </tr>
            </thead>
            <tbody>
                    @php
                    use Carbon\Carbon;
                    @endphp
                @foreach($konsultasis as $key => $konsultasi)
                    @if ($konsultasi->status === 'Diterima')
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ Carbon::parse($konsultasi->tanggal)->format('d/m/y') }}</td>
                            <td>{{ $konsultasi->topik }}</td>
                            <td>{{ $konsultasi->Pembahasan }}</td>
                            <td style="text-align: center">{{ $konsultasi->status }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
