<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    use HasFactory;

    protected $table = 'treatments';

    protected $fillable = [
        'name',
        'category_id',
        'description',
        'price',
        'duration',
        'photo',
        'status',
    ];

    protected $casts = [
        'price' => 'integer',
        'duration' => 'integer',
        'created_at' => 'datetime',
    ];

    // Relasi: treatment belongs to category
    public function category()
    {
        return $this->belongsTo(TreatmentCategory::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
