{{-- resources/views/components/treatment/card.blade.php --}}
@props(['treatment'])

<div
    class="bg-white rounded-2xl border border-gray-100 overflow-hidden flex flex-col group hover:border-gray-200 transition-all duration-200">

    {{-- Gambar --}}
    <div class="relative h-44 bg-gray-50 overflow-hidden shrink-0">
        @if ($treatment->foto)
            <img src="{{ asset('storage/' . $treatment->foto) }}"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                alt="{{ $treatment->nama }}">
        @else
            <div class="flex flex-col items-center justify-center h-full gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-gray-200" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <p class="text-xs text-gray-300">Tidak ada gambar</p>
            </div>
        @endif

        {{-- Badge durasi --}}
        @if ($treatment->durasi)
            <div class="absolute top-2.5 left-2.5">
                <span
                    class="inline-flex items-center gap-1 text-xs font-medium px-2 py-1 rounded-full bg-teal-50 text-teal-700 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ $treatment->durasi }} menit
                </span>
            </div>
        @endif

        {{-- Badge status --}}
        <div class="absolute top-2.5 right-2.5">
            @if ($treatment->status == 'tersedia')
                <span class="text-xs font-medium px-2 py-1 rounded-full bg-green-50 text-green-700 shadow-sm">
                    Tersedia
                </span>
            @else
                <span class="text-xs font-medium px-2 py-1 rounded-full bg-red-50 text-red-600 shadow-sm">
                    Tidak Tersedia
                </span>
            @endif
        </div>
    </div>

    {{-- Konten --}}
    <div class="flex flex-col grow p-4 gap-2">

        {{-- Nama --}}
        <p class="text-sm font-semibold text-gray-800 line-clamp-1 leading-snug">
            {{ $treatment->nama }}
        </p>

        {{-- Deskripsi --}}
        @if ($treatment->deskripsi)
            <p class="text-xs text-gray-400 line-clamp-2 leading-relaxed">
                {{ $treatment->deskripsi }}
            </p>
        @endif

        <div class="grow"></div>

        {{-- Harga & Aksi --}}
        <div class="flex items-center justify-between pt-3 border-t border-gray-100 mt-1">
            <span class="text-base font-bold text-primary-600">
                Rp {{ number_format($treatment->harga, 0, ',', '.') }}
            </span>

            <div class="flex items-center gap-1.5">
                {{-- Edit --}}
                <button type="button" @click.stop="editTreatment({{ $treatment['id'] }})" title="Edit" title="Edit"
                    class="w-8 h-8 flex items-center justify-center bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg transition cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                        <path
                            d="m2.695 14.762-1.262 3.155a.5.5 0 0 0 .65.65l3.155-1.262a4 4 0 0 0 1.343-.886L17.5 5.501a2.121 2.121 0 0 0-3-3L3.58 13.419a4 4 0 0 0-.885 1.343Z" />
                    </svg>
                </button>

                {{-- Hapus --}}
                <form action="{{ route('treatment.destroy', $treatment->id) }}" method="POST"
                    onsubmit="return confirm('Hapus treatment {{ $treatment->nama }}?')">
                    @csrf @method('DELETE')
                    <button type="submit" title="Hapus"
                        class="w-8 h-8 flex items-center justify-center bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                            <path fill-rule="evenodd"
                                d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
