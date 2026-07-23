<div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center"
    x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-black/50" @click="open = false"></div>

    {{-- Modal Panel --}}
    <div class="relative z-10 w-full max-w-lg mx-4 bg-white rounded-sm shadow-[0_0.5rem_1rem_rgba(0,0,0,0.15)] overflow-hidden border border-black/10"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95" @click.stop>

        {{-- Modal Header --}}
        <div class="flex items-center justify-between px-4 py-3 bg-blue-500 border-b border-black/10">
            <h5 class="text-base font-medium text-white m-0">Tambah Reservasi</h5>
            <button type="button" @click="open = false"
                class="text-white text-2xl leading-none opacity-80 hover:opacity-100 transition -mt-1">
                &times;
            </button>
        </div>

        {{-- Form --}}
        <form action="{{ route('reservasi.store') }}" method="POST">
            @csrf

            {{-- Modal Body --}}
            <div class="px-4 py-4 space-y-3 max-h-[70vh] overflow-y-auto">

                {{-- Pasien --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">
                        Pasien <span class="text-red-500">*</span>
                    </label>
                    <select name="pasien_id" required
                        class="w-full px-2.5 py-1.5 text-sm rounded-sm border border-slate-400 bg-white text-slate-700 focus:outline-none focus:border-blue-500 focus:shadow-[0_0_0_0.2rem_rgba(59,130,246,0.25)] transition">
                        <option value="" disabled selected>Pilih pasien...</option>
                        @foreach ($pasiens as $pasien)
                        <option value="{{ $pasien->id }}">{{ $pasien->nama }}</option>
                        @endforeach
                    </select>
                    @error('pasien_id')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Dokter --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">
                        Dokter <span class="text-red-500">*</span>
                    </label>
                    <select name="dokter_id" required
                        class="w-full px-2.5 py-1.5 text-sm rounded-sm border border-slate-400 bg-white text-slate-700 focus:outline-none focus:border-blue-500 focus:shadow-[0_0_0_0.2rem_rgba(59,130,246,0.25)] transition">
                        <option value="" disabled selected>Pilih dokter...</option>
                        @foreach ($dokters as $dokter)
                        <option value="{{ $dokter->id }}">{{ $dokter->nama }}</option>
                        @endforeach
                    </select>
                    @error('dokter_id')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tanggal --}}
                <div x-data x-init="flatpickr($refs.tanggal, {
                    dateFormat: 'Y-m-d',
                    altInput: true,
                    altFormat: 'd F Y',
                    locale: 'id',
                    minDate: 'today',
                    allowInput: false,
                    disableMobile: true,
                })">
                    <label class="block text-sm font-medium text-slate-700 mb-1">
                        Tanggal <span class="text-red-500">*</span>
                    </label>
                    <input x-ref="tanggal" type="text" name="tanggal" required placeholder="Pilih tanggal reservasi"
                        readonly
                        class="w-full px-2.5 py-1.5 text-sm rounded-sm border border-slate-400 bg-white text-slate-700 focus:outline-none focus:border-blue-500 focus:shadow-[0_0_0_0.2rem_rgba(59,130,246,0.25)] transition cursor-pointer">
                    @error('tanggal')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            {{-- Modal Footer --}}
            <div class="flex items-center justify-end gap-2 px-4 py-3 border-t border-black/10">
                <button type="button" @click="open = false"
                    class="px-3 py-1.5 text-sm font-medium text-white bg-slate-500 hover:bg-slate-600 rounded-sm transition">
                    Batal
                </button>
                <button type="submit"
                    class="px-3 py-1.5 text-sm font-medium text-white bg-blue-500 hover:bg-blue-600 rounded-sm transition">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
