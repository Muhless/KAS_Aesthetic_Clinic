<?php

namespace App\Http\Controllers;

use App\Models\JadwalPraktek;
use Illuminate\Http\Request;

class JadwalPraktekController extends Controller
{

      public function api()
    {
        return response()->json([
            'status' => 'success',
            'data' => JadwalPraktek::all(),
        ]);
    }

    // Ambil jadwal berdasarkan dokter
    public function index($dokterId)
    {
        $jadwal = JadwalPraktek::where('dokter_id', $dokterId)
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')")
            ->get();

        return response()->json([
            'data' => $jadwal
        ]);
    }

    // Simpan atau update jadwal
    public function store(Request $request)
    {
        $request->validate([
            'dokter_id' => 'required|exists:dokter,id',
            'jadwal' => 'required|array',
            'jadwal.*.hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jadwal.*.jam_mulai' => 'required|date_format:H:i',
            'jadwal.*.jam_selesai' => 'required|date_format:H:i|after:jadwal.*.jam_mulai',
            'jadwal.*.aktif' => 'boolean',
        ]);

        // Hapus jadwal lama
        JadwalPraktek::where('dokter_id', $request->dokter_id)->delete();

        // Insert jadwal baru
        foreach ($request->jadwal as $item) {
            JadwalPraktek::create([
                'dokter_id' => $request->dokter_id,
                'hari' => $item['hari'],
                'jam_mulai' => $item['jam_mulai'],
                'jam_selesai' => $item['jam_selesai'],
                'aktif' => $item['aktif'] ?? true,
            ]);
        }

        return response()->json([
            'message' => 'Jadwal praktek berhasil disimpan'
        ]);
    }

    // Update status aktif
    public function updateStatus($id)
    {
        $jadwal = JadwalPraktek::findOrFail($id);
        $jadwal->aktif = !$jadwal->aktif;
        $jadwal->save();

        return response()->json([
            'message' => 'Status jadwal berhasil diubah',
            'data' => $jadwal
        ]);
    }

    // Hapus jadwal
    public function destroy($id)
    {
        $jadwal = JadwalPraktek::findOrFail($id);
        $jadwal->delete();

        return response()->json([
            'message' => 'Jadwal berhasil dihapus'
        ]);
    }
}
