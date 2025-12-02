@props(['dokter'])

<div class="bg-white shadow-md rounded-xl overflow-hidden">
    <div class="h-40 bg-gray-100">
        <img
            src="{{ $dokter['foto'] ? asset('storage/' . $dokter['foto']) : asset('images/default.png') }}"
            class="w-full h-full object-cover"
        >
    </div>

    <div class="p-4 text-center">
        <h3 class="text-lg font-semibold">{{ $dokter['nama'] }}</h3>
        <p class="text-gray-500 text-sm">{{ $dokter['email'] ?? '-' }}</p>
        <p class="text-gray-500 text-sm">{{ $dokter['no_telepon'] ?? '-' }}</p>
    </div>
</div>
