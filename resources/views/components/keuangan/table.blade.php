        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50">
                        <th class="text-left px-5 py-3.5 text-xs font-medium text-slate-400 uppercase tracking-wider">ID
                        </th>
                        <th class="text-left px-5 py-3.5 text-xs font-medium text-slate-400 uppercase tracking-wider">
                            Pasien</th>
                        <th class="text-left px-5 py-3.5 text-xs font-medium text-slate-400 uppercase tracking-wider">
                            Total
                            Pembayaran</th>
                        <th class="text-left px-5 py-3.5 text-xs font-medium text-slate-400 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="text-left px-5 py-3.5 text-xs font-medium text-slate-400 uppercase tracking-wider">
                            Dibayar Pada</th>
                        <th class="text-left px-5 py-3.5 text-xs font-medium text-slate-400 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($pembayarans as $pembayaran)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-5 py-4 text-slate-500 font-mono text-xs">#{{ $pembayaran->id }}</td>

                            <td class="px-5 py-4">
                                <p class="font-medium text-slate-800">{{ $pembayaran->pelayanan->pasien->nama ?? '—' }}
                                </p>
                                <p class="text-xs text-slate-400 mt-0.5">Pelayanan #{{ $pembayaran->pelayanan_id }}</p>
                            </td>

                            <td class="px-5 py-4 font-semibold text-slate-800">
                                Rp {{ number_format($pembayaran->total_harga, 0, ',', '.') }}
                            </td>

                            <td class="px-5 py-4">
                                @if ($pembayaran->status === 'lunas')
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-600">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 inline-block"></span>
                                        Lunas
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-rose-50 text-rose-600">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-400 inline-block"></span>
                                        Belum Bayar
                                    </span>
                                @endif
                            </td>

                            <td class="px-5 py-4 text-slate-500 text-xs">
                                {{ $pembayaran->dibayar_pada ? \Carbon\Carbon::parse($pembayaran->dibayar_pada)->format('d M Y, H:i') : '-' }}
                            </td>

                            <td class="px-5 py-4">
                                <a href="{{ route('keuangan.show', $pembayaran->id) }}"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-primary-600 bg-primary-50 hover:bg-primary-100 rounded-lg transition-all">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        class="size-3.5">
                                        <path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                                        <path fill-rule="evenodd"
                                            d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-16 text-center">
                                <div class="flex flex-col items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        class="size-10 text-slate-200">
                                        <path fill-rule="evenodd"
                                            d="M4 4a2 2 0 0 1 2-2h4.586A2 2 0 0 1 12 2.586L15.414 6A2 2 0 0 1 16 7.414V16a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <p class="text-sm text-slate-400">Belum ada data pembayaran</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if ($pembayarans->hasPages())
                <div class="px-5 py-4 border-t border-slate-100">
                    {{ $pembayarans->withQueryString()->links() }}
                </div>
            @endif
        </div>
