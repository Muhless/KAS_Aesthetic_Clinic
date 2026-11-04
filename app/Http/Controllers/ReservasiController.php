<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\Pelayanan;
use App\Models\Reservasi;
use App\Models\Treatment;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReservasiController extends Controller
{
    public function api()
    {
        return response()->json([
            'status' => 'success',
            'data' => Pendaftaran::all(),
        ]);
    }

    public function index(Request $request)
    {
        $reservasis = Reservasi::with(['pasien', 'dokter', 'treatment'])
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->tanggal, fn($q) => $q->whereDate('tanggal', $request->tanggal))
            ->when($request->dokter_id, fn($q) => $q->where('dokter_id', $request->dokter_id))
            ->when($request->pasien_id, fn($q) => $q->where('pasien_id', $request->pasien_id))
            ->latest()
            ->get();

        $pasiens = Pasien::orderBy('nama')->get();
        $dokters = Dokter::orderBy('nama')->get();
        $treatments = Treatment::orderBy('nama')->get();

        return view('pages.reservasi.index', compact('reservasis', 'pasiens', 'dokters', 'treatments'));
    }

    public function cetakPdf(Request $request)
    {
        $reservasis = Reservasi::with(['pasien', 'dokter', 'treatment'])
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->tanggal, fn($q) => $q->whereDate('tanggal', $request->tanggal))
            ->when($request->dokter_id, fn($q) => $q->where('dokter_id', $request->dokter_id))
            ->when($request->pasien_id, fn($q) => $q->where('pasien_id', $request->pasien_id))
            ->latest()
            ->get();

        $filterInfo = [
            'status'  => $request->status,
            'tanggal' => $request->tanggal,
            'dokter'  => $request->dokter_id ? Dokter::find($request->dokter_id)?->nama : null,
            'pasien'  => $request->pasien_id ? Pasien::find($request->pasien_id)?->nama : null,
        ];

        $pdf = Pdf::loadView('pages.reservasi.laporan-pdf', compact('reservasis', 'filterInfo'))
            ->setPaper('a4', 'landscape');

        return $pdf->stream('laporan-reservasi-' . now()->format('Ymd-His') . '.pdf');
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

        Reservasi::create([
            'pasien_id' => $request->pasien_id,
            'dokter_id' => $request->dokter_id,
            'tanggal'   => $request->tanggal,
            'status'    => 'tertunda',
        ]);

        if ($request->reservasi_id) {
            Reservasi::findOrFail($request->reservasi_id)
                      ->update(['status' => 'diproses']);
        }

        return redirect()->back()->with('success', 'Reservasi berhasil dibuat.');
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
