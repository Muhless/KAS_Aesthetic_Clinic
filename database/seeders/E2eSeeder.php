<?php

namespace Database\Seeders;

use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Data minimum agar skenario e2e Cucumber bisa dijalankan.
 * Jalankan hanya pada database testing:
 *   php artisan db:seed --class=E2eSeeder --env=testing --force
 */
class E2eSeeder extends Seeder
{
    public function run(): void
    {
        Pasien::firstOrCreate(
            ['nama' => 'Michael'],
            [
                'jenis_kelamin' => 'L',
                'nomor_telepon' => '081234567890',
            ]
        );

        $userDokter = User::where('role', 'dokter')->first();

        if ($userDokter) {
            Dokter::firstOrCreate(
                ['nama' => 'John'],
                [
                    'user_id' => $userDokter->id,
                    'spesialis' => 'Umum',
                    'biaya_konsultasi' => 0,
                ]
            );
        }

        Produk::firstOrCreate(
            ['nama' => 'Produk E2E'],
            [
                'kategori' => 'Perawatan',
                'harga' => 100000,
                'stok' => 10,
                'status' => 'tersedia',
            ]
        );
    }
}
