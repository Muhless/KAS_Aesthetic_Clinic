@extends('layouts.app')

@section('title', 'Keuangan - KAS Aesthetic Clinic')

@section('content')
<div class="p-4 space-y-4">

    {{-- Header --}}
    <div class="border-b border-black/10 pb-3">
        <h1 class="text-xl font-semibold text-slate-700" data-testid="keuangan-title">Keuangan</h1>
        <p class="text-xs text-slate-400">Laporan pemasukan klinik</p>
    </div>

    {{-- Stat Cards (small-box style) --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">

        {{-- Hari Ini --}}
        <div class="bg-blue-500 rounded-sm shadow-[0_0.5rem_1rem_rgba(0,0,0,0.1)] text-white relative overflow-hidden">
            <div class="p-4">
                <p class="text-xl font-bold" data-testid="keuangan-pemasukan-hari-ini">Rp
                    {{ number_format($pemasukanHariIni, 0, ',', '.') }}</p>
                <p class="text-sm">Hari Ini</p>
            </div>
            <div class="absolute -right-2 -bottom-3 opacity-25">
                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="px-4 pb-2 text-xs text-white/80">{{ now()->translatedFormat('d F Y') }}</div>
        </div>

        {{-- Bulan Ini --}}
        <div class="bg-green-500 rounded-sm shadow-[0_0.5rem_1rem_rgba(0,0,0,0.1)] text-white relative overflow-hidden">
            <div class="p-4">
                <p class="text-xl font-bold" data-testid="keuangan-pemasukan-bulan-ini">Rp
                    {{ number_format($pemasukanBulanIni, 0, ',', '.') }}</p>
                <p class="text-sm">Bulan Ini</p>
            </div>
            <div class="absolute -right-2 -bottom-3 opacity-25">
                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
            </div>
            <div class="px-4 pb-2 text-xs text-white/80">
                {{ \Carbon\Carbon::create()->month($bulan)->translatedFormat('F') }} {{ $tahun }}
            </div>
        </div>

        {{-- Total Transaksi --}}
        <div
            class="bg-yellow-500 rounded-sm shadow-[0_0.5rem_1rem_rgba(0,0,0,0.1)] text-white relative overflow-hidden">
            <div class="p-4">
                <p class="text-xl font-bold" data-testid="keuangan-total-transaksi">{{ $totalTransaksi }}</p>
                <p class="text-sm">Transaksi</p>
            </div>
            <div class="absolute -right-2 -bottom-3 opacity-25">
                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
            <div class="px-4 pb-2 text-xs text-white/80">Transaksi lunas</div>
        </div>

        {{-- Belum Bayar --}}
        <div class="bg-red-500 rounded-sm shadow-[0_0.5rem_1rem_rgba(0,0,0,0.1)] text-white relative overflow-hidden">
            <div class="p-4">
                <p class="text-xl font-bold" data-testid="keuangan-belum-bayar">{{ $totalBelumBayar }}</p>
                <p class="text-sm">Belum Bayar</p>
            </div>
            <div class="absolute -right-2 -bottom-3 opacity-25">
                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <div class="px-4 pb-2 text-xs text-white/80">Menunggu pembayaran</div>
        </div>

    </div>

    <div class="grid grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="col-span-2 space-y-4">
            <x-keuangan.table :pembayarans="$pembayarans" />
            <x-keuangan.riwayat :bulan="$bulan" :tahun="$tahun" :transaksis="$transaksis" />
        </div>
        <x-keuangan.ringkasan :pemasukanBulanIni="$pemasukanBulanIni" :totalTransaksi="$totalTransaksi" />
    </div>
</div>
@endsection
