@props(['treatment'])

<div
    class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md
           hover:border-primary-300 transition-all duration-300 hover:-translate-y-1">

    {{-- Content --}}
    <div class="p-5">

        {{-- Header --}}
        <div class="flex items-start justify-between gap-4 mb-4">

            <div class="flex-1">
                <h3 class="text-lg font-semibold text-gray-900 leading-tight mb-2">
                    {{ $treatment->nama }}
                </h3>

                {{-- Status --}}
                <span
                    class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-medium rounded-full
    {{ $treatment->status === 'tersedia'
        ? 'bg-green-50 text-green-700 border border-green-200'
        : 'bg-red-50 text-red-600 border border-red-200' }}">

                    <span class="w-2.5 h-2.5 rounded-full bg-current"></span>

                    {{ $treatment->status === 'tidak_tersedia' ? 'Tidak Tersedia' : 'Tersedia' }}
                </span>

            </div>

            {{-- Action Buttons --}}
            <div class="flex gap-2">
                <button @click="openEditModal({{ $treatment->id }})"
                    class="p-2 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg transition cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                        <path
                            d="m2.695 14.762-1.262 3.155a.5.5 0 0 0 .65.65l3.155-1.262a4 4 0 0 0 1.343-.886L17.5 5.501a2.121 2.121 0 0 0-3-3L3.58 13.419a4 4 0 0 0-.885 1.343Z" />
                    </svg>

                </button>

                <form action="{{ route('treatment.destroy', $treatment->id) }}" method="POST"
                    onsubmit="return confirm('Hapus {{ $treatment->nama }}?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="p-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                            <path fill-rule="evenodd"
                                d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z"
                                clip-rule="evenodd" />
                        </svg>

                    </button>
                </form>
            </div>
        </div>

        {{-- Description --}}
        <p class="text-sm text-gray-600 mb-4 line-clamp-2">
            {{ $treatment->deskripsi ?: 'Tidak ada deskripsi.' }}
        </p>

        {{-- Price & Duration --}}
        <div class="flex items-center justify-between pt-4 border-t border-gray-200">

            {{-- Harga --}}
            <div>
                <div class="text-xs text-gray-500">Harga</div>
                <div class="text-2xl font-bold text-primary-600">
                    <span class="text-base font-medium">Rp</span>
                    {{ number_format($treatment->harga, 0, ',', '.') }}
                </div>

            </div>

            {{-- Durasi --}}
            @if ($treatment->durasi)
                <div class="text-right">
                    <div class="text-xs text-gray-500">Durasi</div>
                    <div class="text-lg font-semibold text-gray-700">
                        {{ $treatment->durasi }} <span class="text-sm font-normal text-gray-500">menit</span>
                    </div>
                </div>
            @endif

        </div>

    </div>
</div>
