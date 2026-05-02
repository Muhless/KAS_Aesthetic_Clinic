<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use App\Models\Pasien;
use App\Models\Dokter;
use App\Models\Perawat;
use App\Models\Reservasi;

class DashboardController extends Controller
{
    public function index()
    {
        $antriansHariIni = Antrian::with(['pasien', 'dokter'])
            ->whereDate('tanggal', today())
            ->orderBy('nomor_antrian')
            ->get();

        $reservasisHariIni = Reservasi::with(['pasien', 'dokter', 'treatment'])
            ->whereDate('tanggal', today())
            ->orderBy('waktu')
            ->get();

        $pasienSelanjutnya = Antrian::with(['pasien', 'dokter'])
            ->whereDate('tanggal', today())
            ->where('status', 'menunggu')
            ->orderBy('nomor_antrian')
            ->first();

        $totalPasien = Pasien::count();
        $totalDokter = Dokter::count();
        $totalPerawat = Perawat::count();
        $totalAntrian = $antriansHariIni->where('status', 'menunggu')->count();

        return view('pages.dashboard', compact('antriansHariIni', 'reservasisHariIni', 'pasienSelanjutnya', 'totalPasien', 'totalDokter', 'totalPerawat', 'totalAntrian'));
    }
}
