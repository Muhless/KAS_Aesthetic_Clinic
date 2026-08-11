<div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center"
    x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

    <div class="absolute inset-0 bg-black/50" @click="open = false"></div>

    <div class="relative z-10 w-full max-w-lg mx-4 bg-white rounded-md shadow-lg overflow-hidden border border-slate-200"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95" @click.stop>

        {{-- Header --}}
        <div class="flex items-center justify-between px-4 py-3 bg-blue-500">
            <h2 class="text-sm font-semibold text-white">Tambah Antrian</h2>
            <button type="button" @click="open = false"
                class="w-7 h-7 flex items-center justify-center rounded hover:bg-white/20 transition text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Form --}}
        <form action="{{ route('pelayanan.store') }}" method="POST">
            @csrf
            <div class="px-4 py-4 space-y-3">

                {{-- Pasien --}}
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">
                        Pasien <span class="text-red-500">*</span>
                    </label>
                    <select name="pasien_id"
                        class="w-full px-3 py-2 text-sm border rounded focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400 transition @error('pasien_id') border-red-400 @else border-slate-300 @enderror">
                        <option value="">Pilih Pasien</option>
                        @foreach (\App\Models\Pasien::orderBy('nama')->get() as $pasien)
                            <option value="{{ $pasien->id }}">{{ $pasien->nama }}</option>
                        @endforeach
                    </select>
                    @error('pasien_id')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Dokter --}}
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">
                        Dokter
                    </label>
                    <select name="dokter_id"
                        class="w-full px-3 py-2 text-sm border border-slate-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400 transition">
                        <option value="">Pilih Dokter</option>
                        @foreach (\App\Models\Dokter::orderBy('nama')->get() as $dokter)
                            <option value="{{ $dokter->id }}">{{ $dokter->nama }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Tanggal --}}
                <div x-data x-init="flatpickr($refs.tanggalAntrian, {
                    dateFormat: 'Y-m-d',
                    altInput: true,
                    altFormat: 'd F Y',
                    locale: 'id',
                    defaultDate: 'today',
                    allowInput: false,
                    disableMobile: true,
                })">
                    <label class="block text-sm font-medium text-slate-600 mb-1">
                        Tanggal <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none z-10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </span>
                        <input x-ref="tanggalAntrian" type="text" name="tanggal" placeholder="Pilih tanggal"
                            readonly
                            class="w-full pl-9 pr-3 py-2 text-sm border rounded focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400 transition placeholder-slate-400 cursor-pointer @error('tanggal') border-red-400 @else border-slate-300 @enderror">
                    </div>
                    @error('tanggal')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            {{-- Footer --}}
            <div class="flex items-center justify-end gap-2 px-4 py-3 border-t border-slate-200 bg-slate-50">
                <button type="button" @click="open = false"
                    class="px-4 py-1.5 text-sm font-medium text-slate-600 bg-white border border-slate-300 rounded hover:bg-slate-100 transition">
                    Batal
                </button>
                <button type="submit"
                    class="px-4 py-1.5 text-sm font-medium text-white bg-blue-500 hover:bg-blue-600 rounded transition">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
