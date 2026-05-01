@props(['produk'])

<div class="h-full bg-white rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100 overflow-hidden flex flex-col group">

    {{-- Gambar --}}
    <div class="relative w-full h-44 bg-gray-50 shrink-0 overflow-hidden">
        @if ($produk->foto)
            <img src="{{ asset('storage/' . $produk->foto) }}"
                class="w-full h-full object-contain p-3 group-hover:scale-105 transition-transform duration-300"
                alt="{{ $produk->nama }}">
        @else
            <div class="flex flex-col items-center justify-center h-full gap-2 text-gray-300">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                <p class="text-xs">Tidak ada gambar</p>
            </div>
        @endif

        {{-- Badge stok --}}
        <div class="absolute top-2.5 right-2.5">
            @if ($produk->stok > 0)
                <span class="text-xs font-medium px-2 py-1 rounded-full bg-green-100 text-green-700 shadow-sm">
                    Stok {{ $produk->stok }}
                </span>
            @else
                <span class="text-xs font-medium px-2 py-1 rounded-full bg-red-100 text-red-700 shadow-sm">
                    Habis
                </span>
            @endif
        </div>
    </div>

    {{-- Konten --}}
    <div class="flex flex-col grow p-4 gap-2">

        {{-- Nama & Kategori --}}
        <div>
            <h2 class="text-sm font-semibold text-gray-800 line-clamp-1 leading-snug">
                {{ $produk->nama }}
            </h2>
            @if ($produk->kategori)
                <p class="text-xs text-primary-500 mt-0.5">{{ $produk->kategori }}</p>
            @endif
        </div>

        {{-- Deskripsi --}}
        @if ($produk->deskripsi)
            <p class="text-xs text-gray-400 line-clamp-2 leading-relaxed">
                {{ $produk->deskripsi }}
            </p>
        @endif

        <div class="grow"></div>

        {{-- Harga & Aksi --}}
        <div class="flex items-center justify-between pt-2 border-t border-gray-100">
            <span class="text-base font-bold text-primary-600">
                Rp {{ number_format($produk->harga, 0, ',', '.') }}
            </span>

            <div class="flex items-center gap-1.5">
                {{-- Edit --}}
                <button @click="openEditModal({{ $produk->id }})"
                    title="Edit"
                    class="w-8 h-8 flex items-center justify-center bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg transition cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                        <path d="m2.695 14.762-1.262 3.155a.5.5 0 0 0 .65.65l3.155-1.262a4 4 0 0 0 1.343-.886L17.5 5.501a2.121 2.121 0 0 0-3-3L3.58 13.419a4 4 0 0 0-.885 1.343Z" />
                    </svg>
                </button>

                {{-- Hapus --}}
                <form action="{{ route('produk.destroy', $produk->id) }}" method="POST"
                    onsubmit="return confirm('Hapus {{ $produk->nama }}?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        title="Hapus"
                        class="w-8 h-8 flex items-center justify-center bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                            <path fill-rule="evenodd"
                                d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
