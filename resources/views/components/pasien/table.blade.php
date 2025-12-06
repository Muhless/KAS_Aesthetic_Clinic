<div class="overflow-x-auto bg-white">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b text-primary-500 bg-primary-50/40">
                <th class="p-2 text-left">No</th>
                <th class="p-2 text-left">Nama pasien</th>
                <th class="p-2 text-left">Jenis Kelamin</th>
                <th class="p-2 text-left">Nomor Telepon</th>
                <th class="p-2 text-left">Tanggal Lahir</th>
                <th class="p-2">Aksi</th>
            </tr>
        </thead>

        <tbody class="divide-y">

            @forelse ($pasiens as $index => $pasien)
                <tr class="hover:bg-primary-50/20 transition">
                    <td class="py-4 px-2 text-center">{{ $index + 1 }}</td>
                    <td class="py-4 px-2 font-semibold">{{ $pasien->nama }}</td>
                    <td class="py-4 px-2">{{ $pasien->jenis_kelamin }}</td>
                    <td class="py-4 px-2">{{ $pasien->telepon }}</td>
                    <td class="py-4 px-2">{{ $pasien->tanggal_lahir }}</td>

                    <td class="py-4 px-2 flex items-center justify-center space-x-3">
                        <!-- Tombol aksi -->
                        <button class="text-blue-600 hover:text-blue-800" title="Detail">
                            @svg('heroicon-o-eye', 'w-5 h-5')
                        </button>

                        <button class="text-yellow-600 hover:text-yellow-800" title="Edit">
                            @svg('heroicon-o-pencil', 'w-5 h-5')
                        </button>

                        <button class="text-red-600 hover:text-red-800" title="Hapus">
                            @svg('heroicon-o-trash', 'w-5 h-5')
                        </button>
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
