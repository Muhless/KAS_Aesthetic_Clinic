<div>
    <div class="flex items-center justify-between px-4 py-2 bg-white border-b border-slate-200">

        {{-- Notification --}}
        <button type="button" class="relative w-8 h-8 flex items-center justify-center rounded hover:bg-slate-100 transition text-slate-500">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
            </svg>
        </button>

        {{-- User Info --}}
        <div class="flex items-center gap-2.5">
            <div class="text-right leading-tight">
                <p class="text-sm font-semibold text-slate-700">{{ auth()->user()->dokter->nama ?? 'Tidak ada data' }}</p>
                <p class="text-xs text-slate-400">{{ ucfirst(auth()->user()->role) }}</p>
            </div>
            <div class="w-8 h-8 rounded-full overflow-hidden border border-slate-200 shrink-0">
                <img src="{{ optional(auth()->user()->dokter)->foto
                    ? asset('storage/' . optional(auth()->user()->dokter)->foto)
                    : asset('images/default.png') }}"
                    alt="user_picture" class="w-full h-full object-cover">
            </div>
        </div>

    </div>
</div>
