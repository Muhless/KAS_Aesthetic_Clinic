<?php

namespace App\Http\Controllers;

use App\Models\Treatment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class TreatmentController extends Controller
{
    public function api($id)
    {
        $treatment = Treatment::findOrFail($id);
        return response()->json(['data' => $treatment]);
    }

    public function index(Request $request)
    {
        $treatments = Treatment::query()
            ->when($request->nama, fn($q) => $q->where('nama', 'like', '%' . $request->nama . '%'))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->harga_min, fn($q) => $q->where('harga', '>=', $request->harga_min))
            ->when($request->harga_max, fn($q) => $q->where('harga', '<=', $request->harga_max))
            ->get();

        if ($request->expectsJson()) {
            return response()->json(['data' => $treatments]);
        }

        return view('pages.treatment.index', compact('treatments'));
    }

    public function cetakPdf(Request $request)
    {
        $treatments = Treatment::query()
            ->when($request->nama, fn($q) => $q->where('nama', 'like', '%' . $request->nama . '%'))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->harga_min, fn($q) => $q->where('harga', '>=', $request->harga_min))
            ->when($request->harga_max, fn($q) => $q->where('harga', '<=', $request->harga_max))
            ->get();

        $filterInfo = [
            'nama' => $request->nama,
            'status' => $request->status ? ($request->status == 'tersedia' ? 'Tersedia' : 'Tidak Tersedia') : null,
            'harga_min' => $request->harga_min ? 'Rp ' . number_format($request->harga_min, 0, ',', '.') : null,
            'harga_max' => $request->harga_max ? 'Rp ' . number_format($request->harga_max, 0, ',', '.') : null,
        ];

        $pdf = Pdf::loadView('pages.treatment.laporan-pdf', compact('treatments', 'filterInfo'))
            ->setPaper('a4', 'landscape');

        return $pdf->stream('laporan-treatment-' . now()->format('Ymd-His') . '.pdf');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|integer|min:0',
            'durasi' => 'nullable|integer',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required|in:tersedia,tidak_tersedia',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('treatments', 'public');
        }

        $treatment = Treatment::create($validated);

        if ($request->expectsJson()) {
            return response()->json(['data' => $treatment], 201);
        }

        return redirect()
            ->route('treatment.index')
            ->with('success', 'Treatment berhasil ditambahkan.');
    }

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
            'nama' => 'sometimes|string|max:255',
            'deskripsi' => 'sometimes|nullable|string',
            'harga' => 'sometimes|integer|min:0',
            'durasi' => 'sometimes|nullable|integer',
            'foto' => 'sometimes|nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'sometimes|in:tersedia,tidak_tersedia',
        ]);

        if ($request->hasFile('foto')) {
            if ($treatment->foto) {
                Storage::disk('public')->delete($treatment->foto);
            }
            $validated['foto'] = $request->file('foto')->store('treatments', 'public');
        }

        $treatment->update($validated);

        if ($request->expectsJson()) {
            return response()->json(['data' => $treatment]);
        }

        return redirect()->route('treatment.index')->with('success', 'Treatment berhasil diubah.');
    }

    public function destroy(Request $request, $id)
    {
        $treatment = Treatment::find($id);

        if (!$treatment) {
            return response()->json([
                'success' => false,
                'message' => 'Treatment tidak ditemukan'
            ], 404);
        }

        if ($treatment->foto) {
            Storage::disk('public')->delete($treatment->foto);
        }

        $treatment->delete();

        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('treatment.index')->with('success', 'Treatment berhasil dihapus.');
    }
}
