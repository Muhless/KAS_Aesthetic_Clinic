@props(['treatment'])

<div class="bg-white shadow rounded-xl p-4 border border-gray-100 hover:shadow-md transition">
    <div class="flex items-center justify-between mb-3">
        <h3 class="text-lg font-semibold text-gray-800 truncate">
            {{ $treatment->name }}
        </h3>

        {{-- Icon Delete --}}
        <form action="{{ route('treatment.destroy', $treatment->id) }}" method="POST"
            onsubmit="return confirm('Yakin ingin menghapus treatment ini?')" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="p-2 rounded-md bg-red-500 hover:bg-red-600 text-white transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-4">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                </svg>
            </button>
        </form>
    </div>

    {{-- Foto Treatment --}}
    @if ($treatment->foto)
        <div class="mb-3">
            <img src="{{ asset('storage/' . $treatment->foto) }}" alt="{{ $treatment->name }}"
                class="w-full h-40 object-cover rounded-lg">
        </div>
    @endif

    <p class="text-sm text-gray-500 mb-4 line-clamp-2">
        {{ $treatment->deskripsi ?? 'Tidak ada deskripsi' }}
    </p>

    <div class="space-y-1 mb-3">
        <div class="text-xl font-bold text-primary-600">
            Rp {{ number_format($treatment->harga, 0, ',', '.') }}
        </div>

        @if ($treatment->durasi)
            <div class="text-sm text-gray-600">
                <span class="font-medium">Durasi:</span> {{ $treatment->durasi }} menit
            </div>
        @endif

        <div class="inline-flex items-center">
            <span
                class="px-2 py-1 text-xs rounded-full {{ $treatment->status == 'tersedia' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                {{ ucfirst($treatment->status) }}
            </span>
        </div>
    </div>

    <div class="flex items-center justify-between gap-2 pt-3 border-t">
        <button @click="openEditModal({{ $treatment->id }})"
            class="flex-1 cursor-pointer py-1.5 text-sm bg-gray-100 hover:bg-gray-200 rounded-md transition">
            Edit
        </button>
        <a href="{{ route('treatment.show', $treatment->id) }}"
            class="flex-1 text-center cursor-pointer py-1.5 text-sm bg-primary-600 hover:bg-primary-700 text-white rounded-md transition">
            Detail
        </a>
    </div>
</div>
