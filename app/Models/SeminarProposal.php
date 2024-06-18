<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeminarProposal extends Model
{
    use HasFactory;
    protected $fillable = [
        'mahasiswa_bimbingan_id',
        'file_KHS',
        'Kartu_Bimbingan',
        'dosen_penguji_1_id',
        'dosen_penguji_2_id',
        'tanggal_waktu',
        'ruangan_id',
        'status_prodi',
        'status_lulus',
    ];
    protected $casts = [
        'tanggal_waktu' => 'datetime',
    ];
    public function mahasiswaBimbingan()
    {
        return $this->belongsTo(MahasiswaBimbingan::class, 'mahasiswa_bimbingan_id');
    }
    public function dosenPenguji1()
    {
        return $this->belongsTo(Dosen::class, 'dosen_penguji_1_id');
    }

    public function dosenPenguji2()
    {
        return $this->belongsTo(Dosen::class, 'dosen_penguji_2_id');
    }
    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'ruangan_id');
    }
}
