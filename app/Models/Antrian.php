<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Antrian extends Model
{

protected $fillable = [
    'pasien_id',
    'dokter_id',
    'tanggal',
    'nomor_antrian',
    'status',
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
}
