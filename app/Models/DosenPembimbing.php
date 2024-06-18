<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DosenPembimbing extends Model
{
    use HasFactory;

    protected $fillable = [
        'dosen_id',
        'jenis_dosbing',
    ];

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }

    public function mahasiswaBimbingans()
    {
        return $this->belongsToMany(MahasiswaBimbingan::class, 'mahasiswa_bimbingans', 'dosen_pembimbing_id')
                    ->withTimestamps(); // sesuaikan dengan nama foreign key yang benar
    }

}
