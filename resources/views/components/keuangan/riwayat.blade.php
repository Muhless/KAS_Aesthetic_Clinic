  <div class="lg:col-span-2 bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
      <div class="px-5 py-4 border-b border-gray-100">
          <h2 class="font-semibold text-gray-700 text-sm">Riwayat Transaksi</h2>
          <p class="text-xs text-gray-400 mt-0.5">
              {{ \Carbon\Carbon::create()->month($bulan)->translatedFormat('F') }} {{ $tahun }}
          </p>
      </div>

      <div class="overflow-x-auto">
          <table class="w-full text-sm">
              <thead>
                  <tr class="bg-gray-50 text-xs text-gray-400 uppercase tracking-wider">
                      <th class="px-5 py-3 text-left font-medium">Pasien</th>
                      <th class="px-5 py-3 text-left font-medium">Tanggal</th>
                      <th class="px-5 py-3 text-left font-medium">Metode</th>
                      <th class="px-5 py-3 text-right font-medium">Total</th>
                  </tr>
              </thead>
              <tbody class="divide-y divide-gray-50">
                  @forelse ($transaksis as $transaksi)
                      <tr class="hover:bg-gray-50 transition">
                          <td class="px-5 py-3.5">
                              <div class="flex items-center gap-2.5">
                                  <div
                                      class="w-7 h-7 rounded-full bg-primary-100 text-primary-700 flex items-center justify-center font-semibold text-xs shrink-0">
                                      {{ strtoupper(substr($transaksi->pelayanan->pasien->nama ?? '?', 0, 1)) }}
                                  </div>
                                  <span
                                      class="font-medium text-gray-800">{{ $transaksi->pelayanan->pasien->nama ?? '—' }}</span>
                              </div>
                          </td>
                          <td class="px-5 py-3.5 text-gray-500 text-xs">
                              {{ \Carbon\Carbon::parse($transaksi->dibayar_pada)->translatedFormat('d M Y, H:i') }}
                          </td>
                          <td class="px-5 py-3.5">
                              @if ($transaksi->metode_bayar == 'cash')
                                  <span
                                      class="text-xs px-2 py-1 rounded-full bg-green-50 text-green-700 font-medium">Cash</span>
                              @elseif ($transaksi->metode_bayar == 'transfer')
                                  <span
                                      class="text-xs px-2 py-1 rounded-full bg-blue-50 text-blue-700 font-medium">Transfer</span>
                              @elseif ($transaksi->metode_bayar == 'kartu')
                                  <span
                                      class="text-xs px-2 py-1 rounded-full bg-violet-50 text-violet-700 font-medium">Kartu</span>
                              @else
                                  <span class="text-gray-300">—</span>
                              @endif
                          </td>
                          <td class="px-5 py-3.5 text-right font-semibold text-gray-800">
                              Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
                          </td>
                      </tr>
                  @empty
                      <tr>
                          <td colspan="4" class="py-12 text-center">
                              <div class="flex flex-col items-center gap-2 text-gray-400">
                                  <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center">
                                      <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor"
                                          viewBox="0 0 24 24">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                      </svg>
                                  </div>
                                  <p class="text-sm font-medium text-gray-500">Belum ada transaksi</p>
                              </div>
                          </td>
                      </tr>
                  @endforelse
              </tbody>
          </table>
      </div>
  </div>
