<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    use HasFactory;

    protected $table = 'treatments';

    protected $fillable = [
        'nama',
        'deskripsi',
        'harga',
        'durasi',
        'foto',
        'status',
    ];

    protected $casts = [
        'harga' => 'integer',
        'durasi' => 'integer',
        'created_at' => 'datetime',
    ];
  public function user()
    {
        return $this->belongsTo(User::class);
    }

}
