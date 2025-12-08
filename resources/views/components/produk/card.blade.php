@props(['produk'])

<div
    class="h-full bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 border border-gray-100 overflow-hidden flex flex-col">

    <!-- Gambar Produk -->
    <div class="relative w-full h-48 bg-linear-to-br from-blue-50 to-indigo-50 shrink-0 p-3">
        @if ($produk->foto)
            <img src="{{ asset('storage/' . $produk->foto) }}" class="w-full h-full object-contain"
                alt="{{ $produk->nama }}">
        @else
            <div class="flex items-center justify-center h-full">
                <div class="text-center">
                    <svg class="w-12 h-12 mx-auto text-gray-300 mb-1" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    <p class="text-xs text-gray-400">No Image</p>
                </div>
            </div>
        @endif
    </div>

    <!-- Detail - Flex Grow untuk mengisi ruang -->
    <div class="p-4 space-y-2 flex flex-col grow">
        <div class="flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-800 line-clamp-1">
                {{ $produk->nama }}
            </h2>
            <!-- Aksi -->
            <div class="flex gap-2">
                <button @click="openEditModal({{ $produk->id }})"
                    class="p-2 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg transition cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                        <path
                            d="m2.695 14.762-1.262 3.155a.5.5 0 0 0 .65.65l3.155-1.262a4 4 0 0 0 1.343-.886L17.5 5.501a2.121 2.121 0 0 0-3-3L3.58 13.419a4 4 0 0 0-.885 1.343Z" />
                    </svg>

                </button>

                <form action="{{ route('produk.destroy', $produk->id) }}" method="POST"
                    onsubmit="return confirm('Hapus {{ $produk->nama }}?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="p-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                            <path fill-rule="evenodd"
                                d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z"
                                clip-rule="evenodd" />
                        </svg>

                    </button>
                </form>
            </div>
        </div>


        @if ($produk->kategori)
            <p class="text-sm text-gray-500">
                {{ $produk->kategori }}
            </p>
        @endif

        @if ($produk->deskripsi)
            <p class="text-xs text-gray-600 line-clamp-2">
                {{ $produk->deskripsi }}
            </p>
        @endif

        <!-- Spacer untuk push content ke bawah -->
        <div class="grow"></div>

        <div class="flex justify-between items-center pt-2">
            <span class="text-primary-600 font-bold text-lg">
                Rp {{ number_format($produk->harga, 0, ',', '.') }}
            </span>

            <span
                class="text-xs font-medium px-2 py-1 rounded-md
                {{ $produk->stok > 0 ? 'bg-primary-100 text-primary-700' : 'bg-red-100 text-red-700' }}">
                Stok: {{ $produk->stok }}
            </span>
        </div>


    </div>
</div>
