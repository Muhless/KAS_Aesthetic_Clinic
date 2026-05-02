<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kunjungan extends Model
{

    protected $fillable = [
        'pasien_id',
        'dokter_id',
        'tanggal',
        'keluhan',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }

    public function pemeriksaan()
    {
        return $this->hasOne(Pemeriksaan::class);
    }
}
