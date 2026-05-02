<?php
    namespace App\Models;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Pasien extends Model
    {
        use HasFactory;


        protected $fillable = [
            'nama',
            'tanggal_lahir',
            'jenis_kelamin',
            'nomor_telepon',
        ];

        protected $casts = [
            'tanggal_lahir' => 'date',
        ];

        public function reservasi()
        {
            return $this->hasMany(Reservasi::class);
        }

        public function getTanggalLahirFormattedAttribute()
        {
            return $this->tanggal_lahir
                ? $this->tanggal_lahir->format('d-m-Y')
                : '-';
        }

        public function kunjungans()
{
    return $this->hasMany(Kunjungan::class)->latest('tanggal');
}

        public function getJenisKelaminLabelAttribute()
        {
            return $this->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan';
        }
    }
