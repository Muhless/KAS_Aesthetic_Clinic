@php
    $reservasis = collect([
        (object) [
            'id' => 1,
            'pasien' => (object) ['nama' => 'Siti Aisyah'],
            'dokter' => (object) ['nama' => 'dr. Andi'],
            'treatment' => (object) ['nama' => 'Facial Glowing'],
            'tanggal' => now(),
            'status' => 'tertunda',
        ],
        (object) [
            'id' => 2,
            'pasien' => (object) ['nama' => 'Budi Santoso'],
            'dokter' => (object) ['nama' => 'dr. Rina'],
            'treatment' => (object) ['nama' => 'Laser Acne'],
            'tanggal' => now()->addDay(),
            'status' => 'diproses',
        ],
        (object) [
            'id' => 3,
            'pasien' => (object) ['nama' => 'Dewi Lestari'],
            'dokter' => (object) ['nama' => 'dr. Kevin'],
            'treatment' => (object) ['nama' => 'Botox'],
            'tanggal' => now()->addDays(2),
            'status' => 'selesai',
        ],
    ]);
@endphp


<div class="overflow-x-auto bg-white">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b text-primary-500 bg-primary-50/40">
                <th class="p-2 text-left">No</th>
                <th class="p-2 text-left">Nama</th>
                <th class="p-2 text-left">Dokter</th>
                <th class="p-2 text-left">Treatment</th>
                <th class="p-2 text-left">Tanggal</th>
                <th class="p-2 text-center">Status</th>
                <th class="p-2 text-center">Aksi</th>
            </tr>
        </thead>

        <tbody class="divide-y">
            @forelse ($reservasis as $index => $reservasi)
                <tr class="hover:bg-primary-50/20 transition">
                    <td class="py-4 px-2 text-center font-bold text-primary-600">
                        #{{ str_pad($index + 1, 3, '0', STR_PAD_LEFT) }}
                    </td>
                    <td class="py-4 px-2 font-semibold">{{ $reservasi->pasien->nama }}</td>
                    <td class="py-4 px-2">{{ $reservasi->dokter->nama }}</td>
                    <td class="py-4 px-2">{{ $reservasi->treatment->nama }}</td>
                    <td class="py-4 px-2">
                        {{ \Carbon\Carbon::parse($reservasi->tanggal)->translatedFormat('d F Y') }}
                    </td>
                    <td class="py-4 px-2 text-center">
                        @if ($reservasi->status == 'tertunda')
                            <span
                                class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-medium">Tertunda</span>
                        @elseif($reservasi->status == 'diproses')
                            <span
                                class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">Diproses</span>
                        @elseif($reservasi->status == 'selesai')
                            <span
                                class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">Selesai</span>
                        @elseif($reservasi->status == 'dibatalkan')
                            <span
                                class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-medium">Dibatalkan</span>
                        @else
                            <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-medium">-</span>
                        @endif
                    </td>

                    <td class="py-4 px-2">
                        <div class="flex items-center justify-center space-x-2">
                            <!-- Detail -->
                            <div
                                class="w-8 h-8 bg-green-50 hover:bg-green-100 text-green-600 rounded-full flex items-center justify-center shadow">
                                <a href="{{ route('reservasi.show', $reservasi->id) }}" title="Detail">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        class="w-4 h-4">
                                        <path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                                        <path fill-rule="evenodd"
                                            d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </div>

                            <!-- Edit -->
                            <div
                                class="w-8 h-8 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-full flex items-center justify-center shadow">
                                <a href="{{ route('reservasi.edit', $reservasi->id) }}" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        class="w-4 h-4">
                                        <path
                                            d="m2.695 14.762-1.262 3.155a.5.5 0 0 0 .65.65l3.155-1.262a4 4 0 0 0 1.343-.886L17.5 5.501a2.121 2.121 0 0 0-3-3L3.58 13.419a4 4 0 0 0-.885 1.343Z" />
                                    </svg>
                                </a>
                            </div>

                            <!-- Hapus -->
                            <button type="button"
                                onclick="confirmDelete({{ $reservasi->id }}, '{{ $reservasi->pasien->nama }}')"
                                class="cursor-pointer w-8 h-8 bg-red-50 hover:bg-red-100 text-red-600 rounded-full flex items-center justify-center shadow"
                                title="Hapus">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="w-4 h-4">
                                    <path fill-rule="evenodd"
                                        d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>

                            <!-- Form Hidden untuk Delete -->
                            <form id="delete-form-{{ $reservasi->id }}"
                                action="{{ route('reservasi.destroy', $reservasi->id) }}" method="POST"
                                class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </td>
                </tr>

            @empty
                <tr>
                    <td colspan="8" class="text-center py-5 text-gray-500">
                        Belum ada data antrian reservasi
                    </td>
                </tr>
            @endforelse

        </tbody>
    </table>
</div>

<script>
    function confirmDelete(id, nama) {
        Swal.fire({
            title: 'Hapus reservasi?',
            text: `Yakin ingin menghapus reservasi pasien "${nama}"?`,
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
