<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JudulTugasAkhir extends Model
{
    use HasFactory;
    protected $fillable = [
        'mahasiswa_bimbingan_id',
        'judul',
        'deskripsi',
        'file_judul',
        'status',
    ];

    public function mahasiswaBimbingan()
    {
        return $this->belongsTo(MahasiswaBimbingan::class);
    }
}
