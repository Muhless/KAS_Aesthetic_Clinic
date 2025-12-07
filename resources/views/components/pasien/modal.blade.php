<div x-show="open" x-transition.opacity @click.self="open = false"
    class="fixed inset-0 bg-black/50 z-40 flex items-center justify-center">

    <!-- Modal Content -->
    <div x-show="open" x-transition class="bg-white w-full max-w-lg rounded-xl shadow-xl p-6 space-y-4">
        <h2 class="text-xl font-semibold mb-2 text-center">Tambah Data Pasien</h2>

        <form action="{{ route('pasien.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium">Nama Pasien <span class="text-red-500">*</span></label>
                <input type="text" name="nama" value="{{ old('nama') }}" required
                    class="w-full mt-1 px-3 py-2 border rounded-md focus:ring-primary-500 focus:border-primary-500">
                @error('nama')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Jenis Kelamin</label>
                <select name="jenis_kelamin"
                    class="w-full mt-1 px-3 py-2 border rounded-md focus:ring-primary-500 focus:border-primary-500">
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('jenis_kelamin')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Nomor Telepon</label>
                <input type="text" name="nomor_telepon" value="{{ old('nomor_telepon') }}"
                    class="w-full mt-1 px-3 py-2 border rounded-md focus:ring-primary-500 focus:border-primary-500">
                @error('nomor_telepon')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                    class="w-full mt-1 px-3 py-2 border rounded-md focus:ring-primary-500 focus:border-primary-500">
                @error('tanggal_lahir')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Actions -->
            <div class="flex justify-end gap-2 pt-2">
                <button @click="open = false" type="button" class="px-4 py-2 bg-gray-200 rounded-md hover:bg-gray-300">
                    Batal
                </button>

                <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700">
                    Simpan
                </button>
            </div>

        </form>
    </div>

</div>
