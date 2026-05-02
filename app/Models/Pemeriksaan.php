<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemeriksaan extends Model
{

    protected $fillable = [
        'kunjungan_id',
        'diagnosa',
        'tindakan',
        'resep',
        'catatan',
    ];

    public function kunjungan()
    {
        return $this->belongsTo(Kunjungan::class);
    }
}
