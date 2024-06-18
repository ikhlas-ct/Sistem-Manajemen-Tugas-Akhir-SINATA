<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logbook extends Model
{
    use HasFactory;

    protected $fillable = [
        'mahasiswa_id',
        'judul_tugas_akhir',
        'bab',
        'deskripsi',
        'file_path',
        'status',
    ];
    public function mahasiswaBimbingan()
    {
        return $this->belongsTo(MahasiswaBimbingan::class);
    }
    


}
