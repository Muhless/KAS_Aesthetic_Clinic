@extends('layouts.app')

@section('title', 'Detail Pasien - ' . $pasien->nama)

@section('content')
    <div class="p-6 space-y-6">

        {{-- Breadcrumb --}}
        <div class="flex items-center gap-2 text-sm text-gray-400">
            <a href="{{ route('pasien.index') }}" class="hover:text-primary-500 transition">Pasien</a>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="text-gray-600 font-medium">{{ $pasien->nama }}</span>
        </div>

        {{-- Profil Pasien --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-primary-600 to-primary-500 px-6 py-5">
                <div class="flex items-center gap-4">
                    {{-- Avatar --}}
                    <div class="w-16 h-16 rounded-full flex items-center justify-center text-white text-2xl font-bold shrink-0
                        {{ $pasien->jenis_kelamin == 'P' ? 'bg-pink-400/30' : 'bg-blue-400/30' }}">
                        {{ strtoupper(substr($pasien->nama, 0, 1)) }}
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center gap-2">
                            <h1 class="text-xl font-bold text-white">{{ $pasien->nama }}</h1>
                            @if ($pasien->jenis_kelamin == 'L')
                                <span class="text-xs px-2 py-0.5 rounded-full bg-blue-400/20 text-blue-100">Laki-laki</span>
                            @elseif ($pasien->jenis_kelamin == 'P')
                                <span class="text-xs px-2 py-0.5 rounded-full bg-pink-400/20 text-pink-100">Perempuan</span>
                            @endif
                        </div>
                        <p class="text-primary-100 text-sm mt-0.5">
                            {{ $pasien->pelayanans->count() }} riwayat kunjungan
                        </p>
                    </div>
                    <a href="{{ route('pasien.edit', $pasien->id) }}"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-white/20 hover:bg-white/30 text-white text-sm rounded-lg transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m2.695 14.762-1.262 3.155a.5.5 0 0 0 .65.65l3.155-1.262a4 4 0 0 0 1.343-.886L17.5 5.501a2.121 2.121 0 0 0-3-3L3.58 13.419a4 4 0 0 0-.885 1.343Z" />
                        </svg>
                        Edit
                    </a>
                </div>
            </div>

            {{-- Info Grid --}}
            <div class="grid grid-cols-2 sm:grid-cols-4 divide-x divide-y sm:divide-y-0 divide-gray-100">
                <div class="px-5 py-4">
                    <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Tanggal Lahir</p>
                    <p class="text-sm font-medium text-gray-700">
                        {{ $pasien->tanggal_lahir ? \Carbon\Carbon::parse($pasien->tanggal_lahir)->translatedFormat('d F Y') : '—' }}
                    </p>
                </div>
                <div class="px-5 py-4">
                    <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Umur</p>
                    <p class="text-sm font-medium text-gray-700">
                        {{ $pasien->tanggal_lahir ? \Carbon\Carbon::parse($pasien->tanggal_lahir)->age . ' tahun' : '—' }}
                    </p>
                </div>
                <div class="px-5 py-4">
                    <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Nomor Telepon</p>
                    <p class="text-sm font-medium text-gray-700 font-mono">
                        {{ $pasien->nomor_telepon ?? '—' }}
                    </p>
                </div>
                <div class="px-5 py-4">
                    <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Terdaftar</p>
                    <p class="text-sm font-medium text-gray-700">
                        {{ $pasien->created_at->translatedFormat('d F Y') }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Riwayat Pelayanan --}}
        <div>
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Riwayat Kunjungan</h2>

            @if ($pasien->pelayanans->isNotEmpty())
                <div class="space-y-4">
                    @foreach ($pasien->pelayanans as $pelayanan)
                        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">

                            {{-- Header Kunjungan --}}
                            <div class="flex items-center justify-between px-5 py-3.5 bg-gray-50 border-b border-gray-100">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-700">
                                            {{ \Carbon\Carbon::parse($pelayanan->tanggal)->translatedFormat('d F Y') }}
                                        </p>
                                        <p class="text-xs text-gray-400">
                                            No. Antrian {{ $pelayanan->nomor_antrian }} &bull;
                                            {{ $pelayanan->dokter->nama ?? 'Dokter tidak tersedia' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    @if ($pelayanan->reservasi_id)
                                        <span class="text-xs px-2 py-1 rounded-full bg-violet-50 text-violet-700 font-medium">Reservasi</span>
                                    @else
                                        <span class="text-xs px-2 py-1 rounded-full bg-gray-100 text-gray-600 font-medium">Walk-in</span>
                                    @endif
                                    @if ($pelayanan->status == 'selesai')
                                        <span class="text-xs px-2 py-1 rounded-full bg-green-50 text-green-700 font-medium">Selesai</span>
                                    @elseif ($pelayanan->status == 'dipanggil')
                                        <span class="text-xs px-2 py-1 rounded-full bg-blue-50 text-blue-700 font-medium">Dipanggil</span>
                                    @else
                                        <span class="text-xs px-2 py-1 rounded-full bg-yellow-50 text-yellow-700 font-medium">Menunggu</span>
                                    @endif
                                    <a href="{{ route('pelayanan.show', $pelayanan->id) }}"
                                        class="text-xs px-3 py-1 rounded-full bg-primary-50 text-primary-600 hover:bg-primary-100 font-medium transition">
                                        Detail →
                                    </a>
                                </div>
                            </div>

                            {{-- Isi Kunjungan --}}
                            <div class="px-5 py-4">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                                    {{-- Keluhan --}}
                                    <div>
                                        <p class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Keluhan</p>
                                        <p class="text-sm text-gray-700">{{ $pelayanan->keluhan ?? '—' }}</p>
                                    </div>

                                    {{-- Pemeriksaan --}}
                                    @if ($pelayanan->pemeriksaan)
                                        <div>
                                            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Treatment</p>
                                            <p class="text-sm text-gray-700">{{ $pelayanan->pemeriksaan->treatment->nama ?? '—' }}</p>
                                        </div>

                                        <div>
                                            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Diagnosa</p>
                                            <p class="text-sm text-gray-700">{{ $pelayanan->pemeriksaan->diagnosa ?? '—' }}</p>
                                        </div>

                                        <div>
                                            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Tindakan</p>
                                            <p class="text-sm text-gray-700">{{ $pelayanan->pemeriksaan->tindakan ?? '—' }}</p>
                                        </div>

                                        @if ($pelayanan->pemeriksaan->resep)
                                            <div>
                                                <p class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Resep</p>
                                                <p class="text-sm text-gray-700">{{ $pelayanan->pemeriksaan->resep }}</p>
                                            </div>
                                        @endif

                                        @if ($pelayanan->pemeriksaan->catatan)
                                            <div>
                                                <p class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Catatan</p>
                                                <p class="text-sm text-gray-700">{{ $pelayanan->pemeriksaan->catatan }}</p>
                                            </div>
                                        @endif
                                    @else
                                        <div class="sm:col-span-1">
                                            <p class="text-xs text-gray-400 italic">Belum ada hasil pemeriksaan</p>
                                        </div>
                                    @endif
                                </div>

                                {{-- Pembayaran --}}
                                @if ($pelayanan->pembayaran)
                                    <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            <span class="text-sm font-semibold text-gray-800">
                                                Rp {{ number_format($pelayanan->pembayaran->total_harga, 0, ',', '.') }}
                                            </span>
                                            @if ($pelayanan->pembayaran->metode_bayar)
                                                <span class="text-xs text-gray-400">via {{ ucfirst($pelayanan->pembayaran->metode_bayar) }}</span>
                                            @endif
                                        </div>
                                        @if ($pelayanan->pembayaran->status == 'lunas')
                                            <span class="text-xs px-2.5 py-1 rounded-full bg-green-50 text-green-700 font-medium">Lunas</span>
                                        @else
                                            <span class="text-xs px-2.5 py-1 rounded-full bg-red-50 text-red-600 font-medium">Belum Bayar</span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

            {{-- Empty State --}}
            @else
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm flex flex-col items-center justify-center py-16 px-6">
                    <div class="w-14 h-14 rounded-full bg-primary-50 flex items-center justify-center mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-primary-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <p class="text-sm font-medium text-gray-500">Belum ada riwayat kunjungan</p>
                    <p class="text-xs text-gray-400 mt-1">Pasien belum pernah melakukan kunjungan</p>
                </div>
            @endif
        </div>
    </div>
@endsection
