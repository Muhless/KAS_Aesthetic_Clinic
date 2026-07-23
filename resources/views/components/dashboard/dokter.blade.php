@props(['totalDokter'])

<div class="bg-yellow-500 rounded-md shadow-sm text-white relative overflow-hidden">
    <div class="p-4">
        <p class="text-3xl font-bold">{{ $totalDokter }}</p>
        <p class="text-sm">Dokter Bertugas</p>
    </div>
    <div class="absolute -right-2 -bottom-3 opacity-25">
        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
        </svg>
    </div>
    <a href="#" class="block bg-black/10 hover:bg-black/20 text-center text-xs py-1.5 transition">
        Lihat Detail <span aria-hidden="true">→</span>
    </a>
</div>
