<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use Illuminate\Http\Request;

class AntrianController extends Controller
{
    public function index()
    {
        $antrians = Antrian::with(['pasiens', 'dokters'])
                        ->whereDate('tanggal', today())
                        ->orderBy('nomor_antrian')
                        ->get();

        return view('pages.antrian.index', compact('antrians'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pasien_id' => 'required|exists:pasiens,id',
            'dokter_id' => 'nullable|exists:dokters,id',
            'tanggal'   => 'required|date',
        ]);

        // Auto nomor antrian berdasarkan tanggal
        $nomorTerakhir = Antrian::whereDate('tanggal', $request->tanggal)->max('nomor_antrian');

        Antrian::create([
            'pasien_id'     => $request->pasien_id,
            'dokter_id'     => $request->dokter_id,
            'tanggal'       => $request->tanggal,
            'nomor_antrian' => $nomorTerakhir + 1,
            'status'        => 'menunggu',
        ]);

        return redirect()->back()->with('success', 'Antrian berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $antrian = Antrian::findOrFail($id);
        $antrian->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status antrian diperbarui.');
    }

    public function destroy($id)
    {
        Antrian::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Antrian berhasil dihapus.');
    }
}
