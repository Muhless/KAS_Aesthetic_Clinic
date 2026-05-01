<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-primary-50/50 border-b border-primary-100">
                    <th
                        class="px-4 py-3.5 text-left text-xs font-semibold text-primary-500 uppercase tracking-wider w-12">
                        No
                    </th>
                    <th class="px-4 py-3.5 text-left text-xs font-semibold text-primary-500 uppercase tracking-wider">
                        Nama
                        Pasien</th>
                    <th class="px-4 py-3.5 text-left text-xs font-semibold text-primary-500 uppercase tracking-wider">
                        Jenis
                        Kelamin</th>
                    <th class="px-4 py-3.5 text-left text-xs font-semibold text-primary-500 uppercase tracking-wider">
                        Nomor
                        Telepon</th>
                    <th class="px-4 py-3.5 text-left text-xs font-semibold text-primary-500 uppercase tracking-wider">
                        Tanggal
                        Lahir</th>
                    <th class="px-4 py-3.5 text-center text-xs font-semibold text-primary-500 uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-50">
                @forelse ($pasiens as $index => $pasien)
                    <tr class="hover:bg-gray-50/80 transition-colors duration-150 group">

                        {{-- No --}}
                        <td class="px-4 py-3.5 text-gray-400 text-center">
                            {{ $index + 1 }}
                        </td>

                        {{-- Nama — klik ke detail --}}
                        <td class="px-4 py-3.5">
                            <a href="{{ route('pasien.show', $pasien->id) }}"
                                class="flex items-center gap-3 group/name">
                                {{-- Avatar inisial --}}
                                <div
                                    class="w-8 h-8 rounded-full bg-primary-100 text-primary-600 flex items-center justify-center font-semibold text-xs shrink-0">
                                    {{ strtoupper(substr($pasien->nama, 0, 1)) }}
                                </div>
                                <span
                                    class="font-medium text-gray-800 group-hover/name:text-primary-600 transition-colors">
                                    {{ $pasien->nama }}
                                </span>
                            </a>
                        </td>

                        {{-- Jenis Kelamin --}}
                        <td class="px-4 py-3.5">
                            @if ($pasien->jenis_kelamin == 'L')
                                <span
                                    class="inline-flex items-center gap-1 px-2.5 py-1 bg-blue-50 text-blue-700 rounded-full text-xs font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M16 2v2h3.586l-3.972 3.972A7 7 0 1 0 17 13h2a9 9 0 1 1-2.618-6.382L20 3H16V2h.001L16 2zm-6 18a5 5 0 1 1 0-10 5 5 0 0 1 0 10z" />
                                    </svg>
                                    Laki-laki
                                </span>
                            @elseif ($pasien->jenis_kelamin == 'P')
                                <span
                                    class="inline-flex items-center gap-1 px-2.5 py-1 bg-pink-50 text-pink-700 rounded-full text-xs font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M12 2a7 7 0 1 0 0 14A7 7 0 0 0 12 2zm0 12a5 5 0 1 1 0-10 5 5 0 0 1 0 10zm-1 2h2v3h-2zm-2 3h6v2H9z" />
                                    </svg>
                                    Perempuan
                                </span>
                            @else
                                <span class="text-gray-300">—</span>
                            @endif
                        </td>

                        {{-- Nomor Telepon --}}
                        <td class="px-4 py-3.5 text-gray-600">
                            @if ($pasien->nomor_telepon)
                                <span class="font-mono tracking-wide">{{ $pasien->nomor_telepon }}</span>
                            @else
                                <span class="text-gray-300">—</span>
                            @endif
                        </td>

                        {{-- Tanggal Lahir --}}
                        <td class="px-4 py-3.5 text-gray-600">
                            @if ($pasien->tanggal_lahir)
                                {{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->translatedFormat('d F Y') }}
                            @else
                                <span class="text-gray-300">—</span>
                            @endif
                        </td>

                        {{-- Aksi --}}
                        <td class="px-4 py-3.5">
                            <div class="flex items-center justify-center gap-2">

                                {{-- Detail --}}
                                <a href="{{ route('pasien.show', $pasien->id) }}" title="Lihat Detail"
                                    class="w-8 h-8 bg-primary-50 hover:bg-primary-100 text-primary-600 rounded-full flex items-center justify-center transition-colors shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        class="w-4 h-4">
                                        <path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                                        <path fill-rule="evenodd"
                                            d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>

                                {{-- Edit --}}
                                <a href="{{ route('pasien.edit', $pasien->id) }}" title="Edit"
                                    class="w-8 h-8 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-full flex items-center justify-center transition-colors shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        class="w-4 h-4">
                                        <path
                                            d="m2.695 14.762-1.262 3.155a.5.5 0 0 0 .65.65l3.155-1.262a4 4 0 0 0 1.343-.886L17.5 5.501a2.121 2.121 0 0 0-3-3L3.58 13.419a4 4 0 0 0-.885 1.343Z" />
                                    </svg>
                                </a>

                                {{-- Hapus --}}
                                <button type="button"
                                    onclick="confirmDelete({{ $pasien->id }}, '{{ $pasien->nama }}')" title="Hapus"
                                    class="cursor-pointer w-8 h-8 bg-red-50 hover:bg-red-100 text-red-600 rounded-full flex items-center justify-center transition-colors shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        class="w-4 h-4">
                                        <path fill-rule="evenodd"
                                            d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>

                                {{-- Form delete hidden --}}
                                <form id="delete-form-{{ $pasien->id }}"
                                    action="{{ route('pasien.destroy', $pasien->id) }}" method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="6" class="py-20 text-center">
                            <div class="flex flex-col items-center gap-3 text-gray-400">
                                <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-300" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-500">Belum ada data pasien</p>
                                    <p class="text-xs mt-0.5">Tambahkan pasien pertama untuk memulai</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    function confirmDelete(id, nama) {
        Swal.fire({
            title: 'Hapus Pasien?',
            text: `Yakin ingin menghapus pasien "${nama}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
