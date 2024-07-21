<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;
    protected $fillable = ['nama'];

    public function pertanyaans()
    {
        return $this->hasMany(Pertanyaan::class);
    }
    public function seminarProposal()
    {
        return $this->belongsTo(SeminarProposal::class);
    }
}
