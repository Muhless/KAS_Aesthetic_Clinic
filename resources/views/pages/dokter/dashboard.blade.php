@extends('layouts.app')

@section('title', 'Dashboard Dokter')

@section('content')
    <div class="p-6 space-y-6">

        {{-- Header --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    Selamat datang, {{ $dokter->nama ?? auth()->user()->username }} 👋
                </h1>
                <p class="text-sm text-gray-400 mt-1">{{ now()->translatedFormat('l, d F Y') }}</p>
            </div>
        </div>

        {{-- Stat Cards --}}
        <div class="grid grid-cols-3 gap-4">
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm px-5 py-4">
                <p class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-2">Menunggu</p>
                <p class="text-3xl font-bold text-yellow-500">{{ $totalMenunggu }}</p>
                <p class="text-xs text-gray-400 mt-1">Pasien hari ini</p>
            </div>
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm px-5 py-4">
                <p class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-2">Dipanggil</p>
                <p class="text-3xl font-bold text-blue-500">{{ $totalDipanggil }}</p>
                <p class="text-xs text-gray-400 mt-1">Sedang diperiksa</p>
            </div>
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm px-5 py-4">
                <p class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-2">Selesai</p>
                <p class="text-3xl font-bold text-green-500">{{ $totalSelesai }}</p>
                <p class="text-xs text-gray-400 mt-1">Hari ini</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <x-dokter.tablee :pelayanans="$pelayanans" />
            {{-- Kanan --}}
            <div class="space-y-4">

                {{-- Daftar Treatment --}}
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-100">
                        <h3 class="font-semibold text-gray-700 text-sm">Treatment Tersedia</h3>
                    </div>
                    <div class="divide-y divide-gray-50 max-h-48 overflow-y-auto">
                        @forelse ($treatments as $treatment)
                            <div class="flex items-center justify-between px-5 py-3">
                                <div>
                                    <p class="text-sm font-medium text-gray-700">{{ $treatment->nama }}</p>
                                    @if ($treatment->durasi)
                                        <p class="text-xs text-gray-400">{{ $treatment->durasi }} menit</p>
                                    @endif
                                </div>
                                <span class="text-xs font-semibold text-primary-600">
                                    Rp {{ number_format($treatment->harga, 0, ',', '.') }}
                                </span>
                            </div>
                        @empty
                            <p class="text-xs text-gray-400 text-center py-4">Belum ada treatment</p>
                        @endforelse
                    </div>
                </div>

                {{-- Daftar Produk --}}
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-100">
                        <h3 class="font-semibold text-gray-700 text-sm">Produk Tersedia</h3>
                    </div>
                    <div class="divide-y divide-gray-50 max-h-48 overflow-y-auto">
                        @forelse ($produks as $produk)
                            <div class="flex items-center justify-between px-5 py-3">
                                <div>
                                    <p class="text-sm font-medium text-gray-700">{{ $produk->nama }}</p>
                                    <p class="text-xs text-gray-400">Stok: {{ $produk->stok }}</p>
                                </div>
                                <span class="text-xs font-semibold text-primary-600">
                                    Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                </span>
                            </div>
                        @empty
                            <p class="text-xs text-gray-400 text-center py-4">Belum ada produk</p>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
