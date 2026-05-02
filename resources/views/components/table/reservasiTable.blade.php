{{-- Tabel Reservasi Hari Ini --}}
<div class="bg-white rounded-2xl border border-slate-100 overflow-hidden">
    <div class="flex items-center justify-between px-5 py-4 border-b border-slate-50">
        <div>
            <h2 class="font-semibold text-slate-800 text-sm">Reservasi Hari Ini</h2>
            <p class="text-xs text-slate-400 mt-0.5">{{ now()->translatedFormat('l, d F Y') }}</p>
        </div>
        <a href="{{ route('reservasi.index') }}"
            class="text-xs text-primary-500 hover:text-primary-700 font-medium transition">
            Lihat Semua →
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 text-xs text-slate-400 uppercase tracking-wider">
                    <th class="px-5 py-3 text-left font-medium">Pasien</th>
                    <th class="px-5 py-3 text-left font-medium">Treatment</th>
                    <th class="px-5 py-3 text-left font-medium">Dokter</th>
                    <th class="px-5 py-3 text-left font-medium">Jam</th>
                    <th class="px-5 py-3 text-left font-medium">Status</th>
                    <th class="px-5 py-3 text-center font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse ($reservasisHariIni as $reservasi)
                    <tr class="hover:bg-slate-50 transition">

                        {{-- Pasien --}}
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-2.5">
                                <div class="w-7 h-7 rounded-full bg-primary-100 text-primary-600 flex items-center justify-center font-semibold text-xs shrink-0">
                                    {{ strtoupper(substr($reservasi->pasien->nama ?? '?', 0, 1)) }}
                                </div>
                                <span class="font-medium text-slate-800">{{ $reservasi->pasien->nama ?? '—' }}</span>
                            </div>
                        </td>

                        {{-- Treatment --}}
                        <td class="px-5 py-3.5 text-slate-500">
                            {{ $reservasi->treatment->nama ?? '—' }}
                        </td>

                        {{-- Dokter --}}
                        <td class="px-5 py-3.5 text-slate-500">
                            {{ $reservasi->dokter->nama ?? '—' }}
                        </td>

                        {{-- Jam --}}
                        <td class="px-5 py-3.5 text-slate-500 font-mono">
                            {{ $reservasi->waktu ? \Carbon\Carbon::parse($reservasi->waktu)->format('H:i') : '—' }}
                        </td>

                        {{-- Status --}}
                        <td class="px-5 py-3.5">
                            @php $status = strtolower($reservasi->status); @endphp
                            @if ($status == 'tertunda')
                                <span class="text-xs px-2.5 py-1 rounded-full bg-amber-50 text-amber-600 font-medium">Tertunda</span>
                            @elseif ($status == 'dikonfirmasi')
                                <span class="text-xs px-2.5 py-1 rounded-full bg-blue-50 text-blue-600 font-medium">Dikonfirmasi</span>
                            @elseif ($status == 'selesai')
                                <span class="text-xs px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-600 font-medium">Selesai</span>
                            @elseif ($status == 'dibatalkan')
                                <span class="text-xs px-2.5 py-1 rounded-full bg-red-50 text-red-500 font-medium">Dibatalkan</span>
                            @else
                                <span class="text-xs px-2.5 py-1 rounded-full bg-slate-100 text-slate-500 font-medium">{{ ucfirst($status) }}</span>
                            @endif
                        </td>

                        {{-- Aksi --}}
                        <td class="px-5 py-3.5">
                            <div class="flex items-center justify-center gap-2">

                                {{-- Konfirmasi --}}
                                @if ($status == 'tertunda')
                                    <form action="{{ route('reservasi.update', $reservasi->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <input type="hidden" name="status" value="dikonfirmasi">
                                        <button type="submit" title="Konfirmasi"
                                            class="w-7 h-7 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-full flex items-center justify-center transition shadow-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </button>
                                    </form>
                                @endif

                                {{-- Check-in → jadi antrian --}}
                                @if ($status == 'dikonfirmasi')
                                    <form action="{{ route('antrian.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="pasien_id" value="{{ $reservasi->pasien_id }}">
                                        <input type="hidden" name="dokter_id" value="{{ $reservasi->dokter_id }}">
                                        <input type="hidden" name="tanggal" value="{{ $reservasi->tanggal }}">
                                        <button type="submit" title="Check-in ke Antrian"
                                            class="w-7 h-7 bg-primary-50 hover:bg-primary-100 text-primary-600 rounded-full flex items-center justify-center transition shadow-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                            </svg>
                                        </button>
                                    </form>
                                @endif

                                {{-- Detail --}}
                                <a href="{{ route('reservasi.show', $reservasi->id) }}"
                                    title="Detail"
                                    class="w-7 h-7 bg-slate-50 hover:bg-slate-100 text-slate-500 rounded-full flex items-center justify-center transition shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>

                            </div>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center">
                            <div class="flex flex-col items-center gap-2 text-slate-400">
                                <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <p class="text-sm font-medium text-slate-500">Belum ada reservasi hari ini</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
