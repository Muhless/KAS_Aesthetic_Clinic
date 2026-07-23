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
            <h5 class="text-base font-medium text-white m-0" x-text="pasien.id ? 'Edit Pasien' : 'Tambah Pasien'"></h5>
            <button type="button" @click="open = false"
                class="text-white text-2xl leading-none opacity-80 hover:opacity-100 transition -mt-1">
                &times;
            </button>
        </div>

        {{-- Form --}}
        <form method="POST" :action="pasien.id ? `/pasien/${pasien.id}` : '{{ route('pasien.store') }}'">
            @csrf
            <input type="hidden" name="_method" :value="pasien.id ? 'PATCH' : 'POST'">

            {{-- Modal Body --}}
            <div class="px-4 py-4 space-y-3 max-h-[70vh] overflow-y-auto">

                {{-- Nama --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">
                        Nama Pasien <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama" :value="pasien.nama" placeholder="Masukkan nama lengkap"
                        class="w-full px-2.5 py-1.5 text-sm rounded-sm border border-slate-400 bg-white text-slate-700 focus:outline-none focus:border-blue-500 focus:shadow-[0_0_0_0.2rem_rgba(59,130,246,0.25)] transition placeholder-slate-400 @error('nama') border-red-400 @enderror">
                    @error('nama')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Jenis Kelamin --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Jenis Kelamin</label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="jenis_kelamin" value="L"
                                :checked="pasien.jenis_kelamin === 'L'"
                                class="w-4 h-4 accent-blue-500">
                            <span class="text-sm text-slate-700">Laki-laki</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="jenis_kelamin" value="P"
                                :checked="pasien.jenis_kelamin === 'P'"
                                class="w-4 h-4 accent-blue-500">
                            <span class="text-sm text-slate-700">Perempuan</span>
                        </label>
                    </div>
                </div>

                {{-- Nomor Telepon --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nomor Telepon</label>
                    <input type="text" name="nomor_telepon" :value="pasien.nomor_telepon"
                        placeholder="08xxxxxxxxxx"
                        class="w-full px-2.5 py-1.5 text-sm rounded-sm border border-slate-400 bg-white text-slate-700 focus:outline-none focus:border-blue-500 focus:shadow-[0_0_0_0.2rem_rgba(59,130,246,0.25)] transition placeholder-slate-400 @error('nomor_telepon') border-red-400 @enderror">
                </div>

                {{-- Tanggal Lahir --}}
                <div x-data x-init="flatpickr($refs.tanggalLahirPasien, {
                    dateFormat: 'Y-m-d',
                    altInput: true,
                    altFormat: 'd F Y',
                    locale: 'id',
                    maxDate: 'today',
                    defaultDate: pasien.tanggal_lahir ?? '',
                    allowInput: false,
                    disableMobile: true,
                })">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal Lahir</label>
                    <input x-ref="tanggalLahirPasien" type="text" name="tanggal_lahir"
                        placeholder="Pilih tanggal lahir" readonly
                        class="w-full px-2.5 py-1.5 text-sm rounded-sm border border-slate-400 bg-white text-slate-700 focus:outline-none focus:border-blue-500 focus:shadow-[0_0_0_0.2rem_rgba(59,130,246,0.25)] transition placeholder-slate-400 cursor-pointer">
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
                    <span x-text="pasien.id ? 'Simpan Perubahan' : 'Simpan'"></span>
                </button>
            </div>
        </form>
    </div>
</div>
