<?php

namespace App\Http\Controllers\E2e;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\Pelayanan;
use App\Models\Pembayaran;
use App\Models\Pemeriksaan;
use App\Models\Produk;
use App\Models\Treatment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Pembuat data kunjungan untuk kebutuhan e2e.
 *
 * Satu request membuat Pasien + Pelayanan sekaligus, karena halaman /nakes
 * hanya menampilkan Pelayanan hari ini milik dokter yang login. Kalau status
 * kunjungan bukan "menunggu", Pemeriksaan dan Pembayaran juga dibuat supaya
 * skenario "Periksa" bisa langsung disiapkan tanpa melewati UI.
 *
 * Route controller ini hanya didaftarkan saat APP_ENV=testing
 * (lihat routes/api.php), jadi tidak pernah terbuka di production.
 */
class VisitController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pasien' => 'required|string|max:255',
            'jenis_kelamin' => 'nullable|in:L,P',
            'nomor_telepon' => 'nullable|string|max:20',
            'tanggal_lahir' => 'nullable|date',
            'keluhan' => 'nullable|string',
            'status' => 'nullable|in:menunggu,dipanggil,selesai',
            'username_dokter' => 'nullable|string|exists:users,username',
            'dokter_id' => 'nullable|integer|exists:dokters,id',
            'treatment_id' => 'nullable|integer|exists:treatments,id',
            'produk_ids' => 'nullable|array',
            'produk_ids.*' => 'integer|exists:produks,id',
            'diagnosa' => 'nullable|string',
            'tindakan' => 'nullable|string',
            'catatan' => 'nullable|string',
        ]);

        $dokter = $this->resolveDokter($validated);
        $status = $validated['status'] ?? 'menunggu';

        $pasien = Pasien::create([
            'nama' => $validated['nama_pasien'],
            'jenis_kelamin' => $validated['jenis_kelamin'] ?? 'L',
            'nomor_telepon' => $validated['nomor_telepon'] ?? null,
            'tanggal_lahir' => $validated['tanggal_lahir'] ?? null,
        ]);

        $nomorTerakhir = Pelayanan::whereDate('tanggal', today())->max('nomor_antrian') ?? 0;

        $pelayanan = Pelayanan::create([
            'pasien_id' => $pasien->id,
            'dokter_id' => $dokter?->id,
            'tanggal' => today(),
            'nomor_antrian' => $nomorTerakhir + 1,
            'status' => $status,
            'keluhan' => $validated['keluhan'] ?? null,
        ]);

        $pemeriksaan = $this->buatPemeriksaan($pelayanan, $validated, $status);

        return response()->json([
            'data' => [
                'pasien_id' => $pasien->id,
                'pelayanan_id' => $pelayanan->id,
                'pemeriksaan_id' => $pemeriksaan?->id,
                'pembayaran_id' => $pelayanan->pembayaran?->id,
                'dokter_id' => $dokter?->id,
                'nomor_antrian' => $pelayanan->nomor_antrian,
                'pemeriksaan_edit_url' => $pemeriksaan
                    ? route('pemeriksaan.edit', $pemeriksaan->id)
                    : null,
            ],
        ], 201);
    }

    /**
     * Meniru PelayananController::update() saat pasien dipanggil: siapkan
     * pembayaran dan pemeriksaan kosong, lalu isi hasil pemeriksaan bila
     * datanya dikirim.
     *
     * Pemeriksaan hanya dibuat kalau status bukan "menunggu", karena pasien
     * yang belum dipanggil memang belum punya form pemeriksaan.
     */
    private function buatPemeriksaan(Pelayanan $pelayanan, array $validated, string $status): ?Pemeriksaan
    {
        if ($status === 'menunggu') {
            return null;
        }

        $pembayaran = Pembayaran::firstOrCreate(
            ['pelayanan_id' => $pelayanan->id],
            ['total_harga' => 0, 'status' => 'belum_bayar'],
        );

        $pemeriksaan = Pemeriksaan::firstOrCreate(['pelayanan_id' => $pelayanan->id]);

        $pemeriksaan->update([
            'treatment_id' => $validated['treatment_id'] ?? null,
            'diagnosa' => $validated['diagnosa'] ?? null,
            'tindakan' => $validated['tindakan'] ?? null,
            'catatan' => $validated['catatan'] ?? null,
        ]);

        $produkIds = $validated['produk_ids'] ?? [];
        $pemeriksaan->produks()->sync($produkIds);

        // Rumus total mengikuti PemeriksaanController::update().
        $total = (float) ($pelayanan->dokter->biaya_konsultasi ?? 0);

        if ($pemeriksaan->treatment_id) {
            $total += (float) ($pemeriksaan->treatment->harga ?? 0);
        }

        $total += (float) Produk::whereIn('id', $produkIds)->sum('harga');

        $pembayaran->update(['total_harga' => $total]);

        return $pemeriksaan;
    }

    /**
     * Daftar treatment dan produk yang tersedia untuk test e2e, supaya test
     * bisa memakai id record tanpa menebak dari seeder.
     */
    public function catalog()
    {
        return response()->json([
            'data' => [
                'treatments' => Treatment::orderBy('nama')->get(['id', 'nama', 'harga']),
                'produks' => Produk::orderBy('nama')->get(['id', 'nama', 'harga']),
            ],
        ]);
    }

    /**
     * Menghapus Pelayanan sekaligus Pasien-nya kalau pasien tidak punya
     * kunjungan lain, supaya data e2e tidak menumpuk.
     */
    public function destroy(int $id)
    {
        $pelayanan = Pelayanan::findOrFail($id);
        $pasien = $pelayanan->pasien;

        $pelayanan->delete();

        if ($pasien && ! $pasien->pelayanans()->exists()) {
            $pasien->delete();
        }

        return response()->json(['success' => true]);
    }

    /**
     * Dokter bisa dipilih lewat dokter_id, username_dokter, atau default ke
     * dokter milik user yang sedang login.
     */
    private function resolveDokter(array $validated): ?Dokter
    {
        if (! empty($validated['dokter_id'])) {
            return Dokter::find($validated['dokter_id']);
        }

        if (! empty($validated['username_dokter'])) {
            return User::where('username', $validated['username_dokter'])->first()?->dokter;
        }

        return Auth::user()?->dokter;
    }
}
