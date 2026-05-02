@props(['totalPerawat'])

<div class="bg-white rounded-2xl p-4 border border-slate-100">
    <div class="flex items-center justify-between mb-3">
        <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Perawat</p>
        <div class="w-7 h-7 bg-rose-50 rounded-lg flex items-center justify-center">
            <svg class="w-3.5 h-3.5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
            </svg>
        </div>
    </div>
    <p class="text-2xl font-semibold text-slate-800">{{ $totalPerawat }}</p>
    <p class="text-xs text-slate-400 mt-1">Bertugas</p>
</div>
