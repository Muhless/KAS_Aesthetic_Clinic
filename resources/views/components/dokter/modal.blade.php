{{-- resources/views/components/dokter/modal.blade.php --}}
<div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center"
    x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-black/50" @click="open = false"></div>

    {{-- Modal Panel --}}
    <div class="relative z-10 w-full max-w-2xl mx-4 bg-white rounded-sm shadow-[0_0.5rem_1rem_rgba(0,0,0,0.15)] overflow-hidden border border-black/10"
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" @click.stop>

        {{-- Modal Header --}}
        <div class="flex items-center justify-between px-4 py-3 bg-blue-500 border-b border-black/10">
            <h5 class="text-base font-medium text-white m-0" x-text="dokter.id ? 'Edit Dokter' : 'Tambah Dokter'"></h5>
            <button type="button" @click="open = false"
                class="text-white text-2xl leading-none opacity-80 hover:opacity-100 transition -mt-1">
                &times;
            </button>
        </div>

        {{-- Form --}}
        <form method="POST" :action="dokter.id ? `/dokter/${dokter.id}` : '{{ route('dokter.store') }}'"
            enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" :value="dokter.id ? 'PATCH' : 'POST'">

            {{-- Modal Body --}}
            <div class="px-4 py-4 space-y-4 max-h-[70vh] overflow-y-auto">

                {{-- Foto Avatar --}}
                <div x-data="{
                    preview: dokter.foto ? `/storage/${dokter.foto}` : null,
                    fotoError: '{{ $errors->first('foto') }}'
                }" class="flex flex-col items-center gap-2">
                    <div class="relative group">
                        <div class="w-20 h-20 rounded-full bg-slate-100 border-2 border-dashed overflow-hidden flex items-center justify-center transition"
                            :class="fotoError ? 'border-red-400' : 'border-slate-300 group-hover:border-blue-400'">
                            <template x-if="!preview">
                                <div class="flex flex-col items-center gap-1 text-slate-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                            </template>
                            <template x-if="preview">
                                <img :src="preview" class="w-full h-full object-cover" alt="Preview Foto">
                            </template>
                        </div>
                        <label for="foto_edit"
                            class="absolute -bottom-1 -right-1 w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center cursor-pointer hover:bg-blue-600 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-white" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </label>
                    </div>
                    <input id="foto_edit" name="foto" type="file" accept="image/jpeg,image/png,image/jpg,image/webp"
                        class="hidden" @change="
            fotoError = '';
            const file = $event.target.files[0];
            if (file) {
                if (file.size > 2048 * 1024) {
                    fotoError = 'Ukuran foto maksimal 2MB.';
                    $event.target.value = '';
                    preview = null;
                    return;
                }
                const reader = new FileReader();
                reader.onload = e => preview = e.target.result;
                reader.readAsDataURL(file);
            }
        ">
                    <p class="text-xs text-slate-400">JPG, PNG, WEBP — maks. 2MB</p>
                    @error('foto')
                    <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                    <p x-show="fotoError" x-text="fotoError" class="text-xs text-red-500"></p>
                </div>

                <hr class="border-black/10">

                {{-- Grid 2 kolom --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">

                    {{-- Nama --}}
                    <div class="sm:col-span-2">
                        <label for="nama" class="block text-sm font-medium text-slate-700 mb-1">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama" id="nama" :value="dokter.nama" placeholder="dr. Nama Lengkap, Sp.XX"
                            class="w-full px-2.5 py-1.5 text-sm rounded-sm border border-slate-400 bg-white text-slate-700 focus:outline-none focus:border-blue-500 focus:shadow-[0_0_0_0.2rem_rgba(59,130,246,0.25)] transition placeholder-slate-400 @error('nama') border-red-400 @enderror">
                        @error('nama')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tanggal Lahir --}}
                    <div x-data x-init="flatpickr($refs.tanggalLahir, {
                        dateFormat: 'Y-m-d',
                        altInput: true,
                        altFormat: 'd F Y',
                        locale: 'id',
                        maxDate: 'today',
                        defaultDate: '{{ old('tanggal_lahir') }}',
                        allowInput: false,
                        disableMobile: true,
                    })">
                        <label for="tanggal_lahir" class="block text-sm font-medium text-slate-700 mb-1">
                            Tanggal Lahir <span class="text-red-500">*</span>
                        </label>
                        <input x-ref="tanggalLahir" type="text" id="tanggal_lahir" name="tanggal_lahir"
                            placeholder="Pilih tanggal lahir" readonly
                            class="w-full px-2.5 py-1.5 text-sm rounded-sm border border-slate-400 bg-white text-slate-700 focus:outline-none focus:border-blue-500 focus:shadow-[0_0_0_0.2rem_rgba(59,130,246,0.25)] transition placeholder-slate-400 cursor-pointer @error('tanggal_lahir') border-red-400 @enderror">
                        @error('tanggal_lahir')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Spesialis --}}
                    <div>
                        <label for="spesialis" class="block text-sm font-medium text-slate-700 mb-1">
                            Spesialisasi <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="spesialis" id="spesialis" :value="dokter.spesialis"
                            placeholder="Contoh: Kulit & Kelamin"
                            class="w-full px-2.5 py-1.5 text-sm rounded-sm border border-slate-400 bg-white text-slate-700 focus:outline-none focus:border-blue-500 focus:shadow-[0_0_0_0.2rem_rgba(59,130,246,0.25)] transition placeholder-slate-400 @error('spesialis') border-red-400 @enderror">
                        @error('spesialis')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Nomor Telepon --}}
                    <div>
                        <label for="no_telepon" class="block text-sm font-medium text-slate-700 mb-1">
                            Nomor Telepon
                        </label>
                        <input type="text" name="no_telepon" id="no_telepon" :value="dokter.no_telepon" placeholder="08xxxxxxxxxx"
                            class="w-full px-2.5 py-1.5 text-sm rounded-sm border border-slate-400 bg-white text-slate-700 focus:outline-none focus:border-blue-500 focus:shadow-[0_0_0_0.2rem_rgba(59,130,246,0.25)] transition placeholder-slate-400 @error('no_telepon') border-red-400 @enderror">
                        @error('no_telepon')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700 mb-1">
                            Email
                        </label>
                        <input type="email" name="email" id="email" :value="dokter.email" placeholder="dokter@kasclinic.com"
                            class="w-full px-2.5 py-1.5 text-sm rounded-sm border border-slate-400 bg-white text-slate-700 focus:outline-none focus:border-blue-500 focus:shadow-[0_0_0_0.2rem_rgba(59,130,246,0.25)] transition placeholder-slate-400 @error('email') border-red-400 @enderror">
                        @error('email')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Biaya Konsultasi --}}
                    <div class="sm:col-span-2">
                        <label for="biaya_konsultasi" class="block text-sm font-medium text-slate-700 mb-1">
                            Biaya Konsultasi
                        </label>
                        <div class="relative">
                            <span class="absolute left-2.5 top-1/2 -translate-y-1/2 text-slate-500 text-sm">Rp</span>
                            <input type="number" id="biaya_konsultasi" name="biaya_konsultasi"
                                :value="dokter.biaya_konsultasi" placeholder="0" min="0"
                                class="w-full pl-8 pr-2.5 py-1.5 text-sm rounded-sm border border-slate-400 bg-white text-slate-700 focus:outline-none focus:border-blue-500 focus:shadow-[0_0_0_0.2rem_rgba(59,130,246,0.25)] transition placeholder-slate-400 @error('biaya_konsultasi') border-red-400 @enderror">
                        </div>
                        @error('biaya_konsultasi')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <hr class="border-black/10">

                {{-- Akun --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">

                    {{-- Username --}}
                    <div x-show="!dokter.id" class="sm:col-span-2">
                        <label for="username" class="block text-sm font-medium text-slate-700 mb-1">
                            Username <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="username" name="username" value="{{ old('username') }}"
                            placeholder="Contoh: dr.budi"
                            class="w-full px-2.5 py-1.5 text-sm rounded-sm border border-slate-400 bg-white text-slate-700 focus:outline-none focus:border-blue-500 focus:shadow-[0_0_0_0.2rem_rgba(59,130,246,0.25)] transition placeholder-slate-400 @error('username') border-red-400 @enderror">
                        @error('username')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div x-show="!dokter.id" class="sm:col-span-2" x-data="{ showPass: false }">
                        <label for="password" class="block text-sm font-medium text-slate-700 mb-1">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input :type="showPass ? 'text' : 'password'" id="password" name="password"
                                placeholder="Min. 8 karakter"
                                class="w-full px-2.5 py-1.5 pr-9 text-sm rounded-sm border border-slate-400 bg-white text-slate-700 focus:outline-none focus:border-blue-500 focus:shadow-[0_0_0_0.2rem_rgba(59,130,246,0.25)] transition placeholder-slate-400 @error('password') border-red-400 @enderror">
                            <button type="button" @click="showPass = !showPass"
                                class="absolute right-2.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition">
                                <template x-if="!showPass">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </template>
                                <template x-if="showPass">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                    </svg>
                                </template>
                            </button>
                        </div>
                        @error('password')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

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
                    <span x-text="dokter.id ? 'Simpan Perubahan' : 'Simpan'"></span>
                </button>
            </div>
        </form>
    </div>
</div>
