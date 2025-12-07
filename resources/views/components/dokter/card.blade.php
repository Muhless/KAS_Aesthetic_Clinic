@props(['dokter'])

<div class="bg-white rounded-md border border-gray-200 overflow-hidden hover:border-gray-300 transition-colors">
    <!-- Foto Dokter -->
    <div class="relative h-48 bg-gray-50 cursor-pointer"
        onclick="window.location.href='{{ route('dokter.detail', $dokter['id']) }}'">
        <img src="{{ $dokter['foto'] ? asset('storage/' . $dokter['foto']) : asset('images/default.png') }}"
            alt="{{ $dokter['nama'] }}" class="w-full h-full object-cover">

        <!-- Actions -->
        <div class="absolute top-3 right-3 flex gap-1">
            <button type="button" @click.stop="editDokter({{ $dokter['id'] }})"
                class="p-2 bg-white/90 backdrop-blur-sm text-gray-700 text-sm font-medium rounded-full shadow-sm hover:bg-green-50 hover:text-green-600 transition-colors hover:cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                    <path
                        d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32L19.513 8.2Z" />
                </svg>
            </button>

            <form action="{{ route('dokter.destroy', $dokter['id']) }}" method="POST"
                onsubmit="return confirm('Yakin ingin menghapus?')" @click.stop>
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="p-2 bg-white/90 backdrop-blur-sm hover:cursor-pointer text-gray-700 text-sm font-medium rounded-full shadow-sm hover:bg-red-50 hover:text-red-600 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                        <path fill-rule="evenodd"
                            d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </form>
        </div>
    </div>

    <!-- Konten - Clickable -->
    <div class="p-5 cursor-pointer hover:bg-gray-50 transition-colors"
        onclick="window.location.href='{{ route('dokter.detail', $dokter['id']) }}'">

        <h3 class="text-lg font-semibold text-gray-900 mb-3">{{ $dokter['nama'] }}</h3>

        <div class="space-y-1 text-sm text-gray-600">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                    </path>
                </svg>
                <p>{{ $dokter['email'] ?? '-' }}</p>
            </div>
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                    </path>
                </svg>
                <p>{{ $dokter['no_telepon'] ?? '-' }}</p>
            </div>
        </div>

        <!-- Badge Jadwal Hari Ini -->
        @if ($dokter->jadwalHariIni())
            <div
                class="mt-3 inline-flex items-center gap-2 px-3 py-1.5 bg-green-50 text-green-700 rounded-full text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>Praktek Hari Ini: {{ $dokter->jadwalHariIni()->jam_mulai }} -
                    {{ $dokter->jadwalHariIni()->jam_selesai }}</span>
            </div>
        @else
            <div class="mt-3 inline-flex items-center gap-2 px-3 py-1.5 bg-gray-100 text-gray-600 rounded-full text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
                <span>Tidak Praktek Hari Ini</span>
            </div>
        @endif

        <div class="mt-3 text-xs text-blue-600 font-medium flex items-center gap-1">
            Lihat Detail
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </div>
    </div>
</div>
