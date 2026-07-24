@props(['totalReservasi'])

<div class="bg-blue-500 rounded-lg shadow-sm text-white relative overflow-hidden">
    <div class="p-4">
        <p class="text-3xl font-bold leading-tight">{{ $totalReservasi }}</p>
        <p class="text-sm text-blue-50">Reservasi Hari Ini</p>
    </div>
    <div class="absolute -right-2 -bottom-3 opacity-25">
        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
    </div>
    <a href="#"
        class="flex items-center justify-center gap-1 bg-black/10 hover:bg-black/20 text-center text-xs font-medium py-1.5 transition">
        Lihat Detail <span aria-hidden="true">→</span>
    </a>
</div>
