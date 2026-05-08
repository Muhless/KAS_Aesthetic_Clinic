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
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-50">
                @forelse ($pasiens as $pasien)
                    <tr class="hover:bg-gray-50/80 transition-colors duration-150 group cursor-pointer"
                        onclick="window.location.href='{{ route('pasien.show', $pasien->id) }}'">

                        <td class="px-4 py-3.5 text-gray-400 text-center">
                            {{ $loop->iteration }}
                        </td>

                        {{-- Nama --}}
                        <td class="px-4 py-3.5">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-8 h-8 rounded-full bg-primary-100 text-primary-600 flex items-center justify-center font-semibold text-xs shrink-0">
                                    {{ strtoupper(substr($pasien->nama, 0, 1)) }}
                                </div>
                                <span class="font-medium text-gray-800 group-hover:text-primary-600 transition-colors">
                                    {{ $pasien->nama }}
                                </span>
                            </div>
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

                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-20 text-center">
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
