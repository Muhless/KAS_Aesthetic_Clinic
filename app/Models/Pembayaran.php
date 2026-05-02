<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $fillable = [
        'pelayanan_id', 'total_harga',
        'metode_bayar', 'status', 'dibayar_pada', 'catatan',
    ];

    protected $casts = ['dibayar_pada' => 'datetime'];

    public function pelayanan() { return $this->belongsTo(Pelayanan::class); }
    public function items() { return $this->hasMany(PembayaranItem::class); }
}
