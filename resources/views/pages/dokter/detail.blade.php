@extends('layouts.app')

@section('title', $dokter->nama . ' - KAS Aesthetic Clinic')

@section('content')
    <div class="p-6 space-y-6">

        {{-- Header --}}
        <div class="flex items-center gap-3">
            <a href="{{ route('dokter.index') }}"
                class="w-9 h-9 rounded-xl border border-gray-200 flex items-center justify-center hover:bg-gray-50 transition">
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-primary-400">Detail Dokter</h1>
                <p class="text-sm text-gray-400 mt-0.5">Informasi lengkap dokter</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Kolom Kiri: Profil --}}
            <div class="space-y-4">

                {{-- Card Profil --}}
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">

                    {{-- Foto --}}
                    <div class="relative aspect-square bg-gradient-to-br from-primary-50 to-indigo-50 overflow-hidden">
                        <img src="{{ $dokter->foto ? asset('storage/' . $dokter->foto) : asset('images/default.png') }}"
                            alt="{{ $dokter->nama }}"
                            class="w-full h-full object-cover object-top">

                        {{-- Status badge --}}
                        @php
                            $hariIni = now()->locale('id')->dayName;
                            $jadwal = is_array($dokter->jadwal_praktik)
                                        ? $dokter->jadwal_praktik
                                        : json_decode($dokter->jadwal_praktik ?? '[]', true);
                            $praktek = in_array(ucfirst($hariIni), $jadwal ?? []);
                        @endphp

                        <div class="absolute bottom-3 left-3">
                            @if ($praktek)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white/95 backdrop-blur-md rounded-full text-xs font-semibold text-green-700 shadow-lg">
                                    <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                                    Praktek Hari Ini
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white/95 backdrop-blur-md rounded-full text-xs font-semibold text-gray-500 shadow-lg">
                                    <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                                    Tidak Praktek
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Info Utama --}}
                    <div class="p-5">
                        <h2 class="text-xl font-bold text-gray-800">{{ $dokter->nama }}</h2>
                        <p class="text-sm font-medium text-primary-600 mt-0.5">{{ $dokter->spesialis ?? '—' }}</p>

                        <div class="mt-4 space-y-3">

                            {{-- Email --}}
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-primary-50 rounded-lg flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <p class="text-sm text-gray-600 truncate">{{ $dokter->email ?? '—' }}</p>
                            </div>

                            {{-- Telepon --}}
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-indigo-50 rounded-lg flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>
                                <p class="text-sm text-gray-600">{{ $dokter->no_telepon ?? '—' }}</p>
                            </div>

                            {{-- Tanggal Lahir --}}
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-orange-50 rounded-lg flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <p class="text-sm text-gray-600">
                                    {{ $dokter->tanggal_lahir ? $dokter->tanggal_lahir->translatedFormat('d F Y') : '—' }}
                                </p>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- Jadwal Praktik --}}
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                    <h3 class="font-semibold text-gray-700 text-sm mb-4">Jadwal Praktik</h3>

                    @php
                        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                        $jadwalDokter = is_array($dokter->jadwal_praktik)
                            ? $dokter->jadwal_praktik
                            : json_decode($dokter->jadwal_praktik ?? '[]', true);
                    @endphp

                    <div class="flex flex-wrap gap-2">
                        @foreach ($hariList as $hari)
                            @if (in_array($hari, $jadwalDokter ?? []))
                                <span class="px-3 py-1.5 text-xs font-semibold bg-primary-50 text-primary-700 rounded-lg border border-primary-200">
                                    {{ $hari }}
                                </span>
                            @else
                                <span class="px-3 py-1.5 text-xs font-medium bg-gray-50 text-gray-400 rounded-lg border border-gray-100">
                                    {{ $hari }}
                                </span>
                            @endif
                        @endforeach
                    </div>

                    @if (empty($jadwalDokter))
                        <p class="text-sm text-gray-400 text-center py-2">Belum ada jadwal</p>
                    @endif
                </div>

            </div>

            {{-- Kolom Kanan: Riwayat Pelayanan --}}
            <div class="lg:col-span-2 space-y-4">

                {{-- Stat Cards --}}
                <div class="grid grid-cols-3 gap-4">
                    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
                        <p class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-2">Total Pelayanan</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $totalPelayanan }}</p>
                    </div>
                    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
                        <p class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-2">Bulan Ini</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $pelayananBulanIni }}</p>
                    </div>
                    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
                        <p class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-2">Hari Ini</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $pelayananHariIni }}</p>
                    </div>
                </div>

                {{-- Tabel Riwayat Pelayanan --}}
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-100">
                        <h3 class="font-semibold text-gray-700 text-sm">Riwayat Pelayanan</h3>
                        <p class="text-xs text-gray-400 mt-0.5">10 pelayanan terakhir</p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-gray-50 text-xs text-gray-400 uppercase tracking-wider">
                                    <th class="px-5 py-3 text-left font-medium">Pasien</th>
                                    <th class="px-5 py-3 text-left font-medium">Tanggal</th>
                                    <th class="px-5 py-3 text-left font-medium">Status</th>
                                    <th class="px-5 py-3 text-left font-medium">Antrian</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse ($pelayananTerakhir as $pelayanan)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-5 py-3.5">
                                            <div class="flex items-center gap-2.5">
                                                <div class="w-7 h-7 rounded-full bg-primary-100 text-primary-700 flex items-center justify-center font-semibold text-xs shrink-0">
                                                    {{ strtoupper(substr($pelayanan->pasien->nama ?? '?', 0, 1)) }}
                                                </div>
                                                <span class="font-medium text-gray-800">{{ $pelayanan->pasien->nama ?? '—' }}</span>
                                            </div>
                                        </td>
                                        <td class="px-5 py-3.5 text-gray-500 text-xs">
                                            {{ \Carbon\Carbon::parse($pelayanan->tanggal)->translatedFormat('d M Y') }}
                                        </td>
                                        <td class="px-5 py-3.5">
                                            @if ($pelayanan->status === 'selesai')
                                                <span class="text-xs px-2 py-1 rounded-full bg-green-50 text-green-700 font-medium">Selesai</span>
                                            @elseif ($pelayanan->status === 'menunggu')
                                                <span class="text-xs px-2 py-1 rounded-full bg-yellow-50 text-yellow-700 font-medium">Menunggu</span>
                                            @elseif ($pelayanan->status === 'dalam_proses')
                                                <span class="text-xs px-2 py-1 rounded-full bg-blue-50 text-blue-700 font-medium">Dalam Proses</span>
                                            @else
                                                <span class="text-xs px-2 py-1 rounded-full bg-red-50 text-red-700 font-medium">Batal</span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-3.5">
                                            <span class="text-xs font-semibold text-gray-600">#{{ $pelayanan->nomor_antrian }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-12 text-center">
                                            <div class="flex flex-col items-center gap-2 text-gray-400">
                                                <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                    </svg>
                                                </div>
                                                <p class="text-sm font-medium text-gray-500">Belum ada riwayat pelayanan</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
