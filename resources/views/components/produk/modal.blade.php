{{-- resources/views/components/produk/modal.blade.php --}}
<div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0">

    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="open = false"></div>

    <div class="relative z-10 w-full max-w-lg mx-4 bg-white rounded-2xl shadow-2xl overflow-hidden"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95 translate-y-4"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-95 translate-y-4"
        @click.stop>

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 py-5 bg-gradient-to-r from-primary-600 to-primary-500">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-white/20 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <h2 class="text-lg font-semibold text-white tracking-wide">Tambah Produk</h2>
            </div>
            <button type="button" @click="open = false"
                class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-white/20 transition text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Form --}}
        <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="px-6 py-5 space-y-4 max-h-[70vh] overflow-y-auto">

                {{-- Foto --}}
                <div x-data="{ preview: null }" class="flex flex-col items-center gap-3">
                    <div class="relative group">
                        <div class="w-20 h-20 rounded-xl bg-gray-100 border-2 border-dashed border-gray-300 overflow-hidden flex items-center justify-center transition group-hover:border-primary-400">
                            <template x-if="!preview">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </template>
                            <template x-if="preview">
                                <img :src="preview" class="w-full h-full object-cover">
                            </template>
                        </div>
                        <label for="foto_produk"
                            class="absolute -bottom-1 -right-1 w-6 h-6 bg-primary-600 rounded-full flex items-center justify-center cursor-pointer shadow hover:bg-primary-700 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                            </svg>
                        </label>
                    </div>
                    <input id="foto_produk" name="foto" type="file" accept="image/jpeg,image/png,image/jpg,image/webp" class="hidden"
                        @change="const file = $event.target.files[0]; if(file){ const r = new FileReader(); r.onload = e => preview = e.target.result; r.readAsDataURL(file); }">
                    <p class="text-xs text-gray-400">JPG, PNG, WEBP — maks. 2MB</p>
                </div>

                <div class="border-t border-gray-100"></div>

                {{-- Nama --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Nama Produk <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama" value="{{ old('nama') }}"
                        placeholder="Masukkan nama produk"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent transition placeholder-gray-400 @error('nama') border-red-400 @enderror">
                    @error('nama')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Kategori --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Kategori</label>
                    <input type="text" name="kategori" value="{{ old('kategori') }}"
                        placeholder="Contoh: Skincare, Serum, Toner..."
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent transition placeholder-gray-400">
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Deskripsi</label>
                    <textarea name="deskripsi" rows="2" placeholder="Deskripsi singkat produk..."
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent transition placeholder-gray-400 resize-none">{{ old('deskripsi') }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    {{-- Harga --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            Harga <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-xs text-gray-400 pointer-events-none font-medium">Rp</span>
                            <input type="number" name="harga" value="{{ old('harga', 0) }}" min="0"
                                class="w-full pl-9 pr-4 py-2.5 text-sm border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent transition @error('harga') border-red-400 @enderror">
                        </div>
                        @error('harga')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Stok --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            Stok <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="stok" value="{{ old('stok', 0) }}" min="0"
                            class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent transition @error('stok') border-red-400 @enderror">
                        @error('stok')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Status --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Status</label>
                    <div class="flex gap-3">
                        <label class="flex-1 flex items-center gap-2.5 px-4 py-2.5 border border-gray-200 rounded-lg cursor-pointer hover:border-green-300 hover:bg-green-50/50 transition has-[:checked]:border-green-400 has-[:checked]:bg-green-50">
                            <input type="radio" name="status" value="tersedia"
                                {{ old('status', 'tersedia') == 'tersedia' ? 'checked' : '' }}
                                class="accent-green-500">
                            <span class="text-sm text-gray-700">Tersedia</span>
                        </label>
                        <label class="flex-1 flex items-center gap-2.5 px-4 py-2.5 border border-gray-200 rounded-lg cursor-pointer hover:border-red-300 hover:bg-red-50/50 transition has-[:checked]:border-red-400 has-[:checked]:bg-red-50">
                            <input type="radio" name="status" value="tidak_tersedia"
                                {{ old('status') == 'tidak_tersedia' ? 'checked' : '' }}
                                class="accent-red-500">
                            <span class="text-sm text-gray-700">Tidak Tersedia</span>
                        </label>
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
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                    </svg>
                    Simpan Produk
                </button>
            </div>
        </form>
    </div>
</div>
