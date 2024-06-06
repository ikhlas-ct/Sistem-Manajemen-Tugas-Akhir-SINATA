<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;
    protected $table = 'dosen';

    protected $fillable = [
        'user_id', 'nidn','nama', 'department', 'deskripsi','gambar_profil', 'no_hp', 'alamat', 'created_at', 'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

}
