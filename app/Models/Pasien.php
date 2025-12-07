<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;

    protected $table = 'pasiens';

    protected $fillable = [
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        'nomor_telepon',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    // Relasi: 1 pasien punya banyak reservasi
    public function reservasi()
    {
        return $this->hasMany(Reservasi::class);
    }

    // Aksesors (opsional)
    public function getTanggalLahirFormattedAttribute()
    {
        return $this->tanggal_lahir
            ? $this->tanggal_lahir->format('d-m-Y')
            : '-';
    }

     public function getJenisKelaminLabelAttribute()
    {
        return $this->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan';
    }
}
