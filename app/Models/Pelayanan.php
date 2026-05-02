<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelayanan extends Model
{

  protected $table = 'pelayanans'; 
    protected $fillable = [
        'pasien_id', 'dokter_id', 'reservasi_id',
        'tanggal', 'nomor_antrian', 'status', 'keluhan',
    ];

    protected $casts = ['tanggal' => 'date'];

    public function pasien() { return $this->belongsTo(Pasien::class); }
    public function dokter() { return $this->belongsTo(Dokter::class); }
    public function reservasi() { return $this->belongsTo(Reservasi::class); }
    public function pemeriksaan() { return $this->hasOne(Pemeriksaan::class); }
    public function pembayaran() { return $this->hasOne(Pembayaran::class); }
}
