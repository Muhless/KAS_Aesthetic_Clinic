<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Carbon\Carbon;

class KeuanganController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->bulan ?? now()->month;
        $tahun = $request->tahun ?? now()->year;

        // Pemasukan bulan ini
        $pemasukanBulanIni = Pembayaran::where('status', 'lunas')->whereMonth('dibayar_pada', $bulan)->whereYear('dibayar_pada', $tahun)->sum('total_harga');

        // Pemasukan hari ini
        $pemasukanHariIni = Pembayaran::where('status', 'lunas')->whereDate('dibayar_pada', today())->sum('total_harga');

        // Total transaksi bulan ini
        $totalTransaksi = Pembayaran::where('status', 'lunas')->whereMonth('dibayar_pada', $bulan)->whereYear('dibayar_pada', $tahun)->count();

        // Belum dibayar
        $totalBelumBayar = Pembayaran::where('status', 'belum_bayar')->count();

        // Pemasukan per metode bayar bulan ini
        $perMetode = Pembayaran::where('status', 'lunas')->whereMonth('dibayar_pada', $bulan)->whereYear('dibayar_pada', $tahun)->selectRaw('metode_bayar, SUM(total_harga) as total, COUNT(*) as jumlah')->groupBy('metode_bayar')->get();

        // Daftar transaksi bulan ini
        $transaksis = Pembayaran::with(['pelayanan.pasien', 'pelayanan.dokter'])
            ->where('status', 'lunas')
            ->whereMonth('dibayar_pada', $bulan)
            ->whereYear('dibayar_pada', $tahun)
            ->latest('dibayar_pada')
            ->get();

        // Pemasukan per hari (untuk grafik)
        $perHari = Pembayaran::where('status', 'lunas')->whereMonth('dibayar_pada', $bulan)->whereYear('dibayar_pada', $tahun)->selectRaw('DATE(dibayar_pada) as tanggal, SUM(total_harga) as total')->groupBy('tanggal')->orderBy('tanggal')->get();

        $pembayarans = Pembayaran::latest()->paginate(15);

        return view('pages.keuangan.index', compact('pemasukanBulanIni', 'pemasukanHariIni', 'totalTransaksi', 'totalBelumBayar', 'pembayarans', 'perMetode', 'transaksis', 'perHari', 'bulan', 'tahun'));
    }

    public function show(Pembayaran $pembayaran)
    {
        $pembayaran->load(['pelayanan.pasien', 'pelayanan.dokter', 'pelayanan.pemeriksaan.treatment']);

        return view('pages.keuangan.detail', compact('pembayaran'));
    }

    public function lunas(Request $request, Pembayaran $pembayaran)
    {
        $pembayaran->update([
            'status' => 'lunas',
            'metode_bayar' => 'cash',
            'dibayar_pada' => now(),
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('keuangan.index')->with('success', 'Pembayaran berhasil ditandai lunas.');
    }

    public function cetak(Pembayaran $pembayaran)
{
    $pembayaran->load([
        'pelayanan.pasien',
        'pelayanan.dokter',
        'pelayanan.pemeriksaan.treatment',
        'pelayanan.pemeriksaan.produks',
    ]);

    return view('pages.keuangan.cetak', compact('pembayaran'));
}
}
