<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
    ];

    public function seminarProposals()
    {
        return $this->hasMany(SeminarProposal::class);
    }
    public function seminarKomprehensif()
    {
        return $this->hasMany(SeminarKomprehensif::class);
    }
}
