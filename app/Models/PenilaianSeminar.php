<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianSeminar extends Model
{
    use HasFactory;
    protected $fillable = [
        'seminar_proposal_id',
        'kriteria_id',
        'pertanyaan_id',
        'dosen_id',
        'nilai',
    ];


 
    public function seminarProposal()
    {
        return $this->belongsTo(SeminarProposal::class, 'seminar_proposal_id');
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
