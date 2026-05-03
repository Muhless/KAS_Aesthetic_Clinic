@props(['dokterHariIni'])

<div class="bg-white rounded-2xl border border-slate-100 overflow-hidden">
    <div class="px-5 py-4 border-b border-slate-50">
        <h3 class="font-semibold text-slate-800 text-sm">Dokter Hari Ini</h3>
    </div>
    <div class="divide-y divide-slate-50">
        @forelse ($dokterHariIni as $dokter)
            <div class="flex items-center gap-3 px-5 py-3.5">
                <div class="w-9 h-9 bg-primary-100 rounded-xl flex items-center justify-center text-primary-600 font-semibold text-xs shrink-0">
                    {{ strtoupper(substr($dokter->nama, 0, 2)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-slate-800 truncate">{{ $dokter->nama }}</p>
                    <p class="text-xs text-slate-400 truncate">{{ $dokter->spesialis ?? '—' }}</p>
                </div>
                <span class="w-2 h-2 bg-emerald-400 rounded-full shrink-0"></span>
            </div>
        @empty
            <div class="px-5 py-8 text-center">
                <p class="text-sm text-slate-400">Tidak ada dokter praktek hari ini</p>
            </div>
        @endforelse
    </div>
</div>
