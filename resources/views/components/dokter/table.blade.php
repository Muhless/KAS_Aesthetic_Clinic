<div class="overflow-x-auto bg-white">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b text-primary-500 bg-primary-50/40">
                <th class="p-2 text-left">No</th>
                <th class="p-2 text-left">Nama Pasien</th>
                <th class="p-2 text-left">Jenis Kelamin</th>
                <th class="p-2 text-left">Nomor Telepon</th>
                <th class="p-2 text-left">Tanggal Lahir</th>
                <th class="p-2">Aksi</th>
            </tr>
        </thead>


        <tbody class="divide-y">
            {{-- @foreach ($dokters as $i => $dokter)
                <tr class="hover:bg-primary-50/20 transition">
                    <td class="py-4 px-2 text-center">{{ $i + 1 }}</td>
                    <td class="py-4 px-2 font-semibold">{{ $dokter->nama }}</td>
                    <td class="py-4 px-2">
                        {{ $dokter->jenis_kelamin ?? '-' }}
                    </td>
                    <td class="py-4 px-2">{{ $dokter->no_telepon ?? '-' }}</td>
                    <td class="py-4 px-2">
                        {{ $dokter->tanggal_lahir ? $dokter->tanggal_lahir->format('d F Y') : '-' }}
                    </td>
                    <td class="py-4 px-2 flex items-center justify-center space-x-3">
                        <button class="text-blue-600 hover:text-blue-800">detail</button>
                        <button class="text-yellow-600 hover:text-yellow-800">edit</button>
                        <button class="text-red-600 hover:text-red-800">hapus</button>
                    </td>

                </tr>
            @endforeach --}}

        </tbody>


    </table>
</div>
