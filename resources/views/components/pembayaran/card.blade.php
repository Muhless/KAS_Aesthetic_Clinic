@props(['pembayaran'])

@php
    // Hitung total tagihan
    $totalProduk = array_sum(array_column($pembayaran['produk'], 'subtotal'));
    $totalTagihan = $pembayaran['harga_dokter'] + $pembayaran['harga_treatment'] + $totalProduk;
@endphp

<div
    class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-shadow duration-300">

    <!-- Header dengan ID Antrian -->
    <div class="bg-linear-to-r from-primary-500 to-primary-600 px-6 py-4">
        <div class="flex items-center justify-between">
            <div>
                <div class="text-xs text-primary-100 uppercase tracking-wide font-medium mb-1">
                    ID Antrian
                </div>
                <div class="text-2xl font-bold text-white">
                    #{{ $pembayaran['antrian'] }}
                </div>
            </div>
            <div class="bg-white/20 backdrop-blur-sm rounded-full p-3">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
        </div>
    </div>

    <div class="p-6 space-y-4">
        <div>
            <div class="text-xs text-gray-500 uppercase tracking-wide mb-1">Nama Pasien</div>
            <h1 class="text-xl font-bold text-gray-900">
                {{ $pembayaran['nama'] }}
            </h1>
        </div>

        <!-- Divider -->
        <div class="border-t border-gray-100 pt-4">
            <div class="text-xs text-gray-500 uppercase tracking-wide mb-3 font-semibold">
                Rincian Biaya
            </div>

            <div class="space-y-3">
                <!-- Dokter -->
                <div class="flex items-center justify-between group">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary-500 mt-0.5 shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <div>
                            <div class="text-xs text-gray-500">Dokter</div>
                            <div class="text-sm font-medium text-gray-900">{{ $pembayaran['dokter'] }}</div>
                        </div>
                    </div>
                    <span class="font-semibold text-gray-900 text-sm">
                        Rp {{ number_format($pembayaran['harga_dokter'], 0, ',', '.') }}
                    </span>
                </div>

                <!-- Treatment -->
                <div class="flex items-center justify-between group">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary-500 mt-0.5 shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        <div>
                            <div class="text-xs text-gray-500">Treatment</div>
                            <div class="text-sm font-medium text-gray-900">{{ $pembayaran['treatment'] }}</div>
                        </div>
                    </div>
                    <span class="font-semibold text-gray-900 text-sm">
                        Rp {{ number_format($pembayaran['harga_treatment'], 0, ',', '.') }}
                    </span>
                </div>

                <!-- Produk -->
                @if (count($pembayaran['produk']) > 0)
                    <div class="space-y-2">

                        <div class="text-xs text-gray-500 uppercase tracking-wide">
                            Produk
                        </div>

                        @foreach ($pembayaran['produk'] as $item)
                            <div class="flex items-center justify-between group">
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-primary-500 mt-0.5 shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>

                                    <div>
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $item->nama }}
                                            <span class="text-xs text-gray-500">x{{ $item->qty }}</span>
                                        </div>
                                    </div>
                                </div>

                                <span class="font-semibold text-gray-900 text-sm">
                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                </span>
                            </div>
                        @endforeach

                    </div>
                @else
                    {{-- Tidak ada produk --}}
                    <div class="flex items-center gap-2 text-sm text-gray-500 italic">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18.364 5.636l-12.728 12.728M6.343 6.343l12.728 12.728" />
                        </svg>
                        Tidak ada produk tambahan
                    </div>
                @endif

            </div>
        </div>

        <div
            class="bg-linear-to-br from-gray-50 to-gray-100 rounded-xl p-4 border border-gray-200
           flex flex-col items-center justify-center text-center">

            <div class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">
                Total Tagihan
            </div>

            <div class="text-2xl font-bold text-primary-600">
                Rp {{ number_format($totalTagihan, 0, ',', '.') }}
            </div>

        </div>


        <button
            class="w-full cursor-pointer bg-linear-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white font-semibold py-3.5 px-4 rounded-xl shadow-lg shadow-primary-500/30 hover:shadow-xl hover:shadow-primary-500/40 transition-all duration-300 transform hover:-translate-y-0.5 active:translate-y-0 flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
            </svg>
            Proses Pembayaran
        </button>
    </div>
</div>
