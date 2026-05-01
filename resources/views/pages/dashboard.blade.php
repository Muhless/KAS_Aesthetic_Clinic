@extends('layouts.app')

@section('title', 'Halaman Awal')

@section('content')
    <div class="p-6 space-y-6">

        {{-- Header --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl font-semibold text-slate-800">Halaman Awal</h1>
                <p class="text-sm text-slate-400 mt-0.5">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="text-right">
                    <p class="text-sm font-medium text-slate-800">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-slate-400">{{ ucfirst(auth()->user()->role) }}</p>
                </div>
                <div
                    class="w-9 h-9 bg-primary-100 rounded-xl flex items-center justify-center text-primary-600 font-semibold text-sm">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            </div>
        </div>

        {{-- Stat Cards --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-2xl p-5 border border-slate-100">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Reservasi</p>
                    <div class="w-8 h-8 bg-primary-50 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-semibold text-slate-800">3</p>
                <p class="text-xs text-slate-400 mt-1">Hari ini</p>
            </div>

            <div class="bg-white rounded-2xl p-5 border border-slate-100">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Antrian</p>
                    <div class="w-8 h-8 bg-violet-50 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0" />
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-semibold text-slate-800">2</p>
                <p class="text-xs text-slate-400 mt-1">Menunggu</p>
            </div>

            <div class="bg-white rounded-2xl p-5 border border-slate-100">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Dokter</p>
                    <div class="w-8 h-8 bg-emerald-50 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-semibold text-slate-800">4</p>
                <p class="text-xs text-slate-400 mt-1">Bertugas</p>
            </div>

            <div class="bg-white rounded-2xl p-5 border border-slate-100">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Perawat</p>
                    <div class="w-8 h-8 bg-rose-50 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-semibold text-slate-800">6</p>
                <p class="text-xs text-slate-400 mt-1">Bertugas</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Kiri --}}
            <div class="lg:col-span-2 space-y-5">

                {{-- Pasien Selanjutnya --}}
                <div class="bg-primary-500 rounded-2xl p-5 text-white">
                    <p class="text-primary-100 text-xs font-medium uppercase tracking-wider mb-4">Pasien Selanjutnya</p>
                    <div class="flex items-center gap-4">
                        <div
                            class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center font-semibold text-lg shrink-0">
                            R
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-lg truncate">Ny. Rina Rani</p>
                            <p class="text-primary-100 text-sm truncate">Facial Treatment &bull; Dr. Muhta Nuryadi</p>
                        </div>
                        <div class="text-right shrink-0">
                            <p class="text-2xl font-semibold">15:00</p>
                            <span class="text-xs bg-white/20 px-2.5 py-1 rounded-full">Menunggu</span>
                        </div>
                    </div>
                </div>

                {{-- Tabel --}}
                <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden">
                    <div class="flex items-center justify-between px-5 py-4 border-b border-slate-50">
                        <h2 class="font-semibold text-slate-800 text-sm">Pasien Hari Ini</h2>
                        <button
                            class="text-xs bg-primary-500 hover:bg-primary-600 text-white px-3 py-1.5 rounded-lg transition cursor-pointer">
                            + Tambah Antrian
                        </button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-slate-50 text-xs text-slate-400 uppercase tracking-wider">
                                    <th class="px-5 py-3 text-left font-medium">Nama Pasien</th>
                                    <th class="px-5 py-3 text-left font-medium">Treatment</th>
                                    <th class="px-5 py-3 text-left font-medium">Dokter</th>
                                    <th class="px-5 py-3 text-left font-medium">Jam</th>
                                    <th class="px-5 py-3 text-left font-medium">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="px-5 py-3.5 font-medium text-slate-800">Ayu Lestari</td>
                                    <td class="px-5 py-3.5 text-slate-500">Chemical Peeling</td>
                                    <td class="px-5 py-3.5 text-slate-500">Dr. Muhta</td>
                                    <td class="px-5 py-3.5 text-slate-500">10:00</td>
                                    <td class="px-5 py-3.5">
                                        <span
                                            class="text-xs px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-600 font-medium">Selesai</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="px-5 py-3.5 font-medium text-slate-800">Nanda Putri</td>
                                    <td class="px-5 py-3.5 text-slate-500">Facial Glow</td>
                                    <td class="px-5 py-3.5 text-slate-500">Dr. Natasya</td>
                                    <td class="px-5 py-3.5 text-slate-500">12:30</td>
                                    <td class="px-5 py-3.5">
                                        <span
                                            class="text-xs px-2.5 py-1 rounded-full bg-amber-50 text-amber-600 font-medium">Menunggu</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="px-5 py-3.5 font-medium text-slate-800">Rika Amelia</td>
                                    <td class="px-5 py-3.5 text-slate-500">Laser Acne</td>
                                    <td class="px-5 py-3.5 text-slate-500">Dr. Muhta</td>
                                    <td class="px-5 py-3.5 text-slate-500">15:00</td>
                                    <td class="px-5 py-3.5">
                                        <span
                                            class="text-xs px-2.5 py-1 rounded-full bg-primary-50 text-primary-600 font-medium">Proses</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="px-5 py-3.5 font-medium text-slate-800">Rina Rani</td>
                                    <td class="px-5 py-3.5 text-slate-500">Facial Treatment</td>
                                    <td class="px-5 py-3.5 text-slate-500">Dr. Muhta</td>
                                    <td class="px-5 py-3.5 text-slate-500">15:00</td>
                                    <td class="px-5 py-3.5">
                                        <span
                                            class="text-xs px-2.5 py-1 rounded-full bg-rose-50 text-rose-500 font-medium">Antrian</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Kanan --}}
            <div class="space-y-5">

                {{-- Dokter Hari Ini --}}
                <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden">
                    <div class="px-5 py-4 border-b border-slate-50">
                        <h3 class="font-semibold text-slate-800 text-sm">Dokter Hari Ini</h3>
                    </div>
                    <div class="divide-y divide-slate-50">
                        <div class="flex items-center gap-3 px-5 py-3.5">
                            <div
                                class="w-9 h-9 bg-primary-100 rounded-xl flex items-center justify-center text-primary-600 font-semibold text-xs shrink-0">
                                MN</div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-slate-800 truncate">Dr. Muhta Nuryadi</p>
                                <p class="text-xs text-slate-400 truncate">Spesialis Kulit & Kecantikan</p>
                            </div>
                            <span class="w-2 h-2 bg-emerald-400 rounded-full shrink-0"></span>
                        </div>
                        <div class="flex items-center gap-3 px-5 py-3.5">
                            <div
                                class="w-9 h-9 bg-violet-100 rounded-xl flex items-center justify-center text-violet-600 font-semibold text-xs shrink-0">
                                NP</div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-slate-800 truncate">Dr. Natasya Putri</p>
                                <p class="text-xs text-slate-400 truncate">Ahli Estetika Wajah</p>
                            </div>
                            <span class="w-2 h-2 bg-emerald-400 rounded-full shrink-0"></span>
                        </div>
                    </div>
                </div>

                {{-- Ringkasan Status --}}
                <div class="bg-white rounded-2xl border border-slate-100 p-5">
                    <h3 class="font-semibold text-slate-800 text-sm mb-4">Ringkasan Status</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 bg-emerald-400 rounded-full"></span>
                                <span class="text-xs text-slate-500">Selesai</span>
                            </div>
                            <span class="text-xs font-semibold text-slate-800">1</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 bg-primary-400 rounded-full"></span>
                                <span class="text-xs text-slate-500">Proses</span>
                            </div>
                            <span class="text-xs font-semibold text-slate-800">1</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 bg-amber-400 rounded-full"></span>
                                <span class="text-xs text-slate-500">Menunggu</span>
                            </div>
                            <span class="text-xs font-semibold text-slate-800">1</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 bg-rose-400 rounded-full"></span>
                                <span class="text-xs text-slate-500">Antrian</span>
                            </div>
                            <span class="text-xs font-semibold text-slate-800">2</span>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection
