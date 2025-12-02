<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perawat extends Model
{
    use HasFactory;

    protected $table = 'perawat';

    protected $fillable = [
        'user_id',
        'nama',
        'no_telepon',
        'email',
        'tanggal_lahir',
        'sip',
        'jadwal',
        'foto'
    ];

     protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

      public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }
}
