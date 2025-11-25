<div
    class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 border border-gray-100 overflow-hidden">
    <!-- Gambar Produk -->
    <div class="w-full h-40 bg-gray-100">
        @if ($image ?? false)
            <img src="{{ $image }}" class="w-full h-full object-cover" alt="product_image">
        @else
            <div class="flex items-center justify-center h-full text-gray-400 text-sm">
                No Image
            </div>
        @endif
    </div>

    <!-- Detail -->
    <div class="p-4 space-y-2">
        <h2 class="text-lg font-semibold text-gray-800 line-clamp-1">
            {{ $title ?? 'Nama Produk' }}
        </h2>

        <p class="text-sm text-gray-500">
            {{ $category ?? 'Kategori' }}
        </p>

        <div class="flex justify-between items-center mt-3">
            <span class="text-primary-600 font-bold">
                Rp {{ number_format($price ?? 0, 0, ',', '.') }}
            </span>

            <span class="text-xs bg-primary-100 text-primary-700 px-2 py-1 rounded-md">
                Stok: {{ $stock ?? 0 }}
            </span>
        </div>

        <!-- Aksi -->
        <div class="flex gap-2 mt-4">
            <button class="flex-1 bg-red-500 hover:bg-red-600 text-white rounded-lg py-1.5">
                Hapus
            </button>
            <button class="flex-1 bg-primary-600 hover:bg-primary-700 text-white rounded-lg py-1.5">
                Ubah
            </button>
        </div>
    </div>
</div>
