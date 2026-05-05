<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Dokter;
use App\Models\Pelayanan;
use App\Models\Perawat;
use App\Models\Reservasi;

class DashboardController extends Controller
{
    public function index()
    {
        $pelayanansHariIni = Pelayanan::with(['pasien', 'dokter'])
            ->whereDate('tanggal', today())
            ->orderBy('nomor_antrian')
            ->get();

        $reservasisHariIni = Reservasi::with(['pasien', 'dokter', 'treatment'])
            ->whereDate('tanggal', today())
            ->orderBy('waktu')
            ->get();

        $pasienSelanjutnya = Pelayanan::with(['pasien', 'dokter'])
            ->whereDate('tanggal', today())
            ->where('status', 'menunggu')
            ->orderBy('nomor_antrian')
            ->first();

        $hariIni = now()->locale('id')->dayName; // "Senin", "Selasa", dst

    $hariIni = now()->locale('id')->dayName;

$dokterHariIni = Dokter::all()->filter(function ($dokter) use ($hariIni) {
    $jadwal = is_array($dokter->jadwal_praktik)
                ? $dokter->jadwal_praktik
                : json_decode($dokter->jadwal_praktik ?? '[]', true);
    return in_array(ucfirst($hariIni), $jadwal ?? []);
})->values();

        $totalPasien = Pasien::count();
        $totalDokter = Dokter::count();
        $totalPerawat = Perawat::count();
        $totalPelayanan = $pelayanansHariIni->count();

        // $totalPelayanan = $pelayanansHariIni->where('status', 'menunggu')->count();

        return view('pages.dashboard.index', compact('pelayanansHariIni', 'reservasisHariIni', 'pasienSelanjutnya', 'totalPasien', 'totalDokter', 'totalPerawat', 'totalPelayanan', 'dokterHariIni'));
    }
}
