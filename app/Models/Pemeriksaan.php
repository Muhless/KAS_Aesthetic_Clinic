<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemeriksaan extends Model
{
    protected $fillable = [
        'pelayanan_id', 'treatment_id',
        'diagnosa', 'tindakan', 'resep', 'catatan',
    ];

    public function pelayanan() { return $this->belongsTo(Pelayanan::class); }
    public function treatment() { return $this->belongsTo(Treatment::class); }
}
