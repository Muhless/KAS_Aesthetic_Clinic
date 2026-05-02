<div class="bg-primary-500 rounded-2xl p-5 text-white">
    <p class="text-primary-100 text-xs font-medium uppercase tracking-wider mb-4">Pasien Selanjutnya</p>

    @if ($pasienSelanjutnya)
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center font-semibold text-lg shrink-0">
                {{ strtoupper(substr($pasienSelanjutnya->pasien->nama, 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="font-semibold text-lg truncate">{{ $pasienSelanjutnya->pasien->nama }}</p>
                <p class="text-primary-100 text-sm truncate">
                    {{ $pasienSelanjutnya->dokter->nama ?? 'Dokter belum ditentukan' }}
                </p>
            </div>
            <div class="text-right shrink-0">
                <p class="text-2xl font-semibold">No. {{ $pasienSelanjutnya->nomor_antrian }}</p>
                <span class="text-xs bg-white/20 px-2.5 py-1 rounded-full">Menunggu</span>
            </div>
        </div>
    @else
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white/50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            <p class="text-primary-100 text-sm">Tidak ada antrian menunggu saat ini</p>
        </div>
    @endif
</div>
