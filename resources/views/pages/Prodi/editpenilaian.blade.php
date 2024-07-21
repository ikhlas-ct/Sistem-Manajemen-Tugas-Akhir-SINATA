<!-- resources/views/penilaians/edit.blade.php -->
@extends('layout.master')

@section('title', 'Edit Penilaian')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h2>Edit Penilaian</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('prodi.penilaians.update', $penilaian->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="nama">Nama Penilaian</label>
                    <input type="text" name="nama" id="nama" class="form-control" value="{{ $penilaian->nama }}" required>
                </div>
                <div id="pertanyaan-container">
                    @foreach($penilaian->pertanyaans as $index => $pertanyaan)
                        <div class="form-group pertanyaan">
                            <label>Pertanyaan {{ $index + 1 }}</label>
                            <input type="text" name="pertanyaans[{{ $index }}][pertanyaan]" class="form-control mb-1" value="{{ $pertanyaan->pertanyaan }}" placeholder="Pertanyaan" required>
                            <label>Bobot</label>
                            <input type="number" name="pertanyaans[{{ $index }}][bobot]" class="form-control" value="{{ $pertanyaan->bobot }}" placeholder="Bobot" required>
                        </div>
                    @endforeach
                </div>
                <button type="button" class="btn btn-secondary mt-4" id="add-pertanyaan">Tambah Pertanyaan</button>
                <div class="form-group mt-3 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
                
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('add-pertanyaan').addEventListener('click', function() {
        const container = document.getElementById('pertanyaan-container');
        const index = container.getElementsByClassName('pertanyaan').length;
        const pertanyaanItem = document.createElement('div');
        pertanyaanItem.className = 'form-group pertanyaan';
        pertanyaanItem.innerHTML = `
            <label>Pertanyaan ${index + 1}</label>
            <input type="text" name="pertanyaans[${index}][pertanyaan]" class="form-control mb-1" placeholder="Pertanyaan" required>
            <label>Bobot</label>
            <input type="number" name="pertanyaans[${index}][bobot]" class="form-control" placeholder="Bobot" required>
        `;
        container.appendChild(pertanyaanItem);
    });
</script>
@endsection
