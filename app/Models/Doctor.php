<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $table = 'doctors';

    protected $fillable = [
        'name',
        'specialization',
        'phone',
        'email',
        'photo',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function treatments()
    {
        return $this->hasMany(Treatment::class);
    }

    public function schedules()
    {
        return $this->hasMany(DoctorSchedule::class);
    }
}
