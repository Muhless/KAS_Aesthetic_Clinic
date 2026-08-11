<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    <div class="flex items-center justify-between px-5 py-4 border-b border-gray-200">
        <div>
            <h3 class="font-semibold text-gray-800 text-sm">Pasien Hari Ini</h3>
            <p class="text-xs text-gray-400 mt-0.5">{{ now()->translatedFormat('l, d F Y') }}</p>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider">
                    <th class="px-5 py-3 text-left font-semibold border-b border-gray-200 w-12">No</th>
                    <th class="px-5 py-3 text-left font-semibold border-b border-gray-200">Nama Pasien</th>
                    <th class="px-5 py-3 text-left font-semibold border-b border-gray-200">Dokter</th>
                    <th class="px-5 py-3 text-left font-semibold border-b border-gray-200">Status</th>
                    <th class="px-5 py-3 text-center font-semibold border-b border-gray-200">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($pelayanansHariIni->whereNotIn('status', ['menunggu']) as $pelayanan)
                <tr class="hover:bg-gray-50 transition">

                    {{-- Nomor Antrian --}}
                    <td class="px-5 py-3.5">
                        <span
                            class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-indigo-100 text-indigo-700 font-bold text-xs">
                            {{ $pelayanan->nomor_antrian }}
                        </span>
                    </td>

                    {{-- Pasien --}}
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-2.5">
                            <div
                                class="w-7 h-7 rounded-full bg-gray-100 text-gray-600 flex items-center justify-center font-semibold text-xs shrink-0">
                                {{ strtoupper(substr($pelayanan->pasien->nama, 0, 1)) }}
                            </div>
                            <span class="font-medium text-gray-800">{{ $pelayanan->pasien->nama }}</span>
                        </div>
                    </td>

                    {{-- Dokter --}}
                    <td class="px-5 py-3.5 text-gray-500">
                        {{ $pelayanan->dokter->nama ?? '—' }}
                    </td>

                    {{-- Status --}}
                    <td class="px-5 py-3.5">
                        @if ($pelayanan->status == 'menunggu')
                        <span
                            class="text-xs px-2.5 py-1 rounded-full bg-amber-100 text-amber-700 font-medium">Menunggu</span>
                        @elseif ($pelayanan->status == 'dipanggil')
                        <span
                            class="text-xs px-2.5 py-1 rounded-full bg-blue-100 text-blue-700 font-medium">Dipanggil</span>
                        @else
                        <span
                            class="text-xs px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-700 font-medium">Selesai</span>
                        @endif
                    </td>

                    {{-- Aksi --}}
                    <td class="px-5 py-3.5">
                        <div class="flex items-center justify-center gap-2">

                            {{-- Panggil --}}
                            @if ($pelayanan->status == 'menunggu')
                            <form action="{{ route('pelayanan.update', $pelayanan->id) }}" method="POST">
                                @csrf @method('PUT')
                                <input type="hidden" name="status" value="dipanggil">
                                <button type="submit" title="Panggil"
                                    class="w-7 h-7 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-full flex items-center justify-center transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                    </svg>
                                </button>
                            </form>
                            @endif

                            {{-- Selesai --}}
                            @if ($pelayanan->status == 'dipanggil')
                            <form action="{{ route('pelayanan.update', $pelayanan->id) }}" method="POST">
                                @csrf @method('PUT')
                                <input type="hidden" name="status" value="selesai">
                                <button type="submit" title="Selesai"
                                    class="w-7 h-7 bg-emerald-50 hover:bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </button>
                            </form>
                            @endif

                        </div>
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="5" class="py-12 text-center">
                        <div class="flex flex-col items-center gap-2 text-gray-400">
                            <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-300" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-gray-500">Belum ada pasien hari ini</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
