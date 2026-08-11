<div class="bg-white rounded-sm shadow-[0_0.5rem_1rem_rgba(0,0,0,0.1)] border border-black/10 overflow-hidden">
    <div class="flex items-center justify-between px-4 py-3 bg-slate-100 border-b border-black/10">
        <div>
            <h5 class="text-sm font-semibold text-slate-700 m-0">Reservasi Hari Ini</h5>
            <p class="text-xs text-slate-400 m-0">{{ now()->translatedFormat('l, d F Y') }}</p>
        </div>
        <a href="{{ route('reservasi.index') }}"
            class="text-xs text-blue-500 hover:text-blue-600 font-medium transition">
            Lihat Semua →
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-100 text-xs text-slate-600 uppercase">
                    <th class="px-3 py-2 text-left font-semibold border-b border-black/10">Pasien</th>
                    <th class="px-3 py-2 text-left font-semibold border-b border-black/10">Status</th>
                    <th class="px-3 py-2 text-center font-semibold border-b border-black/10">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($reservasisHariIni as $reservasi)
                <tr class="border-b border-black/10 even:bg-slate-50 hover:bg-slate-100 transition">

                    {{-- Pasien --}}
                    <td class="px-3 py-2.5">
                        <div class="flex items-center gap-2">
                            <div
                                class="w-7 h-7 rounded-full bg-slate-200 text-slate-600 flex items-center justify-center font-semibold text-xs shrink-0">
                                {{ strtoupper(substr($reservasi->pasien->nama ?? '?', 0, 1)) }}
                            </div>
                            <span class="font-medium text-slate-700">{{ $reservasi->pasien->nama ?? '—' }}</span>
                        </div>
                    </td>

                    {{-- Status --}}
                    <td class="px-3 py-2.5">
                        @php $status = strtolower($reservasi->status); @endphp
                        @if ($status == 'tertunda')
                        <span class="text-xs px-2 py-1 rounded bg-yellow-500 text-white font-medium">Tertunda</span>
                        @elseif ($status == 'dikonfirmasi')
                        <span class="text-xs px-2 py-1 rounded bg-blue-500 text-white font-medium">Dikonfirmasi</span>
                        @elseif ($status == 'selesai')
                        <span class="text-xs px-2 py-1 rounded bg-green-500 text-white font-medium">Selesai</span>
                        @elseif ($status == 'dibatalkan')
                        <span class="text-xs px-2 py-1 rounded bg-red-500 text-white font-medium">Dibatalkan</span>
                        @else
                        <span
                            class="text-xs px-2 py-1 rounded bg-slate-400 text-white font-medium">{{ ucfirst($status) }}</span>
                        @endif
                    </td>

                    {{-- Aksi --}}
                    <td class="px-3 py-2.5">
                        <div class="flex items-center justify-center gap-1.5">

                            {{-- Konfirmasi --}}
                            @if ($status == 'tertunda')
                            <form action="{{ route('reservasi.update', $reservasi->id) }}" method="POST">
                                @csrf @method('PUT')
                                <input type="hidden" name="status" value="dikonfirmasi">
                                <button type="submit" title="Konfirmasi"
                                    class="w-7 h-7 bg-blue-500 hover:bg-blue-600 text-white rounded-sm flex items-center justify-center transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </button>
                            </form>
                            @endif

                            {{-- Check-in → jadi antrian --}}
                            @if ($status == 'dikonfirmasi')
                            <form action="{{ route('pelayanan.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="pasien_id" value="{{ $reservasi->pasien_id }}">
                                <input type="hidden" name="dokter_id" value="{{ $reservasi->dokter_id }}">
                                <input type="hidden" name="tanggal" value="{{ $reservasi->tanggal }}">
                                <input type="hidden" name="reservasi_id" value="{{ $reservasi->id }}">
                                <button type="submit" title="Check-in ke Antrian"
                                    class="w-7 h-7 bg-green-500 hover:bg-green-600 text-white rounded-sm flex items-center justify-center transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                    </svg>
                                </button>
                            </form>
                            @endif

                            {{-- Detail --}}
                            <a href="{{ route('reservasi.show', $reservasi->id) }}" title="Detail"
                                class="w-7 h-7 bg-slate-400 hover:bg-slate-500 text-white rounded-sm flex items-center justify-center transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>

                        </div>
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="3" class="py-10 text-center text-slate-400 text-sm">
                        Belum ada reservasi hari ini
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>