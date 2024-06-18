<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class Admin extends Model
{
    use HasFactory;
    protected $table = 'admin';
    protected $fillable = [
        'user_id', 
        'gambar',
        'nama', 
        'no_hp', 
        'alamat', 
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
   
}
