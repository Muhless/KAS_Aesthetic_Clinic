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
                    <div
                        class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center text-white text-2xl font-bold shrink-0">
                        {{ strtoupper(substr($pasien->nama, 0, 1)) }}
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-white">{{ $pasien->nama }}</h1>
                        <p class="text-primary-100 text-sm mt-0.5">
                            {{ $pasien->kunjungans->count() }} kunjungan tercatat
                        </p>
                    </div>
                    <div class="ml-auto">
                        <a href="{{ route('pasien.edit', $pasien->id) }}"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-white/20 hover:bg-white/30 text-white text-sm rounded-lg transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m2.695 14.762-1.262 3.155a.5.5 0 0 0 .65.65l3.155-1.262a4 4 0 0 0 1.343-.886L17.5 5.501a2.121 2.121 0 0 0-3-3L3.58 13.419a4 4 0 0 0-.885 1.343Z" />
                            </svg>
                            Edit Pasien
                        </a>
                    </div>
                </div>
            </div>

            {{-- Info grid --}}
            <div class="grid grid-cols-2 sm:grid-cols-4 divide-x divide-y sm:divide-y-0 divide-gray-100">
                <div class="px-5 py-4">
                    <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Jenis Kelamin</p>
                    <p class="text-sm font-medium text-gray-700">
                        @if ($pasien->jenis_kelamin == 'L')
                            <span
                                class="inline-flex items-center gap-1 px-2 py-0.5 bg-blue-50 text-blue-700 rounded-full text-xs">Laki-laki</span>
                        @elseif ($pasien->jenis_kelamin == 'P')
                            <span
                                class="inline-flex items-center gap-1 px-2 py-0.5 bg-pink-50 text-pink-700 rounded-full text-xs">Perempuan</span>
                        @else
                            <span class="text-gray-300">—</span>
                        @endif
                    </p>
                </div>
                <div class="px-5 py-4">
                    <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Tanggal Lahir</p>
                    <p class="text-sm font-medium text-gray-700">
                        {{ $pasien->tanggal_lahir ? \Carbon\Carbon::parse($pasien->tanggal_lahir)->translatedFormat('d F Y') : '—' }}
                    </p>
                </div>
                <div class="px-5 py-4">
                    <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Nomor Telepon</p>
                    <p class="text-sm font-medium text-gray-700 font-mono">
                        {{ $pasien->nomor_telepon ?? '—' }}
                    </p>
                </div>
                <div class="px-5 py-4">
                    <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Terdaftar Sejak</p>
                    <p class="text-sm font-medium text-gray-700">
                        {{ $pasien->created_at->translatedFormat('d F Y') }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Riwayat Kunjungan --}}
        <div x-data="{ open: false }">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-700">Riwayat Kunjungan</h2>
                <button @click="open = true"
                    class="inline-flex items-center gap-2 text-sm px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg shadow transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Kunjungan
                </button>
            </div>

            {{-- Timeline Kunjungan --}}
            @if ($pasien->kunjungans->isNotEmpty())
                <div class="space-y-4">
                    @foreach ($pasien->kunjungans as $kunjungan)
                        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                            {{-- Header kunjungan --}}
                            <div class="flex items-center justify-between px-5 py-3.5 bg-gray-50 border-b border-gray-100">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-primary-600"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-700">
                                            {{ \Carbon\Carbon::parse($kunjungan->tanggal)->translatedFormat('d F Y') }}
                                        </p>
                                        <p class="text-xs text-gray-400">
                                            dr. {{ $kunjungan->dokter->nama ?? '—' }}
                                        </p>
                                    </div>
                                </div>
                                <span
                                    class="text-xs px-2.5 py-1 rounded-full
                                    {{ $kunjungan->pemeriksaan ? 'bg-green-50 text-green-700' : 'bg-yellow-50 text-yellow-700' }}">
                                    {{ $kunjungan->pemeriksaan ? 'Selesai' : 'Belum ada hasil' }}
                                </span>
                            </div>

                            {{-- Detail kunjungan --}}
                            <div class="px-5 py-4 space-y-3">

                                {{-- Keluhan --}}
                                <div>
                                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Keluhan</p>
                                    <p class="text-sm text-gray-700">{{ $kunjungan->keluhan ?? '—' }}</p>
                                </div>

                                @if ($kunjungan->pemeriksaan)
                                    <div class="border-t border-gray-100 pt-3 grid grid-cols-1 sm:grid-cols-2 gap-3">
                                        <div>
                                            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">
                                                Diagnosa</p>
                                            <p class="text-sm text-gray-700">{{ $kunjungan->pemeriksaan->diagnosa ?? '—' }}
                                            </p>
                                        </div>
                                        <div>
                                            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">
                                                Tindakan</p>
                                            <p class="text-sm text-gray-700">{{ $kunjungan->pemeriksaan->tindakan ?? '—' }}
                                            </p>
                                        </div>
                                        <div>
                                            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Resep
                                            </p>
                                            <p class="text-sm text-gray-700">{{ $kunjungan->pemeriksaan->resep ?? '—' }}
                                            </p>
                                        </div>
                                        <div>
                                            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">
                                                Catatan</p>
                                            <p class="text-sm text-gray-700">{{ $kunjungan->pemeriksaan->catatan ?? '—' }}
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Empty state kunjungan --}}
            @else
                <div
                    class="bg-white rounded-xl border border-gray-100 shadow-sm flex flex-col items-center justify-center py-16 px-6">
                    <div class="w-16 h-16 rounded-full bg-primary-50 flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-primary-300" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <p class="text-sm font-medium text-gray-500">Belum ada riwayat kunjungan</p>
                    <p class="text-xs text-gray-400 mt-1 mb-5">Tambahkan kunjungan pertama pasien ini</p>
                    <button @click="open = true"
                        class="inline-flex items-center gap-2 text-sm px-5 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg shadow transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Kunjungan Pertama
                    </button>
                </div>
            @endif

            {{-- Modal Tambah Kunjungan --}}
            <div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center"
                x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

                <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="open = false"></div>

                <div class="relative z-10 w-full max-w-lg mx-4 bg-white rounded-2xl shadow-2xl overflow-hidden"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                    x-transition:leave-end="opacity-0 scale-95 translate-y-4" @click.stop>

                    {{-- Header --}}
                    <div
                        class="flex items-center justify-between px-6 py-5 bg-gradient-to-r from-primary-600 to-primary-500">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-white/20 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <h2 class="text-lg font-semibold text-white tracking-wide">Tambah Kunjungan</h2>
                        </div>
                        <button type="button" @click="open = false"
                            class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-white/20 transition text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    {{-- Form --}}
                    <form action="{{ route('kunjungan.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="pasien_id" value="{{ $pasien->id }}">

                        <div class="px-6 py-5 space-y-4">

                            {{-- Dokter --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                    Dokter <span class="text-red-500">*</span>
                                </label>
                                <select name="dokter_id"
                                    class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent transition">
                                    <option value="">Pilih Dokter</option>
                                    @foreach (\App\Models\Dokter::all() as $dokter)
                                        <option value="{{ $dokter->id }}">{{ $dokter->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Tanggal --}}
                            <div x-data x-init="flatpickr($refs.tanggalKunjungan, {
                                dateFormat: 'Y-m-d',
                                altInput: true,
                                altFormat: 'd F Y',
                                locale: 'id',
                                maxDate: 'today',
                                allowInput: false,
                                disableMobile: true,
                            })">
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                    Tanggal Kunjungan <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span
                                        class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none z-10">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </span>
                                    <input x-ref="tanggalKunjungan" type="text" name="tanggal"
                                        placeholder="Pilih tanggal kunjungan" readonly
                                        class="w-full pl-9 pr-4 py-2.5 text-sm border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent transition placeholder-gray-400 cursor-pointer">
                                </div>
                            </div>

                            {{-- Keluhan --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                    Keluhan
                                </label>
                                <textarea name="keluhan" rows="3" placeholder="Deskripsikan keluhan pasien..."
                                    class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent transition placeholder-gray-400 resize-none"></textarea>
                            </div>

                        </div>

                        {{-- Footer --}}
                        <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-gray-100 bg-gray-50">
                            <button type="button" @click="open = false"
                                class="px-5 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 bg-white border border-gray-200 rounded-lg hover:border-gray-300 transition">
                                Batal
                            </button>
                            <button type="submit"
                                class="px-6 py-2 text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 rounded-lg shadow-sm transition flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Simpan Kunjungan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
