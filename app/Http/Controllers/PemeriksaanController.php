<?php

namespace App\Http\Controllers;

use App\Models\Pemeriksaan;
use App\Models\Pelayanan;
use App\Models\Produk;
use App\Models\Treatment;
use Illuminate\Http\Request;

class PemeriksaanController extends Controller
{
    public function index()
    {
        return redirect()->route('pemeriksaan.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'pelayanan_id' => 'required|exists:pelayanans,id',
            'treatment_id' => 'nullable|exists:treatments,id',
            'diagnosa' => 'nullable|string',
            'tindakan' => 'nullable|string',
            'resep' => 'nullable|string',
            'catatan' => 'nullable|string',
        ]);

        // Simpan atau update pemeriksaan
        Pemeriksaan::updateOrCreate(
            ['pelayanan_id' => $request->pelayanan_id],
            [
                'treatment_id' => $request->treatment_id,
                'diagnosa' => $request->diagnosa,
                'tindakan' => $request->tindakan,
                'resep' => $request->resep,
                'catatan' => $request->catatan,
            ],
        );

        // Update status pelayanan jadi selesai
        $pelayanan = Pelayanan::findOrFail($request->pelayanan_id);
        $pelayanan->update(['status' => 'selesai']);

        // Tambah treatment ke pembayaran jika belum ada item treatment
        if ($request->treatment_id && $pelayanan->pembayaran) {
            $pembayaran = $pelayanan->pembayaran;
            $sudahAda = $pembayaran->items()->where('jenis', 'treatment')->exists();

            if (!$sudahAda) {
                $treatment = \App\Models\Treatment::findOrFail($request->treatment_id);
                \App\Models\PembayaranItem::create([
                    'pembayaran_id' => $pembayaran->id,
                    'jenis' => 'treatment',
                    'treatment_id' => $treatment->id,
                    'qty' => 1,
                    'harga_satuan' => $treatment->harga,
                    'subtotal' => $treatment->harga,
                ]);

                // Update total
                $pembayaran->update([
                    'total_harga' => $pembayaran->items()->sum('subtotal'),
                ]);
            }
        }

        return redirect()->back()->with('success', 'Pemeriksaan berhasil disimpan.');
    }

    public function edit(Pemeriksaan $pemeriksaan)
    {
        $pemeriksaan->load(['pelayanan.pasien', 'produks']);
        $treatments = Treatment::orderBy('nama')->get();
        $produks = Produk::orderBy('nama')->get();

        return view('pages.pemeriksaan.edit', compact('pemeriksaan', 'treatments', 'produks'));
    }

    public function update(Request $request, Pemeriksaan $pemeriksaan)
    {
        $request->validate([
            'treatment_id' => 'nullable|exists:treatments,id',
            'diagnosa' => 'nullable|string',
            'tindakan' => 'nullable|string',
            'catatan' => 'nullable|string',
            'produk_ids' => 'nullable|array',
            'produk_ids.*' => 'exists:produks,id',
        ]);

        $pemeriksaan->update($request->only(['treatment_id', 'diagnosa', 'tindakan', 'catatan']));

        // Sync produk
        $pemeriksaan->produks()->sync($request->produk_ids ?? []);

        // Hitung total pembayaran
        $pelayanan = $pemeriksaan->pelayanan;
        $pembayaran = $pelayanan->pembayaran;

        if ($pembayaran) {
            $total = 0;

            // Biaya konsultasi dokter
            if ($pelayanan->dokter) {
                $total += $pelayanan->dokter->biaya_konsultasi ?? 0;
            }

            // Biaya treatment
            if ($request->treatment_id) {
                $treatment = \App\Models\Treatment::find($request->treatment_id);
                $total += $treatment->harga ?? 0;
            }

            // Biaya produk
            $produkTotal = \App\Models\Produk::whereIn('id', $request->produk_ids ?? [])->sum('harga');
            $total += $produkTotal;

            $pembayaran->update(['total_harga' => $total]);
        }

        // Update status pelayanan jadi selesai
        $pelayanan->update(['status' => 'selesai']);

        return redirect()->route('nakes')->with('success', 'Pemeriksaan berhasil disimpan.');
    }
}
