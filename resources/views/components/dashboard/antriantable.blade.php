<div class="bg-white rounded-2xl border border-slate-100 overflow-hidden" x-data="{
    openPanggil: false,
    antrian: {},
    panggilAntrian(id, nama, keluhan) {
        this.antrian = { id, nama, keluhan: keluhan ?? '' };
        this.openPanggil = true;
    }
}">
    <div class="flex items-center justify-between px-5 py-4 border-b border-slate-50">
        <div>
            <h2 class="font-semibold text-slate-800 text-sm">Antrian</h2>
            <p class="text-xs text-slate-400 mt-0.5">{{ now()->translatedFormat('l, d F Y') }}</p>
        </div>
        <div x-data="{ open: false }">
            <button @click="open = true"
                class="inline-flex items-center gap-2 cursor-pointer text-sm px-4 py-2 bg-primary-600 hover:bg-primary-700 active:bg-primary-800 text-white rounded-lg shadow transition-all duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Antrian
            </button>
            <x-dashboard.modalantrian />
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 text-xs text-slate-400 uppercase tracking-wider">
                    <th class="px-5 py-3 text-left font-medium w-12">No</th>
                    <th class="px-5 py-3 text-left font-medium">Nama Pasien</th>
                    <th class="px-5 py-3 text-left font-medium">Dokter</th>
                    <th class="px-5 py-3 text-left font-medium">Status</th>
                    <th class="px-5 py-3 text-center font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse ($pelayanansHariIni->where('status', 'menunggu') as $antrian)
                    <tr class="hover:bg-slate-50 transition">

                        {{-- Nomor Antrian --}}
                        <td class="px-5 py-3.5">
                            <div
                                class="w-7 h-7 rounded-full bg-primary-100 text-primary-700 flex items-center justify-center font-bold text-xs">
                                {{ $antrian->nomor_antrian }}
                            </div>
                        </td>

                        {{-- Pasien --}}
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-2.5">
                                <div
                                    class="w-7 h-7 rounded-full bg-gray-100 text-gray-600 flex items-center justify-center font-semibold text-xs shrink-0">
                                    {{ strtoupper(substr($antrian->pasien->nama, 0, 1)) }}
                                </div>
                                <span class="font-medium text-slate-800">{{ $antrian->pasien->nama }}</span>
                            </div>
                        </td>

                        {{-- Dokter --}}
                        <td class="px-5 py-3.5 text-slate-500">
                            {{ $antrian->dokter->nama ?? '—' }}
                        </td>

                        {{-- Status --}}
                        <td class="px-5 py-3.5">
                            @if ($antrian->status == 'menunggu')
                                <span
                                    class="text-xs px-2.5 py-1 rounded-full bg-amber-50 text-amber-600 font-medium">Menunggu</span>
                            @elseif ($antrian->status == 'dipanggil')
                                <span
                                    class="text-xs px-2.5 py-1 rounded-full bg-primary-50 text-primary-600 font-medium">Dipanggil</span>
                            @else
                                <span
                                    class="text-xs px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-600 font-medium">Selesai</span>
                            @endif
                        </td>

                        {{-- Aksi --}}
                        <td class="px-5 py-3.5">
                            <div class="flex items-center justify-center gap-2">

                                {{-- Panggil --}}
                                @if ($antrian->status == 'menunggu')
                                    <button type="button" title="Panggil"
                                        @click="panggilAntrian({{ $antrian->id }}, '{{ $antrian->pasien->nama }}', '{{ addslashes($antrian->keluhan) }}')"
                                        class="w-7 h-7 bg-primary-50 hover:bg-primary-100 text-primary-600 rounded-full flex items-center justify-center transition shadow-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                        </svg>
                                    </button>
                                @endif

                                {{-- Selesai --}}
                                @if ($antrian->status == 'dipanggil')
                                    <form action="{{ route('pelayanan.update', $antrian->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <input type="hidden" name="status" value="selesai">
                                        <button type="submit" title="Selesai"
                                            class="w-7 h-7 bg-emerald-50 hover:bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center transition shadow-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                        </button>
                                    </form>
                                @endif

                                {{-- Hapus --}}
                                <form action="{{ route('pelayanan.destroy', $antrian->id) }}" method="POST"
                                    onsubmit="return confirm('Hapus antrian ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" title="Hapus"
                                        class="w-7 h-7 bg-red-50 hover:bg-red-100 text-red-500 rounded-full flex items-center justify-center transition shadow-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                            class="w-3.5 h-3.5">
                                            <path fill-rule="evenodd"
                                                d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="5" class="py-12 text-center">
                            <div class="flex flex-col items-center gap-2 text-slate-400">
                                <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-slate-300"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <p class="text-sm font-medium text-slate-500">Belum ada antrian hari ini</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Modal Panggil --}}
    <div x-show="openPanggil" x-cloak class="fixed inset-0 z-50 flex items-center justify-center"
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="openPanggil = false"></div>

        <div class="relative z-10 w-full max-w-md mx-4 bg-white rounded-2xl shadow-2xl overflow-hidden"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95 translate-y-4"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-4" @click.stop>

            {{-- Header --}}
            <div
                class="flex items-center justify-between px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-primary-600 to-primary-500">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-white/20 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-sm font-semibold text-white">Panggil Pasien</h2>
                        <p class="text-xs text-primary-100" x-text="antrian.nama"></p>
                    </div>
                </div>
                <button @click="openPanggil = false"
                    class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-white/20 transition text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Form --}}
            <form method="POST" :action="`/pelayanan/${antrian.id}`">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="dipanggil">

                <div class="px-6 py-5 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Keluhan Pasien</label>
                        <textarea name="keluhan" rows="3" x-model="antrian.keluhan" placeholder="Tuliskan keluhan pasien..."
                            class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent transition resize-none"></textarea>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-gray-100 bg-gray-50">
                    <button type="button" @click="openPanggil = false"
                        class="px-5 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 bg-white border border-gray-200 rounded-lg hover:border-gray-300 transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-6 py-2 text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 rounded-lg shadow-sm transition flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        Panggil
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
