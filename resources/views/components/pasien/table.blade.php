<div class="overflow-x-auto bg-white">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b text-primary-500 bg-primary-50/40">
                <th class="p-2 text-left">No</th>
                <th class="p-2 text-left">Nama pasien</th>
                <th class="p-2 text-left">Jenis Kelamin</th>
                <th class="p-2 text-left">Nomor Telepon</th>
                <th class="p-2 text-left">Tanggal Lahir</th>
                <th class="p-2 text-center">Aksi</th>
            </tr>
        </thead>

        <tbody class="divide-y">

            @forelse ($pasiens as $index => $pasien)
                <tr class="hover:bg-primary-50/20 transition">
                    <td class="py-4 px-2 text-center">{{ $index + 1 }}</td>
                    <td class="py-4 px-2 font-semibold">{{ $pasien->nama }}</td>
                    <td class="py-4 px-2">
                        @if ($pasien->jenis_kelamin == 'L')
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs">Laki-laki</span>
                        @elseif($pasien->jenis_kelamin == 'P')
                            <span class="px-2 py-1 bg-pink-100 text-pink-800 rounded text-xs">Perempuan</span>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="py-4 px-2">{{ $pasien->nomor_telepon ?? '-' }}</td>
                    <td class="py-4 px-2">
                        {{ $pasien->tanggal_lahir ? \Carbon\Carbon::parse($pasien->tanggal_lahir)->translatedFormat('d F Y') : '-' }}
                    </td>

                    <td class="py-4 px-2">
                        <div class="flex items-center justify-center space-x-2">
                            <div
                                class="w-8 h-8 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-full flex items-center justify-center shadow">
                                <a href="{{ route('pasien.edit', $pasien->id) }}" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        class="w-4 h-4">
                                        <path
                                            d="m2.695 14.762-1.262 3.155a.5.5 0 0 0 .65.65l3.155-1.262a4 4 0 0 0 1.343-.886L17.5 5.501a2.121 2.121 0 0 0-3-3L3.58 13.419a4 4 0 0 0-.885 1.343Z" />
                                    </svg>
                                </a>
                            </div>


                            <!-- Hapus -->
                            <button type="button" onclick="confirmDelete({{ $pasien->id }}, '{{ $pasien->nama }}')"
                                class="cursor-pointer w-8 h-8 bg-red-50 hover:bg-red-100 text-red-600 rounded-full flex items-center justify-center shadow "
                                title="Hapus">

                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="w-4 h-4">
                                    <path fill-rule="evenodd"
                                        d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>


                            <!-- Form Hidden untuk Delete -->
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
                    <td colspan="6" class="text-center py-5 text-gray-500">
                        Belum ada data pasien
                    </td>
                </tr>
            @endforelse

        </tbody>
    </table>
</div>

<script>
    function confirmDelete(id, nama) {
        Swal.fire({
            title: 'Hapus Pasien?',
            text: `Yakin ingin menghapus pasien "${nama}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
