@props(['totalPelayanan'])

<div class="bg-green-500 rounded-md shadow-sm text-white relative overflow-hidden">
    <div class="p-4">
        <p class="text-3xl font-bold">{{ $totalPelayanan }}</p>
        <p class="text-sm">Pelayanan Hari Ini</p>
    </div>
    <div class="absolute -right-2 -bottom-3 opacity-25">
        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0" />
        </svg>
    </div>
    <a href="#" class="block bg-black/10 hover:bg-black/20 text-center text-xs py-1.5 transition">
        Lihat Detail <span aria-hidden="true">→</span>
    </a>
</div>