{{-- resources/views/components/dokter/modal.blade.php --}}
<div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center"
    x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="open = false"></div>

    {{-- Modal Panel --}}
    <div class="relative z-10 w-full max-w-2xl mx-4 bg-white rounded-2xl shadow-2xl overflow-hidden"
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
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <h2 class="text-lg font-semibold text-white tracking-wide"
                    x-text="dokter.id ? 'Edit Dokter' : 'Tambah Dokter'"></h2>
            </div>
            <button @click="open = false"
                class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-white/20 transition text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Form --}}
        <form method="POST" :action="dokter.id ? `/dokter/${dokter.id}` : '{{ route('dokter.store') }}'"
            enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" :value="dokter.id ? 'PATCH' : 'POST'">
            <div class="px-6 py-5 space-y-5 max-h-[70vh] overflow-y-auto">

                {{-- Foto Avatar --}}
                <div x-data="{
                    preview: dokter.foto ? `/storage/${dokter.foto}` : null,
                    fotoError: '{{ $errors->first('foto') }}'
                }" class="flex flex-col items-center gap-3">
                    <div class="relative group">
                        <div class="w-24 h-24 rounded-full bg-gray-100 border-2 border-dashed overflow-hidden flex items-center justify-center transition"
                            :class="fotoError ? 'border-red-400' : 'border-gray-300 group-hover:border-primary-400'">
                            <template x-if="!preview">
                                <div class="flex flex-col items-center gap-1 text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none"
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
                            class="absolute -bottom-1 -right-1 w-7 h-7 bg-primary-600 rounded-full flex items-center justify-center cursor-pointer shadow hover:bg-primary-700 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-white" fill="none"
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
                    <p class="text-xs text-gray-400">JPG, PNG, WEBP — maks. 2MB</p>
                    @error('foto')
                    <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                    <p x-show="fotoError" x-text="fotoError" class="text-xs text-red-500"></p>
                </div>

                <div class="border-t border-gray-100"></div>

                {{-- Grid 2 kolom --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                    {{-- Nama --}}
                    <div class="sm:col-span-2">
                        <label for="nama" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama" :value="dokter.nama" placeholder="Nama Lengkap Dokter"
                            placeholder="dr. Nama Lengkap, Sp.XX"
                            class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent transition placeholder-gray-400 @error('nama') border-red-400 @enderror">
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
                        <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Tanggal Lahir <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span
                                class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none z-10">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </span>
                            <input x-ref="tanggalLahir" type="text" id="tanggal_lahir" name="tanggal_lahir"
                                placeholder="Pilih tanggal lahir" readonly
                                class="w-full pl-9 pr-4 py-2.5 text-sm border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent transition placeholder-gray-400 cursor-pointer @error('tanggal_lahir') border-red-400 @enderror">
                        </div>
                        @error('tanggal_lahir')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Spesialis --}}
                    <div>
                        <label for="spesialis" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Spesialisasi <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="spesialis" :value="dokter.spesialis"
                            placeholder="Contoh: Kulit & Kelamin"
                            class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent transition placeholder-gray-400 @error('spesialisasi') border-red-400 @enderror">
                        @error('spesialis')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Nomor Telepon --}}
                    <div>
                        <label for="no_telepon" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Nomor Telepon
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </span>
                            <input type="text" name="no_telepon" :value="dokter.no_telepon" placeholder="08xxxxxxxxxx"
                                class="w-full pl-9 pr-4 py-2.5 text-sm border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent transition placeholder-gray-400 @error('no_telepon') border-red-400 @enderror">
                        </div>
                        @error('no_telepon')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Email
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </span>
                            <input type="email" name="email" :value="dokter.email" placeholder="dokter@kasclinic.com"
                                class="w-full pl-9 pr-4 py-2.5 text-sm border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent transition placeholder-gray-400 @error('email') border-red-400 @enderror">
                        </div>
                        @error('email')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Biaya Konsultasi --}}
                    <div class="sm:col-span-2">
                        <label for="biaya_konsultasi" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Biaya Konsultasi
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm font-medium">
                                Rp
                            </span>
                            <input type="number" id="biaya_konsultasi" name="biaya_konsultasi"
                                :value="dokter.biaya_konsultasi" placeholder="0" min="0"
                                class="w-full pl-10 pr-4 py-2.5 text-sm border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent transition placeholder-gray-400 @error('biaya_konsultasi') border-red-400 @enderror">
                        </div>
                        @error('biaya_konsultasi')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                </div>


                <div class="border-t border-gray-100"></div>

                {{-- Akun --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                    {{-- Username --}}
                    <div x-show="!dokter.id" class="sm:col-span-2">
                        <label for="username" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Username <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </span>
                            <input type="text" id="username" name="username" value="{{ old('username') }}"
                                placeholder="Contoh: dr.budi"
                                class="w-full pl-9 pr-4 py-2.5 text-sm border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent transition placeholder-gray-400 @error('username') border-red-400 @enderror">
                        </div>
                        @error('username')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div x-show="!dokter.id" class="sm:col-span-2" x-data="{ showPass: false }">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </span>
                            <input :type="showPass ? 'text' : 'password'" id="password" name="password"
                                placeholder="Min. 8 karakter"
                                class="w-full pl-9 pr-10 py-2.5 text-sm border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent transition placeholder-gray-400 @error('password') border-red-400 @enderror">
                            <button type="button" @click="showPass = !showPass"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition">
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

            {{-- Footer --}}
            <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-gray-100 bg-gray-50">
                <button type="button" @click="open = false"
                    class="px-5 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 bg-white border border-gray-200 rounded-lg hover:border-gray-300 transition">
                    Batal
                </button>
                <button type="submit"
                    class="px-6 py-2 text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 rounded-lg shadow-sm transition flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                    </svg>
                    <span x-text="dokter.id ? 'Simpan Perubahan' : 'Simpan Dokter'"></span>

                </button>
            </div>
        </form>
    </div>
</div>
