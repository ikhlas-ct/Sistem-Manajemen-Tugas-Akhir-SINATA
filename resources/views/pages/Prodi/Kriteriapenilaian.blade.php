<!-- resources/views/penilaians/create.blade.php -->
@extends('layout.master')

@section('title', 'Tambah Penilaian')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h2>Tambah Penilaian</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('prodi.penilaians.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nama">Nama Penilaian</label>
                    <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama Penilaian" required>
                </div>
                <div id="pertanyaan-container">
                    <div class="form-group pertanyaan">
                        <label>Pertanyaan 1</label>
                        <input type="text" name="pertanyaans[0][pertanyaan]" class="form-control mb-1" placeholder="Pertanyaan" required>
                        <label>Bobot</label>
                        <input type="number" name="pertanyaans[0][bobot]" class="form-control" placeholder="Bobot" required>
                    </div>
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
