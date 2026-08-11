@props(['dokterHariIni'])

<div class="bg-white rounded-sm shadow-[0_0.5rem_1rem_rgba(0,0,0,0.1)] border border-black/10 overflow-hidden">
    <div class="px-4 py-3 bg-slate-100 border-b border-black/10">
        <h5 class="text-sm font-semibold text-slate-700 m-0">Dokter Hari Ini</h5>
    </div>
    <div class="divide-y divide-black/10">
        @forelse ($dokterHariIni as $dokter)
        <div class="flex items-center gap-2.5 px-4 py-2.5">
            <div
                class="w-8 h-8 bg-slate-200 rounded-full flex items-center justify-center text-slate-600 font-semibold text-xs shrink-0">
                {{ strtoupper(substr($dokter->nama, 0, 2)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-slate-700 truncate">{{ $dokter->nama }}</p>
                <p class="text-xs text-slate-400 truncate">{{ $dokter->spesialis ?? '—' }}</p>
            </div>
            <span class="w-2 h-2 bg-green-500 rounded-full shrink-0"></span>
        </div>
        @empty
        <div class="px-4 py-6 text-center">
            <p class="text-sm text-slate-400">Tidak ada dokter praktek hari ini</p>
        </div>
        @endforelse
    </div>
</div>
