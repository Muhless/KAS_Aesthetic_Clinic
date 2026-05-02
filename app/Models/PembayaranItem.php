<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PembayaranItem extends Model
{
    protected $fillable = [
        'pembayaran_id', 'jenis',
        'treatment_id', 'produk_id',
        'qty', 'harga_satuan', 'subtotal',
    ];

    public function pembayaran() { return $this->belongsTo(Pembayaran::class); }
    public function treatment() { return $this->belongsTo(Treatment::class); }
    public function produk() { return $this->belongsTo(Produk::class); }
}
