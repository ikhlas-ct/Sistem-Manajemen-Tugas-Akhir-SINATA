@extends('layout.master')
@section('title', 'Daftar Dosen Pembimbing') 

@section('content')
<div class="container">
    <div class="row justify-content-center ">
        <div class="col-md-8 ">
            <div class="card bg-body-tertiary">
                <div class="card-header">Edit Dosen Pembimbing</div>

                <div class="card-body">
                    <form action="{{ route('prodi.dosen-pembimbings.update', ['id' => $dosenPembimbing->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="editDosen" class="form-label">Dosen</label>
                            <select class="form-select" id="editDosen" name="dosen_id" disabled>
                                @foreach ($dosens as $dosen)
                                <option value="{{ $dosen->id }}" @if ($dosen->id == $dosenPembimbing->dosen_id) selected @endif>{{ $dosen->nama }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="dosen_id" value="{{ $dosenPembimbing->dosen_id }}">
                        </div>
                        <div class="mb-3">
                            <label for="editJenisDosbing" class="form-label">Jenis Pembimbing</label>
                            <select class="form-select" id="editJenisDosbing" name="jenis_dosbing" required>
                                <option value="pembimbing 1" @if ($dosenPembimbing->jenis_dosbing == 'pembimbing 1') selected @endif>Pembimbing 1</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

   
  










