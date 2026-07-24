{{-- resources/views/components/treatment/modal.blade.php --}}
<div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center"
    x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

    <div class="absolute inset-0 bg-black/50" @click="open = false"></div>

    <div class="relative z-10 w-full max-w-lg mx-4 bg-white rounded-sm shadow-[0_0.5rem_1rem_rgba(0,0,0,0.15)] overflow-hidden border border-black/10"
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" @click.stop>

        {{-- Modal Header --}}
        <div class="flex items-center justify-between px-4 py-3 bg-blue-500 border-b border-black/10">
            <h5 class="text-base font-medium text-white m-0"
                x-text="treatment.id ? 'Edit Treatment' : 'Tambah Treatment'"></h5>
            <button type="button" @click="open = false"
                class="text-white text-2xl leading-none opacity-80 hover:opacity-100 transition -mt-1">
                &times;
            </button>
        </div>

        {{-- Form --}}
        <form method="POST" :action="treatment.id ? `/treatment/${treatment.id}` : '{{ route('treatment.store') }}'"
            enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" :value="treatment.id ? 'PATCH' : 'POST'">

            {{-- Modal Body --}}
            <div class="px-4 py-4 space-y-3 max-h-[70vh] overflow-y-auto">

                {{-- Foto --}}
                <div x-data="{ preview: null }" class="flex flex-col items-center gap-2">
                    <div class="relative group">
                        <div
                            class="w-16 h-16 rounded-sm bg-slate-100 border-2 border-dashed border-slate-300 overflow-hidden flex items-center justify-center transition group-hover:border-blue-400">
                            <template x-if="!preview">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-slate-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </template>
                            <template x-if="preview">
                                <img :src="preview" class="w-full h-full object-cover">
                            </template>
                        </div>
                        <label for="foto_treatment"
                            class="absolute -bottom-1 -right-1 w-5 h-5 bg-blue-500 rounded-full flex items-center justify-center cursor-pointer hover:bg-blue-600 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-white" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                        </label>
                    </div>
                    <input id="foto_treatment" name="foto" type="file"
                        accept="image/jpeg,image/png,image/jpg,image/webp" class="hidden"
                        @change="const file = $event.target.files[0]; if(file){ const r = new FileReader(); r.onload = e => preview = e.target.result; r.readAsDataURL(file); }">
                    <p class="text-xs text-slate-400">JPG, PNG, WEBP — maks. 2MB</p>
                </div>

                <hr class="border-black/10">

                {{-- Nama --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">
                        Nama Treatment <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama" :value="treatment.nama"
                        placeholder="Contoh: Facial Glow, Laser Acne..."
                        class="w-full px-2.5 py-1.5 text-sm rounded-sm border border-slate-400 bg-white text-slate-700 focus:outline-none focus:border-blue-500 focus:shadow-[0_0_0_0.2rem_rgba(59,130,246,0.25)] transition placeholder-slate-400 @error('nama') border-red-400 @enderror">
                    @error('nama')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi</label>
                    <textarea name="deskripsi" rows="2" x-model="treatment.deskripsi"
                        placeholder="Deskripsi singkat treatment..."
                        class="w-full px-2.5 py-1.5 text-sm rounded-sm border border-slate-400 bg-white text-slate-700 focus:outline-none focus:border-blue-500 focus:shadow-[0_0_0_0.2rem_rgba(59,130,246,0.25)] transition placeholder-slate-400 resize-none">{{ old('deskripsi') }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    {{-- Harga --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">
                            Harga <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-2.5 top-1/2 -translate-y-1/2 text-sm text-slate-500">Rp</span>
                            <input type="number" name="harga" :value="treatment.harga" min="0"
                                class="w-full pl-8 pr-2.5 py-1.5 text-sm rounded-sm border border-slate-400 bg-white text-slate-700 focus:outline-none focus:border-blue-500 focus:shadow-[0_0_0_0.2rem_rgba(59,130,246,0.25)] transition @error('harga') border-red-400 @enderror">
                        </div>
                        @error('harga')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Durasi --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Durasi (menit)</label>
                        <div class="relative">
                            <input type="number" name="durasi" :value="treatment.durasi" min="0" placeholder="60"
                                class="w-full px-2.5 pr-12 py-1.5 text-sm rounded-sm border border-slate-400 bg-white text-slate-700 focus:outline-none focus:border-blue-500 focus:shadow-[0_0_0_0.2rem_rgba(59,130,246,0.25)] transition placeholder-slate-400">
                            <span
                                class="absolute right-2.5 top-1/2 -translate-y-1/2 text-xs text-slate-400 pointer-events-none">menit</span>
                        </div>
                    </div>
                </div>

                {{-- Status --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="status" value="tersedia"
                                :checked="treatment.status === 'tersedia'" class="w-4 h-4 accent-green-500">
                            <span class="text-sm text-slate-700">Tersedia</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="status" value="tidak_tersedia"
                                :checked="treatment.status === 'tidak_tersedia'" class="w-4 h-4 accent-red-500">
                            <span class="text-sm text-slate-700">Tidak Tersedia</span>
                        </label>
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
                    <span x-text="treatment.id ? 'Simpan Perubahan' : 'Simpan'"></span>
                </button>
            </div>
        </form>
    </div>
</div>
