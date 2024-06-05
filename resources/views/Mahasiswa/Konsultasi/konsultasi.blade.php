@extends('mahasiswa.layouts.master')

@section('title', 'Konsultasi')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col d-flex justify-content-between align-items-center">
                <h2 class="m-0">Konsultasi</h2>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal"><i class="fas fa-plus"></i></button>
            </div>
        </div>
        <div class="my-4">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="table-info">
                        <tr>
                            <th scope="col" class="text-nowrap">No</th>
                            <th scope="col" class="text-nowrap">Tanggal Konsultasi</th>
                            <th scope="col" class="text-nowrap">Dosen Pembimbing</th>
                            <th scope="col" class="text-nowrap">Topik Konsultasi</th>
                            <th scope="col" class="text-nowrap">Deskripsi Konsultasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-nowrap">1</td>
                            <td class="text-nowrap">5 Juni 2024</td>
                            <td class="text-nowrap">Santoso S.Kom</td>
                            <td class="text-nowrap">Membahas TA</td>
                            <td class="text-nowrap">Pada Konsultasi kali ini membahas TA mahasiswa sesuai topiknya</td>
                        </tr>
                        <tr>
                            <td class="text-nowrap">2</td>
                            <td class="text-nowrap">20 Juni 2024</td>
                            <td class="text-nowrap">Santoso S.Kom</td>
                            <td class="text-nowrap">Membahas Perkembangan TA</td>
                            <td class="text-nowrap">Pada Konsultasi kali ini membahas Perkembangan TA mahasiswa dan melanjutkan sebelumnya</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Konsultasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal Konsultasi</label>
                            <input type="date" class="form-control" id="tanggal">
                        </div>
                        <div class="mb-3">
                            <label for="dosen" class="form-label">Dosen Pembimbing</label>
                            <input type="text" class="form-control" id="dosen">
                        </div>
                        <div class="mb-3">
                            <label for="topik" class="form-label">Topik Konsultasi</label>
                            <input type="text" class="form-control" id="topik">
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi Konsultasi</label>
                            <textarea class="form-control" id="deskripsi" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection
