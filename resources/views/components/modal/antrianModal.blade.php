  <div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center"
      x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
      x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
      x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

      <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="open = false"></div>

      <div class="relative z-10 w-full max-w-lg mx-4 bg-white rounded-2xl shadow-2xl overflow-hidden"
          x-transition:enter="transition ease-out duration-200"
          x-transition:enter-start="opacity-0 scale-95 translate-y-4"
          x-transition:enter-end="opacity-100 scale-100 translate-y-0"
          x-transition:leave="transition ease-in duration-150"
          x-transition:leave-start="opacity-100 scale-100 translate-y-0"
          x-transition:leave-end="opacity-0 scale-95 translate-y-4" @click.stop>

          {{-- Header --}}
          <div class="flex items-center justify-between px-6 py-5 bg-linear-to-r from-primary-600 to-primary-500">
              <div class="flex items-center gap-3">
                  <div class="w-9 h-9 rounded-full bg-white/20 flex items-center justify-center">
                      <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none"
                          viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                      </svg>
                  </div>
                  <h2 class="text-lg font-semibold text-white tracking-wide">Tambah Antrian</h2>
              </div>
              <button type="button" @click="open = false"
                  class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-white/20 transition text-white">
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                      stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                          d="M6 18L18 6M6 6l12 12" />
                  </svg>
              </button>
          </div>

          {{-- Form --}}
          <form action="{{ route('pelayanan.store') }}" method="POST">
              @csrf
              <div class="px-6 py-5 space-y-4">

                  {{-- Pasien --}}
                  <div>
                      <label class="block text-sm font-medium text-gray-700 mb-1.5">
                          Pasien <span class="text-red-500">*</span>
                      </label>
                      <select name="pasien_id"
                          class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent transition @error('pasien_id') border-red-400 @enderror">
                          <option value="">Pilih Pasien</option>
                          @foreach (\App\Models\Pasien::orderBy('nama')->get() as $pasien)
                              <option value="{{ $pasien->id }}">{{ $pasien->nama }}</option>
                          @endforeach
                      </select>
                      @error('pasien_id')
                          <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                      @enderror
                  </div>

                  {{-- Dokter --}}
                  <div>
                      <label class="block text-sm font-medium text-gray-700 mb-1.5">
                          Dokter
                      </label>
                      <select name="dokter_id"
                          class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent transition">
                          <option value="">Pilih Dokter</option>
                          @foreach (\App\Models\Dokter::orderBy('nama')->get() as $dokter)
                              <option value="{{ $dokter->id }}">{{ $dokter->nama }}</option>
                          @endforeach
                      </select>
                  </div>

                  {{-- Tanggal --}}
                  <div x-data x-init="flatpickr($refs.tanggalAntrian, {
                      dateFormat: 'Y-m-d',
                      altInput: true,
                      altFormat: 'd F Y',
                      locale: 'id',
                      defaultDate: 'today',
                      allowInput: false,
                      disableMobile: true,
                  })">
                      <label class="block text-sm font-medium text-gray-700 mb-1.5">
                          Tanggal <span class="text-red-500">*</span>
                      </label>
                      <div class="relative">
                          <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none z-10">
                              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                  stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                              </svg>
                          </span>
                          <input x-ref="tanggalAntrian" type="text" name="tanggal" placeholder="Pilih tanggal"
                              readonly
                              class="w-full pl-9 pr-4 py-2.5 text-sm border rounded-lg bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent transition placeholder-gray-400 cursor-pointer @error('tanggal') border-red-400 @else border-gray-200 @enderror">
                      </div>
                      @error('tanggal')
                          <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                      @enderror
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
                      Simpan Antrian
                  </button>
              </div>
          </form>
      </div>
  </div>
