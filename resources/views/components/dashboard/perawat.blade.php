@props(['totalPerawat'])

<div class="bg-red-500 rounded-md shadow-sm text-white relative overflow-hidden">
    <div class="p-4">
        <p class="text-3xl font-bold">{{ $totalPerawat }}</p>
        <p class="text-sm">Perawat Bertugas</p>
    </div>
    <div class="absolute -right-2 -bottom-3 opacity-25">
        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
        </svg>
    </div>
    <a href="#" class="block bg-black/10 hover:bg-black/20 text-center text-xs py-1.5 transition">
        Lihat Detail <span aria-hidden="true">→</span>
    </a>
</div>
