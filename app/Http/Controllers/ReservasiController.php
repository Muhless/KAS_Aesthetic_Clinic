<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\Treatment;
use Illuminate\Http\Request;

class ReservasiController extends Controller
{

      public function api()
    {
        return response()->json([
            'status' => 'success',
            'data' => Reservasi::all(),
        ]);
    }

    public function index()
    {
        $reservasis = Reservasi::with(['pasien', 'dokter', 'treatment'])
            ->orderBy('tanggal', 'desc')
            ->orderBy('waktu', 'asc')
            ->get();

        return view('pages.reservasi.index', compact('reservasis'));
    }

    public function create()
    {
        $patients = Pasien::all();
        $dokters = Dokter::all();
        $treatments = Treatment::all();

        return view('reservasi.create', compact('patients', 'dokters', 'treatments'));
    }

//    public function store(Request $request)
// {
//     $validated = $request->validate([
//         'pasien_id'     => 'required|exists:pasiens,id',
//         'dokter_id'     => 'required|exists:dokters,id',
//         'treatment_id'  => 'required|exists:treatments,id',
//         'tanggal'       => 'required|date',
//         'waktu'         => 'nullable',
//         'keluhan'       => 'nullable|string',
//     ]);

// $validated['status'] = 'tertunda';
// $validated['user_id'] = auth()->id();

//     Reservasi::create($validated);

//     return redirect()->route('pages.reservasi.index')->with('success', 'Reservasi berhasil dibuat.');
// }

    public function show($id)
    {
        $reservasi = Reservasi::with(['pasien', 'dokter', 'treatment'])->findOrFail($id);
        return view('reservasi.show', compact('reservasi'));
    }

    public function edit($id)
    {
        $reservasi = Reservasi::findOrFail($id);
        $patients = Pasien::all();
        $dokters = Dokter::all();
        $treatments = Treatment::all();

        return view('reservasi.edit', compact('reservasi', 'patients', 'dokters', 'treatments'));
    }

    public function update(Request $request, $id)
    {
        $reservasi = Reservasi::findOrFail($id);

        $validated = $request->validate([
            'pasien_id'     => 'required|exists:pasiens,id',
            'dokter_id'     => 'required|exists:dokters,id',
            'treatment_id'  => 'required|exists:treatments,id',
            'tanggal'       => 'required|date',
            'waktu'         => 'nullable',
            'keluhan'       => 'nullable|string',
            'status'        => 'nullable|string|in:tertunda,diproses,selesai,dibatalkan',
        ]);

        $reservasi->update($validated);

        return redirect()->route('reservasi.index')->with('success', 'Reservasi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Reservasi::destroy($id);

        return redirect()->route('reservasi.index')->with('success', 'Reservasi berhasil dihapus.');
    }
}
