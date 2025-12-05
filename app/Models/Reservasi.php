<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $table = 'reservations';

    protected $fillable = [
        'user_id',
        'dokter_id',
        'treatment_id',
        'tanggal',
        'waktu',
        'status',
        'nama_pasien',
        'no_telepon',
        'email',
        'notes',
        'cancel_reason',
        'cancelled_by',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jam_mulai' => 'datetime:H:i',
        'jam_selesai' => 'datetime:H:i',
    ];

    // Relasi
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }

    public function treatment()
    {
        return $this->belongsTo(Treatment::class);
    }

    // Scope untuk tanggal tertentu
    public function scopeOnDate($query, $date)
    {
        return $query->where('tanggal', $date);
    }

    public function scopeForDokter($query, $dokterId)
    {
        return $query->where('dokter_id', $dokterId);
    }

    // helper untuk status checks
    public function isPending()    { return $this->status === 'tertunda'; }
    public function isConfirmed()  { return $this->status === 'diproses'; }
    public function isCancelled()  { return $this->status === 'dibatalkan'; }
}
