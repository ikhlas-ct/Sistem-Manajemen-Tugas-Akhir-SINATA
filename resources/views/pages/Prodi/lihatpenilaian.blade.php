<!-- resources/views/penilaians/index.blade.php -->
@extends('layout.master')

@section('title', 'Lihat Kriteria Penilaian')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Kriteria Penilaian</h2>
                <a href="{{ route('prodi.penilaians.create') }}" class="btn btn-success">Tambah Penilian</a>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @foreach($penilaians as $penilaian)
                <div class="mb-4 p-3 rounded shadow-sm bg-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4>{{ $penilaian->nama }}</h4>
                        <div class="d-flex align-items-center">
                            <a href="{{ route('prodi.penilaians.edit', $penilaian->id) }}" class="btn btn-warning btn-sm me-2">Edit Kriteria</a>
                            <form action="{{ route('prodi.penilaians.destroy', $penilaian->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus kriteria penilaian ini beserta semua pertanyaannya?');">Hapus Kriteria</button>
                            </form>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Pertanyaan</th>
                            <th>Bobot</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($penilaian->pertanyaans as $index => $pertanyaan)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    {{ $pertanyaan->pertanyaan }}
                                    <form action="{{ route('pertanyaans.destroy', $pertanyaan->id) }}" method="POST" class="d-inline ms-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus pertanyaan ini?');">Hapus</button>
                                    </form>
                                </td>
                                <td>{{ $pertanyaan->bobot }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endforeach
        </div>
    </div>
</div>
@endsection
