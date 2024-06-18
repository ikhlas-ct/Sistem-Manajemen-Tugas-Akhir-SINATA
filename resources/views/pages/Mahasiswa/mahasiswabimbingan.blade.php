@extends('layout.master')
@section('title', 'Daftar Dosen Pembimbing') 

@section('content')

<style>
/* public/css/custom.css */

.card {
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.card-header {
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
    background-color: #007bff;
    color: white;
    padding: 20px;
}

.card-footer {
    background-color: #f8f9fa;
    padding: 20px;
    border-bottom-left-radius: 10px;
    border-bottom-right-radius: 10px;
}

.card-body img {
    border: 3px solid #fff;
}

.description {
    position: relative;
    max-height: 4.5em; /* Adjust based on the number of lines you want to show */
    overflow: hidden;
}

.description::after {
    content: '...';
    position: absolute;
    right: 0;
    bottom: 0;
    padding-left: 20px;
    background: linear-gradient(to left, white 50%, rgba(255, 255, 255, 0));
}

.description:hover {
    max-height: none;
    overflow: visible;
}

.description:hover::after {
    content: '';
}
</style>

<div class="container">
    <div class="row">
        @if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
        @foreach ($pembimbings as $pembimbing)
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header text-white bg-primary text-center">
                    <p class="text-capitalize fs-5 text-dark fw-bold">{{$pembimbing->dosen->nama ?? '-'}}</p>
                    <p class="text-capitalize">{{ $pembimbing->jenis_dosbing ?? '-' }}</p>
                    
                </div>
                <div class="card-body text-center">
                    <img src="{{ !empty($pembimbing->dosen->gambar) ? asset( $pembimbing->dosen->gambar) : asset('assets/images/profile/user-1.jpg') }}" 
                         class="rounded-circle mb-3" 
                         width="100" 
                         height="100" 
                         alt="{{ $pembimbing->dosen->nama ?? '-' }}">
                </div>
                <div class="card-footer">
                    <h5 class="mb-3 text-capitalize">Fakultas: {{ $pembimbing->dosen->department ?? '-' }}</h5>
                    <p class="text-capitalize fs-5 text-dark fw-bold">Deskripsi:</p>
                    <p class="description">{{ $pembimbing->dosen->deskripsi ?? '-' }}</p>
                </div>
                <div class="text-center">
                @if (!auth()->user()->mahasiswaBimbingan)
                <form action="{{ route('pilih.dosbing', $pembimbing->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary mx-auto mb-4" style="width: 80%;">Pilih Menjadi {{ $pembimbing->jenis_dosbing ?? '-' }}</button>
                </form>
            </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection
