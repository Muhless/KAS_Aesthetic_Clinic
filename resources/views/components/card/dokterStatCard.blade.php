@props(['totalDokter'])

<div class="bg-white rounded-2xl p-4 border border-slate-100">
    <div class="flex items-center justify-between mb-3">
        <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Dokter</p>
        <div class="w-7 h-7 bg-emerald-50 rounded-lg flex items-center justify-center">
            <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
        </div>
    </div>
    <p class="text-2xl font-semibold text-slate-800">{{ $totalDokter }}</p>
    <p class="text-xs text-slate-400 mt-1">Bertugas</p>
</div>
