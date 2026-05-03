@extends('layouts.app')

@section('title', 'Keuangan - KAS Aesthetic Clinic')

@section('content')
    <div class="p-6 space-y-6">

        {{-- Header --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-primary-400">Keuangan</h1>
                <p class="text-sm text-gray-400 mt-1">Laporan pemasukan klinik</p>
            </div>

            {{-- Filter Bulan & Tahun --}}
            <form method="GET" action="{{ route('keuangan.index') }}" class="flex items-center gap-2">
                <select name="bulan"
                    class="text-sm px-3 py-2 border border-gray-200 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent transition">
                    @foreach (range(1, 12) as $m)
                        <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                        </option>
                    @endforeach
                </select>
                <select name="tahun"
                    class="text-sm px-3 py-2 border border-gray-200 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent transition">
                    @foreach (range(now()->year - 2, now()->year) as $y)
                        <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
                <button type="submit"
                    class="text-sm px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition">
                    Filter
                </button>
            </form>
        </div>

        {{-- Stat Cards --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

            {{-- Pemasukan Hari Ini --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Hari Ini</p>
                    <div class="w-8 h-8 bg-primary-50 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                </div>
                <p class="text-xl font-bold text-gray-800">{{ $totalBelumBayar }}</p>
                <p class="text-xs text-gray-400 mt-1">Menunggu pembayaran</p>
            </div>

        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Tabel Transaksi --}}
            <div class="lg:col-span-2 bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100">
                    <h2 class="font-semibold text-gray-700 text-sm">Riwayat Transaksi</h2>
                    <p class="text-xs text-gray-400 mt-0.5">
                        {{ \Carbon\Carbon::create()->month($bulan)->translatedFormat('F') }} {{ $tahun }}
                    </p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 text-xs text-gray-400 uppercase tracking-wider">
                                <th class="px-5 py-3 text-left font-medium">Pasien</th>
                                <th class="px-5 py-3 text-left font-medium">Tanggal</th>
                                <th class="px-5 py-3 text-left font-medium">Metode</th>
                                <th class="px-5 py-3 text-right font-medium">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse ($transaksis as $transaksi)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-5 py-3.5">
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-7 h-7 rounded-full bg-primary-100 text-primary-700 flex items-center justify-center font-semibold text-xs shrink-0">
                                                {{ strtoupper(substr($transaksi->pelayanan->pasien->nama ?? '?', 0, 1)) }}
                                            </div>
                                            <span class="font-medium text-gray-800">{{ $transaksi->pelayanan->pasien->nama ?? '—' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-5 py-3.5 text-gray-500 text-xs">
                                        {{ \Carbon\Carbon::parse($transaksi->dibayar_pada)->translatedFormat('d M Y, H:i') }}
                                    </td>
                                    <td class="px-5 py-3.5">
                                        @if ($transaksi->metode_bayar == 'cash')
                                            <span class="text-xs px-2 py-1 rounded-full bg-green-50 text-green-700 font-medium">Cash</span>
                                        @elseif ($transaksi->metode_bayar == 'transfer')
                                            <span class="text-xs px-2 py-1 rounded-full bg-blue-50 text-blue-700 font-medium">Transfer</span>
                                        @elseif ($transaksi->metode_bayar == 'kartu')
                                            <span class="text-xs px-2 py-1 rounded-full bg-violet-50 text-violet-700 font-medium">Kartu</span>
                                        @else
                                            <span class="text-gray-300">—</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-3.5 text-right font-semibold text-gray-800">
                                        Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-12 text-center">
                                        <div class="flex flex-col items-center gap-2 text-gray-400">
                                            <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center">
                                                <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                </svg>
                                            </div>
                                            <p class="text-sm font-medium text-gray-500">Belum ada transaksi</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Kanan --}}
            <div class="space-y-4">

                {{-- Per Metode Bayar --}}
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                    <h3 class="font-semibold text-gray-700 text-sm mb-4">Per Metode Bayar</h3>
                    @if ($perMetode->isNotEmpty())
                        <div class="space-y-3">
                            @foreach ($perMetode as $item)
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        @if ($item->metode_bayar == 'cash')
                                            <span class="w-2 h-2 rounded-full bg-green-400"></span>
                                            <span class="text-sm text-gray-600">Cash</span>
                                        @elseif ($item->metode_bayar == 'transfer')
                                            <span class="w-2 h-2 rounded-full bg-blue-400"></span>
                                            <span class="text-sm text-gray-600">Transfer</span>
                                        @else
                                            <span class="w-2 h-2 rounded-full bg-violet-400"></span>
                                            <span class="text-sm text-gray-600">Kartu</span>
                                        @endif
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-semibold text-gray-800">Rp {{ number_format($item->total, 0, ',', '.') }}</p>
                                        <p class="text-xs text-gray-400">{{ $item->jumlah }} transaksi</p>
                                    </div>
                                </div>
                                {{-- Progress bar --}}
                                <div class="w-full bg-gray-100 rounded-full h-1.5 -mt-1">
                                    <div class="h-1.5 rounded-full {{ $item->metode_bayar == 'cash' ? 'bg-green-400' : ($item->metode_bayar == 'transfer' ? 'bg-blue-400' : 'bg-violet-400') }}"
                                        style="width: {{ $pemasukanBulanIni > 0 ? round(($item->total / $pemasukanBulanIni) * 100) : 0 }}%">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-400 text-center py-4">Belum ada data</p>
                    @endif
                </div>

                {{-- Ringkasan --}}
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                    <h3 class="font-semibold text-gray-700 text-sm mb-4">Ringkasan Bulan Ini</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between py-2 border-b border-gray-50">
                            <span class="text-xs text-gray-500">Total Pemasukan</span>
                            <span class="text-sm font-bold text-green-600">Rp {{ number_format($pemasukanBulanIni, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-gray-50">
                            <span class="text-xs text-gray-500">Jumlah Transaksi</span>
                            <span class="text-sm font-semibold text-gray-800">{{ $totalTransaksi }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2">
                            <span class="text-xs text-gray-500">Rata-rata per Transaksi</span>
                            <span class="text-sm font-semibold text-gray-800">
                                Rp {{ $totalTransaksi > 0 ? number_format($pemasukanBulanIni / $totalTransaksi, 0, ',', '.') : 0 }}
                            </span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
