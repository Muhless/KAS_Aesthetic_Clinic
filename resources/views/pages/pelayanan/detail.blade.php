{{-- resources/views/pages/pelayanan/show.blade.php --}}

@extends('layouts.app')

@section('title', 'Detail Pelayanan - KAS Aesthetic Clinic')

@section('content')
    <div class="p-6 space-y-6">

        {{-- Header --}}
        <div class="flex items-center gap-4">
            <a href="{{ route('pelayanan.index') }}"
                class="p-2 rounded-xl text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                    <path fill-rule="evenodd"
                        d="M17 10a.75.75 0 0 1-.75.75H5.612l4.158 3.96a.75.75 0 1 1-1.04 1.08l-5.5-5.25a.75.75 0 0 1 0-1.08l5.5-5.25a.75.75 0 1 1 1.04 1.08L5.612 9.25H16.25A.75.75 0 0 1 17 10Z"
                        clip-rule="evenodd" />
                </svg>
            </a>
            <div>
                <h1 class="text-lg font-semibold text-slate-800">Detail Pelayanan</h1>
                <p class="text-sm text-slate-400 mt-0.5">Antrian #{{ $pelayanan->nomor_antrian }} —
                    {{ \Carbon\Carbon::parse($pelayanan->tanggal)->translatedFormat('d F Y') }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Kolom Kiri --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Info Pelayanan --}}
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                        <h2 class="font-semibold text-slate-700 text-sm">Informasi Pelayanan</h2>
                        @if ($pelayanan->status === 'selesai')
                            <span
                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-600">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 inline-block"></span>
                                Selesai
                            </span>
                        @elseif($pelayanan->status === 'dipanggil')
                            <span
                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-600">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-400 inline-block"></span>
                                Dipanggil
                            </span>
                        @else
                            <span
                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-600">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-400 inline-block"></span>
                                Menunggu
                            </span>
                        @endif
                    </div>
                    <div class="p-5 grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-slate-400 mb-1">Tanggal</p>
                            <p class="text-sm text-slate-700">
                                {{ \Carbon\Carbon::parse($pelayanan->tanggal)->translatedFormat('d F Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 mb-1">Nomor Antrian</p>
                            <p class="text-sm font-medium text-slate-700">#{{ $pelayanan->nomor_antrian }}</p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-xs text-slate-400 mb-1">Keluhan</p>
                            <p class="text-sm text-slate-700">{{ $pelayanan->keluhan ?? '—' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Pemeriksaan --}}
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                        <h2 class="font-semibold text-slate-700 text-sm">Pemeriksaan</h2>
                    </div>

                    @if ($pelayanan->pemeriksaan)
                        <div class="p-5 space-y-4">
                            @if ($pelayanan->pemeriksaan->treatment)
                                <div>
                                    <p class="text-xs text-slate-400 mb-1">Treatment</p>
                                    <p class="text-sm text-slate-700">{{ $pelayanan->pemeriksaan->treatment->nama }}</p>
                                </div>
                            @endif
                            @if ($pelayanan->pemeriksaan->diagnosa)
                                <div>
                                    <p class="text-xs text-slate-400 mb-1">Diagnosa</p>
                                    <p class="text-sm text-slate-700">{{ $pelayanan->pemeriksaan->diagnosa }}</p>
                                </div>
                            @endif
                            @if ($pelayanan->pemeriksaan->tindakan)
                                <div>
                                    <p class="text-xs text-slate-400 mb-1">Tindakan</p>
                                    <p class="text-sm text-slate-700">{{ $pelayanan->pemeriksaan->tindakan }}</p>
                                </div>
                            @endif
                            @if ($pelayanan->pemeriksaan->resep)
                                <div>
                                    <p class="text-xs text-slate-400 mb-1">Resep</p>
                                    <p class="text-sm text-slate-700">{{ $pelayanan->pemeriksaan->resep }}</p>
                                </div>
                            @endif
                            @if ($pelayanan->pemeriksaan->catatan)
                                <div>
                                    <p class="text-xs text-slate-400 mb-1">Catatan</p>
                                    <p class="text-sm text-slate-700">{{ $pelayanan->pemeriksaan->catatan }}</p>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="p-5 text-center">
                            <div class="flex flex-col items-center gap-2 py-6">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="size-8 text-slate-200">
                                    <path fill-rule="evenodd"
                                        d="M4 4a2 2 0 0 1 2-2h4.586A2 2 0 0 1 12 2.586L15.414 6A2 2 0 0 1 16 7.414V16a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4Z"
                                        clip-rule="evenodd" />
                                </svg>
                                <p class="text-sm text-slate-400">Belum ada data pemeriksaan</p>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Pembayaran --}}
                @if ($pelayanan->pembayaran)
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                        <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                            <h2 class="font-semibold text-slate-700 text-sm">Pembayaran</h2>
                            @if ($pelayanan->pembayaran->status === 'lunas')
                                <span
                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-600">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 inline-block"></span>
                                    Lunas
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-rose-50 text-rose-600">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-400 inline-block"></span>
                                    Belum Bayar
                                </span>
                            @endif
                        </div>
                        <div class="p-5 grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-slate-400 mb-1">Total Harga</p>
                                <p class="text-xl font-bold text-slate-800">Rp
                                    {{ number_format($pelayanan->pembayaran->total_harga, 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400 mb-1">Metode Bayar</p>
                                <p class="text-sm text-slate-700">{{ $pelayanan->pembayaran->metode_bayar ?? '—' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400 mb-1">Dibayar Pada</p>
                                <p class="text-sm text-slate-700">
                                    {{ $pelayanan->pembayaran->dibayar_pada
                                        ? \Carbon\Carbon::parse($pelayanan->pembayaran->dibayar_pada)->translatedFormat('d F Y, H:i')
                                        : '—' }}
                                </p>
                            </div>
                            @if ($pelayanan->pembayaran->catatan)
                                <div>
                                    <p class="text-xs text-slate-400 mb-1">Catatan</p>
                                    <p class="text-sm text-slate-700">{{ $pelayanan->pembayaran->catatan }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

            </div>

            {{-- Kolom Kanan --}}
            <div class="space-y-4">

                {{-- Info Pasien --}}
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                    <h3 class="font-semibold text-slate-700 text-sm mb-4">Pasien</h3>
                    <div class="flex items-center gap-3 mb-4">
                        <div
                            class="w-10 h-10 rounded-full bg-primary-100 text-primary-700 flex items-center justify-center font-bold text-sm shrink-0">
                            {{ strtoupper(substr($pelayanan->pasien->nama ?? '?', 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-semibold text-slate-800 text-sm">{{ $pelayanan->pasien->nama ?? '—' }}</p>
                            <p class="text-xs text-slate-400">{{ $pelayanan->pasien->no_rm ?? '' }}</p>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-xs text-slate-400">No. HP</span>
                            <span class="text-xs text-slate-700">{{ $pelayanan->pasien->no_hp ?? '—' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-xs text-slate-400">Jenis Kelamin</span>
                            <span class="text-xs text-slate-700">{{ $pelayanan->pasien->jenis_kelamin ?? '—' }}</span>
                        </div>
                    </div>
                </div>

                {{-- Info Dokter --}}
                @if ($pelayanan->dokter)
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                        <h3 class="font-semibold text-slate-700 text-sm mb-4">Dokter</h3>
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-sm shrink-0">
                                {{ strtoupper(substr($pelayanan->dokter->nama ?? '?', 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-semibold text-slate-800 text-sm">{{ $pelayanan->dokter->nama ?? '—' }}</p>
                                <p class="text-xs text-slate-400">{{ $pelayanan->dokter->spesialis ?? '' }}</p>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection
