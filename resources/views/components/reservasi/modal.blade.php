  <!-- Modal Overlay -->
  <div x-show="open" x-transition.opacity @click.self="open = false"
      class="fixed inset-0 bg-black/50 z-40 flex items-center justify-center">

      <!-- Modal Content -->
      <div x-show="open" x-transition class="bg-white w-full max-w-lg rounded-xl shadow-xl p-6 space-y-4">

          <h2 class="text-xl font-semibold mb-2 text-center">Tambah Perawat</h2>

          <!-- FORM -->
          <form action="/patient" method="POST" class="space-y-4">
              @csrf

              <div>
                  <label class="block text-sm font-medium">Nama Pasien</label>
                  <input type="text" name="name"
                      class="w-full mt-1 px-3 py-2 border rounded-md focus:ring-primary-500 focus:border-primary-500">
              </div>

              <div>
                  <label class="block text-sm font-medium">Nomor Telepon</label>
                  <input type="text" name="phone"
                      class="w-full mt-1 px-3 py-2 border rounded-md focus:ring-primary-500 focus:border-primary-500">
              </div>

              <div>
                  <label class="block text-sm font-medium">Tanggal Lahir</label>
                  <input type="date" name="dob"
                      class="w-full mt-1 px-3 py-2 border rounded-md focus:ring-primary-500 focus:border-primary-500">
              </div>

              <!-- Actions -->
              <div class="flex justify-end gap-2 pt-2">
                  <button @click="open = false" type="button"
                      class="px-4 py-2 bg-gray-200 rounded-md hover:bg-gray-300">
                      Batal
                  </button>

                  <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700">
                      Simpan
                  </button>
              </div>

          </form>

      </div>
  </div>
