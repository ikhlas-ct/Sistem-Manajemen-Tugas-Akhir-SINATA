<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianSeminarKomprehensif extends Model
{
    use HasFactory;
    protected $table = 'penilaian_seminar_komprehensif';

    protected $fillable = [
        'seminar_komprehensif_id', 
        'kriteria_id',
        'pertanyaan_id',
        'dosen_id',
        'nilai',
    ];

    public function seminarKomprehensif()
    {
        return $this->belongsTo(SeminarKomprehensif::class, 'seminar_komprehensif_id'); // Ubah sesuai
    }

    public function kriteria()
    {
        return $this->belongsTo(Penilaian::class, 'kriteria_id');
    }

    public function pertanyaan()
    {
        return $this->belongsTo(Pertanyaan::class, 'pertanyaan_id');
    }
}
