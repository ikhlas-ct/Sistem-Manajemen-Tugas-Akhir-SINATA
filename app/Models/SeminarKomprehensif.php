<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeminarKomprehensif extends Model
{
    use HasFactory;

    protected $table = 'seminar_komprehensif';

    protected $fillable = [
        'mahasiswa_bimbingan_id',
        'transkrip_nilai',
        'Kartu_Bimbingan',
        'sertifikat_pkl',
        'KRS',
        'dosen_penguji_1_id',
        'dosen_penguji_2_id',
        'tanggal_waktu',
        'ruangan_id',
        'status_prodi',
        'validasi_pembimbing',
        'komentar_penguji_1', 
        'komentar_penguji_2',

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

    public function penilaians()
    {
        return $this->hasMany(Penilaian::class);
    }
    public function penilaianSeminarKomprehensif()
    {
        return $this->hasMany(PenilaianSeminarKomprehensif::class, 'seminar_komprehensif_id');
    }
}
