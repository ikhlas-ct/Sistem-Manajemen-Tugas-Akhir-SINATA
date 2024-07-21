<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pertanyaan extends Model
{
    use HasFactory;

    protected $fillable = ['penilaian_id', 'pertanyaan', 'bobot'];

    public function penilaian()
    {
        return $this->belongsTo(Penilaian::class);
    }
}
