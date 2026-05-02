@props(['totalAntrian'])

<div class="bg-white rounded-2xl p-4 border border-slate-100">
    <div class="flex items-center justify-between mb-3">
        <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Antrian</p>
        <div class="w-7 h-7 bg-violet-50 rounded-lg flex items-center justify-center">
            <svg class="w-3.5 h-3.5 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0" />
            </svg>
        </div>
    </div>
    <p class="text-2xl font-semibold text-slate-800">{{ $totalAntrian }}</p>
    <p class="text-xs text-slate-400 mt-1">Menunggu</p>
</div>
