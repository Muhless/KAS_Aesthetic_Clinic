<?php

namespace App\Http\Controllers;

use App\Models\Pelayanan;
use App\Models\Pasien;
use App\Models\Dokter;
use App\Models\Pembayaran;
use App\Models\Pemeriksaan;
use App\Models\Produk;
use App\Models\Reservasi;
use App\Models\Treatment;
use Illuminate\Http\Request;

class PelayananController extends Controller
{
    // ini di halaman pembayaran
    public function show($id)
    {
        $pelayanan = Pelayanan::with(['pasien', 'dokter', 'pemeriksaan.treatment', 'pembayaran.items.treatment', 'pembayaran.items.produk'])->findOrFail($id);

        $treatments = Treatment::orderBy('nama')->get();
        $produks = Produk::orderBy('nama')->get();

        return view('pages.pelayanan.detail', compact('pelayanan', 'treatments', 'produks'));
    }

    public function index()
    {
        $pelayanans = Pelayanan::with(['pasien', 'dokter'])
            ->whereDate('tanggal', today())
            ->orderBy('nomor_antrian')
            ->get();

        $pasiens = Pasien::orderBy('nama')->get();
        $dokters = Dokter::orderBy('nama')->get();

        return view('pages.pelayanan.index', compact('pelayanans', 'pasiens', 'dokters'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pasien_id' => 'required|exists:pasiens,id',
            'dokter_id' => 'nullable|exists:dokters,id',
            'tanggal' => 'required|date',
            'keluhan' => 'nullable|string',
        ]);

        $nomorTerakhir = Pelayanan::whereDate('tanggal', $request->tanggal)->max('nomor_antrian');

        Pelayanan::create([
            'pasien_id' => $request->pasien_id,
            'dokter_id' => $request->dokter_id,
            'reservasi_id' => $request->reservasi_id,
            'tanggal' => $request->tanggal,
            'nomor_antrian' => $nomorTerakhir + 1,
            'status' => 'menunggu',
            'keluhan' => $request->keluhan,
        ]);

        if ($request->reservasi_id) {
            Reservasi::findOrFail($request->reservasi_id)->update(['status' => 'selesai']);
        }

        return redirect()->back()->with('success', 'Pelayanan berhasil ditambahkan.');
    }

  public function update(Request $request, $id)
{
    $pelayanan = Pelayanan::findOrFail($id);

    $pelayanan->update([
        'status' => $request->status,
        'keluhan' => $request->keluhan ?? $pelayanan->keluhan,
    ]);

    if ($request->status == 'dipanggil') {
        // Auto buat pembayaran
        if (!$pelayanan->pembayaran) {
            Pembayaran::create([
                'pelayanan_id' => $pelayanan->id,
                'total_harga' => 0,
                'status' => 'belum_bayar',
            ]);
        }

        // Auto buat pemeriksaan (kosong dulu, diisi dokter)
        if (!$pelayanan->pemeriksaan) {
            Pemeriksaan::create([
                'pelayanan_id' => $pelayanan->id,
            ]);
        }
    }

    return redirect()->back()->with('success', 'Status pelayanan diperbarui.');
}

    public function destroy($id)
    {
        Pelayanan::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Pelayanan berhasil dihapus.');
    }
}
