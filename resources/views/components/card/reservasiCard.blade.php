@props(['totalReservasi'])

<div class="bg-white rounded-2xl p-4 border border-slate-100">
    <div class="flex items-center justify-between mb-3">
        <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Reservasi</p>
        <div class="w-7 h-7 bg-primary-50 rounded-lg flex items-center justify-center">
            <svg class="w-3.5 h-3.5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
        </div>
    </div>
    <p class="text-2xl font-semibold text-slate-800">{{ $totalReservasi }}</p>
    <p class="text-xs text-slate-400 mt-1">Hari ini</p>
</div>
