<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\Dokter;
use App\Models\Pasien;
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

    public function index()
    {
        return view('pages.reservasi.index');
    }

    public function create()
    {
        $patients = Pasien::all();
        $dokters = Dokter::all();
        $treatments = Treatment::all();

        return view('pages.pendaftaran.create', compact('patients', 'dokters', 'treatments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pasien_id' => 'required|exists:pasiens,id',
            'dokter_id' => 'required|exists:dokters,id',
            'treatment_id' => 'required|exists:treatments,id',
            'tanggal' => 'required|date',
            'waktu' => 'nullable',
            'keluhan' => 'nullable|string',
        ]);

        $validated['status'] = 'tertunda';
        // $validated['user_id'] = auth()->id();

        Pendaftaran::create($validated);

        return redirect()->route('pendaftaran.index')->with('success', 'Pendaftaran berhasil dibuat.');
    }

    public function show($id)
    {
        $pendaftaran = Pendaftaran::with(['pasien', 'dokter', 'treatment'])->findOrFail($id);
        return view('pages.pendaftaran.show', compact('pendaftaran'));
    }

    public function edit($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        $patients = Pasien::all();
        $dokters = Dokter::all();
        $treatments = Treatment::all();

        return view('pages.pendaftaran.edit', compact('pendaftaran', 'patients', 'dokters', 'treatments'));
    }

    public function update(Request $request, $id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);

        $validated = $request->validate([
            'pasien_id' => 'required|exists:pasiens,id',
            'dokter_id' => 'required|exists:dokters,id',
            'treatment_id' => 'required|exists:treatments,id',
            'tanggal' => 'required|date',
            'waktu' => 'nullable',
            'keluhan' => 'nullable|string',
            'status' => 'nullable|string|in:tertunda,diproses,selesai,dibatalkan',
        ]);

        $pendaftaran->update($validated);

        return redirect()->route('pendaftaran.index')->with('success', 'Pendaftaran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Pendaftaran::destroy($id);

        return redirect()->route('pendaftaran.index')->with('success', 'Pendaftaran berhasil dihapus.');
    }
}
