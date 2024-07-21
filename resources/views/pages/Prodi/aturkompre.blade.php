@extends('layout.master')

@section('title', 'Atur Jadwal Seminar Komprehensif')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h2>Atur Jadwal Seminar Komprehensif</h2>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('prodi.setuju.sempro', $SeminarKomprehensif->id) }}" method="POST">
                @csrf
                @method('PUT') <!-- Ubah method dari POST menjadi PUT -->
                <div class="mb-3">
                    <label for="dosen_penguji_1_id" class="form-label">Dosen Penguji 1</label>
                    <select name="dosen_penguji_1_id" id="dosen_penguji_1_id" class="form-select" required>
                        <option value="" disabled selected>Pilih Dosen Penguji 1</option>
                        @foreach($dosens as $dosen)
                            @php
                                $selected1 = ($dosen->id == $SeminarKomprehensif->dosen_penguji_1_id) ? 'selected' : '';
                            @endphp
                            <option value="{{ $dosen->id }}" {{ $selected1 }}>{{ $dosen->nama }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-3">
                    <label for="dosen_penguji_2_id" class="form-label">Dosen Penguji 2</label>
                    <select name="dosen_penguji_2_id" id="dosen_penguji_2_id" class="form-select" required>
                        <option value="" disabled selected>Pilih Dosen Penguji 2</option>
                        @foreach($dosens as $dosen)
                            @php
                                $selected2 = ($dosen->id == $SeminarKomprehensif->dosen_penguji_2_id) ? 'selected' : '';
                            @endphp
                            <option value="{{ $dosen->id }}" {{ $selected2 }}>{{ $dosen->nama }}</option>
                        @endforeach
                    </select>
                </div>
            
                <div class="mb-3">
                    <label for="tanggal_waktu" class="form-label">Tanggal dan Waktu</label>
                    <input type="datetime-local" name="tanggal_waktu" id="tanggal_waktu" class="form-control" required min="{{ date('Y-m-d\TH:i') }}"
                        value="{{ \Carbon\Carbon::parse($SeminarKomprehensif->tanggal_waktu)->format('Y-m-d\TH:i') }}">
                </div>
                
                <div class="mb-3">
                    <label for="ruangan_id" class="form-label">Ruangan</label>
                    <select name="ruangan_id" id="ruangan_id" class="form-select" required>
                        <option value="" disabled selected>Pilih Ruangan</option>
                        @foreach($ruangans as $ruangan)
                            @php
                                $selected = ($ruangan->id == $SeminarKomprehensif->ruangan_id) ? 'selected' : '';
                            @endphp
                            <option value="{{ $ruangan->id }}" {{ $selected }}>{{ $ruangan->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function validateDosenPengujiSelections(dosenPembimbingId) {
        var dosenPenguji1Id = $('#dosen_penguji_1_id').val();
        var dosenPenguji2Id = $('#dosen_penguji_2_id').val();

        // Reset all options to be enabled first
        $('#dosen_penguji_1_id option').show(); // Menampilkan semua opsi
        $('#dosen_penguji_2_id option').show(); // Menampilkan semua opsi

        // Disable selected dosen penguji 1 from dosen penguji 2 options
        if (dosenPenguji1Id) {
            $('#dosen_penguji_2_id option[value="' + dosenPenguji1Id + '"]').hide(); // Menyembunyikan opsi yang sudah dipilih
        }

        // Disable selected dosen penguji 2 from dosen penguji 1 options
        if (dosenPenguji2Id) {
            $('#dosen_penguji_1_id option[value="' + dosenPenguji2Id + '"]').hide(); // Menyembunyikan opsi yang sudah dipilih
        }

        // Ensure dosen pembimbing is not selectable as dosen penguji
        $('#dosen_penguji_1_id option[value="' + dosenPembimbingId + '"]').hide(); // Menyembunyikan opsi dosen pembimbing
        $('#dosen_penguji_2_id option[value="' + dosenPembimbingId + '"]').hide(); // Menyembunyikan opsi dosen pembimbing
    }

    // Call the function to validate dosen penguji selections when changes occur
    $(document).ready(function() {
        validateDosenPengujiSelections({{ optional($SeminarKomprehensif->mahasiswaBimbingan->dosenpembimbing)->dosen_id }});
    });

    // Trigger validation on modal shown
    $('#approvalModal').on('shown.bs.modal', function () {
        validateDosenPengujiSelections({{ optional($SeminarKomprehensif->mahasiswaBimbingan->dosenpembimbing)->dosen_id }});
    });

    // Reset options on modal close
    $('#approvalModal').on('hidden.bs.modal', function () {
        $('#dosen_penguji_1_id, #dosen_penguji_2_id').find('option').show(); // Kembali menampilkan semua opsi
    });

    // Handle change event for dosen penguji 1
    $('#dosen_penguji_1_id').change(function() {
        validateDosenPengujiSelections({{ optional($SeminarKomprehensif->mahasiswaBimbingan->dosenpembimbing)->dosen_id }});
    });

    // Handle change event for dosen penguji 2
    $('#dosen_penguji_2_id').change(function() {
        validateDosenPengujiSelections({{ optional($SeminarKomprehensif->mahasiswaBimbingan->dosenpembimbing)->dosen_id }});
    });
</script>

@endsection
