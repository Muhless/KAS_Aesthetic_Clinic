@extends('layouts.app')

@section('title', 'Halaman Detail Dokter')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <!-- Header Profile -->
                <div class="p-8 border-b border-gray-200">
                    <div class="flex flex-col md:flex-row gap-6">
                        <!-- Foto -->
                        <div class="shrink-0">
                            <img src="{{ $dokter->foto ? asset('storage/' . $dokter->foto) : asset('images/default.png') }}"
                                alt="{{ $dokter->nama }}"
                                class="w-32 h-32 rounded-full object-cover border-4 border-gray-100">
                        </div>

                        <!-- Info Utama -->
                        <div class="flex-1">
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $dokter->nama }}</h1>

                            @if ($dokter->spesialis)
                                <p class="text-lg text-gray-600 mb-4">{{ $dokter->spesialis }}</p>
                            @endif

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-600">
                                <div class="flex items-center gap-3">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    <span>{{ $dokter->email }}</span>
                                </div>

                                <div class="flex items-center gap-3">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                        </path>
                                    </svg>
                                    <span>{{ $dokter->no_telepon }}</span>
                                </div>

                                @if ($dokter->tanggal_lahir)
                                    <div class="flex items-center gap-3">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        <span>{{ \Carbon\Carbon::parse($dokter->tanggal_lahir)->isoFormat('D MMMM YYYY') }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Jadwal Praktek -->
                <div class="p-8">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">Jadwal Praktek</h2>
                        <a href="#"
                            class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                            Kelola Jadwal
                        </a>
                    </div>

                    @if ($dokter->jadwalPraktek && $dokter->jadwalPraktek->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($dokter->jadwalPraktek->sortBy(function ($jadwal) {
            $hari = ['Senin' => 1, 'Selasa' => 2, 'Rabu' => 3, 'Kamis' => 4, 'Jumat' => 5, 'Sabtu' => 6, 'Minggu' => 7];
            return $hari[$jadwal->hari] ?? 8;
        }) as $jadwal)
                                <div
                                    class="border rounded-lg p-4 {{ $jadwal->aktif ? 'bg-green-50 border-green-200' : 'bg-gray-50 border-gray-200' }}">
                                    <div class="flex items-center justify-between mb-2">
                                        <h3 class="font-semibold text-gray-900">{{ $jadwal->hari }}</h3>
                                        <span
                                            class="px-2 py-1 text-xs rounded-full {{ $jadwal->aktif ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-600' }}">
                                            {{ $jadwal->aktif ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-2 text-gray-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="text-sm">{{ substr($jadwal->jam_mulai, 0, 5) }} -
                                            {{ substr($jadwal->jam_selesai, 0, 5) }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12 bg-gray-50 rounded-lg">
                            <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            <p class="text-gray-600 mb-4">Belum ada jadwal praktek</p>
                            <a href="#"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                                Tambah Jadwal
                            </a>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>

@endsection
