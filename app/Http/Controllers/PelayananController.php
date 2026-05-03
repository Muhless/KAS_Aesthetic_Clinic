<?php

namespace App\Http\Controllers;

use App\Models\Pelayanan;
use App\Models\Pasien;
use App\Models\Dokter;
use Illuminate\Http\Request;

class PelayananController extends Controller
{
    public function show($id)
    {
        $pelayanan = Pelayanan::with(['pasien', 'dokter', 'pemeriksaan.treatment', 'pembayaran.items.treatment', 'pembayaran.items.produk'])->findOrFail($id);

        $treatments = \App\Models\Treatment::orderBy('nama')->get();
        $produks = \App\Models\Produk::orderBy('nama')->get();

        return view('pages.pelayanan.show', compact('pelayanan', 'treatments', 'produks'));
    }

    public function index()
    {
        $pelayanans = Pelayanan::with(['pasien', 'dokter'])
            ->whereDate('tanggal', today())
            ->orderBy('nomor_antrian')
            ->get();

        $pasiens = Pasien::orderBy('nama')->get();
        $dokters = Dokter::orderBy('nama')->get();

        return view('pages.pelayanan.index', compact('pelayanan', 'pasien', 'dokter'));
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
            \App\Models\Reservasi::findOrFail($request->reservasi_id)->update(['status' => 'selesai']);
        }

        return redirect()->back()->with('success', 'Pelayanan berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $pelayanan = Pelayanan::findOrFail($id);
        $pelayanan->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status pelayanan diperbarui.');
    }

    public function destroy($id)
    {
        Pelayanan::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Pelayanan berhasil dihapus.');
    }
}
