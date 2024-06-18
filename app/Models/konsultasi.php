<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konsultasi extends Model
{
    use HasFactory;
    protected $fillable = ['tanggal','topik', 'mahasiswa_bimbingan_id', 'Pembahasan', 'status'];

    public function mahasiswaBimbingan()
    {
        return $this->belongsTo(MahasiswaBimbingan::class);
    }
}
