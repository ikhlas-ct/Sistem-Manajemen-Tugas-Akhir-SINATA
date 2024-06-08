<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;
    protected $table = 'dosen';

    protected $fillable = [
        'user_id', 
        'gambar',
        'nama', 
        'nidn', 
        'departemen', 
        'no_hp', 
        'alamat', 
        'deskripsi'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

}
