<?php

namespace App\Http\Controllers;

use App\Models\Pelayanan;
use App\Models\Pasien;
use App\Models\Treatment;
use App\Models\Produk;
use App\Models\Pemeriksaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DokterDashboardController extends Controller
{
    public function index()
    {
        // Ambil dokter yang sedang login via relasi user
        $dokter = Auth::user()->dokter;

        // Pelayanan hari ini untuk dokter ini
        $pelayanans = Pelayanan::with(['pasien', 'pemeriksaan', 'pembayaran'])
            ->where('dokter_id', $dokter?->id)
            ->whereDate('tanggal', today())
            ->orderBy('nomor_antrian')
            ->get();

        $totalMenunggu  = $pelayanans->where('status', 'menunggu')->count();
        $totalDipanggil = $pelayanans->where('status', 'dipanggil')->count();
        $totalSelesai   = $pelayanans->where('status', 'selesai')->count();

        $treatments = Treatment::where('status', 'tersedia')->orderBy('nama')->get();
        $produks    = Produk::where('status', 'tersedia')->orderBy('nama')->get();

        return view('pages.dokter.dashboard', compact(
            'dokter',
            'pelayanans',
            'totalMenunggu',
            'totalDipanggil',
            'totalSelesai',
            'treatments',
            'produks',
        ));
    }
}
