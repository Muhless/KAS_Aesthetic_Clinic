<!-- Modal Overlay -->
<div x-show="open" x-transition.opacity @click.self="open = false"
    class="fixed inset-0 bg-black/50 z-40 flex items-center justify-center">

    <!-- Modal Content -->
    <div x-show="open" x-transition class="bg-white w-full max-w-lg rounded-xl shadow-xl p-6 space-y-4">

        <h2 class="text-xl font-semibold mb-2">Ubah Data Dokter</h2>

        <form :action="'/dokter/' + form.id" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PATCH')

            <div>
                <label class="block text-sm font-medium">Nama</label>
                <input type="text" name="nama" x-model="form.nama"
                    class="w-full mt-1 px-3 py-2 border rounded-lg">
            </div>

            <div>
                <label class="block text-sm font-medium">Nomor Telepon</label>
                <input type="text" name="no_telepon" x-model="form.no_telepon"
                    class="w-full mt-1 px-3 py-2 border rounded-lg">
            </div>

            <div>
                <label class="block text-sm font-medium">Email</label>
                <input type="email" name="email" x-model="form.email"
                    class="w-full mt-1 px-3 py-2 border rounded-lg">
            </div>

            <div>
                <label class="block text-sm font-medium">Spesialis</label>
                <input type="text" name="text" x-model="form.spesialis"
                    class="w-full mt-1 px-3 py-2 border rounded-lg">
            </div>

            <div>
                <label class="block text-sm font-medium">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" x-model="form.tanggal_lahir"
                    class="w-full mt-1 px-3 py-2 border rounded-lg">
            </div>

            <div>
                <label class="block text-sm font-medium">Foto Dokter</label>

                <!-- Preview -->
                <template x-if="preview">
                    <img :src="preview" class="w-24 h-24 rounded-lg object-cover mb-2 border">
                </template>

                <!-- Input File -->
                <input type="file" name="foto" accept="image/*"
                    @change="
                        const file = $event.target.files[0];
                        if (file) {
                            preview = URL.createObjectURL(file);
                        }
                    "
                    class="w-full mt-1 px-3 py-2 border rounded-lg">
            </div>

            <div class="flex justify-end gap-2 pt-2">
                <button @click="open = false" type="button"
                    class="w-32 cursor-pointer py-2 bg-gray-200 rounded-lg hover:bg-gray-300">
                    Batal
                </button>

                <button type="submit"
                    class="w-32 cursor-pointer py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600">
                    Simpan
                </button>
            </div>

        </form>

    </div>
</div>
