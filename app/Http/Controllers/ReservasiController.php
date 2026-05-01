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
    $pasiens = Pasien::all();
    $dokters = Dokter::all();
    $treatments = Treatment::all();

    return view('pages.reservasi.index', compact('pasiens', 'dokters', 'treatments'));
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
    $validated = $request->validate([
        'pasien_id'    => 'required|exists:pasiens,id',
        'dokter_id'    => 'required|exists:dokters,id',
        'treatment_id' => 'required|exists:treatments,id',
        'tanggal'      => 'required|date',
        'waktu'        => 'nullable',
        'keluhan'      => 'nullable|string',
    ]);

    $validated['status'] = 'tertunda';
    // $validated['user_id'] = auth()->id();

    Reservasi::create($validated);

    return redirect()->route('reservasi.index')->with('success', 'Reservasi berhasil dibuat.');
}

    public function destroy($id)
    {
        Pendaftaran::destroy($id);

        return redirect()->route('pendaftaran.index')->with('success', 'Pendaftaran berhasil dihapus.');
    }
}
