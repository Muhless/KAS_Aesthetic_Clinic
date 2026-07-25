<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PasienController extends Controller
{
    public function index(Request $request)
    {
        $pasiens = Pasien::query()
            ->when($request->nama, fn($q) => $q->where('nama', 'like', '%' . $request->nama . '%'))
            ->when($request->jenis_kelamin, fn($q) => $q->where('jenis_kelamin', $request->jenis_kelamin))
            ->when($request->tanggal_dari, fn($q) => $q->whereDate('tanggal_lahir', '>=', $request->tanggal_dari))
            ->when($request->tanggal_sampai, fn($q) => $q->whereDate('tanggal_lahir', '<=', $request->tanggal_sampai))
            ->latest()
            ->get();

        return view('pages.pasien.index', compact('pasiens'));
    }

    public function cetakPdf(Request $request)
    {
        $pasiens = Pasien::query()
            ->when($request->nama, fn($q) => $q->where('nama', 'like', '%' . $request->nama . '%'))
            ->when($request->jenis_kelamin, fn($q) => $q->where('jenis_kelamin', $request->jenis_kelamin))
            ->when($request->tanggal_dari, fn($q) => $q->whereDate('tanggal_lahir', '>=', $request->tanggal_dari))
            ->when($request->tanggal_sampai, fn($q) => $q->whereDate('tanggal_lahir', '<=', $request->tanggal_sampai))
            ->latest()
            ->get();

        $filterInfo = [
            'nama'          => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin ? ($request->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan') : null,
            'tanggal_dari'  => $request->tanggal_dari,
            'tanggal_sampai'=> $request->tanggal_sampai,
        ];

        $pdf = Pdf::loadView('pages.pasien.laporan-pdf', compact('pasiens', 'filterInfo'))
            ->setPaper('a4', 'landscape');

        return $pdf->stream('laporan-pasien-' . now()->format('Ymd-His') . '.pdf');
    }

    public function show($id)
    {
        $pasien = Pasien::with([
            'pelayanans.dokter',
            'pelayanans.pemeriksaan.treatment',
            'pelayanans.pembayaran',
        ])->findOrFail($id);

        return view('pages.pasien.show', compact('pasien'));
    }

    public function api($id)
    {
        $pasien = Pasien::findOrFail($id);
        return response()->json(['data' => $pasien]);
    }

    public function create()
    {
        return view('pasien.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'          => 'required|string|max:255',
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
            'nama'          => 'required|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'nomor_telepon' => 'nullable|string|max:20',
            'alamat'        => 'nullable|string',
        ]);

        $pasien->update($request->all());

        return redirect()->route('pasien.index')->with('success', 'Data pasien berhasil diperbarui.');
    }

    public function destroy(Pasien $pasien)
    {
        $pasien->delete();

        return redirect()->route('pasien.index')->with('success', 'Data pasien berhasil dihapus.');
    }
}
