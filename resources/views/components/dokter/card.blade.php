@props(['dokter'])

<div class="group bg-white rounded-2xl border border-gray-200 overflow-hidden hover:border-primary-300 hover:shadow-xl transition-all duration-300">

    <!-- Foto Dokter -->
    <div class="relative aspect-3/4 bg-linear-to-br from-blue-50 to-indigo-50 overflow-hidden cursor-pointer"
         onclick="window.location.href='{{ route('dokter.detail', $dokter['id']) }}'">
        <img src="{{ $dokter['foto'] ? asset('storage/' . $dokter['foto']) : asset('images/default.png') }}"
             alt="{{ $dokter['nama'] }}"
             class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-500">

        <!-- Overlay Gradient -->
        <div class="absolute inset-0 bg-linear-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

        <!-- Actions -->
        <div class="absolute top-3 right-3 flex gap-2 opacity-0 group-hover:opacity-100 transition-all duration-300 transform -translate-y-2.5 group-hover:translate-y-0">
            <button type="button"
                    @click.stop="editDokter({{ $dokter['id'] }})"
                    class="p-2.5 bg-white/95 backdrop-blur-md text-gray-700 rounded-xl shadow-lg hover:bg-blue-50 hover:text-blue-600 hover:scale-110 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                    <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32L19.513 8.2Z" />
                </svg>
            </button>

            <form action="{{ route('dokter.destroy', $dokter['id']) }}" method="POST"
                  onsubmit="return confirm('Yakin ingin menghapus {{ $dokter['nama'] }}?')"
                  @click.stop>
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="p-2.5 bg-white/95 backdrop-blur-md text-gray-700 rounded-xl shadow-lg hover:bg-red-50 hover:text-red-600 hover:scale-110 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                        <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
                    </svg>
                </button>
            </form>
        </div>

        <!-- Status Badge -->
        @if ($dokter->jadwalHariIni())
            <div class="absolute bottom-3 left-3 opacity-0 group-hover:opacity-100 transition-all duration-300">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white/95 backdrop-blur-md rounded-full text-xs font-semibold text-green-700 shadow-lg">
                    <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                    Praktek Hari Ini
                </span>
            </div>
        @endif
    </div>

    <!-- Content -->
    <div class="p-5 cursor-pointer hover:bg-gray-50 transition-colors"
         onclick="window.location.href='{{ route('dokter.detail', $dokter['id']) }}'">

        <!-- Name & Specialty -->
        <div class="mb-4">
            <h3 class="text-xl font-bold text-gray-900 mb-1 group-hover:text-blue-600 transition-colors">
                {{ $dokter['nama'] }}
            </h3>
            @if(isset($dokter['spesialisasi']))
                <p class="text-sm font-medium text-blue-600">{{ $dokter['spesialisasi'] }}</p>
            @endif
        </div>

        <!-- Info -->
        <div class="space-y-2.5 mb-4">
            <!-- Email -->
            <div class="flex items-center gap-3 group/item">
                <div class="shrink-0 w-9 h-9 bg-blue-50 rounded-lg flex items-center justify-center group-hover/item:bg-blue-100 transition-colors">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
                <p class="text-sm text-gray-600 truncate flex-1">{{ $dokter['email'] ?? 'Email tidak tersedia' }}</p>
            </div>

            <!-- Phone -->
            <div class="flex items-center gap-3 group/item">
                <div class="shrink-0 w-9 h-9 bg-indigo-50 rounded-lg flex items-center justify-center group-hover/item:bg-indigo-100 transition-colors">
                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                        </path>
                    </svg>
                </div>
                <p class="text-sm text-gray-600">{{ $dokter['no_telepon'] ?? 'Nomor tidak tersedia' }}</p>
            </div>
        </div>

        <!-- Schedule Badge -->
        @if ($dokter->jadwalHariIni())
            <div class="mb-4 p-3 bg-linear-to-r from-green-50 to-emerald-50 border border-green-200 rounded-xl">
                <div class="flex items-center gap-2 text-green-700">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="flex-1">
                        <p class="text-xs font-semibold mb-0.5">Praktek Hari Ini</p>
                        <p class="text-sm font-bold">
                            {{ $dokter->jadwalHariIni()->jam_mulai }} - {{ $dokter->jadwalHariIni()->jam_selesai }}
                        </p>
                    </div>
                </div>
            </div>
        @else
            <div class="mb-4 p-3 bg-gray-50 border border-gray-200 rounded-xl">
                <div class="flex items-center gap-2 text-gray-600">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    <p class="text-sm font-medium">Tidak Praktek Hari Ini</p>
                </div>
            </div>
        @endif

        <!-- Action Link -->
        <div class="flex items-center justify-between pt-3 border-t border-gray-100">
            <span class="text-sm font-semibold text-blue-600 group-hover:text-blue-700 transition-colors">
                Lihat Detail Lengkap
            </span>
            <svg class="w-5 h-5 text-blue-600 transform group-hover:translate-x-1 transition-transform"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </div>
    </div>
</div>
