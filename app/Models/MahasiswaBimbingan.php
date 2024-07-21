<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MahasiswaBimbingan extends Model
{   

    use HasFactory;
    protected $table = 'mahasiswa_bimbingans';

    protected $fillable = [
        'dosen_pembimbing_id',
        'mahasiswa_id',
    ];
    public function dosenPembimbing()
    {
        return $this->belongsTo(DosenPembimbing::class, 'dosen_pembimbing_id');
    }

    // Relasi dengan model Mahasiswa
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }

    public function konsultasis()
    {
        return $this->hasMany(Konsultasi::class);
    }
    public function judulTugasAkhirs()
    {
        return $this->hasMany(JudulTugasAkhir::class);
    }
    public function acceptedJudulTugasAkhirs()
    {
        return $this->HasOne(JudulTugasAkhir::class)->where('status', 'diterima');
    }
}
