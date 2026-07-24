@extends('layouts.app')

@section('title', $dokter->nama . ' - KAS Aesthetic Clinic')

@section('content')
<div class="p-4 space-y-4">

    {{-- Header --}}
    <div class="flex items-center gap-2.5">
        <a href="{{ route('dokter.index') }}"
            class="w-8 h-8 rounded-sm border border-slate-300 flex items-center justify-center hover:bg-slate-100 transition">
            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <div>
            <h1 class="text-xl font-semibold text-slate-700">Detail Dokter</h1>
            <p class="text-xs text-slate-400">Informasi lengkap dokter</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

        {{-- Kolom Kiri: Profil --}}
        <div class="space-y-4">

            {{-- Card Profil --}}
            <div
                class="bg-white rounded-sm shadow-[0_0.5rem_1rem_rgba(0,0,0,0.1)] border border-black/10 overflow-hidden">

                {{-- Foto --}}
                <div class="relative bg-slate-100">
                    <img src="{{ $dokter->foto ? asset('storage/' . $dokter->foto) : asset('images/default.png') }}"
                        alt="{{ $dokter->nama }}" class="w-full h-56 object-cover object-top">

                    {{-- Status badge --}}
                    @php
                    $hariIni = now()->locale('id')->dayName;
                    $jadwal = is_array($dokter->jadwal_praktik)
                    ? $dokter->jadwal_praktik
                    : json_decode($dokter->jadwal_praktik ?? '[]', true);
                    $praktek = in_array(ucfirst($hariIni), $jadwal ?? []);
                    @endphp

                    <div class="absolute bottom-2 left-2">
                        @if ($praktek)
                        <span
                            class="inline-flex items-center gap-1.5 px-2 py-1 bg-green-500 rounded-sm text-xs font-semibold text-white">
                            <span class="w-1.5 h-1.5 bg-white rounded-full"></span>
                            Praktek Hari Ini
                        </span>
                        @else
                        <span
                            class="inline-flex items-center gap-1.5 px-2 py-1 bg-slate-500 rounded-sm text-xs font-semibold text-white">
                            <span class="w-1.5 h-1.5 bg-white rounded-full"></span>
                            Tidak Praktek
                        </span>
                        @endif
                    </div>
                </div>

                {{-- Info Utama --}}
                <div class="p-4">
                    <h2 class="text-base font-semibold text-slate-700">{{ $dokter->nama }}</h2>
                    <p class="text-sm font-medium text-blue-500 mt-0.5">{{ $dokter->spesialis ?? '—' }}</p>

                    <div class="mt-3 space-y-2 text-sm text-slate-600">

                        {{-- Email --}}
                        <div class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span class="truncate">{{ $dokter->email ?? '—' }}</span>
                        </div>

                        {{-- Telepon --}}
                        <div class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <span>{{ $dokter->no_telepon ?? '—' }}</span>
                        </div>

                        {{-- Tanggal Lahir --}}
                        <div class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>
                                {{ $dokter->tanggal_lahir ? $dokter->tanggal_lahir->translatedFormat('d F Y') : '—' }}
                            </span>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Jadwal Praktik --}}
            <div class="bg-white rounded-sm shadow-[0_0.5rem_1rem_rgba(0,0,0,0.1)] border border-black/10 p-4">
                <h5 class="font-semibold text-slate-700 text-sm mb-3">Jadwal Praktik</h5>

                @php
                $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                $jadwalDokter = is_array($dokter->jadwal_praktik)
                ? $dokter->jadwal_praktik
                : json_decode($dokter->jadwal_praktik ?? '[]', true);
                @endphp

                <div class="flex flex-wrap gap-1.5">
                    @foreach ($hariList as $hari)
                    @if (in_array($hari, $jadwalDokter ?? []))
                    <span class="px-2 py-1 text-xs font-medium bg-blue-500 text-white rounded-sm">
                        {{ $hari }}
                    </span>
                    @else
                    <span class="px-2 py-1 text-xs font-medium bg-slate-100 text-slate-400 rounded-sm">
                        {{ $hari }}
                    </span>
                    @endif
                    @endforeach
                </div>

                @if (empty($jadwalDokter))
                <p class="text-sm text-slate-400 text-center py-2">Belum ada jadwal</p>
                @endif
            </div>

        </div>

        {{-- Kolom Kanan: Riwayat Pelayanan --}}
        <div class="lg:col-span-2 space-y-4">

            {{-- Stat Cards --}}
            <div class="grid grid-cols-3 gap-3">
                <div class="bg-white rounded-sm shadow-[0_0.5rem_1rem_rgba(0,0,0,0.1)] border border-black/10 p-3">
                    <p class="text-xs font-medium text-slate-400 uppercase mb-1">Total Pelayanan</p>
                    <p class="text-xl font-bold text-slate-700">{{ $totalPelayanan }}</p>
                </div>
                <div class="bg-white rounded-sm shadow-[0_0.5rem_1rem_rgba(0,0,0,0.1)] border border-black/10 p-3">
                    <p class="text-xs font-medium text-slate-400 uppercase mb-1">Bulan Ini</p>
                    <p class="text-xl font-bold text-slate-700">{{ $pelayananBulanIni }}</p>
                </div>
                <div class="bg-white rounded-sm shadow-[0_0.5rem_1rem_rgba(0,0,0,0.1)] border border-black/10 p-3">
                    <p class="text-xs font-medium text-slate-400 uppercase mb-1">Hari Ini</p>
                    <p class="text-xl font-bold text-slate-700">{{ $pelayananHariIni }}</p>
                </div>
            </div>

            {{-- Tabel Riwayat Pelayanan --}}
            <div
                class="bg-white rounded-sm shadow-[0_0.5rem_1rem_rgba(0,0,0,0.1)] border border-black/10 overflow-hidden">
                <div class="px-4 py-3 bg-slate-100 border-b border-black/10">
                    <h5 class="font-semibold text-slate-700 text-sm m-0">Riwayat Pelayanan</h5>
                    <p class="text-xs text-slate-400 m-0">10 pelayanan terakhir</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-slate-100 text-xs text-slate-600 uppercase">
                                <th class="px-3 py-2 text-left font-semibold border-b border-black/10">Pasien</th>
                                <th class="px-3 py-2 text-left font-semibold border-b border-black/10">Tanggal</th>
                                <th class="px-3 py-2 text-left font-semibold border-b border-black/10">Status</th>
                                <th class="px-3 py-2 text-left font-semibold border-b border-black/10">Antrian</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pelayananTerakhir as $pelayanan)
                            <tr class="border-b border-black/10 even:bg-slate-50 hover:bg-slate-100 transition">
                                <td class="px-3 py-2.5">
                                    <div class="flex items-center gap-2">
                                        <div
                                            class="w-7 h-7 rounded-full bg-slate-200 text-slate-600 flex items-center justify-center font-semibold text-xs shrink-0">
                                            {{ strtoupper(substr($pelayanan->pasien->nama ?? '?', 0, 1)) }}
                                        </div>
                                        <span
                                            class="font-medium text-slate-700">{{ $pelayanan->pasien->nama ?? '—' }}</span>
                                    </div>
                                </td>
                                <td class="px-3 py-2.5 text-slate-500 text-xs">
                                    {{ \Carbon\Carbon::parse($pelayanan->tanggal)->translatedFormat('d M Y') }}
                                </td>
                                <td class="px-3 py-2.5">
                                    @if ($pelayanan->status === 'selesai')
                                    <span
                                        class="text-xs px-2 py-1 rounded bg-green-500 text-white font-medium">Selesai</span>
                                    @elseif ($pelayanan->status === 'menunggu')
                                    <span
                                        class="text-xs px-2 py-1 rounded bg-yellow-500 text-white font-medium">Menunggu</span>
                                    @elseif ($pelayanan->status === 'dalam_proses')
                                    <span class="text-xs px-2 py-1 rounded bg-blue-500 text-white font-medium">Dalam
                                        Proses</span>
                                    @else
                                    <span
                                        class="text-xs px-2 py-1 rounded bg-red-500 text-white font-medium">Batal</span>
                                    @endif
                                </td>
                                <td class="px-3 py-2.5">
                                    <span
                                        class="text-xs font-semibold text-slate-600">#{{ $pelayanan->nomor_antrian }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-10 text-center text-slate-400 text-sm">
                                    Belum ada riwayat pelayanan
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
