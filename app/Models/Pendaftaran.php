<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $table = 'pendaftarans';

    protected $fillable = [
        'pasien_id',
        'dokter_id',
        'treatment_id',
        'user_id',
        'tanggal',
        'waktu',
        'keluhan',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    // Relasi ke Pasien
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'pasien_id');
    }

    // Relasi ke Dokter
    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'dokter_id');
    }

    // Relasi ke Treatment
    public function treatment()
    {
        return $this->belongsTo(Treatment::class, 'treatment_id');
    }

    // Relasi ke User (yang membuat pendaftaran)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Scope untuk filter berdasarkan status
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Scope untuk pendaftaran hari ini
    public function scopeToday($query)
    {
        return $query->whereDate('tanggal', today());
    }

    // Scope untuk pendaftaran yang akan datang
    public function scopeUpcoming($query)
    {
        return $query->whereDate('tanggal', '>=', today())
                     ->orderBy('tanggal', 'asc')
                     ->orderBy('waktu', 'asc');
    }

    // Accessor untuk format tanggal yang lebih mudah dibaca
    public function getTanggalFormattedAttribute()
    {
        return $this->tanggal->format('d F Y');
    }

    // Accessor untuk status badge class
    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'tertunda' => 'warning',
            'diproses' => 'info',
            'selesai' => 'success',
            'dibatalkan' => 'danger',
            default => 'secondary',
        };
    }
}
