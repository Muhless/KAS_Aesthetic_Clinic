@props(['perawat'])

<div class="bg-white rounded-sm shadow-[0_0.5rem_1rem_rgba(0,0,0,0.1)] border border-black/10 overflow-hidden">

    {{-- Foto Perawat --}}
    <div class="relative bg-slate-100">
        <img src="{{ $perawat['foto'] ? asset('storage/' . $perawat['foto']) : asset('images/default.png') }}"
            alt="{{ $perawat['nama'] }}"
            class="w-full h-48 object-cover object-top" />

        {{-- Actions --}}
        <div class="absolute top-2 right-2 flex gap-1.5">
            <button type="button" @click.stop="editPerawat({{ $perawat['id'] }})"
                class="w-7 h-7 bg-blue-500 hover:bg-blue-600 text-white rounded-sm flex items-center justify-center transition">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3.5 h-3.5">
                    <path
                        d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32L19.513 8.2Z" />
                </svg>
            </button>

            <form action="{{ route('perawat.destroy', $perawat['id']) }}" method="POST"
                onsubmit="return confirm('Yakin ingin menghapus {{ $perawat['nama'] }}?')" @click.stop>
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="w-7 h-7 bg-red-500 hover:bg-red-600 text-white rounded-sm flex items-center justify-center transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-3.5 h-3.5" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </form>
        </div>
    </div>

    {{-- Content --}}
    <div class="p-3">

        {{-- Name --}}
        <h3 class="text-sm font-semibold text-slate-700 mb-2 truncate">
            {{ $perawat['nama'] }}
        </h3>

        {{-- Info --}}
        <div class="space-y-1.5 text-xs text-slate-500">
            <div class="flex items-center gap-2">
                <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span class="truncate">
                    {{ $perawat['tanggal_lahir'] ? \Carbon\Carbon::parse($perawat['tanggal_lahir'])->translatedFormat('d F Y') : '-' }}
                </span>
            </div>

            <div class="flex items-center gap-2">
                <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <span class="truncate">{{ $perawat['email'] ?? 'Email tidak tersedia' }}</span>
            </div>

            <div class="flex items-center gap-2">
                <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
                <span class="truncate">{{ $perawat['no_telepon'] ?? 'Nomor tidak tersedia' }}</span>
            </div>
        </div>
    </div>

</div>
