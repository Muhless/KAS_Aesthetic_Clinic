<div class="bg-white rounded-md shadow-sm border border-slate-200" x-data="{
    openPanggil: false,
    antrian: {},
    panggilAntrian(id, nama, keluhan) {
        this.antrian = { id, nama, keluhan: keluhan ?? '' };
        this.openPanggil = true;
    }
}">
    {{-- Box Header --}}
    <div class="flex items-center justify-between px-4 py-3 border-b border-slate-200">
        <div>
            <h3 class="font-semibold text-slate-700 text-sm">Antrian</h3>
            <p class="text-xs text-slate-400">{{ now()->translatedFormat('l, d F Y') }}</p>
        </div>
        <div x-data="{ open: false }">
            <button @click="open = true"
                class="inline-flex items-center gap-1.5 cursor-pointer text-xs px-3 py-1.5 bg-blue-500 hover:bg-blue-600 text-white rounded transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Antrian
            </button>
            <x-dashboard.modalantrian />
        </div>
    </div>

    {{-- Box Body --}}
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-100 text-xs text-slate-600 uppercase">
                    <th class="px-4 py-2 text-left font-semibold border-b border-slate-200 w-12">No</th>
                    <th class="px-4 py-2 text-left font-semibold border-b border-slate-200">Nama Pasien</th>
                    <th class="px-4 py-2 text-left font-semibold border-b border-slate-200">Dokter</th>
                    <th class="px-4 py-2 text-left font-semibold border-b border-slate-200">Status</th>
                    <th class="px-4 py-2 text-center font-semibold border-b border-slate-200">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pelayanansHariIni->where('status', 'menunggu') as $antrian)
                    <tr class="border-b border-slate-100 even:bg-slate-50 hover:bg-slate-100 transition">

                        {{-- Nomor Antrian --}}
                        <td class="px-4 py-2.5 text-slate-600 font-medium">
                            {{ $antrian->nomor_antrian }}
                        </td>

                        {{-- Pasien --}}
                        <td class="px-4 py-2.5">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full bg-slate-200 text-slate-600 flex items-center justify-center font-semibold text-xs shrink-0">
                                    {{ strtoupper(substr($antrian->pasien->nama, 0, 1)) }}
                                </div>
                                <span class="font-medium text-slate-700">{{ $antrian->pasien->nama }}</span>
                            </div>
                        </td>

                        {{-- Dokter --}}
                        <td class="px-4 py-2.5 text-slate-500">
                            {{ $antrian->dokter->nama ?? '—' }}
                        </td>

                        {{-- Status --}}
                        <td class="px-4 py-2.5">
                            @if ($antrian->status == 'menunggu')
                                <span class="text-xs px-2 py-1 rounded bg-yellow-500 text-white font-medium">Menunggu</span>
                            @elseif ($antrian->status == 'dipanggil')
                                <span class="text-xs px-2 py-1 rounded bg-blue-500 text-white font-medium">Dipanggil</span>
                            @else
                                <span class="text-xs px-2 py-1 rounded bg-green-500 text-white font-medium">Selesai</span>
                            @endif
                        </td>

                        {{-- Aksi --}}
                        <td class="px-4 py-2.5">
                            <div class="flex items-center justify-center gap-1.5">

                                {{-- Panggil --}}
                                @if ($antrian->status == 'menunggu')
                                    <button type="button" title="Panggil"
                                        @click="panggilAntrian({{ $antrian->id }}, '{{ $antrian->pasien->nama }}', '{{ addslashes($antrian->keluhan) }}')"
                                        class="w-7 h-7 bg-blue-500 hover:bg-blue-600 text-white rounded flex items-center justify-center transition">
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
                                            class="w-7 h-7 bg-green-500 hover:bg-green-600 text-white rounded flex items-center justify-center transition">
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
                                        class="w-7 h-7 bg-red-500 hover:bg-red-600 text-white rounded flex items-center justify-center transition">
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
                        <td colspan="5" class="py-10 text-center text-slate-400 text-sm">
                            Belum ada antrian hari ini
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

        <div class="absolute inset-0 bg-black/50" @click="openPanggil = false"></div>

        <div class="relative z-10 w-full max-w-md mx-4 bg-white rounded-md shadow-lg overflow-hidden border border-slate-200"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95" @click.stop>

            {{-- Header --}}
            <div class="flex items-center justify-between px-4 py-3 bg-blue-500">
                <div>
                    <h2 class="text-sm font-semibold text-white">Panggil Pasien</h2>
                    <p class="text-xs text-blue-100" x-text="antrian.nama"></p>
                </div>
                <button @click="openPanggil = false"
                    class="w-7 h-7 flex items-center justify-center rounded hover:bg-white/20 transition text-white">
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

                <div class="px-4 py-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1">Keluhan Pasien</label>
                        <textarea name="keluhan" rows="3" x-model="antrian.keluhan" placeholder="Tuliskan keluhan pasien..."
                            class="w-full px-3 py-2 text-sm border border-slate-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400 transition resize-none"></textarea>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="flex items-center justify-end gap-2 px-4 py-3 border-t border-slate-200 bg-slate-50">
                    <button type="button" @click="openPanggil = false"
                        class="px-4 py-1.5 text-sm font-medium text-slate-600 bg-white border border-slate-300 rounded hover:bg-slate-100 transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 py-1.5 text-sm font-medium text-white bg-blue-500 hover:bg-blue-600 rounded transition">
                        Panggil
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
