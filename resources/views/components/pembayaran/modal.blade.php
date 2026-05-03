{{-- resources/views/components/keuangan/modal-bayar.blade.php --}}
{{-- Usage: letakkan di halaman keuangan, panggil dengan x-data="{ open: false, transaksiId: null, namaP: '', total: 0 }" --}}
{{-- Trigger tombol: @click="open = true; transaksiId = {{ $t->id }}; namaPasien = '...'; total = ..." --}}

<div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center"
    x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="open = false"></div>

    {{-- Modal Panel --}}
    <div class="relative z-10 w-full max-w-md mx-4 bg-white rounded-2xl shadow-2xl overflow-hidden"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95 translate-y-4"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-95 translate-y-4"
        @click.stop>

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-primary-600 to-primary-500">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-white/20 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h2 class="text-lg font-semibold text-white tracking-wide">Proses Pembayaran</h2>
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
        <form method="POST" :action="`/keuangan/bayar/${transaksiId}`"
            x-data="{ metode: '' }" @submit.prevent="
                if (!metode) { alert('Pilih metode pembayaran terlebih dahulu.'); return; }
                $el.submit();
            ">
            @csrf

            <div class="px-6 py-5 space-y-5">

                {{-- Info Pasien --}}
                <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-xl border border-gray-100">
                    <div class="w-11 h-11 rounded-full bg-primary-100 text-primary-700 flex items-center justify-center font-bold text-base shrink-0"
                        x-text="namaPasien ? namaPasien.charAt(0).toUpperCase() : '?'">
                    </div>
                    <div class="min-w-0">
                        <p class="font-semibold text-gray-800 truncate" x-text="namaPasien">—</p>
                        <p class="text-xs text-gray-400">Pasien</p>
                    </div>
                </div>

                {{-- Total Tagihan --}}
                <div class="flex items-center justify-between px-4 py-3.5 bg-primary-50 rounded-xl border border-primary-100">
                    <span class="text-sm font-medium text-primary-700">Total Tagihan</span>
                    <span class="text-xl font-bold text-primary-600"
                        x-text="'Rp ' + Number(total).toLocaleString('id-ID')">
                    </span>
                </div>

                {{-- Metode Pembayaran --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        Metode Pembayaran <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-3 gap-3">

                        {{-- Cash --}}
                        <label class="cursor-pointer">
                            <input type="radio" name="metode_bayar" value="cash" class="peer sr-only"
                                x-model="metode">
                            <div class="border-2 border-gray-200 rounded-xl p-3.5 text-center transition
                                        peer-checked:border-green-500 peer-checked:bg-green-50 hover:border-gray-300">
                                <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-2
                                            peer-checked:bg-green-200" style="transition: background 0.15s">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-600" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <p class="text-xs font-semibold text-gray-700 peer-checked:text-green-700">Cash</p>
                            </div>
                        </label>

                        {{-- Transfer --}}
                        <label class="cursor-pointer">
                            <input type="radio" name="metode_bayar" value="transfer" class="peer sr-only"
                                x-model="metode">
                            <div class="border-2 border-gray-200 rounded-xl p-3.5 text-center transition
                                        peer-checked:border-blue-500 peer-checked:bg-blue-50 hover:border-gray-300">
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mx-auto mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-600" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                    </svg>
                                </div>
                                <p class="text-xs font-semibold text-gray-700 peer-checked:text-blue-700">Transfer</p>
                            </div>
                        </label>

                        {{-- Kartu --}}
                        <label class="cursor-pointer">
                            <input type="radio" name="metode_bayar" value="kartu" class="peer sr-only"
                                x-model="metode">
                            <div class="border-2 border-gray-200 rounded-xl p-3.5 text-center transition
                                        peer-checked:border-violet-500 peer-checked:bg-violet-50 hover:border-gray-300">
                                <div class="w-8 h-8 rounded-full bg-violet-100 flex items-center justify-center mx-auto mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-violet-600" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                </div>
                                <p class="text-xs font-semibold text-gray-700 peer-checked:text-violet-700">Kartu</p>
                            </div>
                        </label>

                    </div>

                    @error('metode_bayar')
                        <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Indikator metode dipilih --}}
                <div x-show="metode"
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 -translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="flex items-center gap-2 text-xs text-gray-500 bg-gray-50 rounded-lg px-3 py-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-green-500 shrink-0" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                    </svg>
                    Metode dipilih: <span class="font-semibold text-gray-700 capitalize" x-text="metode"></span>
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
                    Konfirmasi Bayar
                </button>
            </div>
        </form>
    </div>
</div>
