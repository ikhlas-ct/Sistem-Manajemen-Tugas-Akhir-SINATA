@extends('layout.master')

@section('title', 'Penilaian Ujian Komprehensif')

@section('content')
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white text-center">
            <h2>Form Penilaian Ujian Komprehensif</h2>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-12">
                    <p><strong>Nama Mahasiswa:</strong> {{ $komprehensif->mahasiswaBimbingan->mahasiswa->nama }}</p>
                    <p><strong>NIM:</strong> {{ $komprehensif->mahasiswaBimbingan->mahasiswa->nim }}</p>
                    <p><strong>Judul:</strong> {{ $komprehensif->mahasiswaBimbingan->acceptedJudulTugasAkhirs->judul }}</p>
                    <p><strong>Jadwal Ujian:</strong> {{ \Carbon\Carbon::parse($komprehensif->tanggal_waktu)->format('M d, Y \a\t h:i A') }}</p>
                    <p><strong>Pembimbing:</strong> {{ $komprehensif->mahasiswaBimbingan->dosenPembimbing->dosen->nama ?? 'Tidak Ada Pembimbing' }}</p>
                    <p><strong>Penguji 1:</strong> {{ $komprehensif->dosenPenguji1->nama }}</p>
                    <p><strong>Penguji 2:</strong> {{ $komprehensif->dosenPenguji2->nama }}</p>
                </div>
            </div>

            <form action="{{ route('dosen_komprehensif.penilaian.store', $komprehensif->id) }}" method="POST" id="penilaianForm" onsubmit="return confirmSubmit()">
                @csrf
                @method('POST')

                @foreach($penilaians as $penilaian)
                    <fieldset class="border rounded p-3 mb-4">
                        <legend class="w-auto px-2">{{ $penilaian->nama }}</legend>
                        @foreach($penilaian->pertanyaans as $pertanyaan)
                        <div class="form-group mb-3">
                            <label>{{ $pertanyaan->pertanyaan }}</label>
                            <input type="number" name="penilaians[{{ $penilaian->id }}][pertanyaans][{{ $pertanyaan->id }}]" class="form-control" value="{{ old('penilaians.'.$penilaian->id.'.pertanyaans.'.$pertanyaan->id) ?? $existingPenilaians->get($penilaian->id . '.' . $pertanyaan->id)->nilai ?? '' }}" required min="0" max="100">
                            @error('penilaians.'.$penilaian->id.'.pertanyaans.'.$pertanyaan->id)
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    @endforeach
                    
                    </fieldset>
                @endforeach

                @if(auth()->id() === $komprehensif->dosen_penguji_1_id)
                    <div class="form-group mb-4">
                        <label for="komentar_penguji_1">Komentar Penguji 1</label>
                        <textarea name="komentar_penguji_1" id="komentar_penguji_1" class="form-control" rows="4">{{ old('komentar_penguji_1') ?? $komprehensif->komentar_penguji_1 }}</textarea>
                    </div>
                @elseif(auth()->id() === $komprehensif->dosen_penguji_2_id)
                    <div class="form-group mb-4">
                        <label for="komentar_penguji_2">Komentar Penguji 2</label>
                        <textarea name="komentar_penguji_2" id="komentar_penguji_2" class="form-control" rows="4">{{ old('komentar_penguji_2') ?? $komprehensif->komentar_penguji_2 }}</textarea>
                    </div>
                @endif

                <div class="form-group d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    fieldset {
        margin-bottom: 20px;
        border: 1px solid #ddd;
    }
    legend {
        font-size: 1.2em;
        font-weight: bold;
        margin-bottom: 10px;
        color: #007bff;
    }
    strong {
        min-width: 150px;
        display: inline-block;
        text-align: left;
        margin-right: 1em;
    }
    .form-control {
        border-radius: 0.25rem;
        border: 1px solid #ced4da;
    }
    .form-group label {
        font-weight: 600;
    }
</style>
@endsection

@section('scripts')
<script>
    function confirmSubmit() {
        return confirm("Apakah Anda yakin ingin menyimpan nilai ini?");
    }
</script>
@endsection
