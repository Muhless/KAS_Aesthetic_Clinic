@props(['reservasis'])

<div class="overflow-x-auto bg-white">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b text-primary-500 bg-primary-50/40">
                <th class="p-2 text-left">No</th>
                <th class="p-2 text-left">Nama</th>
                <th class="p-2 text-left">Dokter</th>
                <th class="p-2 text-left">Tanggal</th>
                <th class="p-2 text-center">Status</th>
                <th class="p-2 text-center">Aksi</th>
            </tr>
        </thead>

        <tbody class="divide-y">
            @forelse ($reservasis as $index => $reservasi)
                <tr class="hover:bg-primary-50/20 transition">
                    <td class="py-4 px-2 text-center text-gray-500">
                        {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                    </td>
                    <td class="py-4 px-2 font-semibold">{{ $reservasi->pasien->nama ?? '—' }}</td>
                    <td class="py-4 px-2">{{ $reservasi->dokter->nama ?? '—' }}</td>
                    <td class="py-4 px-2">
                        {{ \Carbon\Carbon::parse($reservasi->tanggal)->translatedFormat('d F Y') }}
                    </td>

                    <td class="py-4 px-2 text-center">
                        @if ($reservasi->status == 'tertunda')
                            <span
                                class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-medium">Tertunda</span>
                        @elseif ($reservasi->status == 'dikonfirmasi')
                            <span
                                class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">Dikonfirmasi</span>
                        @elseif ($reservasi->status == 'selesai')
                            <span
                                class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">Selesai</span>
                        @elseif ($reservasi->status == 'dibatalkan')
                            <span
                                class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-medium">Dibatalkan</span>
                        @else
                            <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-medium">—</span>
                        @endif
                    </td>
                    <td class="py-4 px-2">
                        <div class="flex items-center justify-center gap-2">
                            @if ($reservasi->status == 'tertunda')
                                <form action="{{ route('reservasi.update', $reservasi->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="status" value="dikonfirmasi">
                                    <button type="submit" title="Konfirmasi"
                                        class="w-8 h-8 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-full flex items-center justify-center shadow">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                            class="w-4 h-4">
                                            <path fill-rule="evenodd"
                                                d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </form>
                            @endif

                            {{-- Check-in --}}
                            @if ($reservasi->status == 'dikonfirmasi')
                                <form action="{{ route('pelayanan.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="pasien_id" value="{{ $reservasi->pasien_id }}">
                                    <input type="hidden" name="dokter_id" value="{{ $reservasi->dokter_id }}">
                                    <input type="hidden" name="tanggal" value="{{ $reservasi->tanggal }}">
                                    <input type="hidden" name="reservasi_id" value="{{ $reservasi->id }}">
                                    <input type="hidden" name="keluhan" value="{{ $reservasi->keluhan }}">
                                    <button type="submit" title="Check-in"
                                        class="w-8 h-8 bg-primary-50 hover:bg-primary-100 text-primary-600 rounded-full flex items-center justify-center shadow">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                            class="w-4 h-4">
                                            <path fill-rule="evenodd"
                                                d="M3 4.25A2.25 2.25 0 0 1 5.25 2h5.5A2.25 2.25 0 0 1 13 4.25v2a.75.75 0 0 1-1.5 0v-2a.75.75 0 0 0-.75-.75h-5.5a.75.75 0 0 0-.75.75v11.5c0 .414.336.75.75.75h5.5a.75.75 0 0 0 .75-.75v-2a.75.75 0 0 1 1.5 0v2A2.25 2.25 0 0 1 10.75 18h-5.5A2.25 2.25 0 0 1 3 15.75V4.25Z"
                                                clip-rule="evenodd" />
                                            <path fill-rule="evenodd"
                                                d="M19 10a.75.75 0 0 0-.75-.75H8.704l1.048-1.08a.75.75 0 1 0-1.004-1.11l-2.5 2.25a.75.75 0 0 0 0 1.08l2.5 2.25a.75.75 0 1 0 1.004-1.11l-1.048-1.08h9.546A.75.75 0 0 0 19 10Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </form>
                            @endif

                            <button type="button"
                                onclick="confirmDelete({{ $reservasi->id }}, '{{ $reservasi->pasien->nama }}')"
                                class="cursor-pointer w-8 h-8 bg-red-50 hover:bg-red-100 text-red-600 rounded-full flex items-center justify-center shadow">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="w-4 h-4">
                                    <path fill-rule="evenodd"
                                        d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>

                            <form id="delete-form-{{ $reservasi->id }}"
                                action="{{ route('reservasi.destroy', $reservasi->id) }}" method="POST"
                                class="hidden">
                                @csrf @method('DELETE')
                            </form>
                            {{-- Konfirmasi --}}

                        </div>
                    </td>
                </tr>

            @empty
                <tr>
                    <td colspan="7" class="text-center py-12">
                        <div class="flex flex-col items-center gap-2 text-gray-400">
                            <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-300" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-gray-500">Belum ada data reservasi</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
