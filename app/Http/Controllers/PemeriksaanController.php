<?php

namespace App\Http\Controllers;

use App\Models\Pemeriksaan;
use App\Models\Pelayanan;
use Illuminate\Http\Request;

class PemeriksaanController extends Controller
{
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
}
