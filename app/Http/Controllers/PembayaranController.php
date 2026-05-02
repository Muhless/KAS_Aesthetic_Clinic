<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\PembayaranItem;
use App\Models\Treatment;
use App\Models\Produk;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index()
    {
        $pembayarans = Pembayaran::with(['pelayanan.pasien', 'pelayanan.dokter', 'items'])
                        ->latest()
                        ->get();

        return view('pages.pembayaran.index', compact('pembayarans'));
    }

    public function show($id)
    {
        $pembayaran = Pembayaran::with([
            'pelayanan.pasien',
            'pelayanan.dokter',
            'pelayanan.pemeriksaan',
            'items.treatment',
            'items.produk',
        ])->findOrFail($id);

        $treatments = Treatment::all();
        $produks    = Produk::all();

        return view('pages.pembayaran.show', compact('pembayaran', 'treatments', 'produks'));
    }

    public function addItem(Request $request, $id)
    {
        $request->validate([
            'jenis'        => 'required|in:treatment,produk',
            'treatment_id' => 'nullable|exists:treatments,id',
            'produk_id'    => 'nullable|exists:produks,id',
            'qty'          => 'required|integer|min:1',
        ]);

        $pembayaran = Pembayaran::findOrFail($id);

        // Ambil harga dari treatment atau produk
        if ($request->jenis == 'treatment') {
            $item = Treatment::findOrFail($request->treatment_id);
        } else {
            $item = Produk::findOrFail($request->produk_id);
        }

        $hargaSatuan = $item->harga;
        $subtotal    = $hargaSatuan * $request->qty;

        PembayaranItem::create([
            'pembayaran_id' => $pembayaran->id,
            'jenis'         => $request->jenis,
            'treatment_id'  => $request->treatment_id,
            'produk_id'     => $request->produk_id,
            'qty'           => $request->qty,
            'harga_satuan'  => $hargaSatuan,
            'subtotal'      => $subtotal,
        ]);

        // Update total
        $pembayaran->update([
            'total_harga' => $pembayaran->items()->sum('subtotal'),
        ]);

        return redirect()->back()->with('success', 'Item berhasil ditambahkan.');
    }

    public function removeItem($id)
    {
        $item       = PembayaranItem::findOrFail($id);
        $pembayaran = $item->pembayaran;
        $item->delete();

        // Recalculate total
        $pembayaran->update([
            'total_harga' => $pembayaran->items()->sum('subtotal'),
        ]);

        return redirect()->back()->with('success', 'Item berhasil dihapus.');
    }

    public function bayar(Request $request, $id)
    {
        $request->validate([
            'metode_bayar' => 'required|in:cash,transfer,kartu',
            'catatan'      => 'nullable|string',
        ]);

        Pembayaran::findOrFail($id)->update([
            'metode_bayar' => $request->metode_bayar,
            'status'       => 'lunas',
            'dibayar_pada' => now(),
            'catatan'      => $request->catatan,
        ]);

        return redirect()->back()->with('success', 'Pembayaran berhasil diproses.');
    }

    public function destroy($id)
    {
        PembayaranItem::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Item berhasil dihapus.');
    }
}
