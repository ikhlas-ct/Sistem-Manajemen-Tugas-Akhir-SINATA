@extends('Dosen.layouts.master')

@section('title', 'Dashboard')

@section('content')
<div class="container mt-2">
    <h2>Form Pengisian Profil Dosen</h2>
    <hr>
            <form method="POST" action="{{route('dosen.profile.update')}}" id="biodataForm">
                @csrf
                @method('PUT')
                @if(Auth::user()->dosen)
                    <div class="form-group row mb-3">
                        <label for="nidn" class="col-sm-2 col-form-label">NIDN</label>
                        <div class="col-sm-10">
                            <input type="number"  class="form-control" id="nidn" name="nidn" value="{{ Auth::user()->dosen->nidn }}">
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text"  class="form-control" name="nama" id="nama" value="{{ Auth::user()->dosen->nama }}">
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label for="department" class="col-sm-2 col-form-label">Departement</label>
                        <div class="col-sm-10">
                            <input type="text"  class="form-control" name="department" id="department" value="{{ Auth::user()->dosen->department }}">
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label for="no_hp" class="col-sm-2 col-form-label">No HP</label>
                        <div class="col-sm-10">
                            <input type="text"  class="form-control" name="no_hp" id="no_hp" value="{{ Auth::user()->dosen->no_hp }}">
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                            <input type="text"  class="form-control" name="alamat" id="alamat" value="{{ Auth::user()->dosen->alamat }}">
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label for="deskripsi" class="col-sm-2 col-form-label">Deskripsi</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" name="deskripsi" id="deskripsi" rows="4" >{{ Auth::user()->dosen->deskripsi }}</textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary px-4 float-end">Simpan</button>
                @else
                    <p>Informasi Dosen tidak tersedia.</p>
                @endif
            </form>
</div>
@endsection
