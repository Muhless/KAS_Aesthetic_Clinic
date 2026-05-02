<?php

namespace App\Http\Controllers;

use App\Models\Pemeriksaan;
use App\Models\Pelayanan;
use App\Models\Pembayaran;
use App\Models\PembayaranItem;
use App\Models\Treatment;
use App\Models\Produk;
use Illuminate\Http\Request;

class PemeriksaanController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'pelayanan_id' => 'required|exists:pelayanans,id',
            'treatment_id' => 'nullable|exists:treatments,id',
            'diagnosa'     => 'nullable|string',
            'tindakan'     => 'nullable|string',
            'resep'        => 'nullable|string',
            'catatan'      => 'nullable|string',
        ]);

        // Simpan pemeriksaan
        Pemeriksaan::updateOrCreate(
            ['pelayanan_id' => $request->pelayanan_id],
            [
                'treatment_id' => $request->treatment_id,
                'diagnosa'     => $request->diagnosa,
                'tindakan'     => $request->tindakan,
                'resep'        => $request->resep,
                'catatan'      => $request->catatan,
            ]
        );

        // Update status pelayanan jadi selesai
        Pelayanan::findOrFail($request->pelayanan_id)
                  ->update(['status' => 'selesai']);

        // Auto buat pembayaran jika belum ada
        $pelayanan = Pelayanan::with('pembayaran')->findOrFail($request->pelayanan_id);
        if (!$pelayanan->pembayaran) {
            $pembayaran = Pembayaran::create([
                'pelayanan_id' => $request->pelayanan_id,
                'total_harga'  => 0,
                'status'       => 'belum_bayar',
            ]);

            // Tambah treatment ke items jika ada
            if ($request->treatment_id) {
                $treatment = Treatment::findOrFail($request->treatment_id);
                PembayaranItem::create([
                    'pembayaran_id' => $pembayaran->id,
                    'jenis'         => 'treatment',
                    'treatment_id'  => $treatment->id,
                    'qty'           => 1,
                    'harga_satuan'  => $treatment->harga,
                    'subtotal'      => $treatment->harga,
                ]);

                // Update total
                $pembayaran->update(['total_harga' => $treatment->harga]);
            }
        }

        return redirect()->back()->with('success', 'Pemeriksaan berhasil disimpan.');
    }
}
