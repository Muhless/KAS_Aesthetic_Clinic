<div class="bg-white rounded-sm shadow-[0_0.5rem_1rem_rgba(0,0,0,0.1)] border border-black/10 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-100 border-b border-black/10">
                    <th class="px-3 py-2 text-left text-xs font-semibold text-slate-600 uppercase w-12">No</th>
                    <th class="px-3 py-2 text-left text-xs font-semibold text-slate-600 uppercase">Nama Pasien</th>
                    <th class="px-3 py-2 text-left text-xs font-semibold text-slate-600 uppercase">Jenis Kelamin</th>
                    <th class="px-3 py-2 text-left text-xs font-semibold text-slate-600 uppercase">Nomor Telepon</th>
                    <th class="px-3 py-2 text-left text-xs font-semibold text-slate-600 uppercase">Tanggal Lahir</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($pasiens as $pasien)
                    <tr data-testid="patient-row"
                        class="border-b border-black/10 even:bg-slate-50 hover:bg-slate-100 transition cursor-pointer"
                        onclick="window.location.href='{{ route('pasien.show', $pasien->id) }}'">

                        <td class="px-3 py-2.5 text-slate-500 text-center">
                            {{ $loop->iteration }}
                        </td>

                        {{-- Nama --}}
                        <td class="px-3 py-2.5">
                            <div class="flex items-center gap-2.5">
                                <div class="w-7 h-7 rounded-full bg-slate-200 text-slate-600 flex items-center justify-center font-semibold text-xs shrink-0">
                                    {{ strtoupper(substr($pasien->nama, 0, 1)) }}
                                </div>
                                <span data-testid="patient-name" class="font-medium text-slate-700">
                                    {{ $pasien->nama }}
                                </span>
                            </div>
                        </td>

                        {{-- Jenis Kelamin --}}
                        <td class="px-3 py-2.5">
                            @if ($pasien->jenis_kelamin == 'L')
                                <span class="inline-block px-2 py-1 bg-blue-500 text-white rounded text-xs font-medium">
                                    Laki-laki
                                </span>
                            @elseif ($pasien->jenis_kelamin == 'P')
                                <span class="inline-block px-2 py-1 bg-red-500 text-white rounded text-xs font-medium">
                                    Perempuan
                                </span>
                            @else
                                <span class="text-slate-300">—</span>
                            @endif
                        </td>

                        {{-- Nomor Telepon --}}
                        <td class="px-3 py-2.5 text-slate-600">
                            @if ($pasien->nomor_telepon)
                                <span class="font-mono">{{ $pasien->nomor_telepon }}</span>
                            @else
                                <span class="text-slate-300">—</span>
                            @endif
                        </td>

                        {{-- Tanggal Lahir --}}
                        <td class="px-3 py-2.5 text-slate-600">
                            @if ($pasien->tanggal_lahir)
                                {{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->translatedFormat('d F Y') }}
                            @else
                                <span class="text-slate-300">—</span>
                            @endif
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-10 text-center text-slate-400 text-sm">
                            Belum ada data pasien
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
            confirmButtonColor: '#ef4444',
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
