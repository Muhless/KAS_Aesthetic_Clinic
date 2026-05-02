@extends('layouts.app')

@section('title', 'Halaman Antrian - KAS Aesthetic Clinic')

@section('content')
    <div class="p-6" x-data="{ open: false }">
        <x-notification />

        {{-- Header --}}
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-primary-400">Antrian</h1>
                <p class="text-sm text-gray-400 mt-1">
                    {{ now()->translatedFormat('l, d F Y') }} —
                    {{ $antrians->where('status', 'menunggu')->count() }} menunggu
                </p>
            </div>
            <button @click="open = true"
                class="inline-flex items-center gap-2 cursor-pointer text-sm px-5 py-2.5 bg-primary-600 hover:bg-primary-700 active:bg-primary-800 text-white rounded-lg shadow transition-all duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Antrian
            </button>
        </div>

        {{-- Stat Cards --}}
        <div class="grid grid-cols-3 gap-4 mb-6">
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm px-5 py-4">
                <p class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-2">Menunggu</p>
                <p class="text-3xl font-bold text-yellow-500">{{ $antrians->where('status', 'menunggu')->count() }}</p>
            </div>
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm px-5 py-4">
                <p class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-2">Dipanggil</p>
                <p class="text-3xl font-bold text-blue-500">{{ $antrians->where('status', 'dipanggil')->count() }}</p>
            </div>
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm px-5 py-4">
                <p class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-2">Selesai</p>
                <p class="text-3xl font-bold text-green-500">{{ $antrians->where('status', 'selesai')->count() }}</p>
            </div>
        </div>

        {{-- Tabel Antrian --}}
        @if ($antrians->isNotEmpty())
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-primary-50/50 border-b border-primary-100">
                                <th
                                    class="px-4 py-3.5 text-left text-xs font-semibold text-primary-500 uppercase tracking-wider w-16">
                                    No</th>
                                <th
                                    class="px-4 py-3.5 text-left text-xs font-semibold text-primary-500 uppercase tracking-wider">
                                    Pasien</th>
                                <th
                                    class="px-4 py-3.5 text-left text-xs font-semibold text-primary-500 uppercase tracking-wider">
                                    Dokter</th>
                                <th
                                    class="px-4 py-3.5 text-left text-xs font-semibold text-primary-500 uppercase tracking-wider">
                                    Tanggal</th>
                                <th
                                    class="px-4 py-3.5 text-left text-xs font-semibold text-primary-500 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="px-4 py-3.5 text-center text-xs font-semibold text-primary-500 uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach ($antrians as $antrian)
                                <tr class="hover:bg-gray-50/80 transition-colors duration-150">

                                    {{-- Nomor Antrian --}}
                                    <td class="px-4 py-3.5">
                                        <div
                                            class="w-9 h-9 rounded-full bg-primary-100 text-primary-700 flex items-center justify-center font-bold text-sm">
                                            {{ $antrian->nomor_antrian }}
                                        </div>
                                    </td>

                                    {{-- Pasien --}}
                                    <td class="px-4 py-3.5">
                                        <div class="flex items-center gap-2.5">
                                            <div
                                                class="w-8 h-8 rounded-full bg-gray-100 text-gray-600 flex items-center justify-center font-semibold text-xs shrink-0">
                                                {{ strtoupper(substr($antrian->pasien->nama, 0, 1)) }}
                                            </div>
                                            <span class="font-medium text-gray-800">{{ $antrian->pasien->nama }}</span>
                                        </div>
                                    </td>

                                    {{-- Dokter --}}
                                    <td class="px-4 py-3.5 text-gray-600">
                                        {{ $antrian->dokter->nama ?? '—' }}
                                    </td>

                                    {{-- Tanggal --}}
                                    <td class="px-4 py-3.5 text-gray-600">
                                        {{ \Carbon\Carbon::parse($antrian->tanggal)->translatedFormat('d F Y') }}
                                    </td>

                                    {{-- Status --}}
                                    <td class="px-4 py-3.5">
                                        @if ($antrian->status == 'menunggu')
                                            <span
                                                class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-50 text-yellow-700">
                                                <span class="w-1.5 h-1.5 rounded-full bg-yellow-400"></span>
                                                Menunggu
                                            </span>
                                        @elseif ($antrian->status == 'dipanggil')
                                            <span
                                                class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                                                <span class="w-1.5 h-1.5 rounded-full bg-blue-400"></span>
                                                Dipanggil
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700">
                                                <span class="w-1.5 h-1.5 rounded-full bg-green-400"></span>
                                                Selesai
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Aksi --}}
                                    <td class="px-4 py-3.5">
                                        <div class="flex items-center justify-center gap-2">

                                            {{-- Panggil --}}
                                            @if ($antrian->status == 'menunggu')
                                                <form action="{{ route('pelayanan.update', $antrian->id) }}"
                                                    method="POST">
                                                    @csrf @method('PUT')
                                                    <input type="hidden" name="status" value="dipanggil">
                                                    <button type="submit" title="Panggil"
                                                        class="w-8 h-8 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-full flex items-center justify-center transition shadow-sm">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endif

                                            {{-- Selesai --}}
                                            @if ($antrian->status == 'dipanggil')
                                                <form action="{{ route('pelayanan.update', $antrian->id) }}"
                                                    method="POST">
                                                    @csrf @method('PUT')
                                                    <input type="hidden" name="status" value="selesai">
                                                    <button type="submit" title="Selesai"
                                                        class="w-8 h-8 bg-green-50 hover:bg-green-100 text-green-600 rounded-full flex items-center justify-center transition shadow-sm">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2.5" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endif

                                            {{-- Hapus --}}
                                            <form action="{{ route('pelayanan.destroy', $antrian->id) }}" method="POST"
                                                onsubmit="return confirm('Hapus antrian ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" title="Hapus"
                                                    class="w-8 h-8 bg-red-50 hover:bg-red-100 text-red-600 rounded-full flex items-center justify-center transition shadow-sm">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                        fill="currentColor" class="w-4 h-4">
                                                        <path fill-rule="evenodd"
                                                            d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Empty State --}}
        @else
            <div
                class="bg-white rounded-xl border border-gray-100 shadow-sm flex flex-col items-center justify-center py-24 px-6">
                <div class="relative mb-6">
                    <div class="w-28 h-28 rounded-full bg-primary-50 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-14 h-14 text-primary-300" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div
                        class="absolute -bottom-1 -right-1 w-8 h-8 rounded-full bg-primary-600 flex items-center justify-center shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-lg font-semibold text-gray-700 mb-1">Belum ada antrian hari ini</h3>
                <p class="text-sm text-gray-400 text-center max-w-sm mb-6">
                    Tambahkan antrian pasien untuk mulai melayani hari ini.
                </p>
                <button @click="open = true"
                    class="inline-flex items-center gap-2 text-sm px-6 py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-lg shadow transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Antrian Pertama
                </button>
            </div>
        @endif

        {{-- Modal Tambah Antrian --}}


    </div>
@endsection
