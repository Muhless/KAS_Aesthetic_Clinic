@props(['perawat'])

<div
    class="group bg-white rounded-2xl border border-gray-200 overflow-hidden hover:border-primary-300 hover:shadow-xl transition-all duration-300">

    <!-- Foto Perawat -->
    <div class="relative aspect-3/4 bg-linear-to-br from-primary-50 to-purple-50 overflow-hidden">
        <img src="{{ $perawat['foto'] ? asset('storage/' . $perawat['foto']) : asset('images/default.png') }}"
            alt="{{ $perawat['nama'] }}"
            class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-500" />

        <!-- Overlay Gradient -->
        <div
            class="absolute inset-0 bg-linear-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        </div>

        <!-- Actions - Visible on Hover -->
        <div
            class="absolute top-3 right-3 flex gap-2 opacity-0 group-hover:opacity-100 transition-all duration-300 transform -translate-y-2.5 group-hover:translate-y-0">
            <button type="button" @click.stop="editPerawat({{ $perawat['id'] }})"
                class="p-2.5 bg-white/95 backdrop-blur-md text-gray-700 rounded-xl shadow-lg hover:bg-primary-50 hover:text-primary-600 hover:scale-110 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-5 h-5" viewBox="0 0 24 24">
                    <path
                        d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32L19.513 8.2Z" />
                </svg>
            </button>

            <form action="{{ route('perawat.destroy', $perawat['id']) }}" method="POST"
                onsubmit="return confirm('Yakin ingin menghapus {{ $perawat['nama'] }}?')" @click.stop>
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="p-2.5 bg-white/95 backdrop-blur-md text-gray-700 rounded-xl shadow-lg hover:bg-red-50 hover:text-red-600 hover:scale-110 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-5 h-5" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </form>
        </div>


    </div>

    <!-- Content -->
    <div class="p-5 cursor-pointer hover:bg-gray-50 transition-colors">

        <!-- Name -->
        <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-primary-600 transition-colors">
            {{ $perawat['nama'] }}
        </h3>

        <!-- Info -->
        <div class="space-y-2.5">
            <div class="flex items-center gap-3 group/item">
                <div
                    class="shrink-0 w-9 h-9 bg-purple-50 rounded-lg flex items-center justify-center group-hover/item:bg-purple-100 transition-colors">
                    <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15.75 7.5a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4.5 20.25a9.75 9.75 0 1 1 15 0" />
                    </svg>
                </div>
                <p class="text-sm text-gray-600">
                    {{ $perawat['tanggal_lahir'] ? \Carbon\Carbon::parse($perawat['tanggal_lahir'])->translatedFormat('d F Y') : '-' }}
                </p>

            </div>
        </div>
        <!-- Email -->
        <div class="flex items-center gap-3 group/item">
            <div
                class="shrink-0 w-9 h-9 bg-primary-50 rounded-lg flex items-center justify-center group-hover/item:bg-primary-100 transition-colors">
                <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                    </path>
                </svg>
            </div>
            <p class="text-sm text-gray-600 truncate flex-1">{{ $perawat['email'] ?? 'Email tidak tersedia' }}</p>
        </div>

        <!-- Phone -->
        <div class="flex items-center gap-3 group/item">
            <div
                class="shrink-0 w-9 h-9 bg-purple-50 rounded-lg flex items-center justify-center group-hover/item:bg-purple-100 transition-colors">
                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                    </path>
                </svg>
            </div>
            <p class="text-sm text-gray-600">{{ $perawat['no_telepon'] ?? 'Nomor tidak tersedia' }}</p>
        </div>
    </div>


</div>
