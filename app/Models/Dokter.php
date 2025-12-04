<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    use HasFactory;

    protected $table = 'dokter';

    protected $fillable = ['user_id', 'nama', 'no_telepon', 'email', 'tanggal_lahir', 'str', 'sip', 'spesialis', 'jadwal_praktik', 'foto'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }


public function jadwalPraktek()
{
    return $this->hasMany(JadwalPraktek::class);
}

// Mendapatkan jadwal hari ini
public function jadwalHariIni()
{
    $hari = now()->locale('id')->dayName; // Senin, Selasa, dll

    return $this->jadwalPraktek()
        ->where('hari', $hari)
        ->where('aktif', true)
        ->first();
}

}
