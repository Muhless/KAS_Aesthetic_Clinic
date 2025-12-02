<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = ['username', 'password','role'];

    public function username()
    {
        return 'username';
    }

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'password' => 'hashed',
    ];

  public function dokter()
    {
        return $this->hasOne(Dokter::class);
    }

    public function perawat()
    {
        return $this->hasOne(Perawat::class);
    }


}
