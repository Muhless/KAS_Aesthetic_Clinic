@extends('layouts.app')

@section('title', 'Keuangan - KAS Aesthetic Clinic')

@section('content')
    <div class="p-6 space-y-6">

        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-primary-400">Keuangan</h1>
                <p class="text-sm text-gray-400 mt-1">Laporan pemasukan klinik</p>
            </div>


        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Hari Ini</p>
                    <div class="w-8 h-8 bg-primary-50 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <p class="text-xl font-bold text-gray-800">Rp {{ number_format($pemasukanHariIni, 0, ',', '.') }}</p>
                <p class="text-xs text-gray-400 mt-1">{{ now()->translatedFormat('d F Y') }}</p>
            </div>

            {{-- Pemasukan Bulan Ini --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Bulan Ini</p>
                    <div class="w-8 h-8 bg-green-50 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                </div>
                <p class="text-xl font-bold text-gray-800">Rp {{ number_format($pemasukanBulanIni, 0, ',', '.') }}</p>
                <p class="text-xs text-gray-400 mt-1">
                    {{ \Carbon\Carbon::create()->month($bulan)->translatedFormat('F') }} {{ $tahun }}
                </p>
            </div>

            {{-- Total Transaksi --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Transaksi</p>
                    <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                </div>
                <p class="text-xl font-bold text-gray-800">{{ $totalTransaksi }}</p>
                <p class="text-xs text-gray-400 mt-1">Transaksi lunas</p>
            </div>

            {{-- Belum Bayar --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Belum Bayar</p>
                    <div class="w-8 h-8 bg-red-50 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                </div>
                <p class="text-xl font-bold text-gray-800">{{ $totalBelumBayar }}</p>
                <p class="text-xs text-gray-400 mt-1">Menunggu pembayaran</p>
            </div>

        </div>

        <div class="grid grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="col-span-2 space-y-4">
                <x-keuangan.table :pembayarans="$pembayarans" />
                <x-keuangan.riwayat :bulan="$bulan" :tahun="$tahun" :transaksis="$transaksis" />
            </div>
            <x-keuangan.ringkasan :pemasukanBulanIni="$pemasukanBulanIni" :totalTransaksi="$totalTransaksi" />
        </div>
    </div>
@endsection
