<?php

use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\Pelayanan;
use App\Models\Pembayaran;
use App\Models\Pemeriksaan;
use App\Models\Produk;
use App\Models\Treatment;
use App\Models\User;

/**
 * Menyiapkan satu pelayanan beserta dokter dan pasiennya.
 *
 * @return array{0: User, 1: Dokter, 2: Pasien, 3: Pelayanan}
 */
function buatPelayanan(array $atribut = []): array
{
    $user = User::create([
        'username' => 'dokter_'.uniqid(),
        'password' => 'password123',
        'role' => 'dokter',
    ]);

    $dokter = Dokter::create([
        'user_id' => $user->id,
        'nama' => 'dr. Ayu Lestari',
        'biaya_konsultasi' => 100000,
    ]);

    $pasien = Pasien::create([
        'nama' => 'Siti Aminah',
        'jenis_kelamin' => 'P',
        'nomor_telepon' => '081234567890',
    ]);

    $pelayanan = Pelayanan::create(array_merge([
        'pasien_id' => $pasien->id,
        'dokter_id' => $dokter->id,
        'tanggal' => today(),
        'nomor_antrian' => 1,
        'status' => 'menunggu',
        'keluhan' => 'Kulit kusam dan berjerawat',
    ], $atribut));

    return [$user, $dokter, $pasien, $pelayanan];
}

/**
 * Menyiapkan pemeriksaan kosong + pembayaran, seperti kondisi setelah
 * pasien dipanggil dari halaman nakes.
 *
 * @return array{0: User, 1: Pemeriksaan, 2: Pembayaran, 3: Pelayanan}
 */
function buatPemeriksaanKosong(): array
{
    [$user, , , $pelayanan] = buatPelayanan(['status' => 'dipanggil']);

    $pembayaran = Pembayaran::create([
        'pelayanan_id' => $pelayanan->id,
        'total_harga' => 0,
        'status' => 'belum_bayar',
    ]);

    $pemeriksaan = Pemeriksaan::create([
        'pelayanan_id' => $pelayanan->id,
    ]);

    return [$user, $pemeriksaan, $pembayaran, $pelayanan];
}

it('membuat pemeriksaan dan pembayaran saat pasien dipanggil', function () {
    [$user, , , $pelayanan] = buatPelayanan();

    $this->actingAs($user)
        ->put(route('pelayanan.update', $pelayanan->id), ['status' => 'dipanggil'])
        ->assertRedirect();

    expect($pelayanan->fresh()->status)->toBe('dipanggil');

    $pemeriksaan = Pemeriksaan::where('pelayanan_id', $pelayanan->id)->first();
    expect($pemeriksaan)->not->toBeNull();

    $pembayaran = Pembayaran::where('pelayanan_id', $pelayanan->id)->first();
    expect($pembayaran)->not->toBeNull()
        ->and($pembayaran->status)->toBe('belum_bayar')
        ->and((float) $pembayaran->total_harga)->toBe(0.0);
});

it('tidak menggandakan pemeriksaan dan pembayaran saat dipanggil dua kali', function () {
    [$user, , , $pelayanan] = buatPelayanan();

    $this->actingAs($user)->put(route('pelayanan.update', $pelayanan->id), ['status' => 'dipanggil']);
    $this->actingAs($user)->put(route('pelayanan.update', $pelayanan->id), ['status' => 'dipanggil']);

    expect(Pemeriksaan::where('pelayanan_id', $pelayanan->id)->count())->toBe(1)
        ->and(Pembayaran::where('pelayanan_id', $pelayanan->id)->count())->toBe(1);
});

it('menyimpan pemeriksaan dengan produk dan menghitung total tagihan', function () {
    [$user, $pemeriksaan, $pembayaran, $pelayanan] = buatPemeriksaanKosong();

    $treatment = Treatment::create([
        'nama' => 'Facial Brightening',
        'harga' => 300000,
        'durasi' => 60,
        'status' => 'tersedia',
    ]);

    $produk = Produk::create([
        'nama' => 'Serum Vitamin C',
        'harga' => 150000,
        'stok' => 50,
        'status' => 'tersedia',
    ]);

    $this->actingAs($user)
        ->patch(route('pemeriksaan.update', $pemeriksaan->id), [
            'treatment_id' => $treatment->id,
            'diagnosa' => 'Hiperpigmentasi ringan',
            'tindakan' => 'Facial brightening',
            'catatan' => 'Kontrol 2 minggu lagi',
            'produk_ids' => [$produk->id],
        ])
        ->assertRedirect(route('nakes'));

    $pemeriksaan->refresh();

    expect($pemeriksaan->treatment_id)->toBe($treatment->id)
        ->and($pemeriksaan->diagnosa)->toBe('Hiperpigmentasi ringan')
        ->and($pemeriksaan->tindakan)->toBe('Facial brightening')
        ->and($pemeriksaan->catatan)->toBe('Kontrol 2 minggu lagi')
        ->and($pemeriksaan->produks()->pluck('produks.id')->all())->toBe([$produk->id])
        ->and($pemeriksaan->produks()->first()->pivot->qty)->toBe(1)
        ->and($pelayanan->fresh()->status)->toBe('selesai')
        ->and((float) $pembayaran->fresh()->total_harga)->toBe(550000.0);
});

it('menghapus produk dari pemeriksaan saat disimpan ulang tanpa produk', function () {
    [$user, $pemeriksaan, $pembayaran] = buatPemeriksaanKosong();

    $produk = Produk::create([
        'nama' => 'Serum Vitamin C',
        'harga' => 150000,
        'stok' => 50,
        'status' => 'tersedia',
    ]);

    $this->actingAs($user)->patch(route('pemeriksaan.update', $pemeriksaan->id), [
        'produk_ids' => [$produk->id],
    ]);

    $this->actingAs($user)->patch(route('pemeriksaan.update', $pemeriksaan->id), [
        'produk_ids' => [],
    ]);

    expect($pemeriksaan->fresh()->produks()->count())->toBe(0)
        // tanpa treatment dan produk, tagihan hanya biaya konsultasi dokter
        ->and((float) $pembayaran->fresh()->total_harga)->toBe(100000.0);
});
