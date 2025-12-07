<!-- Modal Overlay -->
<div x-show="open" x-transition.opacity @click.self="open = false"
    class="fixed inset-0 bg-black/50 z-40 flex items-center justify-center">

    <!-- Modal Content -->
    <div x-show="open" x-transition class="bg-white w-full max-w-lg rounded-xl shadow-xl p-6 space-y-4">

        <h2 class="text-xl font-semibold mb-2 text-center">Tambah Treatment</h2>

        <!-- FORM -->
        <form action="{{ route('treatment.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium">Nama Treatment</label>
                <input type="text" name="nama" value="{{ old('nama') }}" required
                    class="w-full mt-1 px-3 py-2 border rounded-md focus:ring-primary-500 focus:border-primary-500">
                @error('nama')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Deskripsi</label>
                <textarea name="deskripsi"
                    class="w-full mt-1 px-3 py-2 border rounded-md focus:ring-primary-500 focus:border-primary-500" rows="2">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Harga</label>
                <input type="number" name="harga" value="{{ old('harga') }}" required
                    class="w-full mt-1 px-3 py-2 border rounded-md focus:ring-primary-500 focus:border-primary-500">
                @error('harga')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Durasi (menit)</label>
                <input type="number" name="durasi" value="{{ old('durasi') }}"
                    class="w-full mt-1 px-3 py-2 border rounded-md focus:ring-primary-500 focus:border-primary-500">
                @error('durasi')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">Foto Treatment</label>

                <!-- Preview atau Upload Area -->
                <div @click="$refs.fotoInput.click()"
                    class="w-full border-2 border-dashed border-gray-300 rounded-md p-6 text-center cursor-pointer hover:border-primary-500 hover:bg-primary-50 transition">

                    <!-- Jika sudah ada preview -->
                    <template x-if="preview">
                        <div class="space-y-2">
                            <img :src="preview" class="w-32 h-32 rounded-md object-cover mx-auto border">
                            <p class="text-sm text-gray-600">Klik untuk ganti foto</p>
                        </div>
                    </template>

                    <!-- Jika belum ada foto -->
                    <template x-if="!preview">
                        <div class="space-y-2">
                            <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            <p class="text-sm font-medium text-gray-700">Klik untuk upload foto</p>
                            <p class="text-xs text-gray-500">PNG, JPG hingga 2MB</p>
                        </div>
                    </template>
                </div>

                <!-- Hidden Input File -->
                <input type="file" accept="image/*" x-ref="fotoInput" @change="handleFileChange($event)"
                    class="hidden">

                @error('foto')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Actions -->
            <div class="flex justify-end gap-2 pt-2">
                <button @click="open = false; preview = null" type="button"
                    class="w-32 py-2 bg-gray-200 rounded-md hover:bg-gray-300 transition">
                    Batal
                </button>

                <button type="submit"
                    class="py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 transition w-32">
                    Simpan
                </button>
            </div>

        </form>

    </div>
</div>
</div>
