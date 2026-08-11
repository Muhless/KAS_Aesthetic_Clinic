<div class="lg:col-span-2 bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">

    {{-- Header + Filter --}}
    <div class="px-5 py-4 border-b border-gray-100 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
        <div>
            <h2 class="font-semibold text-gray-700 text-sm">Laporan Transaksi</h2>
            <p class="text-xs text-gray-400 mt-0.5">
                {{ \Carbon\Carbon::create()->month((int) $bulan)->translatedFormat('F') }} {{ $tahun }}
            </p>
        </div>

        {{-- Form Filter Periode --}}
        <form action="{{ route('keuangan.index') }}" method="GET" class="flex flex-wrap items-center gap-2"
            x-data="{ periode: '{{ $periode ?? 'bulanan' }}' }">

            <select name="periode" x-model="periode" onchange="this.form.submit()"
                class="text-xs border border-gray-200 rounded-lg px-2.5 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 text-gray-700">
                <option value="harian" {{ ($periode ?? '') == 'harian' ? 'selected' : '' }}>Harian</option>
                <option value="bulanan" {{ ($periode ?? 'bulanan') == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                <option value="tahunan" {{ ($periode ?? '') == 'tahunan' ? 'selected' : '' }}>Tahunan</option>
            </select>

            {{-- Input Tanggal (Harian) --}}
            <input type="date" name="tanggal" x-show="periode === 'harian'" x-cloak
                value="{{ $tanggal ?? now()->format('Y-m-d') }}" onchange="this.form.submit()"
                class="text-xs border border-gray-200 rounded-lg px-2.5 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 text-gray-700">

            {{-- Input Bulan + Tahun (Bulanan) --}}
            <select name="bulan" x-show="periode === 'bulanan'" x-cloak onchange="this.form.submit()"
                class="text-xs border border-gray-200 rounded-lg px-2.5 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 text-gray-700">
                @foreach (range(1, 12) as $m)
                <option value="{{ $m }}" {{ (int) $bulan == $m ? 'selected' : '' }}>
                    {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                </option>
                @endforeach
            </select>

            {{-- Input Tahun (Bulanan & Tahunan) --}}
            <select name="tahun" x-show="periode === 'bulanan' || periode === 'tahunan'" x-cloak
                onchange="this.form.submit()"
                class="text-xs border border-gray-200 rounded-lg px-2.5 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 text-gray-700">
                @foreach (range(now()->year, now()->year - 5) as $y)
                <option value="{{ $y }}" {{ (int) $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endforeach
            </select>

            {{-- Tombol Cetak PDF --}}
            <a href="{{ route('keuangan.laporan.cetak', request()->only(['periode', 'tanggal', 'bulan', 'tahun'])) }}"
                target="_blank"
                class="inline-flex items-center gap-1.5 text-xs px-3 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Cetak PDF
            </a>
        </form>
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
                        <span class="text-xs px-2 py-1 rounded-full bg-green-50 text-green-700 font-medium">Cash</span>
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
