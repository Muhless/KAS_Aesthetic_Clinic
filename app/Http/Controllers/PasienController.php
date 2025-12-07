<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PasienController extends Controller
{

      public function api()
    {
        return response()->json([
            'status' => 'success',
            'data' => Pasien::all(),
        ]);
    }

public function index()
{
    $pasiens = Pasien::all();

    return view('pages.pasien.index', compact('pasiens'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pasien.create');
    }

    /**
     * Store a newly created resource in storage.
     */
  public function store(Request $request)
{
    $validated = $request->validate([
        'nama' => 'required|string|max:255',
        'jenis_kelamin' => 'required|in:L,P',
        'nomor_telepon' => 'required|string|max:20',
        'tanggal_lahir' => 'required|date|before:today',
    ]);

    Pasien::create($validated);

    return redirect()->route('pasien.index')->with('success', 'Pasien berhasil ditambahkan.');
}


    public function edit(Pasien $pasien)
    {
        return view('pasiens.edit', compact('pasien'));
    }


    public function update(Request $request, Pasien $pasien)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'nomor_telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
        ]);

        $pasien->update($request->all());

        return redirect()->route('pasien.index')
            ->with('success', 'Data pasien berhasil diperbarui.');
    }


    public function destroy(Pasien $pasien)
    {
        $pasien->delete();

        return redirect()->route('pasien.index')
            ->with('success', 'Data pasien berhasil dihapus.');
    }
}
