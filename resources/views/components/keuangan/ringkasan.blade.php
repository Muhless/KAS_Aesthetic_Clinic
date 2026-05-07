   <div class="space-y-4">

                {{-- Ringkasan --}}
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                    <h3 class="font-semibold text-gray-700 text-sm mb-4">Ringkasan Bulan Ini</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between py-2 border-b border-gray-50">
                            <span class="text-xs text-gray-500">Total Pemasukan</span>
                            <span class="text-sm font-bold text-green-600">Rp
                                {{ number_format($pemasukanBulanIni, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-gray-50">
                            <span class="text-xs text-gray-500">Jumlah Transaksi</span>
                            <span class="text-sm font-semibold text-gray-800">{{ $totalTransaksi }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2">
                            <span class="text-xs text-gray-500">Rata-rata per Transaksi</span>
                            <span class="text-sm font-semibold text-gray-800">
                                Rp
                                {{ $totalTransaksi > 0 ? number_format($pemasukanBulanIni / $totalTransaksi, 0, ',', '.') : 0 }}
                            </span>
                        </div>
                    </div>
                </div>

            </div>
