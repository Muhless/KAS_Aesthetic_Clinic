<?php

namespace App\Http\Controllers;

use App\Models\Treatment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TreatmentController extends Controller
{

      public function api()
    {
        return response()->json([
            'status' => 'success',
            'data' => Treatment::all(),
        ]);
    }

 public function index()
{
    $treatments = Treatment::all();
    return view('pages.treatment.index', compact('treatments'));
}

public function store(Request $request)
{
    $validated = $request->validate([
        'nama'        => 'required|string|max:255',
        'deskripsi'   => 'nullable|string',
        'harga'       => 'required|integer|min:0',
        'durasi'      => 'nullable|integer',
        'foto'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        // 'status'      => 'required|in:tersedia,tidak_tersedia',
    ]);

    // Upload foto jika ada
    if ($request->hasFile('foto')) {
        $validated['foto'] = $request->file('foto')->store('treatments', 'public');
    }

    Treatment::create($validated);

    return redirect()
        ->route('treatment.index')
        ->with('success', 'Treatment berhasil ditambahkan.');
}


    /**
     * Display a single treatment.
     */
    public function show($id)
    {
        $treatment = Treatment::find($id);

        if (!$treatment) {
            return response()->json([
                'success' => false,
                'message' => 'Treatment tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $treatment
        ]);
    }

    /**
     * Update treatment.
     */
    public function update(Request $request, $id)
    {
        $treatment = Treatment::find($id);

        if (!$treatment) {
            return response()->json([
                'success' => false,
                'message' => 'Treatment tidak ditemukan'
            ], 404);
        }

        $validated = $request->validate([
            'nama'        => 'sometimes|string|max:255',
            'deskripsi'   => 'sometimes|nullable|string',
            'harga'       => 'sometimes|integer|min:0',
            'durasi'      => 'sometimes|nullable|integer',
            'foto'        => 'sometimes|nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status'      => 'sometimes|in:tersedia,tidak_tersedia',
        ]);

        // Jika ada foto baru, hapus foto lama & upload baru
        if ($request->hasFile('foto')) {
            if ($treatment->foto) {
                Storage::disk('public')->delete($treatment->foto);
            }
            $validated['foto'] = $request->file('foto')->store('treatments', 'public');
        }

        $treatment->update($validated);
    return redirect()->route('treatment.index')->with('success', 'Treatment berhasil diubah.');
    }

    /**
     * Remove treatment.
     */
    public function destroy($id)
    {
        $treatment = Treatment::find($id);

        if (!$treatment) {
            return response()->json([
                'success' => false,
                'message' => 'Treatment tidak ditemukan'
            ], 404);
        }

        // hapus foto
        if ($treatment->foto) {
            Storage::disk('public')->delete($treatment->foto);
        }

        $treatment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Treatment berhasil dihapus'
        ]);
    }
}
