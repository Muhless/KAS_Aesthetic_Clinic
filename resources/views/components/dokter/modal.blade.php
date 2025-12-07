<!-- Modal Overlay -->
<div x-show="open" x-transition.opacity @click.self="open = false"
    class="fixed inset-0 bg-black/50 z-40 flex items-center justify-center">

    <!-- Modal Content -->
    <div x-show="open" x-transition class="bg-white w-full max-w-lg rounded-xl shadow-xl p-6 space-y-4">

        <h2 class="text-xl font-semibold mb-2">Ubah Data Dokter</h2>

        <form @submit.prevent="submitForm" class="space-y-4">

            <div>
                <label class="block text-sm font-medium">Nama</label>
                <input type="text" name="nama" x-model="form.nama" class="w-full mt-1 px-3 py-2 border rounded-md"
                    required>
            </div>

            <div>
                <label class="block text-sm font-medium">Nomor Telepon</label>
                <input type="text" name="no_telepon" x-model="form.no_telepon"
                    class="w-full mt-1 px-3 py-2 border rounded-md" required>
            </div>

            <div>
                <label class="block text-sm font-medium">Email</label>
                <input type="email" name="email" x-model="form.email"
                    class="w-full mt-1 px-3 py-2 border rounded-md" required>
            </div>

            <div>
                <label class="block text-sm font-medium">Spesialis</label>
                <input type="text" name="spesialis" x-model="form.spesialis"
                    class="w-full mt-1 px-3 py-2 border rounded-md">
            </div>

            <div>
                <label class="block text-sm font-medium">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" x-model="form.tanggal_lahir"
                    class="w-full mt-1 px-3 py-2 border rounded-md">
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">Foto Dokter</label>

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
                <input type="file" name="foto" accept="image/*" x-ref="fotoInput"
                    @change="handleFileChange($event)" class="hidden">
            </div>

            <div class="flex justify-end gap-2 pt-2">
                <button @click="open = false" type="button"
                    class="w-32 cursor-pointer py-2 bg-gray-200 rounded-md hover:bg-gray-300">
                    Batal
                </button>

                <button type="submit"
                    class="w-32 cursor-pointer py-2 bg-primary-500 text-white rounded-md hover:bg-primary-600">
                    Simpan
                </button>
            </div>

        </form>

    </div>
</div>
