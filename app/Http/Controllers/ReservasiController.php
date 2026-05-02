<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\Pelayanan;
use App\Models\Reservasi;
use App\Models\Treatment;
use Illuminate\Http\Request;

class ReservasiController extends Controller
{
    public function api()
    {
        return response()->json([
            'status' => 'success',
            'data' => Pendaftaran::all(),
        ]);
    }

    // ReservasiController - index
    // ReservasiController - index
    public function index()
    {
        $reservasis = Reservasi::with(['pasien', 'dokter', 'treatment'])
            ->latest()
            ->get();
        $pasiens = Pasien::orderBy('nama')->get();
        $dokters = Dokter::orderBy('nama')->get();
        $treatments = Treatment::orderBy('nama')->get();

        return view('pages.reservasi.index', compact('reservasis', 'pasiens', 'dokters', 'treatments'));
    }

    public function create()
    {
        $pasiens = Pasien::all();
        $dokters = Dokter::all();
        $treatments = Treatment::all();

        return view('pages.pendaftaran.create', compact('pasiens', 'dokters', 'treatments'));
    }

   public function store(Request $request)
{
    $request->validate([
        'pasien_id' => 'required|exists:pasiens,id',
        'dokter_id' => 'nullable|exists:dokters,id',
        'tanggal'   => 'required|date',
        'keluhan'   => 'nullable|string',
    ]);

    $nomorTerakhir = Pelayanan::whereDate('tanggal', $request->tanggal)
                        ->max('nomor_antrian');

    Pelayanan::create([
        'pasien_id'     => $request->pasien_id,
        'dokter_id'     => $request->dokter_id,
        'reservasi_id'  => $request->reservasi_id,
        'tanggal'       => $request->tanggal,
        'nomor_antrian' => $nomorTerakhir + 1,
        'status'        => 'menunggu',
        'keluhan'       => $request->keluhan,
    ]);

    // Update status reservasi jadi diproses
    if ($request->reservasi_id) {
        Reservasi::findOrFail($request->reservasi_id)
                  ->update(['status' => 'diproses']);
    }

    return redirect()->back()->with('success', 'Pasien berhasil check-in.');
}

    public function update(Request $request, $id)
    {
        $reservasi = Reservasi::findOrFail($id);
        $reservasi->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status reservasi diperbarui.');
    }

    public function destroy($id)
    {
        Pendaftaran::destroy($id);

        return redirect()->route('pendaftaran.index')->with('success', 'Pendaftaran berhasil dihapus.');
    }
}
