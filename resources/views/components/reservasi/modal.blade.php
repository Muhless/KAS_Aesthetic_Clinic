{{-- resources/views/components/reservasi/modal.blade.php --}}

<div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center">

    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" @click="open = false"></div>

    {{-- Modal --}}
    <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-lg mx-4 max-h-[90vh] overflow-y-auto">

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <div>
                <h2 class="font-semibold text-slate-800">Tambah Reservasi</h2>
                <p class="text-xs text-slate-400 mt-0.5">Isi data reservasi pasien</p>
            </div>
            <button @click="open = false"
                class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-slate-100 transition cursor-pointer text-slate-400 hover:text-slate-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Form --}}
        <form action="{{ route('reservasi.store') }}" method="POST" class="px-6 py-5 space-y-4">
            @csrf
            {{-- Pasien --}}
            <div>
                <label class="block text-xs font-medium text-slate-500 uppercase tracking-wider mb-1.5">Pasien</label>
                <select name="pasien_id" required
                    class="w-full px-3 py-2.5 text-sm rounded-xl border border-slate-200 bg-slate-50 text-slate-800 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-transparent transition">
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
                <label class="block text-xs font-medium text-slate-500 uppercase tracking-wider mb-1.5">Dokter</label>
                <select name="dokter_id" required
                    class="w-full px-3 py-2.5 text-sm rounded-xl border border-slate-200 bg-slate-50 text-slate-800 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-transparent transition">
                    <option value="" disabled selected>Pilih dokter...</option>
                    @foreach ($dokters as $dokter)
                        <option value="{{ $dokter->id }}">{{ $dokter->nama }}</option>
                    @endforeach
                </select>
                @error('dokter_id')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tanggal & Waktu --}}
            <div x-data x-init="flatpickr($refs.tanggal, {
                dateFormat: 'Y-m-d',
                altInput: true,
                altFormat: 'd F Y',
                locale: 'id',
                minDate: 'today',
                allowInput: false,
                disableMobile: true,
            })">
                <label class="block text-xs font-medium text-slate-500 uppercase tracking-wider mb-1.5">Tanggal</label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none z-10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </span>
                    <input x-ref="tanggal" type="text" name="tanggal" required placeholder="Pilih tanggal reservasi"
                        readonly
                        class="w-full pl-9 pr-4 py-2.5 text-sm rounded-xl border border-slate-200 bg-slate-50 text-slate-800 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-transparent transition cursor-pointer">
                </div>
                @error('tanggal')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end gap-3 pt-2 border-t border-slate-100">
                <button type="button" @click="open = false"
                    class="px-4 py-2 text-sm text-slate-600 hover:text-slate-800 hover:bg-slate-100 rounded-xl transition cursor-pointer">
                    Batal
                </button>
                <button type="submit"
                    class="px-5 py-2 text-sm bg-primary-500 hover:bg-primary-600 text-white rounded-xl transition cursor-pointer shadow-sm">
                    Simpan Reservasi
                </button>
            </div>

        </form>
    </div>
</div>
