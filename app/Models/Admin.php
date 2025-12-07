<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $table = 'admins';

    protected $fillable = [
        'user_id',
        'nama',
        'no_telepon',
        'email',
        'tanggal_lahir',
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
