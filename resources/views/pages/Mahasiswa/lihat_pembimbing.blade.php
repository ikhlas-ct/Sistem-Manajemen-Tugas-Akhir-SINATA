@extends('layout.master')
@section('title', 'Daftar Pembimbing') 

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
    <h2 class="my-4">Daftar Pembimbing</h2>
    <hr>
    <div class="row">
        @foreach ($mahasiswaBimbingans as $bimbingan)
            <div class="col-md-4 mb-4">
                <div class="card ">
                    <div class="card-header text-white bg-primary text-center">
                        <p class="text-capitalize fs-5 text-dark fw-bold">{{$bimbingan->dosenPembimbing->dosen->nama ?? '-'}}</p>
                        <p class="text-capitalize">{{ $bimbingan->dosenPembimbing->jenis_dosbing ?? '-' }}</p>
                    </div>
                    <div class="card-body text-center" style="height:25vh">
                        <img src="{{ !empty($bimbingan->dosenPembimbing->dosen->gambar) ? asset($bimbingan->dosenPembimbing->dosen->gambar) : asset('assets/images/profile/user-1.jpg') }}" 
                             class="rounded-circle" 
                             width="100" 
                             height="100" 
                             alt="{{ $bimbingan->dosenPembimbing->dosen->nama ?? '-' }}">
                             <hr>

                    </div>
                    <div class="card-footer">
                        <h5 class="mb-3 text-capitalize">Fakultas: {{ $bimbingan->dosenPembimbing->dosen->department ?? '-' }}</h5>
                        <h5 class="mb-3 text-capitalize">No HP/WA: {{ $bimbingan->dosenPembimbing->dosen->no_hp ?? '-' }}</h5>
                        <p class="fw-bold fs-4">Diskripsi:</p>
                        <p class="description">{{ $bimbingan->dosenPembimbing->dosen->deskripsi ?? '-' }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection
